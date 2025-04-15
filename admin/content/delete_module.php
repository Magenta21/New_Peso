<?php
header('Content-Type: application/json');

$db = new mysqli('localhost', 'root', '', 'pesoo');

if ($db->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

$module_id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($module_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid module ID']);
    exit;
}

// First get file path to delete the file
$query = "SELECT files FROM modules WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param('i', $module_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    echo json_encode(['success' => false, 'message' => 'Module not found']);
    exit;
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
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $db->error]);
}

$db->close();
?>