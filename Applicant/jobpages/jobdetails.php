<?php
include '../../db.php';

if (!isset($_GET['id'])) {
    echo "<p>Invalid job listing.</p>";
    exit;
}

$jobId = base64_decode($_GET['id']);

if (!is_numeric($jobId)) {
    echo "<p>Invalid job ID format.</p>";
    exit;
}

// Fetch job details including company info
$query = "SELECT jp.*, c.* FROM job_post jp JOIN employer c ON jp.employer_id = c.id WHERE jp.id = $jobId";
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 30px;
        }
        .card-header {
            background-color: #8B0000;
            color: white;
            font-size: 20px;
            font-weight: bold;
        }
        .company-logo {
            width: 100px;
            height: 100px;
            border-radius: 5px;
        }
        .btn-save {
            background-color: #ffc107;
            color: #000;
        }
        .btn-apply {
            background-color: #28a745;
            color: white;
        }
    </style>
</head>
<body>
<div class="container">
    <a href="../applicant_home.php" class="btn btn-primary mb-3"><i class="bi bi-arrow-left"></i> Back to Job Listings</a>
    
    <div class="card shadow">
        <div class="card-header text-center">Job Details</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    <img id="preview" src="../<?php echo $job['company_photo']; ?>" alt="Profile Image" class="company-logo" alt="Company Logo">
                    <h5 class="mt-3"><?= htmlspecialchars($job['company_name']) ?></h5>
                    <p><?= htmlspecialchars($job['company_address']) ?></p>
                    <p><strong>HR:</strong> <?= htmlspecialchars($job['hr']) ?></p>
                    <p><strong>Contact:</strong> <?= htmlspecialchars($job['company_contact']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($job['company_email']) ?></p>
                    <p><strong>President:</strong> <?= htmlspecialchars($job['president']) ?></p>
                </div>
                <div class="col-md-8">
                    <p><strong>Job Title:</strong> <?= htmlspecialchars($job['job_title']) ?></p>
                    <p><strong>Posted:</strong> <?= htmlspecialchars($job['date_posted']) ?></p>
                    <p><strong>Job Type:</strong> <?= htmlspecialchars($job['job_type']) ?></p>
                    <p><strong>Location:</strong> <?= htmlspecialchars($job['work_location']) ?></p>
                    <p><strong>Salary:</strong> <?= htmlspecialchars($job['salary']) ?></p>
                    <p><strong>Description:</strong></p>
                    <div class="border p-3 bg-light"> <?= nl2br(htmlspecialchars($job['job_description'])) ?></div>
                    <p><strong>Requirements:</strong></p>
                    <div class="border p-3 bg-light"> <?= nl2br(htmlspecialchars($job['requirement'])) ?></div>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <button class="btn btn-save"><i class="bi bi-bookmark"></i> Save Job</button>
            <button class="btn btn-apply"><i class="bi bi-send"></i> Apply Now</button>
        </div>
    </div>
</div>
</body>
</html>
