<?php
// Database connection
$db = new mysqli('localhost', 'root', '', 'pesoo');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$module_id = $_GET['id'] ?? 0;
$training = $_GET['training'] ?? '';

if ($module_id <= 0) {
    die("Invalid module ID");
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
    if (file_exists($row['files'])) {
        unlink($row['files']);
    }
    header("Location: ?page=training&action=view_modules&training=$training&success=Module deleted successfully");
} else {
    header("Location: ?page=training&action=view_modules&training=$training&error=" . urlencode("Database error: " . $db->error));
}

$db->close();
?>