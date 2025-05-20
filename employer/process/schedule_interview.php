<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '../../vendor/autoload.php';

session_start();

// Verify session
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] || !isset($_SESSION['employer_id'])) {
    header("Location: ../employer_login.php");
    exit();
}

// Validate inputs
if (!isset($_POST['applicant']) || !isset($_POST['job']) || !isset($_POST['datetime'])) {
    $_SESSION['error'] = "Missing required parameters";
    header("Location: ../applicant/applicant_list.php");
    exit();
}

$applicantId = (int)$_POST['applicant'];
$jobId = (int)$_POST['job'];
$interviewDateTime = $_POST['datetime'];

// Validate datetime
try {
    $date = new DateTime($interviewDateTime);
    if ($date < new DateTime()) {
        throw new Exception("Date must be in the future");
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Invalid date: " . $e->getMessage();
    header("Location: ../applicant/applicant_list.php?job_id=".base64_encode($jobId)."&tab=interview");
    exit();
}

// Verify job ownership
$stmt = $conn->prepare("SELECT id, job_title FROM job_post WHERE id=? AND employer_id=?");
$stmt->bind_param("ii", $jobId, $_SESSION['employer_id']);
$stmt->execute();
$job = $stmt->get_result()->fetch_assoc();

if (!$job) {
    $_SESSION['error'] = "Job not found or access denied";
    header("Location: ../applicant/applicant_list.php");
    exit();
}

// Verify applicant status
$stmt = $conn->prepare("SELECT status FROM applied_job WHERE applicant_id=? AND job_posting_id=?");
$stmt->bind_param("ii", $applicantId, $jobId);
$stmt->execute();
$status = $stmt->get_result()->fetch_assoc()['status'];

if ($status !== 'Interview') {
    $_SESSION['error'] = "Applicant not in interview status";
    header("Location: ../applicant/applicant_list.php?job_id=".base64_encode($jobId)."&tab=interview");
    exit();
}

// Get applicant details
$stmt = $conn->prepare("SELECT fname, lname, email FROM applicant_profile WHERE id=?");
$stmt->bind_param("i", $applicantId);
$stmt->execute();
$applicant = $stmt->get_result()->fetch_assoc();

// Get employer details for email signature
$stmt = $conn->prepare("SELECT company_name, company_address, company_contact FROM employer WHERE id=?");
$stmt->bind_param("i", $_SESSION['employer_id']);
$stmt->execute();
$employer = $stmt->get_result()->fetch_assoc();

// Update database
$stmt = $conn->prepare("UPDATE applied_job SET interview_date=?, status='Interview Scheduled' WHERE applicant_id=? AND job_posting_id=?");
$stmt->bind_param("sii", $interviewDateTime, $applicantId, $jobId);

if ($stmt->execute()) {
    // Send email
    $emailSent = sendInterviewEmail(
        $applicant['email'], 
        $applicant['fname'] . ' ' . $applicant['lname'],
        $job['title'],
        $interviewDateTime,
        $employer['company_name'],
        $employer['company_address'],
        $employer['contact_no']
    );
    
    if ($emailSent) {
        $_SESSION['success'] = "Interview scheduled successfully and confirmation email sent!";
    } else {
        $_SESSION['warning'] = "Interview scheduled but email failed to send. Please contact the applicant directly.";
    }
} else {
    $_SESSION['error'] = "Database error occurred: " . $conn->error;
}

header("Location: ../applicant/applicant_list.php?job_id=".base64_encode($jobId)."&tab=interview");
exit();

function sendInterviewEmail($toEmail, $name, $jobTitle, $datetime, $companyName, $companyAddress, $companyContact) {
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'pesolosbanos4@gmail.com';
        $mail->Password = 'rooy awbq emme qqyt';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('pesolosbanos4@gmail.com', 'PESO Los Baños');
        $mail->addAddress($toEmail, $name);
        $mail->addReplyTo('pesolosbanos4@gmail.com', 'PESO Los Baños');

        $formattedDate = date('F j, Y \a\t g:i a', strtotime($datetime));
        $mail->isHTML(true);
        $mail->Subject = "Interview Confirmation: $jobTitle";
        
        $mail->Body = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                <h2 style='color: #2c3e50;'>Interview Confirmation</h2>
                <p>Dear $name,</p>
                <p>Your interview for <strong>$jobTitle</strong> has been scheduled.</p>
                
                <div style='background-color: #f8f9fa; padding: 15px; border-left: 4px solid #3498db; margin: 20px 0;'>
                    <p><strong>Date & Time:</strong> $formattedDate</p>
                    <p><strong>Company:</strong> $companyName</p>
                    <p><strong>Address:</strong> $companyAddress</p>
                    <p><strong>Contact:</strong> $companyContact</p>
                </div>
                
                <p>Please bring the following documents:</p>
                <ul>
                    <li>Updated resume</li>
                    <li>Valid ID</li>
                    <li>Other supporting documents</li>
                </ul>
                
                <p>Please arrive 10-15 minutes before your scheduled time.</p>
                
                <p>If you need to reschedule or have any questions, please reply to this email.</p>
                
                <p>Best regards,<br>
                $companyName<br>
                PESO Los Baños</p>
            </div>
        ";
        
        // Plain text version for non-HTML email clients
        $mail->AltBody = "Dear $name,\n\n" .
            "Your interview for $jobTitle has been scheduled for $formattedDate at $companyName.\n\n" .
            "Address: $companyAddress\n" .
            "Contact: $companyContact\n\n" .
            "Please bring your documents and arrive 10-15 minutes early.\n\n" .
            "Best regards,\n" .
            "$companyName\n" .
            "PESO Los Baños";
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mail Error: " . $mail->ErrorInfo);
        return false;
    }
}