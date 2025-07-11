<?php
require_once '../../vendor/autoload.php'; // Require Composer's autoload for TCPDF
require_once '../../db.php'; // Your database connection file

use TCPDF as TCPDF;

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('PESO System');
$pdf->SetTitle('PESO System Report');
$pdf->SetSubject('Database Statistics Report');
$pdf->SetKeywords('PESO, Report, Statistics');

// Set default header data
$pdf->SetHeaderData('', 0, 'PESO System Report', 'Generated on: ' . date('Y-m-d H:i:s'));

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

// Number of applicants
$sql = "SELECT COUNT(*) as total FROM applicant_profile";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$pdf->Cell(0, 10, 'Number of Applicants: ' . $row['total'], 0, 1);

// Number of job posted
$sql = "SELECT COUNT(*) as total FROM job_post";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$pdf->Cell(0, 10, 'Number of Job Posted: ' . $row['total'], 0, 1);

// Number of cases
$sql = "SELECT COUNT(*) as total FROM cases";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$pdf->Cell(0, 10, 'Number of Cases: ' . $row['total'], 0, 1);

// Number of trainees per training
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Number of Trainees per Training:', 0, 1);
$pdf->SetFont('helvetica', '', 12);

$sql = "SELECT t.name, COUNT(tt.trainee_id) as count 
        FROM skills_training t
        LEFT JOIN trainee_trainings tt ON t.id = tt.training_id
        GROUP BY t.id";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(0, 10, $row['name'] . ': ' . $row['count'], 0, 1);
}

// Add a page for employer/company section
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, '2. Employer/Company Information', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 12);

// List of employers/companies
$sql = "SELECT id, company_name, company_address, company_contact FROM employer";
$result = $conn->query($sql);

while ($employer = $result->fetch_assoc()) {
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Company: ' . $employer['company_name'], 0, 1);
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, 10, 'Address: ' . $employer['company_address'], 0, 1);
    $pdf->Cell(0, 10, 'Contact: ' . $employer['company_contact'], 0, 1);

    // List of jobs posted by this company
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 10, 'Jobs Posted:', 0, 1);
    $pdf->SetFont('helvetica', '', 10);

    $jobSql = "SELECT job_title, job_type, salary, date_posted FROM job_post WHERE employer_id = " . $employer['id'];
    $jobResult = $conn->query($jobSql);

    while ($job = $jobResult->fetch_assoc()) {
        $pdf->Cell(0, 10, '- ' . $job['job_title'] . ' (' . $job['job_type'] . ') - ' . $job['salary'] . ' - Posted: ' . $job['date_posted'], 0, 1);

        // List of applicants for this job
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(0, 10, '  Applicants:', 0, 1);
        $pdf->SetFont('helvetica', '', 8);

        $appSql = "SELECT a.fname, a.lname, a.sex, aj.status 
                  FROM applied_job aj
                  JOIN applicant_profile a ON aj.applicant_id = a.id
                  WHERE aj.job_posting_id IN (SELECT id FROM job_post WHERE employer_id = " . $employer['id'] . " AND job_title = '" . $job['job_title'] . "')";
        $appResult = $conn->query($appSql);

        while ($applicant = $appResult->fetch_assoc()) {
            $pdf->Cell(0, 10, '  - ' . $applicant['fname'] . ' ' . $applicant['lname'] . ' (' . $applicant['sex'] . ') - Status: ' . $applicant['status'], 0, 1);
        }
    }

    // Hired males and females
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 10, 'Hired Employees:', 0, 1);
    $pdf->SetFont('helvetica', '', 10);

    // Hired males
    $maleSql = "SELECT COUNT(*) as males FROM current_employee WHERE employer_id = " . $employer['id'] . " AND gender = 'Male'";
    $maleResult = $conn->query($maleSql);
    $maleCount = $maleResult->fetch_assoc()['males'];
    $pdf->Cell(0, 10, 'Hired Males: ' . $maleCount, 0, 1);

    // Hired females
    $femaleSql = "SELECT COUNT(*) as females FROM current_employee WHERE employer_id = " . $employer['id'] . " AND gender = 'Female'";
    $femaleResult = $conn->query($femaleSql);
    $femaleCount = $femaleResult->fetch_assoc()['females'];
    $pdf->Cell(0, 10, 'Hired Females: ' . $femaleCount, 0, 1);

    $pdf->Ln(5);
}

// Add a page for OFW section
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, '3. OFW Information', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 12);

// List of OFWs
$sql = "SELECT id, first_name, last_name, occupation, country FROM ofw_profile";
$result = $conn->query($sql);

while ($ofw = $result->fetch_assoc()) {
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'OFW: ' . $ofw['first_name'] . ' ' . $ofw['last_name'], 0, 1);
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, 10, 'Occupation: ' . $ofw['occupation'] . ' in ' . $ofw['country'], 0, 1);

    // Cases for this OFW
    $caseSql = "SELECT title, description, status FROM cases WHERE user_id = " . $ofw['id'];
    $caseResult = $conn->query($caseSql);

    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 10, 'Cases:', 0, 1);
    $pdf->SetFont('helvetica', '', 10);

    while ($case = $caseResult->fetch_assoc()) {
        $pdf->Cell(0, 10, '- ' . $case['title'] . ' (' . $case['status'] . ')', 0, 1);
        $pdf->Cell(0, 10, '  ' . $case['description'], 0, 1);
    }

    $pdf->Ln(5);
}

// Total resolved cases
$resolvedSql = "SELECT COUNT(*) as resolved FROM cases WHERE status = 'result'";
$resolvedResult = $conn->query($resolvedSql);
$resolvedCount = $resolvedResult->fetch_assoc()['resolved'];
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Total Resolved Cases: ' . $resolvedCount, 0, 1);

// Add a page for Training section
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, '4. Training Information', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 12);

// List of trainings
$sql = "SELECT id, name FROM skills_training";
$result = $conn->query($sql);

while ($training = $result->fetch_assoc()) {
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Training: ' . $training['name'], 0, 1);

    // Accepted trainees
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 10, 'Accepted Trainees:', 0, 1);
    $pdf->SetFont('helvetica', '', 10);

    $acceptedSql = "SELECT tp.fname, tp.lname 
                   FROM trainee_trainings tt
                   JOIN trainees_profile tp ON tt.trainee_id = tp.id
                   WHERE tt.training_id = " . $training['id'] . " AND tt.status = 'accepted'";
    $acceptedResult = $conn->query($acceptedSql);

    while ($trainee = $acceptedResult->fetch_assoc()) {
        $pdf->Cell(0, 10, '- ' . $trainee['fname'] . ' ' . $trainee['lname'], 0, 1);
    }

    // All trainees (including pending, graduated, etc.)
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 10, 'All Trainees:', 0, 1);
    $pdf->SetFont('helvetica', '', 10);

    $allSql = "SELECT tp.fname, tp.lname, tt.status 
              FROM trainee_trainings tt
              JOIN trainees_profile tp ON tt.trainee_id = tp.id
              WHERE tt.training_id = " . $training['id'] . "
              ORDER BY tt.status";
    $allResult = $conn->query($allSql);

    while ($trainee = $allResult->fetch_assoc()) {
        $pdf->Cell(0, 10, '- ' . $trainee['fname'] . ' ' . $trainee['lname'] . ' (' . $trainee['status'] . ')', 0, 1);
    }

    $pdf->Ln(5);
}

// Close and output PDF document
$pdf->Output('peso_system_report.pdf', 'D');

// Close database connection
$conn->close();
