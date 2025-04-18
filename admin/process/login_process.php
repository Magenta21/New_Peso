<?php
session_start(); // Start session

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernameOrEmail = $_POST['username'];
    $password = $_POST['password'];

    // Database connection
    $pdo = new PDO("mysql:host=localhost;dbname=pesoo;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    try {
        // Fetch user details by username or email
        $stmt = $pdo->prepare("SELECT * FROM admin_profile WHERE (username = :username OR email = :email) AND is_verified = 1");
        $stmt->bindParam(':username', $usernameOrEmail);
        $stmt->bindParam(':email', $usernameOrEmail);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['Passwords'])) {
            // Set session variables
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['admin_name'] = $user['fname'];
            $_SESSION['logged_in'] = true;

            // Redirect to employer dashboard
            header("Location: ../admin_home.php");
            exit();
        } else {
            echo "<script> alert('Invalid username or password'); window.location.href='../admin_login.php' </script>";
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    echo "<script> alert('Unauthorized access!'); window.location.href='../admin_login.php' </script>";
}
?>
