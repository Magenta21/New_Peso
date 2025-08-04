<?php
include '../../db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);

    // Check if the email exists in the database
    $sql = "SELECT id FROM ofw_profile WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Generate a unique reset token
        $token = bin2hex(random_bytes(50)); // Generate a random token
        date_default_timezone_set('Asia/Manila'); // Adjust to your correct timezone
        $expiry_time = date("Y-m-d H:i:s", strtotime('+5 minutes')); // Token valid for 1 hour

        // Store the token and expiry time in the database
        $sql = "UPDATE ofw_profile SET reset_token = '$token', reset_token_expiry = '$expiry_time' WHERE email = '$email'";
        $conn->query($sql);

        // Send email with reset link       
        $reset_link = "http://peso.rf.gd/NEW_PESO/ofw/reset_password.php?token=" . urlencode($token);

        sendResetEmail($email, $reset_link);

        echo "<script>alert('A reset link has been sent to your email address.'); window.location.href='../ofw_login.php';</script>";
    } else {
        echo "<script>alert('No account found with that email address.'); window.location.href='../ofw_login.php';</script>";
    }

    $conn->close();
}

function sendResetEmail($email, $reset_link) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true;
        $mail->Username = 'pesolosbanos4@gmail.com'; // SMTP username
        $mail->Password = 'tjfx zrvm epvf wwyy'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('pesolosbanos4@gmail.com', 'PESO-lb.ph');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body = 'Click the following link to reset your password: <a href="' . $reset_link . '">Reset Password</a>';

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
