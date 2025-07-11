<?php
require_once '../../vendor/autoload.php'; // Require Composer's autoload for TCPDF
require_once '../../db.php'; // Your database connection file

use TCPDF as TCPDF;

// Check if form was submitted with date range
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : null;
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : null;

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('PESO System');
$pdf->SetTitle('PESO System Report');
$pdf->SetSubject('Database Statistics Report');
$pdf->SetKeywords('PESO, Report, Statistics');

// Set default header data
$pdf->SetHeaderData('', 0, 'PESO System Report', 'Generated on: ' . date('Y-m-d H:i:s') .
    ($start_date ? "\nDate Range: $start_date to $end_date" : ''));

// Set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', 'B', 14);

// 1. Basic Statistics
$pdf->Cell(0, 10, '1. Basic Statistics', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 12);

// Number of applicants (with date filter if provided)
$sql = "SELECT COUNT(*) as total FROM applicant_profile";
if ($start_date && $end_date) {
    $sql .= " WHERE created_at BETWEEN '$start_date' AND '$end_date'";
}
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$pdf->Cell(0, 10, 'Number of Applicants: ' . $row['total'], 0, 1);

// Number of job posted (with date filter if provided)
$sql = "SELECT COUNT(*) as total FROM job_post";
if ($start_date && $end_date) {
    $sql .= " WHERE date_posted BETWEEN '$start_date' AND '$end_date'";
}
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$pdf->Cell(0, 10, 'Number of Job Posted: ' . $row['total'], 0, 1);

// Number of cases (with date filter if provided)
$sql = "SELECT COUNT(*) as total FROM cases";
if ($start_date && $end_date) {
    $sql .= " WHERE created_at BETWEEN '$start_date' AND '$end_date'";
}
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$pdf->Cell(0, 10, 'Number of Cases: ' . $row['total'], 0, 1);

// Number of trainees per training (with date filter if provided)
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Number of Trainees per Training:', 0, 1);
$pdf->SetFont('helvetica', '', 12);

$sql = "SELECT t.name, COUNT(tt.trainee_id) as count 
        FROM skills_training t
        LEFT JOIN trainee_trainings tt ON t.id = tt.training_id";
if ($start_date && $end_date) {
    $sql .= " WHERE tt.enrollment_date BETWEEN '$start_date' AND '$end_date'";
}
$sql .= " GROUP BY t.id";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(0, 10, $row['name'] . ': ' . $row['count'], 0, 1);
}

// Add Service Applications section
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, '2. Service Applications', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 12);

// Get all service types
$serviceTypes = ['TUPAD', 'Livelihood', 'SPES'];

foreach ($serviceTypes as $service) {
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, $service . ' Enrollees:', 0, 1);
    $pdf->SetFont('helvetica', '', 10);

    $sql = "SELECT first_name, last_name, birthdate, gender, address, status 
            FROM service_applications 
            WHERE service_type = '$service'";

    if ($start_date && $end_date) {
        $sql .= " AND application_date BETWEEN '$start_date' AND '$end_date'";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pdf->Cell(0, 10, '- ' . $row['first_name'] . ' ' . $row['last_name'] .
                ' (' . $row['gender'] . ', ' . $row['birthdate'] . ') - Status: ' . $row['status'], 0, 1);
            $pdf->Cell(0, 10, '  Address: ' . $row['address'], 0, 1);
        }
        $pdf->Cell(0, 10, 'Total ' . $service . ' Enrollees: ' . $result->num_rows, 0, 1);
    } else {
        $pdf->Cell(0, 10, 'No enrollees found for ' . $service, 0, 1);
    }

    $pdf->Ln(5);
}

// Add a page for employer/company section
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, '3. Employer/Company Information', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 12);

// List of employers/companies (with date filter if provided)
$sql = "SELECT id, company_name, company_address, company_contact, created_at FROM employer";
if ($start_date && $end_date) {
    $sql .= " WHERE created_at BETWEEN '$start_date' AND '$end_date'";
}
$result = $conn->query($sql);

