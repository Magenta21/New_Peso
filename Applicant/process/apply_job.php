<?php
include '../../db.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['applicant_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'You must be logged in to apply for jobs']);
    exit;
}

// Check if job ID is provided
if (!isset($_POST['job_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Job ID is required']);
    exit;
}

$applicantId = $_SESSION['applicant_id'];
$jobId = $_POST['job_id'];
$currentDate = date('Y-m-d');

// Check if already applied
$checkQuery = "SELECT * FROM applied_job WHERE applicant_id = ? AND job_posting_id = ?";
$stmt = $conn->prepare($checkQuery);
$stmt->bind_param("ii", $applicantId, $jobId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'You have already applied for this job']);
    exit;
}

// Get job title for the application record
$jobQuery = "SELECT job_title FROM job_post WHERE id = ?";
$stmt = $conn->prepare($jobQuery);
$stmt->bind_param("i", $jobId);
$stmt->execute();
$jobResult = $stmt->get_result();

if ($jobResult->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Job not found']);
    exit;
}

$job = $jobResult->fetch_assoc();
$jobTitle = $job['job_title'];

// Insert application
$insertQuery = "INSERT INTO applied_job (applicant_id, job_posting_id, application_date, status, job) 
                VALUES (?, ?, ?, 'Pending', ?)";
$stmt = $conn->prepare($insertQuery);
$stmt->bind_param("iiss", $applicantId, $jobId, $currentDate, $jobTitle);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Application submitted successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to submit application']);
}

$stmt->close();
$conn->close();
?>