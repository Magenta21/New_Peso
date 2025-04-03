<?php
// Pagination setup
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch total count of rejected applicants
$totalQuery = "SELECT COUNT(a.id) AS total 
               FROM applied_job aj
               JOIN applicant_profile a ON aj.applicant_id = a.id
               WHERE aj.job_posting_id = ? AND aj.status = 'Rejected'";
$totalStmt = $conn->prepare($totalQuery);
$totalStmt->bind_param("i", $jobId);
$totalStmt->execute();
$totalResult = $totalStmt->get_result();
$totalRow = $totalResult->fetch_assoc();
$totalApplicants = $totalRow['total'];
$totalPages = ceil($totalApplicants / $limit);
?>

<div class="container mt-3">
    <?php
    // Fetch rejected applicants with pagination
    $query = "SELECT a.*, aj.application_date 
              FROM applied_job aj
              JOIN applicant_profile a ON aj.applicant_id = a.id
              WHERE aj.job_posting_id = ? AND aj.status = 'Rejected'
              ORDER BY aj.application_date DESC
              LIMIT ?, ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $jobId, $start, $limit);
    $stmt->execute();
    $applicants = $stmt->get_result();
    
    if ($applicants->num_rows > 0): 
        while ($applicant = $applicants->fetch_assoc()): 
    ?>
            <div class="row job-row border rounded mb-3 shadow-sm p-3">
                <div class="col-md-8">
                    <p><i class="bi bi-person"></i> <?= htmlspecialchars($applicant['fname'] . ' ' . $applicant['lname']) ?></p>
                    <p><i class="bi bi-envelope"></i> <?= htmlspecialchars($applicant['email']) ?></p>
                    <p><i class="bi bi-telephone"></i> <?= htmlspecialchars($applicant['contact_no']) ?></p>
                    <p><i class="bi bi-calendar-x"></i> Rejected: <?= date('M d, Y', strtotime($applicant['application_date'])) ?></p>
                </div>
                <div class="col-md-4 text-end align-self-center">
                    <div class="d-flex flex-wrap justify-content-end gap-2">
                        <a href="view_applicant.php?id=<?= $applicant['id'] ?>" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"></i> View
                        </a>
                        <a href="update_status.php?applicant=<?= $applicant['id'] ?>&job=<?= $jobId ?>&status=Pending" class="btn btn-sm btn-success">
                            <i class="bi bi-arrow-counterclockwise"></i> Reconsider
                        </a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="alert alert-info">No rejected applicants.</div>
    <?php endif; ?>
</div>

<!-- Pagination -->
<div class="pagination justify-content-center mt-3">
    <?php if ($page > 1): ?>
        <a href="?id=<?= $_GET['id'] ?>&tab=rejected&page=<?= $page - 1 ?>" class="btn btn-outline-primary">Previous</a>
    <?php endif; ?>
    <span class="mx-2">Page <?= $page ?> of <?= $totalPages ?></span>
    <?php if ($page < $totalPages): ?>
        <a href="?id=<?= $_GET['id'] ?>&tab=rejected&page=<?= $page + 1 ?>" class="btn btn-outline-primary">Next</a>
    <?php endif; ?>
</div>