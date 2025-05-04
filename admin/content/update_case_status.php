<?php
require_once '../../db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['case_id']) || !isset($_POST['new_status'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$case_id = intval($_POST['case_id']);
$new_status = in_array($_POST['new_status'], ['filed', 'in_progress', 'resolved']) ? 
    str_replace('_', ' ', $_POST['new_status']) : 'filed';

$query = "UPDATE cases SET status = ? WHERE id = ?";
$stmt = $conn ->prepare($query);
$stmt->bind_param('si', $new_status, $case_id);
$result = $stmt->execute();

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $conn->error]);
}

$stmt->close();
?>