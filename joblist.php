<?php
include 'db.php';

// Define the number of results per page
$limit = 5;

// Get the current page number from URL, default is page 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch total number of jobs
$totalQuery = "SELECT COUNT(id) AS total FROM job_post WHERE is_active = 1";
$totalResult = $conn->query($totalQuery);
$totalRow = $totalResult->fetch_assoc();
$totalJobs = $totalRow['total'];

// Calculate total pages
$totalPages = ceil($totalJobs / $limit);

// Fetch jobs with limit and offset
$query = "SELECT id, job_title, company_name, salary, vacant, work_location FROM job_post WHERE is_active = 1 LIMIT $start, $limit";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="joblist.css">
    <script src="joblist.js" defer></script>
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
    
<div class="container container-fluid">
    <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="row job-row border rounded mb-3 shadow-sm" data-id="<?= htmlspecialchars($row['id']) ?>" style="cursor: pointer;">
            <div class="col-md-2 justify-content-center">
                <img src="img/mission.png" alt="Profile 1" class="img-fluid" style="width: 100px; height: 100px;">
            </div>
            <div class="col-md-8 row justify-content-start">
                <div class="col-md-12 pt-3 text-start">
                    <div class="col"><p class="text-start"><i class="bi bi-suitcase-lg"></i> <?= htmlspecialchars($row['job_title']) ?></p></div>
                    <div class="col"><p class="text-start"><i class="bi bi-buildings"></i> <?= htmlspecialchars($row['company_name']) ?></p></div>
                    <div class="col"><p class="text-start"><i class="bi bi-pin-map"></i> <?= htmlspecialchars($row['work_location']) ?></p></div>
                    <div class="col"><p class="text-start"><i class="bi bi-cash"></i> <?= htmlspecialchars($row['salary']) ?></p></div>
                </div>
            </div>
            <div class="col-md-2 pt-5 text-start">
                <span class="ms-2 fs-5">
                    <?= htmlspecialchars($row['vacant']) ?> openings
                </span>
            </div>
        </div>
    <?php } ?>
</div>

<!-- Pagination Links -->
<div class="pagination justify-content-center">
    <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>" class="prev">Previous</a>
    <?php endif; ?>

    <span>Page <?= $page ?> of <?= $totalPages ?></span>

    <?php if ($page < $totalPages): ?>
        <a href="?page=<?= $page + 1 ?>" class="next">Next</a>
    <?php endif; ?>
</div>


<!-- Modal -->
<div id="jobModal" class="modal">
    <div class="modal-content">
        <span class="close text-end">&times;</span> <!-- Close button -->
        <h3 id="modalTitle"></h3>
        <p><strong>Company:</strong> <span id="modalCompany"></span></p>
        <p><strong>Job Type:</strong> <span id="modalJobType"></span></p>
        <p><strong>Salary:</strong> <span id="modalSalary"></span></p>
        <p><strong>Vacancies:</strong> <span id="modalVacant"></span></p>
        <p><strong>Location:</strong> <span id="modalLocation"></span></p>
        <p><strong>Education:</strong> <span id="modalEducation"></span></p>
        <p><strong>Description:</strong> <span id="modalDescription"></span></p>
        <p><strong>Requirements:</strong> <span id="modalRequirement"></span></p>
        <p><strong>Posted On:</strong> <span id="modalDate"></span></p>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
