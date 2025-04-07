<?php
include '../../db.php';
session_start();

// Check if employer is logged in
if (!isset($_SESSION['employer_id']) || $_SESSION['logged_in'] !== true) {
    header("Location: employer_login.php");
    exit();
}

// Get applicant ID
$jobId = $_GET['job'] ?? null;
$applicantId = $_GET['id'] ?? null;
if (!$applicantId) {
    die("Applicant ID not specified");
}

// Fetch applicant basic info
$applicantQuery = "SELECT * FROM applicant_profile WHERE id = ?";
$stmt = $conn->prepare($applicantQuery);
$stmt->bind_param("i", $applicantId);
$stmt->execute();
$applicant = $stmt->get_result()->fetch_assoc();

if (!$applicant) {
    die("Applicant not found");
}

// Fetch work experience
$workExpQuery = "SELECT * FROM work_exp WHERE user_id = ? ORDER BY started_date DESC";
$stmt = $conn->prepare($workExpQuery);
$stmt->bind_param("i", $applicantId);
$stmt->execute();
$workExperiences = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Fetch education
$educationQuery = "SELECT tertiary_school, tertiary_course, tertiary_graduated, tertiary_award, 
                  college_school, grad_course, college_graduated, college_award 
                  FROM applicant_profile WHERE id = ?";
$stmt = $conn->prepare($educationQuery);
$stmt->bind_param("i", $applicantId);
$stmt->execute();
$education = $stmt->get_result()->fetch_assoc();

