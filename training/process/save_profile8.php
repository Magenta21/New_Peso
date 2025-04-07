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

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['selectedOptions'])) {
        // Get selected skills from the form
        $skills = trim($_POST['selectedOptions']); // Comma-separated string

        // Check if the user already has a record
        $checkSql = "SELECT id FROM applicant_profile WHERE id = :user_id";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute([':user_id' => $user_id]);
        $existingRecord = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($existingRecord) {
            // Update existing record
            $sql = "UPDATE applicant_profile SET selected_option = :skills WHERE id = :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':user_id' => $user_id,
                ':skills' => $skills
            ]);
        }
        // If no record exists, do nothing (no insert)
    }
    
    // Redirect back
    header('Location: ../training_profile.php');
    exit();
}
?>
