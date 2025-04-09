<?php
require '../../db.php'; // Database connection

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);

    $response = ["usernameTaken" => false, "emailTaken" => false];

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=pesoo;charset=utf8", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if username exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM admin_profile WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        if ($stmt->fetchColumn() > 0) {
            $response["usernameTaken"] = true;
        }

        // Check if email exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM admin_profile WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        if ($stmt->fetchColumn() > 0) {
            $response["emailTaken"] = true;
        }

    } catch (PDOException $e) {
        $response["error"] = "Database error: " . $e->getMessage();
    }

    echo json_encode($response);
}
?>
