<?php
require '../../db.php'; // Database connection

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);

    $response = ["usernameTaken" => false, "emailTaken" => false];

    try {
        $pdo = new PDO("mysql:host=sql305.infinityfree.com;dbname=if0_39380841_peso;charset=utf8", "if0_39380841", "pesolosbanos4");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if username exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM ofw_profile WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        if ($stmt->fetchColumn() > 0) {
            $response["usernameTaken"] = true;
        }

        // Check if email exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM ofw_profile WHERE email = :email");
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
