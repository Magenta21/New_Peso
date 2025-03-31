<?php
session_start();

// Database connection
$host = 'localhost';
$dbname = 'pesoo';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Get user ID from session
$user_id = $_SESSION['applicant_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $companies = $_POST['company'] ?? [];
    $addresses = $_POST['address'] ?? [];
    $positions = $_POST['position'] ?? [];
    $start_dates = $_POST['start_date'] ?? [];
    $end_dates = $_POST['end_date'] ?? [];
    $statuses = $_POST['status'] ?? [];

    // Prepare SQL for insertion
    $sql = "INSERT INTO work_exp (user_id, company_name, address, position, started_date, termination_date, status) 
            VALUES (:user_id, :company, :address, :position, :started_date, :termination_date, :status)";
    $stmt = $pdo->prepare($sql);

    for ($i = 0; $i < count($companies); $i++) {
        $stmt->execute([
            ':user_id' => $user_id,
            ':company' => $companies[$i],
            ':address' => $addresses[$i],
            ':position' => $positions[$i],
            ':started_date' => $start_dates[$i],
            ':termination_date' => $end_dates[$i],
            ':status' => $statuses[$i]
        ]);
    }

    header('Location: ../applicant_profile.php');
    exit();
} else {
    header('Location: ../applicant_profile.php');
    exit();
}
?>
