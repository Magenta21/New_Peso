<?php

// Check if applicant is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: applicant_login.php");
    exit();
}

$applicantId = $_SESSION['applicant_id'];

// Define the number of results per page
$limit = 5;

// Get the current page number from URL, default is page 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch total number of applied jobs
$totalQuery = "SELECT COUNT(aj.id) AS total 
               FROM applied_job aj
               JOIN job_post jp ON aj.job_posting_id = jp.id
               WHERE aj.applicant_id = $applicantId";
$totalResult = $conn->query($totalQuery);
$totalRow = $totalResult->fetch_assoc();
$totalJobs = $totalRow['total'];

// Calculate total pages
$totalPages = ceil($totalJobs / $limit);

// Fetch applied jobs with limit and offset
$query = "SELECT jp.*, aj.application_date, aj.status 
          FROM applied_job aj
          JOIN job_post jp ON aj.job_posting_id = jp.id
          WHERE aj.applicant_id = $applicantId
          ORDER BY aj.application_date DESC 
          LIMIT $start, $limit";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applied Jobs</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        .job-row:hover {
            background-color: #f8f9fa;
            transition: background-color 0.3s;
        }
        .pagination a {
            margin: 0 10px;
            padding: 5px 10px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            text-decoration: none;
        }
        .pagination a:hover {
            background-color: #e9ecef;
        }
        .status-pending {
            color: #ffc107;
        }
        .status-approved {
            color: #28a745;
        }
        .status-rejected {
            color: #dc3545;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="table">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <a href="jobpages/jobdetails.php?id=<?= urlencode(base64_encode($row['id'])) ?>" class="text-decoration-none text-dark">
                    <div class="row job-row border rounded mb-3 shadow-sm" style="cursor: pointer;">
                        <div class="col-md-6 row justify-content-start">
                            <div class="col-md-12 pt-3 text-start">
                                <div class="col"><p class="text-start"><i class="bi bi-suitcase-lg"></i> <?= htmlspecialchars($row['job_title']) ?></p></div>
                                <div class="col"><p class="text-start"><i class="bi bi-buildings"></i> <?= htmlspecialchars($row['company_name']) ?></p></div>
                                <div class="col"><p class="text-start"><i class="bi bi-pin-map"></i> <?= htmlspecialchars($row['work_location']) ?></p></div>
                                <div class="col"><p class="text-start"><i class="bi bi-cash"></i> <?= htmlspecialchars($row['salary']) ?></p></div>
                            </div>
                        </div>

                        <div class="col-md-4 pt-5 text-start">
                            <div class="ms-5">
                                <p>Applied: <?= date('M d, Y', strtotime($row['application_date'])) ?></p>
                                <p class="status-<?= strtolower($row['status']) ?>">
                                    Status: <?= htmlspecialchars($row['status']) ?>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-2 pt-5 text-start">
                            <?php if ($row['status'] === 'Pending'): ?>
                                <button class="btn btn-sm btn-warning withdraw-application" 
                                        data-job-id="<?= $row['id'] ?>">
                                    <i class="bi bi-x-circle"></i> Withdraw
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-info">You haven't applied to any jobs yet.</div>
        <?php endif; ?>
    </div>

    <!-- Pagination Links -->
    <div class="pagination justify-content-center mt-4">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>&tab=appliedjob" class="btn btn-outline-primary">Previous</a>
        <?php endif; ?>

        <span class="mx-3 align-self-center">Page <?= $page ?> of <?= $totalPages ?></span>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>&tab=appliedjob" class="btn btn-outline-primary">Next</a>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Withdraw application functionality
    document.querySelectorAll('.withdraw-application').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const jobId = this.getAttribute('data-job-id');
            const jobRow = this.closest('.job-row');
            
            if (confirm('Are you sure you want to withdraw this application?')) {
                fetch('process/withdraw_application.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `job_id=${jobId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        jobRow.remove();
                        // Show message if no jobs left
                        if (document.querySelectorAll('.job-row').length === 0) {
                            document.querySelector('.table').innerHTML = '<div class="alert alert-info">You haven\'t applied to any jobs yet.</div>';
                        }
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while withdrawing the application');
                });
            }
        });
    });
});
</script>
</body>
</html>