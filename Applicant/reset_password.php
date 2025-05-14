<?php
include '../db.php';

// Initialize variables
$token = null;
$email = null;

// Check if the token is set
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verify the token
    $sql = "SELECT email, reset_token_expiry FROM applicant_profile WHERE reset_token = '$token' AND reset_token_expiry > NOW()";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Token is valid
        $row = $result->fetch_assoc();
        $email = $row['email'];
    } else {
        echo "Invalid or expired token.";
        exit;
    }
} else {
    echo "No token provided.";
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/reset_pass.css" defer>
    <style>
         
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="reset-card">
        <div class="reset-header">
            <h2>Reset Password</h2>
        </div>
        <div class="reset-body">
            <form action="process/update_password.php" method="POST">
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" name="new_password" id="new_password" required>
                </div>
                <button type="submit" class="reset-btn">Update Password</button>
            </form>
        </div>
    </div>
</body>
</html>