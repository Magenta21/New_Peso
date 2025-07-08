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
    $statusClass = "";

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
            $statusClass = "success";
        } else {
            $statusMessage = "Invalid or expired OTP. Please try again.";
            $statusClass = "error";
        }
    } else {
        $statusMessage = "No account found!";
        $statusClass = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/process_otp.css">

</head>

<body>
    <div class="header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <img src="../img/logolb.png" alt="lblogo" class="logo">
                </div>
                <div class="col-md-8 mt-2">
                    <h3 class="header-text">MUNICIPALITY OF LOS BANOS</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="otp-container">
            <h2>OTP Verification</h2>
            <p class="email-text">Verifying account for: <span class="highlight-email"><?php echo htmlspecialchars($email); ?></span></p>

            <div class="status-message <?php echo $statusClass; ?>">
                <?php echo $statusMessage; ?>
            </div>

            <?php if ($statusClass === "success"): ?>
                <a href="../employer_login.php" class="btn btn-success">Go to Login</a>
            <?php else: ?>
                <a href="../otp_verification.php?email=<?php echo urlencode($email); ?>" class="btn btn-danger">Try Again</a>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>