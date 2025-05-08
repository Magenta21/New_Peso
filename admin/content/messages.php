<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

// Function to generate and download Excel report
if (isset($_POST['download_applicant_report'])) {
    // Create new Spreadsheet
    $spreadsheet = new Spreadsheet();
    
    // Remove default sheet (we'll create our own)
    $spreadsheet->removeSheetByIndex(0);
    
    // Database connection
    $conn = new mysqli("localhost", "root", "", "pesoo");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get applicant data grouped by company
    $query = "SELECT 
                aj.id, 
                aj.applicant_id, 
                aj.job_posting_id, 
                aj.application_date, 
                aj.status, 
                aj.job,
                ap.fname, 
                ap.lname, 
                ap.email, 
                ap.contact_no,
                jp.company_name,
                jp.job_title
              FROM applied_job aj
              JOIN applicant_profile ap ON aj.applicant_id = ap.id
              JOIN job_post jp ON aj.job_posting_id = jp.id
              ORDER BY jp.company_name, ap.lname, ap.fname";
    
    $result = $conn->query($query);
    
    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    // Group data by company
    $companies = [];
    while ($row = $result->fetch_assoc()) {
        $companyName = $row['company_name'];
        if (!isset($companies[$companyName])) {
            $companies[$companyName] = [];
        }
        $companies[$companyName][] = $row;
    }

    // Create a worksheet for each company
    foreach ($companies as $companyName => $applicants) {
        // Add new worksheet
        $sheet = new Worksheet($spreadsheet, substr($companyName, 0, 31));
        $spreadsheet->addSheet($sheet);
        $spreadsheet->setActiveSheetIndexByName(substr($companyName, 0, 31));
        $sheet = $spreadsheet->getActiveSheet();

        // Set company header
        $sheet->setCellValue('A1', 'Company: ' . $companyName);
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true);

        // Set column headers
        $headers = [
            'A' => 'Applicant Name',
            'B' => 'Email',
            'C' => 'Contact No',
            'D' => 'Job Applied',
            'E' => 'Application Date',
            'F' => 'Status'
        ];

        $rowNum = 3;
        foreach ($headers as $col => $header) {
            $sheet->setCellValue($col . $rowNum, $header);
        }

        // Style headers
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'DDDDDD']]
        ];
        $sheet->getStyle('A3:F3')->applyFromArray($headerStyle);

        // Add applicant data
        $rowNum = 4;
        foreach ($applicants as $applicant) {
            $sheet->setCellValue('A' . $rowNum, $applicant['lname'] . ', ' . $applicant['fname']);
            $sheet->setCellValue('B' . $rowNum, $applicant['email']);
            $sheet->setCellValue('C' . $rowNum, $applicant['contact_no']);
            $sheet->setCellValue('D' . $rowNum, $applicant['job_title']);
            $sheet->setCellValue('E' . $rowNum, $applicant['application_date']);
            $sheet->setCellValue('F' . $rowNum, $applicant['status']);
            $rowNum++;
        }

        // Auto-size columns
        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }

    // Set first sheet as active
    $spreadsheet->setActiveSheetIndex(0);

    // Save and download
    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="applicant_report_by_company.xlsx"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit;
}
?>

<!-- HTML Interface -->
<div class="page-header">
    <h1>Messages & Reports</h1>
</div>

<div class="card">
    <div class="card-header">
        <h3>Applicant Report</h3>
    </div>
    <div class="card-body">
        <p>Generate a report of all applicants grouped by the companies they applied to.</p>
        
        <form method="post">
            <button type="submit" name="download_applicant_report" class="btn btn-primary">
                <i class="fas fa-file-excel"></i> Download Excel Report
            </button>
        </form>
    </div>
</div>

</div>