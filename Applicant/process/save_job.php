<?php
include '../../db.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['applicant_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'You must be logged in to save jobs']);
    exit;
}

// Check if job ID is provided
if (!isset($_POST['job_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Job ID is required']);
    exit;
}

$applicantId = $_SESSION['applicant_id'];
$jobId = $_POST['job_id'];

// Check if job is already saved
$checkQuery = "SELECT * FROM save_job WHERE applicant_id = ? AND job_id = ?";
$stmt = $conn->prepare($checkQuery);
$stmt->bind_param("ii", $applicantId, $jobId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Job already saved - unsave it
    $deleteQuery = "DELETE FROM save_job WHERE applicant_id = ? AND job_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("ii", $applicantId, $jobId);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Job unsaved successfully', 'action' => 'unsave']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to unsave job']);
    }
} else {
    // Save the job
    $insertQuery = "INSERT INTO save_job (applicant_id, job_id) VALUES (?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ii", $applicantId, $jobId);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Job saved successfully', 'action' => 'save']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save job']);
    }
}

$stmt->close();
$conn->close();
?>