// Fetch licenses/certifications
$licenseQuery = "SELECT * FROM license WHERE user_id = ?";
$stmt = $conn->prepare($licenseQuery);
$stmt->bind_param("i", $applicantId);
$stmt->execute();
$licenses = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Fetch trainings
$trainingQuery = "SELECT * FROM training WHERE user_id = ? ORDER BY end_date DESC";
$stmt = $conn->prepare($trainingQuery);
$stmt->bind_param("i", $applicantId);
$stmt->execute();
$trainings = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($applicant['fname'] . ' ' . $applicant['lname']) ?> - Applicant Details</title>
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
        .profile-pic-container {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }
        .profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #f1f1f1;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .applicant-info p {
            margin-bottom: 0.5rem;
        }
        .detail-section {
            margin-bottom: 1.5rem;
        }
        .detail-section h5 {
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
        .btn-view {
            background-color: #8B0000;
            color: white;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
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
        .experience-item, .education-item, .license-item, .training-item {
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }
        .experience-item:last-child, .education-item:last-child, 
        .license-item:last-child, .training-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
    </style>
</head>
<body>
<div class="container">
    <a href="applicant_list.php?job_id=<?= htmlspecialchars(base64_encode($jobId)) ?>" class="btn btn-primary back-btn">
        <i class="bi bi-arrow-left"></i> Back to Applicants
    </a>
    
    <div class="card shadow">
        <div class="card-header text-center">Applicant Profile</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-pic-container">
                        <img src="<?= !empty($applicant['photo']) ? '../../applicant/' . htmlspecialchars($applicant['photo']) : '../../img/user-placeholder.png' ?>" 
                             alt="Profile Picture" class="profile-pic">
                    </div>
                    <div class="applicant-info">
                        <h4 class="text-center mb-3"><?= htmlspecialchars($applicant['fname'] . ' ' . $applicant['lname']) ?></h4>
                        <p><i class="bi bi-envelope"></i> <?= htmlspecialchars($applicant['email'] ?? '') ?></p>
                        <p><i class="bi bi-telephone"></i> <?= htmlspecialchars($applicant['contact_no'] ?? '') ?></p>
                        <p><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($applicant['present_address'] ?? '') ?></p>
                        <p><i class="bi bi-person"></i> <?= htmlspecialchars($applicant['sex'] ?? '') ?>, <?= htmlspecialchars($applicant['age'] ?? '') ?> years old</p>
                        <p><i class="bi bi-heart"></i> <?= htmlspecialchars($applicant['civil_status'] ?? '') ?></p>
                        <p><i class="bi bi-briefcase"></i> <?= htmlspecialchars($applicant['employment_status'] ?? '') ?></p>
                        <p><i class="bi bi-cash"></i> Expected Salary: ₱<?= number_format($applicant['expected_salary'] ?? 0, 2) ?></p>
                        
                        <div class="mt-4 text-center">
                            <?php if (!empty($applicant['resume'])): ?>
                                <a href="../../applicant/<?= htmlspecialchars($applicant['resume']) ?>" 
                                class="btn btn-view" target="_blank">
                                    <i class="bi bi-file-earmark-person"></i> View Resume
                                </a>
                            <?php else: ?>
                                <button class="btn btn-secondary" disabled>
                                    <i class="bi bi-file-earmark-person"></i> No Resume Uploaded
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <!-- Work Experience Section -->
                    <div class="detail-section">
                        <h5><i class="bi bi-briefcase"></i> Work Experience</h5>
                        <?php if (!empty($workExperiences)): ?>
                            <?php foreach ($workExperiences as $exp): ?>
                                <div class="detail-box experience-item">
                                    <h6><?= htmlspecialchars($exp['position']) ?></h6>
                                    <p class="text-muted"><?= htmlspecialchars($exp['company_name']) ?></p>
                                    <p><?= date('M Y', strtotime($exp['started_date'])) ?> - 
                                       <?= $exp['termination_date'] ? date('M Y', strtotime($exp['termination_date'])) : 'Present' ?></p>
                                    <p><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($exp['address']) ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="detail-box">
                                <p>No work experience listed</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Education Section -->
                    <div class="detail-section">
                        <h5><i class="bi bi-mortarboard"></i> Education</h5>
                        <div class="detail-box">
                            <?php if (!empty($education['college_school'])): ?>
                                <div class="education-item">
                                    <h6>College/University</h6>
                                    <p><?= htmlspecialchars($education['college_school']) ?></p>
                                    <p><?= htmlspecialchars($education['grad_course']) ?></p>
                                    <p>Graduated: <?= date('Y', strtotime($education['college_graduated'])) ?></p>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($education['tertiary_school'])): ?>
                                <div class="education-item">
                                    <h6>Senior High/Vocational</h6>
                                    <p><?= htmlspecialchars($education['tertiary_school']) ?></p>
                                    <p><?= htmlspecialchars($education['tertiary_course']) ?></p>
                                    <p>Graduated: <?= date('Y', strtotime($education['tertiary_graduated'])) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Licenses/Certifications Section -->
                    <div class="detail-section">
                        <h5><i class="bi bi-award"></i> Licenses & Certifications</h5>
                        <?php if (!empty($licenses)): ?>
                            <?php foreach ($licenses as $license): ?>
                                <div class="detail-box license-item">
                                    <h6><?= htmlspecialchars($license['eligibility']) ?></h6>
                                    <p>Rating: <?= htmlspecialchars($license['rating']) ?></p>
                                    <p>Date of Exam: <?= date('M Y', strtotime($license['doe'])) ?></p>
                                    <?php if (!empty($license['prc_path'])): ?>
                                        <a href="../../applicant/<?= htmlspecialchars($license['prc_path']) ?>" 
                                           class="btn btn-sm btn-outline-primary mt-2" target="_blank">
                                            <i class="bi bi-file-earmark"></i> View Certificate
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="detail-box">
                                <p>No licenses or certifications listed</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Trainings Section -->
                    <div class="detail-section">
                        <h5><i class="bi bi-lightbulb"></i> Trainings</h5>
                        <?php if (!empty($trainings)): ?>
                            <?php foreach ($trainings as $training): ?>
                                <div class="detail-box training-item">
                                    <h6><?= htmlspecialchars($training['training']) ?></h6>
                                    <p><?= htmlspecialchars($training['institution']) ?></p>
                                    <p><?= date('M Y', strtotime($training['start_date'])) ?> - <?= date('M Y', strtotime($training['end_date'])) ?></p>
                                    <?php if (!empty($training['certificate_path'])): ?>
                                        <a href="../../applicant/<?= htmlspecialchars($training['certificate_path']) ?>" 
                                           class="btn btn-sm btn-outline-primary mt-2" target="_blank">
                                            <i class="bi bi-file-earmark"></i> View Certificate
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="detail-box">
                                <p>No trainings listed</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>