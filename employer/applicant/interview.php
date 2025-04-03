<?php
// Pagination setup
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch total count of interview applicants
$totalQuery = "SELECT COUNT(a.id) AS total 
               FROM applied_job aj
               JOIN applicant_profile a ON aj.applicant_id = a.id
               WHERE aj.job_posting_id = ? AND aj.status = 'Interview'";
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
    // Fetch interview applicants with pagination
    $query = "SELECT a.*, aj.application_date 
              FROM applied_job aj
              JOIN applicant_profile a ON aj.applicant_id = a.id
              WHERE aj.job_posting_id = ? AND aj.status = 'Interview'
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
                    <div class="mt-2">
                        <label for="interview_date_<?= $applicant['id'] ?>" class="form-label"><i class="bi bi-clock"></i> Interview Date:</label>
                        <input type="datetime-local" class="form-control form-control-sm" 
                               id="interview_date_<?= $applicant['id'] ?>" 
                               value="<?= date('Y-m-d\TH:i', strtotime('+1 day 10:00')) ?>">
                    </div>
                </div>
                <div class="col-md-4 text-end align-self-center">
                    <div class="d-flex flex-wrap justify-content-end gap-2">
                        <a href="view_applicant.php?id=<?= $applicant['id'] ?>" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"></i> View
                        </a>
                        <button class="btn btn-sm btn-success" onclick="scheduleInterview(<?= $applicant['id'] ?>, <?= $jobId ?>)">
                            <i class="bi bi-calendar-check"></i> Confirm
                        </button>
                        <a href="update_status.php?applicant=<?= $applicant['id'] ?>&job=<?= $jobId ?>&status=Rejected" class="btn btn-sm btn-danger">
                            <i class="bi bi-x-circle"></i> Reject
                        </a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="alert alert-info">No applicants scheduled for interview.</div>
    <?php endif; ?>
</div>

<!-- Pagination -->
<div class="pagination justify-content-center mt-3">
    <?php if ($page > 1): ?>
        <a href="?id=<?= $_GET['id'] ?>&tab=interview&page=<?= $page - 1 ?>" class="btn btn-outline-primary">Previous</a>
    <?php endif; ?>
    <span class="mx-2">Page <?= $page ?> of <?= $totalPages ?></span>
    <?php if ($page < $totalPages): ?>
        <a href="?id=<?= $_GET['id'] ?>&tab=interview&page=<?= $page + 1 ?>" class="btn btn-outline-primary">Next</a>
    <?php endif; ?>
</div>

<script>
function scheduleInterview(applicantId, jobId) {
    const dateTime = document.getElementById('interview_date_' + applicantId).value;
    if (!dateTime) {
        alert('Please select interview date and time');
        return;
    }
    
    window.location.href = `schedule_interview.php?applicant=${applicantId}&job=${jobId}&datetime=${encodeURIComponent(dateTime)}`;
}
</script>