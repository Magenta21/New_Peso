<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    date_default_timezone_set('Asia/Manila'); // Ensure timezone is set

    $email = $_POST['email'];
    $otp = $_POST['otp'];

    $pdo = new PDO("mysql:host=localhost;dbname=pesoo;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch OTP details from database
    $stmt = $pdo->prepare("SELECT otp, otp_expiry FROM employer WHERE email = :email AND is_verified = 0");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $statusMessage = "";
    $redirect = "../employer_login.php";

    if ($user) {
        date_default_timezone_set('Asia/Manila');
        $current_time = date('Y-m-d H:i:s'); // Current Manila time
        $otp_expiry = $user['otp_expiry'];

        if ($user['otp'] == $otp && $current_time <= $otp_expiry) {
            // Mark account as verified
            $stmt = $pdo->prepare("UPDATE employer SET is_verified = 1 WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $statusMessage = "OTP Verified! Your account is now activated.";
        } else {
            $statusMessage = "Invalid or expired OTP. Please try again.";
            $redirect = "../otp_verification.php?email=" . urlencode($email);
        }
    } else {
        $statusMessage = "No account found!";
        $redirect = "../otp_verification.php?email=" . urlencode($email);
    }

    // Output JavaScript for alert and redirect
    echo "<script>
        alert('" . addslashes($statusMessage) . "');
        window.location.href = '" . $redirect . "';
    </script>";
    exit();
}

// If not a POST request, redirect to login
header("Location: ../employer_login.php");
exit();
