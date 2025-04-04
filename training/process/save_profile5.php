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
    $languages = $_POST['language'] ?? [];
    $read = $_POST['read'] ?? [];
    $write = $_POST['write'] ?? [];
    $speak = $_POST['speak'] ?? [];
    $understand = $_POST['understand'] ?? [];

    // Prepare SQL for insertion
    $sql = "INSERT INTO language_proficiency (user_id, language_p, read_i, write_i, speak_i, understand_i) 
            VALUES (:user_id, :language, :read_l, :write_l, :speak_l, :understand_l)";
    
    $stmt = $pdo->prepare($sql);

    foreach ($languages as $index => $language) {
        // Ensure checkboxes are handled correctly
        $read_l = isset($read[$index]) ? 1 : 0;
        $write_l = isset($write[$index]) ? 1 : 0;
        $speak_l = isset($speak[$index]) ? 1 : 0;
        $understand_l = isset($understand[$index]) ? 1 : 0;

        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':language', $language);
        $stmt->bindParam(':read_l', $read_l);
        $stmt->bindParam(':write_l', $write_l);
        $stmt->bindParam(':speak_l', $speak_l);
        $stmt->bindParam(':understand_l', $understand_l);
        $stmt->execute();
    }

    header('Location: ../training_profile.php');
    exit();
}
else {
    // Redirect to the form if accessed directly
    header('Location: ../training_profile.php');
    exit();
}
?>
