<?php
$applicantid = $_SESSION['applicant_id'];
// Check if the applicant is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: applicant_login.php");
    exit();
}

// Define the number of results per page
$limit = 5;

// Get the current page number from URL, default is page 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch total number of available jobs (not saved or applied by this applicant)
$totalQuery = "SELECT COUNT(jp.id) AS total 
               FROM job_post jp
               WHERE jp.is_active = 1
               AND jp.id NOT IN (
                   SELECT job_id FROM save_job WHERE applicant_id = ?
               )
               AND jp.id NOT IN (
                   SELECT job_posting_id FROM applied_job WHERE applicant_id = ?
               )";
$totalStmt = $conn->prepare($totalQuery);
$totalStmt->bind_param("ii", $applicantid, $applicantid);
$totalStmt->execute();
$totalResult = $totalStmt->get_result();
$totalRow = $totalResult->fetch_assoc();
$totalJobs = $totalRow['total'];
$totalStmt->close();

// Calculate total pages
$totalPages = ceil($totalJobs / $limit);

// Fetch jobs with limit and offset (excluding saved and applied jobs)
$query = "SELECT jp.* 
          FROM job_post jp
          WHERE jp.is_active = 1
          AND jp.id NOT IN (
              SELECT job_id FROM save_job WHERE applicant_id = ?
          )
          AND jp.id NOT IN (
              SELECT job_posting_id FROM applied_job WHERE applicant_id = ?
          )
          ORDER BY jp.date_posted DESC 
          LIMIT ?, ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("iiii", $applicantid, $applicantid, $start, $limit);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>

<div class="table container mt-1">
<?php while ($row = $result->fetch_assoc()) { ?>
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
                    <span class="ms-5 fs-5">
                        <?= htmlspecialchars($row['vacant']) ?> openings
                    </span>
                </div>
                
                <div class="col-md-2 pt-5 text-start">
                <form action="process/hide.php" method="post">
                    <input type="hidden" name="job_id" value="<?= $row['id'] ?>">
                    <button type="submit" class="btn btn-sm <?= $row['is_active'] == 1 ? 'btn-success' : 'btn-danger' ?> toggle-status"
                        data-id="<?= $row['id'] ?>" 
                        data-status="<?= $row['is_active'] ?>">
                        <?= $row['is_active'] == 1 ? 'Active' : 'Inactive' ?>
                    </button>
                </form>
                </div>
            </div>
        </a>
    <?php } ?>
</div>

<!-- Pagination Links -->
<div class="pagination justify-content-center">
    <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>&tab=joblist" class="prev">Previous</a>
    <?php endif; ?>

    <span>Page <?= $page ?> of <?= $totalPages ?></span>

    <?php if ($page < $totalPages): ?>
        <a href="?page=<?= $page + 1 ?>&joblist" class="next">Next</a>
    <?php endif; ?>
</div>

</body>
</html>
