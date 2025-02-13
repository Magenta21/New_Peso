<?php
include 'db.php';

if (isset($_GET['id'])) {
    $jobId = (int)$_GET['id'];

    // Fetch job details
    $query = "SELECT * FROM job_post WHERE id = $jobId";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $job = $result->fetch_assoc();
        echo json_encode($job);
    } else {
        echo json_encode(["error" => "Job not found"]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}
?>