while ($employer = $result->fetch_assoc()) {
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Company: ' . $employer['company_name'], 0, 1);
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, 10, 'Address: ' . $employer['company_address'], 0, 1);
    $pdf->Cell(0, 10, 'Contact: ' . $employer['company_contact'], 0, 1);

    // List of jobs posted by this company (with date filter if provided)
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 10, 'Jobs Posted:', 0, 1);
    $pdf->SetFont('helvetica', '', 10);

    $jobSql = "SELECT job_title, job_type, salary, date_posted FROM job_post WHERE employer_id = " . $employer['id'];
    if ($start_date && $end_date) {
        $jobSql .= " AND date_posted BETWEEN '$start_date' AND '$end_date'";
    }
    $jobResult = $conn->query($jobSql);

    while ($job = $jobResult->fetch_assoc()) {
        $pdf->Cell(0, 10, '- ' . $job['job_title'] . ' (' . $job['job_type'] . ') - ' . $job['salary'] . ' - Posted: ' . $job['date_posted'], 0, 1);

        // List of applicants for this job (with date filter if provided)
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(0, 10, '  Applicants:', 0, 1);
        $pdf->SetFont('helvetica', '', 8);

        $appSql = "SELECT a.fname, a.lname, a.sex, aj.status, aj.application_date 
                  FROM applied_job aj
                  JOIN applicant_profile a ON aj.applicant_id = a.id
                  WHERE aj.job_posting_id IN (SELECT id FROM job_post WHERE employer_id = " . $employer['id'] . " AND job_title = '" . $job['job_title'] . "')";
        if ($start_date && $end_date) {
            $appSql .= " AND aj.application_date BETWEEN '$start_date' AND '$end_date'";
        }
        $appResult = $conn->query($appSql);

        while ($applicant = $appResult->fetch_assoc()) {
            $pdf->Cell(0, 10, '  - ' . $applicant['fname'] . ' ' . $applicant['lname'] . ' (' . $applicant['sex'] . ') - Status: ' . $applicant['status'] . ' - Applied: ' . $applicant['application_date'], 0, 1);
        }
    }

    // Hired males and females (with date filter if provided)
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 10, 'Hired Employees:', 0, 1);
    $pdf->SetFont('helvetica', '', 10);

    // Hired males
    $maleSql = "SELECT COUNT(*) as males FROM current_employee WHERE employer_id = " . $employer['id'] . " AND gender = 'Male'";
    if ($start_date && $end_date) {
        $maleSql .= " AND hired_date BETWEEN '$start_date' AND '$end_date'";
    }
    $maleResult = $conn->query($maleSql);
    $maleCount = $maleResult->fetch_assoc()['males'];
    $pdf->Cell(0, 10, 'Hired Males: ' . $maleCount, 0, 1);

    // Hired females
    $femaleSql = "SELECT COUNT(*) as females FROM current_employee WHERE employer_id = " . $employer['id'] . " AND gender = 'Female'";
    if ($start_date && $end_date) {
        $femaleSql .= " AND hired_date BETWEEN '$start_date' AND '$end_date'";
    }
    $femaleResult = $conn->query($femaleSql);
    $femaleCount = $femaleResult->fetch_assoc()['females'];
    $pdf->Cell(0, 10, 'Hired Females: ' . $femaleCount, 0, 1);

    $pdf->Ln(5);
}

// Add a page for OFW section
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, '4. OFW Information', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 12);

// List of OFWs (with date filter if provided)
$sql = "SELECT id, first_name, last_name, occupation, country, created_at FROM ofw_profile";
if ($start_date && $end_date) {
    $sql .= " WHERE created_at BETWEEN '$start_date' AND '$end_date'";
}
$result = $conn->query($sql);

