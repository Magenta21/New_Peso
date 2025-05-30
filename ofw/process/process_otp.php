<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    date_default_timezone_set('Asia/Manila'); // Ensure timezone is set

    $email = $_POST['email'];
    $otp = $_POST['otp'];

    $pdo = new PDO("mysql:host=localhost;dbname=pesoo;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch OTP details from database
    $stmt = $pdo->prepare("SELECT otp, otp_expiry FROM ofw_profile WHERE email = :email AND is_verified = 0");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        date_default_timezone_set('Asia/Manila'); // Ensure Manila time is used
        $current_time = date('Y-m-d H:i:s'); // Current Manila time
        $otp_expiry = $user['otp_expiry'];
    
        // Debugging: Check fetched OTP and expiry time
        // var_dump($user['otp'], $otp, $current_time, $otp_expiry);
    
        // Ensure both OTP values are treated as strings before comparing
        if (strval($user['otp']) === strval($otp) && $current_time <= $otp_expiry) {
            // Mark account as verified
            $stmt = $pdo->prepare("UPDATE ofw_profile SET is_verified = 1 WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
    
            header("Location: ../ofw_home.php");
        } else {
            echo "Invalid or expired OTP. <a href='../otp_verification.php?email=" . urlencode($email) . "'>Try Again</a>";
        }
    } else {
        echo "No account found!";
    }
    
}

?>
