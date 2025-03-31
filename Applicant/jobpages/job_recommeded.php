<?php
include '../db.php';

// Check if the applicant is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../applicant_login.php");
    exit();
}

$applicantid = $_SESSION['applicant_id'];
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch total number of jobs
$totalQuery = "SELECT COUNT(id) AS total FROM job_post WHERE is_active = 1";
$totalResult = $conn->query($totalQuery);
$totalRow = $totalResult->fetch_assoc();
$totalJobs = $totalRow['total'];
$totalPages = ceil($totalJobs / $limit);

// Fetch jobs
$query = "SELECT * FROM job_post WHERE is_active = 1 ORDER BY date_posted DESC LIMIT ?, ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $start, $limit);
$stmt->execute();
$jobs = $stmt->get_result();

// Fetch applicant's profile
$applicantQuery = "SELECT preferred_occupation, selected_option FROM applicant_profile WHERE id = ?";
$stmt = $conn->prepare($applicantQuery);
$stmt->bind_param('i', $applicantid);
$stmt->execute();
$applicant = $stmt->get_result()->fetch_assoc();

$preferredOccupation = array_map('trim', explode(',', strtolower($applicant['preferred_occupation'] ?? '')));
$applicantSkills = array_map('trim', explode(',', strtolower($applicant['selected_option'] ?? '')));

// Function to check job match
function isMatch($preferredOccupations, $applicantSkills, $jobTitle, $jobSkills) {
    $jobSkillsArray = array_map('trim', explode(',', strtolower($jobSkills)));

    foreach ($preferredOccupations as $occupation) {
        similar_text($occupation, $jobTitle, $percent);
        $levenshteinDistance = levenshtein($occupation, $jobTitle);
        $length = max(strlen($occupation), strlen($jobTitle));
        $levenshteinPercent = ($length > 0) ? (1 - ($levenshteinDistance / $length)) * 100 : 0;
        if (max($percent, $levenshteinPercent) >= 40) return true;
    }

    return !empty(array_intersect($applicantSkills, $jobSkillsArray));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
<div class="container mt-3">
    <?php while ($row = $jobs->fetch_assoc()) {
        if (isMatch($preferredOccupation, $applicantSkills, strtolower($row['job_title']), $row['selected_option'])) { ?>
            <a href="jobdetails.php?id=<?= urlencode(base64_encode($row['id'])) ?>" class="text-decoration-none text-dark">
                <div class="row job-row border rounded mb-3 shadow-sm p-3" style="cursor: pointer;">
                    <div class="col-md-8">
                        <p><i class="bi bi-suitcase-lg"></i> <?= htmlspecialchars($row['job_title']) ?></p>
                        <p><i class="bi bi-buildings"></i> <?= htmlspecialchars($row['company_name']) ?></p>
                        <p><i class="bi bi-pin-map"></i> <?= htmlspecialchars($row['work_location']) ?></p>
                        <p><i class="bi bi-cash"></i> <?= htmlspecialchars($row['salary']) ?></p>
                    </div>
                    <div class="col-md-4 text-end align-self-center">
                        <span class="fs-5"> <?= htmlspecialchars($row['vacant']) ?> openings </span>
                    </div>
                </div>
            </a>
    <?php } } ?>
</div>

<!-- Pagination -->
<div class="pagination justify-content-center mt-3">
    <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>" class="btn btn-outline-primary">Previous</a>
    <?php endif; ?>
    <span class="mx-2">Page <?= $page ?> of <?= $totalPages ?></span>
    <?php if ($page < $totalPages): ?>
        <a href="?page=<?= $page + 1 ?>" class="btn btn-outline-primary">Next</a>
    <?php endif; ?>
</div>

</body>
</html>
