<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../db.php';
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '../../vendor/autoload.php';

// Verify session
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] || !isset($_SESSION['employer_id'])) {
    header("Location: employer_login.php");
    exit();
}

// Validate inputs
if (!isset($_GET['applicant']) || !isset($_GET['job']) || !isset($_GET['datetime'])) {
    $_SESSION['error'] = "Missing required parameters";
    header("Location: applicant_list.php");
    exit();
}

$applicantId = (int)$_GET['applicant'];
$jobId = (int)$_GET['job'];
$interviewDateTime = $_GET['datetime'];

// Validate datetime
try {
    $date = new DateTime($interviewDateTime);
    if ($date < new DateTime()) {
        throw new Exception("Date must be in the future");
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Invalid date: " . $e->getMessage();
    header("Location: applicant_list.php?job_id=".base64_encode($jobId)."&tab=interview");
    exit();
}

// Verify job ownership
$stmt = $conn->prepare("SELECT id, title FROM job_postings WHERE id=? AND employer_id=?");
$stmt->bind_param("ii", $jobId, $_SESSION['employer_id']);
$stmt->execute();
$job = $stmt->get_result()->fetch_assoc();

if (!$job) {
    $_SESSION['error'] = "Job not found or access denied";
    header("Location: applicant_list.php");
    exit();
}

// Verify applicant status
$stmt = $conn->prepare("SELECT status FROM applied_job WHERE applicant_id=? AND job_posting_id=?");
$stmt->bind_param("ii", $applicantId, $jobId);
$stmt->execute();
$status = $stmt->get_result()->fetch_assoc()['status'];

if ($status !== 'Interview') {
    $_SESSION['error'] = "Applicant not in interview status";
    header("Location: applicant_list.php?job_id=".base64_encode($jobId)."&tab=interview");
    exit();
}

// Get applicant details
$stmt = $conn->prepare("SELECT fname, lname, email FROM applicant_profile WHERE id=?");
$stmt->bind_param("i", $applicantId);
$stmt->execute();
$applicant = $stmt->get_result()->fetch_assoc();

// Update database
$stmt = $conn->prepare("UPDATE applied_job SET interview_date=?, status='Interview Scheduled' WHERE applicant_id=? AND job_posting_id=?");
$stmt->bind_param("sii", $interviewDateTime, $applicantId, $jobId);

if ($stmt->execute()) {
    // Send email notification
    $mailSent = sendInterviewEmail(
        $applicant['email'],
        $applicant['fname'],
        $job['title'],
        $interviewDateTime
    );
    
    if ($mailSent === true) {
        // Store success alert data
        $_SESSION['interview_alert'] = [
            'success' => true,
            'name' => $applicant['fname'] . ' ' . $applicant['lname'],
            'email' => $applicant['email'],
            'date' => date('F j, Y \a\t g:i a', strtotime($interviewDateTime)),
            'job_title' => $job['title']
        ];
    } else {
        $_SESSION['warning'] = "Interview scheduled but email failed to send";
    }
} else {
    $_SESSION['error'] = "Database error occurred: " . $conn->error;
}

header("Location: ../jobpages/applicant_list.php?job_id=".base64_encode($jobId)."&tab=interview");
exit();

function sendInterviewEmail($toEmail, $name, $jobTitle, $datetime) {
    $mail = new PHPMailer(true);
    
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'jervinguevarra123@gmail.com';
        $mail->Password = 'wdul asom bddj yhfd';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('jervinguevarra123@gmail.com', 'PESO Los Baños');
        $mail->addAddress($toEmail, $name);

        $formattedDate = date('F j, Y \a\t g:i a', strtotime($datetime));
        $mail->isHTML(true);
        $mail->Subject = "Interview Confirmation: $jobTitle";
        
        $mail->Body = "<h3>Dear $name,</h3>
                      <p>Your interview for <strong>$jobTitle</strong> has been scheduled.</p>
                      <p><strong>Date:</strong> $formattedDate</p>
                      <p>Please bring your documents and arrive 10 minutes early.</p>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mail Error: " . $mail->ErrorInfo);
        return false;
    }
}