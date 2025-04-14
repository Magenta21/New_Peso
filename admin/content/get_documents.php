<?php
header('Content-Type: application/json');

// Database connection
$db = new mysqli('localhost', 'root', '', 'pesoo');

if ($db->connect_error) {
    die(json_encode(['error' => 'Database connection failed']));
}

$employer_id = intval($_GET['employer_id']);
$query = "SELECT * FROM documents WHERE employer_id = ? ORDER BY created_at DESC";
$stmt = $db->prepare($query);
$stmt->bind_param('i', $employer_id);
$stmt->execute();
$result = $stmt->get_result();

$documents = [];
while ($row = $result->fetch_assoc()) {
    $documents[] = $row;
}

echo json_encode($documents);
?>