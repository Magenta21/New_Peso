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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/otp_ver.css">
    <title>OTP Verification</title>
</head>

<body>
    <div class="header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-2 col-xxl-3 text-start">
                    <a href="../index.php" style="display: block; text-decoration: none;">
                        <img src="../img/logolb.png" alt="lblogo" style="height: 50px;">
                    </a>
                </div>
                <div class="col-md-8 col-xxl-6 text-center">
                    <h3 style="margin-top: 5px; font-weight: 700; color: #ffffff;">MUNICIPALITY OF LOS BANOS</h3>
                </div>
            </div>
        </div>
    </div>
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
                    <label>Enter OTP:</label>
                    <input type="text" name="otp" class="otp-input" required>
            </div>
            <div class="row mb-3">
                <div class="col-8">

                </div>
                <div class="col-4">
                    <button type="submit" class="btn btn-primary verify-btn">Verify</button>
                </div>
                <div class="col-8">

                </div>
                <div class="col-4 mt-4">
                    <a href="process/resend_otp.php?email=<?php echo urlencode($email); ?>" class="btn btn-secondary">Resend OTP</a>
                </div>
            </div>
        </div>
        </form>
    </div>
</body>

</html>