<?php
include '../../db.php';
session_start();

if (!isset($_GET['job_id'])) {
    echo "<p>Invalid job listing.</p>";
    exit;
}

if (isset($_GET['job_id'])) {
    $jobId = base64_decode($_GET['job_id']);
    if (!is_numeric($jobId)) {
        die('Invalid ID');
    }
} else {
    die('ID not specified');
}

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
    <title>Applicant List</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/applicant.css">
</head>
<body>
<div class="header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <!-- Logo Section -->
            <div class="col-md-2 col-xxl-3 text-start">
                <a href="#" style="display: block; text-decoration: none;">
                    <img src="../../img/logolb.png" alt="lblogo" style="height: 50px;">
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
                        <?php if (!empty($row_emp['company_photo'])): ?>
                            <img id="preview" src="../<?php echo $row_emp['company_photo']; ?>" alt="Profile Image" class="img-fluid rounded-circle" style="width: 40px; height: 40px;">
                        <?php else: ?>
                            <img src="../../img/user-placeholder.png" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 40px; height: 40px;">
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
    </div>
</div>

<div class="container mt-4">
    <div class="container mt-4 mb-3">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="toggleButton" href="#" data-tab="applicant" role="tab"> Applicants</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="toggleButton4" href="#" data-tab="accepted" role="tab"> Accepted </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="toggleButton3" href="#" data-tab="interview" role="tab">Inteview</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="toggleButton2" href="#" data-tab="rejected" role="tab"> Rejected</a>
            </li>      
        </ul>
    </div>

    <div class="row align-items-start" style="margin-top:-1.6rem;">
        <div id="applicant" class="list">
            <?php 
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
                include 'applicant.php'; 
            ?>
        </div>

        <div id="accepted" class="list">
            <?php 
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
                include 'accepted.php'; 
            ?>
        </div>

        <div id="interview" class="list">
            <?php 
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
                include 'interview.php'; 
            ?>
        </div>

        <div id="rejected" class="list">
            <?php 
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
                include 'rejected.php'; 
            ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tabs - hide all except the active one
    const tabs = ['applicant', 'accepted', 'interview', 'rejected'];
    const defaultTab = 'applicant'; // Set your default tab here

    // Function to show a specific tab and hide others
    function showTab(tabId) {
        // First check if the tab exists
        const tabElement = document.getElementById(tabId);
        if (!tabElement) {
            console.error(`Tab with ID ${tabId} not found`);
            return;
        }

        // Hide all tabs
        tabs.forEach(tab => {
            const element = document.getElementById(tab);
            if (element) {
                element.style.display = 'none';
            }
        });

        // Show the selected tab
        tabElement.style.display = 'block';
        
        // Update active state of nav links
        document.querySelectorAll('.nav-link').forEach(navLink => {
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
    function initializeTabs() {
        // Get active tab from URL parameter or localStorage
        const urlParams = new URLSearchParams(window.location.search);
        const activeTabParam = urlParams.get('tab');
        const activeTab = tabs.includes(activeTabParam) ? activeTabParam : 
                         localStorage.getItem('activeTab') && tabs.includes(localStorage.getItem('activeTab')) ? 
                         localStorage.getItem('activeTab') : defaultTab;
        
        // Show the appropriate tab
        showTab(activeTab);
    }

    // Set up click handlers for tab buttons
    function setupTabHandlers() {
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const tabId = this.getAttribute('data-tab');
                if (tabs.includes(tabId)) {
                    showTab(tabId);
                }
            });
        });
    }

    // Initialize everything
    initializeTabs();
    setupTabHandlers();

    // Handle back/forward navigation
    window.addEventListener('popstate', function() {
        initializeTabs();
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>