<?php
if (isset($_GET['email'])) {
    $email = $_GET['email'];

    // Load Composer's autoloader (if using Composer)
    require '../../vendor/autoload.php';

    // Generate new OTP and expiry time
    date_default_timezone_set('Asia/Manila');
    $otp = rand(100000, 999999);
    $otp_expiry = date('Y-m-d H:i:s', strtotime('+10 minutes')); // OTP valid for 10 minutes

    try {
        $pdo = new PDO("mysql:host=sql305.localhost.com;dbname=pesoo;charset=utf8", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Update OTP in database
        $stmt = $pdo->prepare("UPDATE ofw_profile SET otp = :otp, otp_expiry = :otp_expiry WHERE email = :email AND is_verified = 0");
        $stmt->bindParam(':otp', $otp);
        $stmt->bindParam(':otp_expiry', $otp_expiry);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Create PHPMailer instance
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();                                      // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';               // Set your SMTP server
            $mail->SMTPAuth   = true;                             // Enable SMTP authentication
            $mail->Username   = 'pesolosbanos4@gmail.com';         // SMTP username
            $mail->Password   = 'rooy awbq emme qqyt';            // SMTP password
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
            $mail->Port       = 587;                              // TCP port to connect to

            // Recipients
            $mail->setFrom('pesolosbanos4@gmail.com', 'PESO-lb.ph');
            $mail->addAddress($email);                            // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Your New OTP Code';
            $mail->Body    = '
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; }
                        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                        .otp-code { 
                            font-size: 24px; 
                            font-weight: bold; 
                            color: #0066cc;
                            margin: 20px 0;
                        }
                        .note {
                            color: #666;
                            font-size: 14px;
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <h2>OTP Verification</h2>
                        <p>Your new OTP code is:</p>
                        <div class="otp-code">' . $otp . '</div>
                        <p class="note">This code is valid for 10 minutes. Please do not share this code with anyone.</p>
                        <p>If you didn\'t request this OTP, please ignore this email.</p>
                    </div>
                </body>
                </html>
            ';

            $mail->AltBody = "Your new OTP code is: $otp\nThis code is valid for 10 minutes. Please do not share this code with anyone.";

            $mail->send();

            // Redirect back with success message
            header("Location: ../otp_verification.php?email=" . urlencode($email) . "&resend=success");
            exit;
        } catch (Exception $e) {
            // Log error and redirect with error message
            error_log("Mailer Error: " . $mail->ErrorInfo);
            header("Location: ../otp_verification.php?email=" . urlencode($email) . "&error=mail_failed");
            exit;
        }
    } catch (PDOException $e) {
        // Handle database errors
        error_log("Database Error: " . $e->getMessage());
        header("Location: ../otp_verification.php?email=" . urlencode($email) . "&error=database_error");
        exit;
    }
} else {
    header("Location: ../otp_verification.php?error=no_email");
    exit;
}
