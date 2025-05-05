<?php
include '../db.php';

// Check if the token is set
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verify the token
    $sql = "SELECT email, reset_token_expiry FROM admin_profile WHERE reset_token = '$token' AND reset_token_expiry > NOW()";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
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
</head>
<body>
    <h2>Reset Password</h2>
    <form action="process/update_password.php" method="POST">
        <input type="hidden" name="email" value="<?php echo $email; ?>">
        <input type="hidden" name="token" value="<?php echo $token; ?>">
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
