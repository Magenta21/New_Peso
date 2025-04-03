<?php
include '../../db.php';
session_start();

// Check if employer is logged in
if (!isset($_SESSION['employer_id']) || $_SESSION['logged_in'] !== true) {
    header("Location: employer_login.php");
    exit();
}

// Get parameters
$applicantId = $_GET['applicant'] ?? null;
$jobId = $_GET['job'] ?? null;
$status = $_GET['status'] ?? null;

// Validate parameters
if (!$applicantId || !$jobId || !$status) {
    die("Missing parameters");
}

// Verify the job belongs to this employer
$verifyQuery = "SELECT id FROM job_post WHERE id = ? AND employer_id = ?";
$stmt = $conn->prepare($verifyQuery);
$stmt->bind_param("ii", $jobId, $_SESSION['employer_id']);
$stmt->execute();
if ($stmt->get_result()->num_rows === 0) {
    die("Unauthorized action");
}

// Update status
$updateQuery = "UPDATE applied_job SET status = ? 
                WHERE applicant_id = ? AND job_posting_id = ?";
$stmt = $conn->prepare($updateQuery);
$stmt->bind_param("sii", $status, $applicantId, $jobId);

if ($stmt->execute()) {
    // Redirect back with success message
    $_SESSION['message'] = "Status updated successfully";
} else {
    $_SESSION['error'] = "Error updating status";
}

// Redirect back to applicant list
header("Location: applicant_list.php?job_id=" . base64_encode($jobId));
exit();
?>