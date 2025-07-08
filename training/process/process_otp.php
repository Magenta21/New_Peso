<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    date_default_timezone_set('Asia/Manila');

    $email = $_POST['email'];
    $otp = $_POST['otp'];
    $training_id = $_POST['training_id']; // Get training_id from form

    $pdo = new PDO("mysql:host=localhost;dbname=pesoo;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch OTP details from database
    $stmt = $pdo->prepare("SELECT otp, otp_expiry FROM trainees_profile WHERE email = :email AND is_verified = 0");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        date_default_timezone_set('Asia/Manila');
        $current_time = date('Y-m-d H:i:s');
        $otp_expiry = $user['otp_expiry'];

        if ($user['otp'] == $otp && $current_time <= $otp_expiry) {
            // Mark account as verified
            $stmt = $pdo->prepare("UPDATE trainees_profile SET is_verified = 1 WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // Redirect with training_id
            header("Location: ../training_login.php?training=" . $training_id);
            exit();
        } else {
            echo "Invalid or expired OTP. <a href='../otp_verification.php?email=" . urlencode($email) . "&training_id=" . $training_id . "'>Try Again</a>";
            exit;
        }
    } else {
        header("Location: ../otp_verification.php?email=" . urlencode($email) . "&error=no_account");
        exit;
    }
}
