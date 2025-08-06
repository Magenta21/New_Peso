<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session properly
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database configuration
$host = 'localhost';
$db = 'pesoo';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check authentication
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    die("Unauthorized access");
}

$trainingid = $_SESSION['ofw_id'];

try {
    // Prepare SQL statement with named parameters
    $sql = "UPDATE ofw_profile SET 
            spouse_name = :spouse_name, 
            spouse_contact = :spouse_contact, 
            fathers_name = :fathers_name, 
            fathers_address = :fathers_address, 
            mothers_name = :mothers_name, 
            mothers_address = :mothers_address, 
            emergency_contact_name = :emergency_contact_name, 
            emergency_contact_number = :emergency_contact_number 
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    
    // Bind parameters with explicit data types
    $stmt->bindParam(':spouse_name', $_POST['spouse_name'], PDO::PARAM_STR);
    $stmt->bindParam(':spouse_contact', $_POST['spouse_contact'], PDO::PARAM_STR);
    $stmt->bindParam(':fathers_name', $_POST['fathers_name'], PDO::PARAM_STR);
    $stmt->bindParam(':fathers_address', $_POST['fathers_address'], PDO::PARAM_STR);
    $stmt->bindParam(':mothers_name', $_POST['mothers_name'], PDO::PARAM_STR);
    $stmt->bindParam(':mothers_address', $_POST['mothers_address'], PDO::PARAM_STR);
    $stmt->bindParam(':emergency_contact_name', $_POST['emergency_contact_name'], PDO::PARAM_STR);
    $stmt->bindParam(':emergency_contact_number', $_POST['emergency_contact_number'], PDO::PARAM_STR);
    $stmt->bindParam(':id', $trainingid, PDO::PARAM_INT);

    // Execute the statement
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Family information updated successfully!";
    } else {
        $_SESSION['error_message'] = "Failed to update family information.";
    }
    
    // Redirect back to profile page
    header("Location: ../ofw_profile.php");
    exit();

} catch (PDOException $e) {
    // Log the error
    error_log("Database error: " . $e->getMessage());
    
    // Set error message
    $_SESSION['error_message'] = "A database error occurred. Please try again.";
    
    // Redirect back
    header("Location: ../ofw_profile.php");
    exit();
}
?>