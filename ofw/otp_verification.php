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
    <title>OTP Verification</title>
</head>
<body>
    <h2>Verify Your Email</h2>
    <p>An OTP has been sent to your email: <strong><?php echo htmlspecialchars($email); ?></strong></p>
    <form action="process/process_otp.php" method="POST">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
        <label>Enter OTP:</label>
        <input type="text" name="otp" required>
        <button type="submit">Verify</button>
    </form>
</body>
</html>
