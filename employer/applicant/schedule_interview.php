<?php
// Pagination setup
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch total count of scheduled interviews
$totalQuery = "SELECT COUNT(a.id) AS total 
               FROM applied_job aj
               JOIN applicant_profile a ON aj.applicant_id = a.id
               WHERE aj.job_posting_id = ? AND aj.status = 'Interview Scheduled'";
$totalStmt = $conn->prepare($totalQuery);
$totalStmt->bind_param("i", $jobId);
$totalStmt->execute();
$totalResult = $totalStmt->get_result();
$totalRow = $totalResult->fetch_assoc();
$totalApplicants = $totalRow['total'];
$totalPages = ceil($totalApplicants / $limit);

// Display success/error messages
if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success">'.$_SESSION['success'].'</div>';
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger">'.$_SESSION['error'].'</div>';
    unset($_SESSION['error']);
}
?>

<div class="container mt-3">
    <?php
    // Fetch scheduled interviews with pagination
    $query = "SELECT a.*, aj.application_date, aj.interview_date, j.job_title AS job_title
              FROM applied_job aj
              JOIN applicant_profile a ON aj.applicant_id = a.id
              JOIN job_post j ON aj.job_posting_id = j.id
              WHERE aj.job_posting_id = ? AND aj.status = 'Interview Scheduled'
              ORDER BY aj.interview_date ASC
              LIMIT ?, ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $jobId, $start, $limit);
    $stmt->execute();
    $applicants = $stmt->get_result();
    
    if ($applicants->num_rows > 0): 
        while ($applicant = $applicants->fetch_assoc()): 
            $interviewDate = new DateTime($applicant['interview_date']);
            $now = new DateTime();
            $isPast = $interviewDate < $now;
    ?>
            <div class="row job-row border rounded mb-3 shadow-sm p-3 <?= $isPast ? 'bg-light' : '' ?>">
                <div class="col-md-8">
                    <h5><?= htmlspecialchars($applicant['fname'] . ' ' . $applicant['lname']) ?></h5>
                    <p><strong>Job:</strong> <?= htmlspecialchars($applicant['job_title']) ?></p>
                    <p><i class="bi bi-envelope"></i> <?= htmlspecialchars($applicant['email']) ?></p>
                    <p><i class="bi bi-telephone"></i> <?= htmlspecialchars($applicant['contact_no']) ?></p>
                    <div class="mt-2">
                        <p class="<?= $isPast ? 'text-danger' : 'text-success' ?>">
                            <i class="bi bi-calendar-event"></i> 
                            <strong>Interview:</strong> 
                            <?= $interviewDate->format('F j, Y \a\t g:i a') ?>
                            <?= $isPast ? '(Completed)' : '(Upcoming)' ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-4 text-end align-self-center">
                    <div class="d-flex flex-wrap justify-content-end gap-2">
                        <a href="view_applicant.php?id=<?= $applicant['id'] ?>&job=<?= $jobId ?>" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"></i> View
                        </a>
                        <?php if (!$isPast): ?>
                            <button class="btn btn-sm btn-warning" onclick="rescheduleInterview(<?= $applicant['id'] ?>, <?= $jobId ?>)">
                                <i class="bi bi-calendar-plus"></i> Reschedule
                            </button>
                        <?php endif; ?>
                        <!-- Add this Accept button -->
                        <a href="update_status.php?applicant=<?= $applicant['id'] ?>&job=<?= $jobId ?>&status=Accepted" 
                        class="btn btn-sm btn-success">
                            <i class="bi bi-check-circle"></i> Accept
                        </a>
                        <a href="update_status.php?applicant=<?= $applicant['id'] ?>&job=<?= $jobId ?>&status=<?= $isPast ? 'Completed' : 'Rejected' ?>" 
                        class="btn btn-sm btn-<?= $isPast ? 'secondary' : 'danger' ?>">
                            <i class="bi bi-<?= $isPast ? 'check-circle' : 'x-circle' ?>"></i> 
                            <?= $isPast ? 'Mark Completed' : 'Reject' ?>
                        </a>
                    </div>
                </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="alert alert-info">No scheduled interviews found.</div>
    <?php endif; ?>
</div>

<!-- Pagination -->
<div class="pagination justify-content-center mt-3">
    <?php if ($page > 1): ?>
        <a href="?id=<?= $_GET['id'] ?>&tab=scheduled&page=<?= $page - 1 ?>" class="btn btn-outline-primary">Previous</a>
    <?php endif; ?>
    <span class="mx-2">Page <?= $page ?> of <?= $totalPages ?></span>
    <?php if ($page < $totalPages): ?>
        <a href="?id=<?= $_GET['id'] ?>&tab=scheduled&page=<?= $page + 1 ?>" class="btn btn-outline-primary">Next</a>
    <?php endif; ?>
</div>

<script>
function rescheduleInterview(applicantId, jobId) {
    // Create a modal for rescheduling
    const modal = document.createElement('div');
    modal.className = 'modal fade';
    modal.id = 'rescheduleModal';
    modal.innerHTML = `
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reschedule Interview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="newInterviewDate" class="form-label">New Interview Date & Time</label>
                        <input type="datetime-local" class="form-control" id="newInterviewDate">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="confirmReschedule(${applicantId}, ${jobId})">Confirm</button>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    const modalInstance = new bootstrap.Modal(modal);
    modalInstance.show();
    
    // Remove modal when closed
    modal.addEventListener('hidden.bs.modal', function() {
        document.body.removeChild(modal);
    });
}

function confirmReschedule(applicantId, jobId) {
    const newDate = document.getElementById('newInterviewDate').value;
    if (!newDate) {
        alert('Please select a new date and time');
        return;
    }
    
    // Submit the form
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '../process/reschedule_interview.php';
    
    const applicantInput = document.createElement('input');
    applicantInput.type = 'hidden';
    applicantInput.name = 'applicant';
    applicantInput.value = applicantId;
    form.appendChild(applicantInput);
    
    const jobInput = document.createElement('input');
    jobInput.type = 'hidden';
    jobInput.name = 'job';
    jobInput.value = jobId;
    form.appendChild(jobInput);
    
    const dateInput = document.createElement('input');
    dateInput.type = 'hidden';
    dateInput.name = 'datetime';
    dateInput.value = newDate;
    form.appendChild(dateInput);
    
    document.body.appendChild(form);
    form.submit();
}
</script>