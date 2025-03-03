<?php
include '../../db.php';
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['job_id'])) {
    $jobId = $_POST['job_id'];

    // Get current status
    $query = "SELECT is_active FROM job_post WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $jobId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $newStatus = $row['is_active'] == 1 ? 0 : 1;

        // Update status
        $updateQuery = "UPDATE job_post SET is_active = ? WHERE id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ii", $newStatus, $jobId);

        if ($stmt->execute()) {
            header("Location: ../job_list.php?success=Job updated successfully");
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Update failed']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Job not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
