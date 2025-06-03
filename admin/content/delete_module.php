<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header('Location: admin_login.php');
    exit;
}
// Database connection
$db = new mysqli('localhost', 'root', '', 'pesoo');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$module_id = $_GET['id'] ?? 0;
$training_id = $_GET['training_id'] ?? 0;

if ($module_id <= 0 || $training_id <= 0) {
    die("Invalid module ID or training ID");
}

// First get file path to delete the file
$query = "SELECT files FROM modules WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param('i', $module_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("Module not found");
}

// Delete the record
$query = "DELETE FROM modules WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param('i', $module_id);

if ($stmt->execute()) {
    // Delete the file
    if (!empty($row['files']) && file_exists($row['files'])) {
        unlink($row['files']);
    }
    $db->close();
    header("Location: ../admin_home.php");
    exit(); // Add this to stop script execution after redirect
} else {
    $db->close();
    header("Location: ../admin_home.php");
    exit();
}