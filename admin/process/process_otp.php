<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $otp = $_POST['otp'];

    $pdo = new PDO("mysql:host=localhost;dbname=pesoo;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch OTP details from database
    $stmt = $pdo->prepare("SELECT otp FROM admin_profile WHERE email = :email AND is_verified = 0");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {

        if ($user['otp'] == $otp) {
            // Mark account as verified
            $stmt = $pdo->prepare("UPDATE admin_profile SET is_verified = 1 WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            header("Location: ../admin_login.php");
        } else {
            echo "Invalid or expired OTP. <a href='../otp_verification.php?email=" . urlencode($email) . "'>Try Again</a>";
        }
    } else {
        echo "No account found!";
    }
}
