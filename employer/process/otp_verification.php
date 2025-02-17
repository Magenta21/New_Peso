<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $otp = $_POST['otp'];

    $pdo = new PDO("mysql:host=localhost;dbname=peso2;charset=utf8", "root", "");
    $stmt = $pdo->prepare("SELECT otp, otp_expiry FROM employer WHERE email = :email AND is_verified = 0");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $user['otp'] == $otp && strtotime($user['otp_expiry']) > time()) {
        $stmt = $pdo->prepare("UPDATE employer SET is_verified = 1 WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        echo "OTP Verified! You can now log in.";
    } else {
        echo "Invalid or expired OTP!";
    }
}
?>
