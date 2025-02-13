<?php
include 'db.php';

// Define the number of results per page
$limit = 3;

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
$query = "SELECT id, job_title, company_name, salary, vacant FROM job_post WHERE is_active = 1 LIMIT $start, $limit";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="joblist.css">
    <script src="joblist.js"></script>
</head>
<body>

<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <img src="img/logolb.png" alt="lblogo" style="height: 50px;">
            </div>
            <div class="col-md-8">
                <h3 style="margin-top: 5px; font-weight: 900; color: #ffffff;">Job Listings</h3>
            </div>
        </div>
    </div>
</div>  

<table>
    <thead>
        <tr>
            <th>Job Title</th>
            <th>Company Name</th>
            <th>Salary</th>
            <th>Vacancies</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr class="job-row" data-id="<?= $row['id'] ?>">
                <td><?= htmlspecialchars($row['job_title']) ?></td>
                <td><?= htmlspecialchars($row['company_name']) ?></td>
                <td><?= htmlspecialchars($row['salary']) ?></td>
                <td><?= htmlspecialchars($row['vacant']) ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<!-- Pagination Links -->
<div class="pagination">
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
        <span class="close">&times;</span>
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

</body>
</html>