while ($ofw = $result->fetch_assoc()) {
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'OFW: ' . $ofw['first_name'] . ' ' . $ofw['last_name'], 0, 1);
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, 10, 'Occupation: ' . $ofw['occupation'] . ' in ' . $ofw['country'], 0, 1);

    // Cases for this OFW (with date filter if provided)
    $caseSql = "SELECT title, description, status, created_at FROM cases WHERE user_id = " . $ofw['id'];
    if ($start_date && $end_date) {
        $caseSql .= " AND created_at BETWEEN '$start_date' AND '$end_date'";
    }
    $caseResult = $conn->query($caseSql);

    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 10, 'Cases:', 0, 1);
    $pdf->SetFont('helvetica', '', 10);

    while ($case = $caseResult->fetch_assoc()) {
        $pdf->Cell(0, 10, '- ' . $case['title'] . ' (' . $case['status'] . ') - Date: ' . $case['created_at'], 0, 1);
        $pdf->Cell(0, 10, '  ' . $case['description'], 0, 1);
    }

    $pdf->Ln(5);
}

// Total resolved cases (with date filter if provided)
$resolvedSql = "SELECT COUNT(*) as resolved FROM cases WHERE status = 'result'";
if ($start_date && $end_date) {
    $resolvedSql .= " AND created_at BETWEEN '$start_date' AND '$end_date'";
}
$resolvedResult = $conn->query($resolvedSql);
$resolvedCount = $resolvedResult->fetch_assoc()['resolved'];
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Total Resolved Cases: ' . $resolvedCount, 0, 1);

// Add a page for Training section
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, '5. Training Information', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 12);

// List of trainings
$sql = "SELECT id, name FROM skills_training";
$result = $conn->query($sql);

while ($training = $result->fetch_assoc()) {
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Training: ' . $training['name'], 0, 1);

    // Accepted trainees (with date filter if provided)
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 10, 'Accepted Trainees:', 0, 1);
    $pdf->SetFont('helvetica', '', 10);

    $acceptedSql = "SELECT tp.fname, tp.lname, tt.enrollment_date 
                   FROM trainee_trainings tt
                   JOIN trainees_profile tp ON tt.trainee_id = tp.id
                   WHERE tt.training_id = " . $training['id'] . " AND tt.status = 'accepted'";
    if ($start_date && $end_date) {
        $acceptedSql .= " AND tt.enrollment_date BETWEEN '$start_date' AND '$end_date'";
    }
    $acceptedResult = $conn->query($acceptedSql);

    while ($trainee = $acceptedResult->fetch_assoc()) {
        $pdf->Cell(0, 10, '- ' . $trainee['fname'] . ' ' . $trainee['lname'] . ' (Enrolled: ' . $trainee['enrollment_date'] . ')', 0, 1);
    }

    // All trainees (including pending, graduated, etc.) (with date filter if provided)
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 10, 'All Trainees:', 0, 1);
    $pdf->SetFont('helvetica', '', 10);

    $allSql = "SELECT tp.fname, tp.lname, tt.status, tt.enrollment_date 
              FROM trainee_trainings tt
              JOIN trainees_profile tp ON tt.trainee_id = tp.id
              WHERE tt.training_id = " . $training['id'];
    if ($start_date && $end_date) {
        $allSql .= " AND tt.enrollment_date BETWEEN '$start_date' AND '$end_date'";
    }
    $allSql .= " ORDER BY tt.status";
    $allResult = $conn->query($allSql);

    while ($trainee = $allResult->fetch_assoc()) {
        $pdf->Cell(0, 10, '- ' . $trainee['fname'] . ' ' . $trainee['lname'] . ' (' . $trainee['status'] . ') - Enrolled: ' . $trainee['enrollment_date'], 0, 1);
    }

    $pdf->Ln(5);
}

// Close and output PDF document
$pdf->Output('peso_system_report.pdf', 'D');

// Close database connection
$conn->close();
