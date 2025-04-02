<?php
include '../../db.php';
session_start();

if (!isset($_SESSION['applicant_id']) {
    echo json_encode(['is_saved' => false]);
    exit;
}

if (!isset($_GET['job_id'])) {
    echo json_encode(['is_saved' => false]);
    exit;
}

$applicantId = $_SESSION['applicant_id'];
$jobId = $_GET['job_id'];

$query = "SELECT * FROM save_job WHERE applicant_id = ? AND job_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $applicantId, $jobId);
$stmt->execute();
$result = $stmt->get_result();

echo json_encode(['is_saved' => $result->num_rows > 0]);

$stmt->close();
$conn->close();
?>