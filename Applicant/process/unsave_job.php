<?php
include '../../db.php';
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo json_encode(['status' => 'error', 'message' => 'You must be logged in to unsave jobs']);
    exit;
}

if (!isset($_POST['job_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Job ID is required']);
    exit;
}

$applicantId = $_SESSION['applicant_id'];
$jobId = $_POST['job_id'];

$query = "DELETE FROM save_job WHERE applicant_id = ? AND job_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $applicantId, $jobId);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Job unsaved successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to unsave job']);
}

$stmt->close();
$conn->close();
?>