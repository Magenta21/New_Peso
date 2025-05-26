<?php
include '../../db.php';

session_start();

// Check if employer is logged in
if (!isset($_SESSION['employer_id']) || $_SESSION['logged_in'] !== true) {
    header("Location: employer_login.php");
    exit();
}

// Get parameters
$applicantId = $_GET['applicant'] ?? null;
$jobId = $_GET['job'] ?? null;
$status = $_GET['status'] ?? null;

// Validate parameters
if (!$applicantId || !$jobId || !$status) {
    die("Missing parameters");
}

// Verify the job belongs to this employer
$verifyQuery = "SELECT id, job_title FROM job_post WHERE id = ? AND employer_id = ?";
$stmt = $conn->prepare($verifyQuery);
$stmt->bind_param("ii", $jobId, $_SESSION['employer_id']);
$stmt->execute();
$jobResult = $stmt->get_result();

if ($jobResult->num_rows === 0) {
    die("Unauthorized action");
}
$job = $jobResult->fetch_assoc();

// Get applicant details
$applicantQuery = "SELECT fname, lname, email FROM applicant_profile WHERE id = ?";
$stmt = $conn->prepare($applicantQuery);
$stmt->bind_param("i", $applicantId);
$stmt->execute();
$applicant = $stmt->get_result()->fetch_assoc();

// Get employer details
$employerQuery = "SELECT company_name, company_address, company_contact FROM employer WHERE id = ?";
$stmt = $conn->prepare($employerQuery);
$stmt->bind_param("i", $_SESSION['employer_id']);
$stmt->execute();
$employer = $stmt->get_result()->fetch_assoc();

// Update status
$updateQuery = "UPDATE applied_job SET status = ? 
                WHERE applicant_id = ? AND job_posting_id = ?";
$stmt = $conn->prepare($updateQuery);
$stmt->bind_param("sii", $status, $applicantId, $jobId);

if ($stmt->execute()) {
    // Load PHPMailer
    require '../../vendor/autoload.php';
    
    try {
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'pesolosbanos4@gmail.com'; // Your email
        $mail->Password = 'rooy awbq emme qqyt'; // Your app password
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        // Recipients
        $mail->setFrom('pesolosbanos4@gmail.com', 'PESO Los Baños');
        $mail->addAddress($applicant['email'], $applicant['fname'] . ' ' . $applicant['lname']);
        
        // Content
        $mail->isHTML(true);
        
        if ($status === 'Accepted') {
            $mail->Subject = 'Congratulations! Your Application for ' . $job['title'] . ' Has Been Accepted';
            $mail->Body = '
                <h3>Dear ' . htmlspecialchars($applicant['fname']) . ',</h3>
                <p>We are pleased to inform you that your application for <strong>' . 
                htmlspecialchars($job['title']) . '</strong> has been <strong>accepted</strong>!</p>
                
                <h4>Next Steps:</h4>
                <ul>
                    <li>You will be contacted shortly by ' . htmlspecialchars($employer['company_name']) . '</li>
                    <li>Prepare your requirements for onboarding</li>
                </ul>
                
                <p><strong>Company:</strong> ' . htmlspecialchars($employer['company_name']) . '</p>
                <p><strong>Address:</strong> ' . htmlspecialchars($employer['company_address']) . '</p>
                <p><strong>Contact:</strong> ' . htmlspecialchars($employer['company_contact']) . '</p>
                
                <p>Welcome to the team!</p>
                <p>Sincerely,<br>PESO Los Baños</p>
            ';
        } elseif ($status === 'Rejected') {
            $mail->Subject = 'Update on Your Application for ' . $job['title'];
            $mail->Body = '
                <h3>Dear ' . htmlspecialchars($applicant['fname']) . ',</h3>
                <p>Thank you for applying for the position of <strong>' . 
                htmlspecialchars($job['title']) . '</strong> at ' . 
                htmlspecialchars($employer['company_name']) . '.</p>
                
                <p>After careful consideration, we regret to inform you that we have decided to move forward 
                with other candidates whose qualifications more closely match our current needs.</p>
                
                <p>We appreciate the time and effort you invested in your application and encourage you to 
                apply for future openings that may be a better fit for your skills and experience.</p>
                
                <p>Thank you again for your interest in ' . htmlspecialchars($employer['company_name']) . '.</p>
                
                <p>Sincerely,<br>PESO Los Baños</p>
            ';
        }
        
        $mail->send();
        $_SESSION['message'] = "Status updated and notification email sent successfully";
    } catch (Exception $e) {
        $_SESSION['warning'] = "Status updated but email failed to send: " . $mail->ErrorInfo;
    }
} else {
    $_SESSION['error'] = "Error updating status";
}

// Redirect back to applicant list
header("Location: applicant_list.php?job_id=" . base64_encode($jobId));
exit();
?>