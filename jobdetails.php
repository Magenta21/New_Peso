<?php
include 'db.php';

if (!isset($_GET['id'])) {
    echo "<p>Invalid job listing.</p>";
    exit;
}

$jobId = (int)$_GET['id'];

// Fetch job details
$query = "SELECT * FROM job_post WHERE id = $jobId";
$result = $conn->query($query);

if ($result->num_rows === 0) {
    echo "<p>Job not found.</p>";
    exit;
}

$job = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($job['job_title']) ?> - Job Details</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="joblist.css">
</head>
<body>
<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <a href="index.php" style="display: block; text-decoration: none;">
                    <img src="img/logolb.png" alt="lblogo" style="height: 50px;">
                </a>
            </div>
            <div class="col-md-8">
                <h3 style="margin-top: 5px; font-weight: 900; color: #ffffff;">Job Listings</h3>
            </div>
        </div>
    </div>
</div>
<div class="container mt-5">
    <a href="joblist.php" class="btn btn-primary mb-3"><i class="bi bi-arrow-left"></i> Back to Job Listings</a>
    
    <div class="card shadow">
        <div class="card-body">
            <h3 class="card-title"><?= htmlspecialchars($job['job_title']) ?></h3>
            <h5 class="text-muted"><?= htmlspecialchars($job['company_name']) ?></h5>
            <p><strong>Location:</strong> <?= htmlspecialchars($job['work_location']) ?></p>
            <p><strong>Salary:</strong> <?= htmlspecialchars($job['salary']) ?></p>
            <p><strong>Vacancies:</strong> <?= htmlspecialchars($job['vacant']) ?></p>
            <p><strong>Job Type:</strong> <?= htmlspecialchars($job['job_type']) ?></p>
            <p><strong>Education:</strong> <?= htmlspecialchars($job['education']) ?></p>
            <p><strong>Job Description:</strong> <?= nl2br(htmlspecialchars($job['job_description'])) ?></p>
            <p><strong>Requirements:</strong> <?= nl2br(htmlspecialchars($job['requirement'])) ?></p>
            <p><strong>Posted On:</strong> <?= htmlspecialchars($job['date_posted']) ?></p>
        </div>
    </div>
</div>

</body>
</html>
