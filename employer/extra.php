<?php
include '../db.php';
session_start();

$employerid = $_SESSION['employer_id'];
// Check if the employer is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: employer_login.php");
    exit();
}

$sql = "SELECT * FROM employer WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $employerid);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Invalid query: " . $conn->error); 
}

$row = $result->fetch_assoc();
if (!$row) {
    die("User not found.");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .stat-card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .card-icon {
            font-size: 2rem;
            opacity: 0.7;
        }
        .chart-container {
            position: relative;
            height: 300px;
            margin-bottom: 20px;
        }
        .recent-applicants {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
<nav class="navbar bg-primary text-white py-2">
    <div class="container-fluid">
        <!-- Navigation Links -->
        <img src="../img/logolb.png" alt="lblogo" style="height: 50px;">
        <div class="ms-auto">           
        </div>
        <div class="d-flex flex-wrap align-items-center">
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"> </div>
                <a href="#" class="nav-link px-3">Home</a>
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>
            
            <div class="dropdown">
                <a class="nav-link px-3" href="post_job.php">
                    Job Post
                </a>
            </div>
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>

            <div class="dropdown">
                 <a class="nav-link px-3" href="job_list.php">
                    Job List
                </a> 
            </div>

            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>

            <div class="dropdown">
                <a class="nav-link px-3" href="employees.php">
                    Employer
                </a>
                
            </div>
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>

        </div>
        <div class="ms-auto">
            <div class="dropdown">
                <a href="#" class="text-decoration-none mt-5" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php if (!empty($row['company_photo'])): ?>
                        <img id="preview" src="<?php echo $row['company_photo']; ?>" alt="Profile Image" class="img-fluid rounded-circle" style="width: 40px; height: 40px;">
                    <?php else: ?>
                        <img src="../img/user-placeholder.png" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 40px; height: 40px;">
                    <?php endif; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end text-center mt-2" aria-labelledby="profileDropdown">
                    <li><a class="dropdown-item" href="employer_profile.php">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
    <!-- Your existing navbar code remains the same -->
    
    <div class="container-fluid mt-4">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2>Dashboard Overview</h2>
                <p class="text-muted">Welcome back, <?php echo htmlspecialchars($row['company_name']); ?>!</p>
            </div>
        </div>
        
        <!-- Stats Cards Row -->
        <div class="row mb-4">
            <!-- Total Applicants Card -->
            <div class="col-md-3 mb-3">
                <div class="card stat-card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Total Applicants</h5>
                                <?php
                                $applicantCount = $conn->query("SELECT COUNT(*) FROM applied_job WHERE job_posting_id IN (SELECT id FROM job_post WHERE employer_id = $employerid)")->fetch_row()[0];
                                ?>
                                <h2 class="mb-0"><?php echo $applicantCount; ?></h2>
                            </div>
                            <i class="bi bi-people card-icon"></i>
                        </div>
                        <p class="card-text mt-2">All-time applications</p>
                    </div>
                </div>
            </div>
            
            <!-- Interviews Scheduled Card -->
            <div class="col-md-3 mb-3">
                <div class="card stat-card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Interviews</h5>
                                <?php
                                $interviewCount = $conn->query("SELECT COUNT(*) FROM applied_job WHERE job_posting_id IN (SELECT id FROM job_post WHERE employer_id = $employerid) AND interview_date IS NOT NULL")->fetch_row()[0];
                                ?>
                                <h2 class="mb-0"><?php echo $interviewCount; ?></h2>
                            </div>
                            <i class="bi bi-calendar-event card-icon"></i>
                        </div>
                        <p class="card-text mt-2">Scheduled interviews</p>
                    </div>
                </div>
            </div>
            
            <!-- Current Employees Card -->
            <div class="col-md-3 mb-3">
                <div class="card stat-card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Employees</h5>
                                <?php
                                $employeeCount = $conn->query("SELECT COUNT(*) FROM current_employee WHERE employer_id = $employerid")->fetch_row()[0];
                                ?>
                                <h2 class="mb-0"><?php echo $employeeCount; ?></h2>
                            </div>
                            <i class="bi bi-person-badge card-icon"></i>
                        </div>
                        <p class="card-text mt-2">Currently employed</p>
                    </div>
                </div>
            </div>
            
            <!-- Active Job Posts Card -->
            <div class="col-md-3 mb-3">
                <div class="card stat-card bg-warning text-dark">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Active Jobs</h5>
                                <?php
                                $activeJobsCount = $conn->query("SELECT COUNT(*) FROM job_post WHERE employer_id = $employerid AND is_active = 1")->fetch_row()[0];
                                ?>
                                <h2 class="mb-0"><?php echo $activeJobsCount; ?></h2>
                            </div>
                            <i class="bi bi-briefcase card-icon"></i>
                        </div>
                        <p class="card-text mt-2">Open positions</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Charts Row -->
        <div class="row mb-4">
            <!-- Application Status Pie Chart -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5>Application Status Distribution</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Top Jobs Bar Chart -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5>Most Applied Jobs</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="topJobsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Additional Data Row -->
        <div class="row">
            <!-- Recent Applicants -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5>Recent Applicants</h5>
                        <a href="job_list.php" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body recent-applicants">
                        <ul class="list-group list-group-flush">
                            <?php
                            $recentApplicants = $conn->query("
                                SELECT a.*, j.job_title 
                                FROM applied_job a
                                JOIN job_post j ON a.job_posting_id = j.id
                                WHERE j.employer_id = $employerid
                                ORDER BY a.application_date DESC
                                LIMIT 5
                            ");
                            
                            if ($recentApplicants->num_rows > 0) {
                                while ($applicant = $recentApplicants->fetch_assoc()) {
                                    echo '<li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">' . htmlspecialchars($applicant['job']) . '</h6>
                                            <small class="text-muted">Applied on ' . date('M d, Y', strtotime($applicant['application_date'])) . '</small>
                                        </div>
                                        <span class="badge bg-' . 
                                        ($applicant['status'] == 'Pending' ? 'warning' : 
                                         ($applicant['status'] == 'Approved' ? 'success' : 
                                          ($applicant['status'] == 'Rejected' ? 'danger' : 'secondary'))) . '">
                                            ' . htmlspecialchars($applicant['status']) . '
                                        </span>
                                    </li>';
                                }
                            } else {
                                echo '<li class="list-group-item">No recent applicants found</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Upcoming Interviews -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5>Upcoming Interviews</h5>
                        <a href="job_list.php" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body recent-applicants">
                        <ul class="list-group list-group-flush">
                            <?php
                            $upcomingInterviews = $conn->query("
                                SELECT a.*, j.job_title 
                                FROM applied_job a
                                JOIN job_post j ON a.job_posting_id = j.id
                                WHERE j.employer_id = $employerid 
                                AND a.interview_date IS NOT NULL
                                AND a.interview_date >= CURDATE()
                                ORDER BY a.interview_date ASC
                                LIMIT 5
                            ");
                            
                            if ($upcomingInterviews->num_rows > 0) {
                                while ($interview = $upcomingInterviews->fetch_assoc()) {
                                    echo '<li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">' . htmlspecialchars($interview['job']) . '</h6>
                                            <small class="text-muted">' . date('M d, Y h:i A', strtotime($interview['interview_date'])) . '</small>
                                        </div>
                                        <span class="badge bg-primary">
                                            Interview
                                        </span>
                                    </li>';
                                }
                            } else {
                                echo '<li class="list-group-item">No upcoming interviews scheduled</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Application Status Pie Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        <?php
        $statusData = $conn->query("
            SELECT status, COUNT(*) as count 
            FROM applied_job 
            WHERE job_posting_id IN (SELECT id FROM job_post WHERE employer_id = $employerid)
            GROUP BY status
        ");
        
        $statusLabels = [];
        $statusCounts = [];
        $statusColors = [];
        
        while ($row = $statusData->fetch_assoc()) {
            $statusLabels[] = $row['status'];
            $statusCounts[] = $row['count'];
            
            // Assign colors based on status
            switch($row['status']) {
                case 'Pending': $statusColors[] = '#ffc107'; break;
                case 'Approved': $statusColors[] = '#28a745'; break;
                case 'Rejected': $statusColors[] = '#dc3545'; break;
                case 'Hired': $statusColors[] = '#17a2b8'; break;
                default: $statusColors[] = '#6c757d'; break;
            }
        }
        ?>
        
        const statusChart = new Chart(statusCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($statusLabels); ?>,
                datasets: [{
                    data: <?php echo json_encode($statusCounts); ?>,
                    backgroundColor: <?php echo json_encode($statusColors); ?>,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
        
        // Top Jobs Bar Chart
        const topJobsCtx = document.getElementById('topJobsChart').getContext('2d');
        <?php
        $topJobsData = $conn->query("
            SELECT j.job_title, COUNT(a.id) as applicant_count
            FROM job_post j
            LEFT JOIN applied_job a ON j.id = a.job_posting_id
            WHERE j.employer_id = $employerid
            GROUP BY j.id, j.job_title
            ORDER BY applicant_count DESC
            LIMIT 5
        ");
        
        $jobTitles = [];
        $applicantCounts = [];
        $jobColors = ['#007bff', '#6610f2', '#6f42c1', '#e83e8c', '#fd7e14'];
        
        while ($row = $topJobsData->fetch_assoc()) {
            $jobTitles[] = $row['job_title'];
            $applicantCounts[] = $row['applicant_count'];
        }
        ?>
        
        const topJobsChart = new Chart(topJobsCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($jobTitles); ?>,
                datasets: [{
                    label: 'Number of Applicants',
                    data: <?php echo json_encode($applicantCounts); ?>,
                    backgroundColor: <?php echo json_encode(array_slice($jobColors, 0, count($jobTitles))); ?>,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>