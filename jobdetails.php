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
    <style>
        .skeleton {
    background: rgb(255, 255, 255);
    height: 50px;
    border-radius: 4px;
    margin-top: 5px;
    border: 3px solid #ccc; /* Add border */
    padding: 5px; /* Add padding for spacing */
}

        
        .scrollable-box {
            max-height: 150px; /* Adjust height as needed */
            overflow-y: auto;
            padding: 10px;
            border: 1px solid #ccc;
            background: #f9f9f9;
            border-radius: 5px;
        }
        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            cursor: pointer;
        }
    </style>
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
    <p><strong>Posted:</strong> <?= htmlspecialchars($job['date_posted']) ?></p>

    <div class="card shadow p-4">
        <div class="row">
            <!-- Left Column -->
            <div class="col-md-6">
                <p><strong>Company</strong></p>
                <div class="skeleton"><?= htmlspecialchars($job['company_name']) ?></div>

                <p><strong>Job Type</strong></p>
                <div class="skeleton"><?= htmlspecialchars($job['job_type']) ?></div>

                <p><strong>Description</strong></p>
                <div class="scrollable-box"><?= nl2br(htmlspecialchars($job['job_description'])) ?></div>
            </div>

            <!-- Right Column -->
            <div class="col-md-6">
                <p><strong>Location</strong></p>
                <div class="skeleton"><?= htmlspecialchars($job['work_location']) ?></div>

                <p><strong>Salary</strong></p>
                <div class="skeleton"><?= htmlspecialchars($job['salary']) ?></div>

                <p><strong>Requirements</strong></p>
                <div class="scrollable-box"><?= nl2br(htmlspecialchars($job['requirement'])) ?></div>
            </div>
        </div>
    </div>

</div>

</body>
</html>
