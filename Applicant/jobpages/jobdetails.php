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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 30px;
            max-width: 1200px;
        }
        .card-header {
            background-color: #8B0000;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            padding: 1.25rem;
        }
        .company-logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }
        .company-logo {
            width: 150px;
            height: 150px;
            border-radius: 8px;
            object-fit: cover;
            border: 3px solid #f1f1f1;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .company-info p {
            margin-bottom: 0.5rem;
        }
        .job-details-section {
            margin-bottom: 1.5rem;
        }
        .job-details-section h5 {
            color: #8B0000;
            margin-bottom: 1rem;
            font-weight: 600;
        }
        .detail-box {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 1.25rem;
            margin-bottom: 1.25rem;
            border-left: 4px solid #8B0000;
        }
        .btn-save {
            background-color: #ffc107;
            color: #000;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
        }
        .btn-apply {
            background-color: #28a745;
            color: white;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
        }
        .btn-save.active, .btn-apply.disabled {
            opacity: 0.9;
        }
        .back-btn {
            margin-bottom: 1.5rem;
        }
        .card {
            border: none;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        .card-body {
            padding: 2rem;
        }
        .card-footer {
            background-color: rgba(139, 0, 0, 0.03);
            padding: 1.5rem;
        }
    </style>
</head>
<body>
<div class="container">
    <a href="../applicant_home.php" class="btn btn-primary back-btn">
        <i class="bi bi-arrow-left"></i> Back to Job Listings
    </a>
    
    <div class="card shadow">
        <div class="card-header text-center">Job Details</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="company-logo-container">
                        <img id="preview" src="<?= !empty($job['company_photo']) ? '../../employer/' . htmlspecialchars($job['company_photo']) : '../../img/company-placeholder.png' ?>" 
                             alt="Company Logo" class="company-logo">
                    </div>
                    <div class="company-info">
                        <h5 class="text-center mb-3"><?= htmlspecialchars($job['company_name']) ?></h5>
                        <p><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($job['company_address']) ?></p>
                        <p><i class="bi bi-person-badge"></i> <strong>HR:</strong> <?= htmlspecialchars($job['hr']) ?></p>
                        <p><i class="bi bi-telephone"></i> <strong>Contact:</strong> <?= htmlspecialchars($job['company_contact']) ?></p>
                        <p><i class="bi bi-envelope"></i> <strong>Email:</strong> <?= htmlspecialchars($job['company_email']) ?></p>
                        <p><i class="bi bi-person-vcard"></i> <strong>President:</strong> <?= htmlspecialchars($job['president']) ?></p>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <div class="job-details-section">
                        <h5>Job Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong><i class="bi bi-briefcase"></i> Job Title:</strong> <?= htmlspecialchars($job['job_title']) ?></p>
                                <p><strong><i class="bi bi-calendar"></i> Posted:</strong> <?= htmlspecialchars($job['date_posted']) ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong><i class="bi bi-clock"></i> Job Type:</strong> <?= htmlspecialchars($job['job_type']) ?></p>
                                <p><strong><i class="bi bi-cash"></i> Salary:</strong> <?= htmlspecialchars($job['salary']) ?></p>
                            </div>
                        </div>
                        <p><strong><i class="bi bi-geo"></i> Location:</strong> <?= htmlspecialchars($job['work_location']) ?></p>
                    </div>
                    
                    <div class="job-details-section">
                        <h5>Job Description</h5>
                        <div class="detail-box">
                            <?= nl2br(htmlspecialchars($job['job_description'])) ?>
                        </div>
                    </div>
                    
                    <div class="job-details-section">
                        <h5>Requirements</h5>
                        <div class="detail-box">
                            <?= nl2br(htmlspecialchars($job['requirement'])) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <button class="btn btn-save me-3"><i class="bi bi-bookmark"></i> Save Job</button>
            <button class="btn btn-apply"><i class="bi bi-send"></i> Apply Now</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Save Job button handler
        document.querySelector('.btn-save').addEventListener('click', function() {
            const jobId = <?= $jobId ?>;
            
            fetch('../../process/save_job.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `job_id=${jobId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const btn = document.querySelector('.btn-save');
                    if (data.action === 'save') {
                        btn.innerHTML = '<i class="bi bi-bookmark-fill"></i> Saved';
                        btn.classList.add('active');
                    } else {
                        btn.innerHTML = '<i class="bi bi-bookmark"></i> Save Job';
                        btn.classList.remove('active');
                    }
                    // Show toast notification instead of alert
                    showToast(data.message, 'success');
                } else {
                    showToast(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred while processing your request', 'error');
            });
        });

        // Apply Now button handler
        document.querySelector('.btn-apply').addEventListener('click', function() {
            if (confirm('Are you sure you want to apply for this position?')) {
                const jobId = <?= $jobId ?>;
                
                fetch('../../process/apply_job.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `job_id=${jobId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const btn = document.querySelector('.btn-apply');
                        btn.innerHTML = '<i class="bi bi-check-circle"></i> Applied';
                        btn.classList.add('disabled');
                        btn.style.backgroundColor = '#6c757d';
                        showToast(data.message, 'success');
                    } else {
                        showToast(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('An error occurred while processing your application', 'error');
                });
            }
        });

        // Check if job is already saved on page load
        const jobId = <?= $jobId ?>;
        fetch('../../process/check_saved_job.php?job_id=' + jobId)
            .then(response => response.json())
            .then(data => {
                if (data.is_saved) {
                    const btn = document.querySelector('.btn-save');
                    btn.innerHTML = '<i class="bi bi-bookmark-fill"></i> Saved';
                    btn.classList.add('active');
                }
            });

        // Check if job is already applied on page load
        fetch('../../process/check_applied_job.php?job_id=' + jobId)
            .then(response => response.json())
            .then(data => {
                if (data.is_applied) {
                    const btn = document.querySelector('.btn-apply');
                    btn.innerHTML = '<i class="bi bi-check-circle"></i> Applied';
                    btn.classList.add('disabled');
                    btn.style.backgroundColor = '#6c757d';
                }
            });

        // Toast notification function
        function showToast(message, type) {
            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0 position-fixed bottom-0 end-0 m-3`;
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');
            toast.style.zIndex = '9999';
            
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            `;
            
            document.body.appendChild(toast);
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
            
            // Remove toast after it hides
            toast.addEventListener('hidden.bs.toast', function() {
                toast.remove();
            });
        }
    });
</script>
</body>
</html>