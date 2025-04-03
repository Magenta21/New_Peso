<?php
include '../db.php';

session_start();

$applicantid = $_SESSION['applicant_id'];
// Check if the employer is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: applicant_login.php");
    exit();
}

$sql = "SELECT * FROM applicant_profile WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $applicantid);
$stmt->execute();
$result_emp = $stmt->get_result();

if (!$result_emp) {
    die("Invalid query: " . $conn->error); 
}

$row_emp = $result_emp->fetch_assoc();
if (!$row_emp) {
    die("User not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant</title>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/jobpage.css">
</head>
<body>

<div class="header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <!-- Logo Section -->
            <div class="col-md-2 col-xxl-3 text-start">
                <a href="#" style="display: block; text-decoration: none;">
                    <img src="../img/logolb.png" alt="lblogo" style="height: 50px;">
                </a>
            </div>
            
            <!-- Municipality Name Section -->
            <div class="col-md-8 col-xxl-6 text-center">
                <h3 style="margin-top: 5px; font-weight: 700; color: #ffffff;">MUNICIPALITY OF LOS BANOS</h3>
            </div>

            <!-- Profile Picture Section -->
            <div class="col-md-2 col-xxl-3 text-end">
                <div class="dropdown">
                    <a href="#" class="text-decoration-none" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php if (!empty($row_emp['photo'])): ?>
                            <img id="preview" src="<?php echo $row_emp['photo']; ?>" alt="Profile Image" class="img-fluid rounded-circle" style="width: 40px; height: 40px;">
                        <?php else: ?>
                            <img src="../img/user-placeholder.png" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 40px; height: 40px;">
                        <?php endif; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-center mt-2" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="applicant_profile.php">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="container mt-4 mb-3">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="toggleButton" href="#" data-tab="joblist" role="tab">Available Job</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="toggleButton4" href="#" data-tab="recommeded" role="tab">Recommeded Job</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="toggleButton3" href="#" data-tab="savejob" role="tab">Saved Job</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="toggleButton2" href="#" data-tab="appliedjob" role="tab">Applied Job</a>
            </li>      
        </ul>
    </div>

    <div class="row align-items-start" style="margin-top:-1.6rem;">
        <div id="joblist" class="jobs">
            <?php 
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
                include 'jobpages/job_list.php'; 
            ?>
        </div>

        <div id="recommeded" class="jobs">
            <?php 
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
                include 'jobpages/job_recommeded.php'; 
            ?>
        </div>

        <div id="savejob" class="jobs">
            <?php 
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
                include 'jobpages/saved_jobs.php'; 
            ?>
        </div>

        <div id="appliedjob" class="jobs">
            <?php 
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
                include 'jobpages/applied_jobs.php'; 
            ?>
        </div>
    </div>
</div>

<script>
// Map between included filenames and tab container IDs
const tabMap = {
    'job_list': 'joblist',
    'job_recommeded': 'recommeded',
    'saved_jobs': 'savejob',
    'applied_jobs': 'appliedjob'
};

// Function to show a specific tab and hide others
function showTab(tabId) {
    // Hide all job lists
    document.querySelectorAll('.jobs').forEach(function(list) {
        list.style.display = 'none';
    });
    
    // Show the selected tab
    document.getElementById(tabId).style.display = 'block';
    
    // Update active state of nav links
    document.querySelectorAll('.nav-link').forEach(function(navLink) {
        navLink.classList.remove('active');
        if (navLink.getAttribute('data-tab') === tabId) {
            navLink.classList.add('active');
        }
    });
    
    // Store the active tab in localStorage
    localStorage.setItem('activeTab', tabId);
    
    // Update URL without reloading
    const url = new URL(window.location);
    url.searchParams.set('tab', tabId);
    window.history.pushState({}, '', url);
}

// On page load, determine which tab to show
document.addEventListener('DOMContentLoaded', function() {
    // Get active tab from URL parameter or localStorage
    const urlParams = new URLSearchParams(window.location.search);
    const activeTabParam = urlParams.get('tab');
    const activeTab = activeTabParam || localStorage.getItem('activeTab') || 'joblist';
    
    // Show the appropriate tab
    showTab(activeTab);
    
    // Set up click handlers for tab buttons
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const tabId = this.getAttribute('data-tab');
            showTab(tabId);
        });
    });
});

// Handle back/forward navigation
window.addEventListener('popstate', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const activeTab = urlParams.get('tab') || 'joblist';
    showTab(activeTab);
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>