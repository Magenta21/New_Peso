<?php
if (!isset($_GET['email'])) {
    echo "Invalid request!";
    exit;
}

$email = $_GET['email']; // Get the email from URL
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/otp.css">
</head>

<body>


    <div class="container">
        <div class="otp-container">
            <h2>Verify Your Email</h2>
            <p>An OTP has been sent to your email:
                <span class="highlight-email"><?php echo htmlspecialchars($email); ?></span>
            </p>
            <form action="process/process_otp.php" method="POST">
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <label>Enter OTP:</label>
                <input type="text" name="otp" class="otp-input" required>
                <button type="submit" class="btn btn-primary verify-btn">Verify</button>
                <br> <br>
                <a href="process/resend_otp.php?email=<?php echo urlencode($email); ?>" class="btn btn-secondary">Resend OTP</a>
            </form>
        </div>
    </div>
</body>

</html>