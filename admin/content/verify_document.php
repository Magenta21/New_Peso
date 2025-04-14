<?php
header('Content-Type: application/json');

// Database connection
$db = new mysqli('localhost', 'root', '', 'pesoo');

if ($db->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

$doc_id = intval($_POST['doc_id']);
$status = intval($_POST['status']);
$comment = $db->real_escape_string($_POST['comment']);

$query = "UPDATE documents SET is_verified = ?, comment = ? WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param('isi', $status, $comment, $doc_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $db->error]);
}
?>