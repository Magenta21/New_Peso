<?php
include 'db.php'; // Make sure you have a database connection file
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $website = trim($_POST['website']);
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT); // Hash password

    try {
        $sql = "INSERT INTO users (name, email, phone, website, password) VALUES (:name, :email, :phone, :website, :password)";
        $stmt = $conn->prepare($sql);
        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':website', $website);
        $stmt->bindParam(':password', $password);

        $stmt->execute();
        
        $_SESSION['success_message'] = "Profile updated successfully!";
        header("Location: profile.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Error updating profile: " . $e->getMessage();
        header("Location: profile.php");
        exit();
    }
} else {
    header("Location: profile.php");
    exit();
}
?>
