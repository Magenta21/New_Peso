<?php
if (!isset($_GET['email']) || !isset($_GET['training_id'])) {
    echo "Invalid request!";
    exit;
}

$email = $_GET['email'];
$training_id = $_GET['training_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/otp.css">
    <title>OTP Verification</title>
</head>
<body>
    <div class="container mt-5">
        <div class="container-fluid bg-white shadow-lg w-50 mx-auto text-center p-3">
            <div class="row mb-2">
                <h2>Verify Your Email</h2>
            </div>
            <div class="row mb-1">
                <p>An OTP has been sent to your email: 
                    <span class="highlight-email"><?php echo htmlspecialchars($email); ?></span>
                </p>
            </div>
            <div class="row mb-1">
                <form action="process/process_otp.php" method="POST">
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                    <input type="hidden" name="training_id" value="<?php echo htmlspecialchars($training_id); ?>">
                    <label>Enter OTP:</label>
                    <input type="text" name="otp" class="otp-input" required>
            </div>
            <div class="row mb-1">
                <div class="col-8"></div>
                <div class="col-4 ">
                    <button type="submit" class="btn btn-primary verify-btn">Verify</button>
                </div>
            </div>
        </div>
            </form>
    </div>
</body>
</html>