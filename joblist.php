<?php
include 'db.php';

// Define the number of results per page
$limit = 5;

// Get the current page number from URL, default is page 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch total number of jobs
$totalQuery = "SELECT COUNT(id) AS total FROM job_post WHERE is_active = 1";
$totalResult = $conn->query($totalQuery);
$totalRow = $totalResult->fetch_assoc();
$totalJobs = $totalRow['total'];

// Calculate total pages
$totalPages = ceil($totalJobs / $limit);

// Fetch jobs with limit and offset
$query = "SELECT id, job_title, company_name, salary, vacant, work_location FROM job_post WHERE is_active = 1 LIMIT $start, $limit";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="joblist.css">
    <script src="joblist.js" defer></script>
</head>
<body>



<!-- Add the navigation bar here -->
<nav class="navbar bg-primary text-white py-2">
    <div class="container-fluid">
        <!-- Navigation Links -->
        <div class="ms-auto"></div>
        <div class="d-flex flex-wrap align-items-center">
           <a href="https://www.gov.ph/" target="_blank" class="nav-link px-3 text-white">GOVPH</a>
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>
            <a href="index.php" class="nav-link px-3">HOME</a>
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>
            
            <!-- Applicant Dropdown -->
            <div class="dropdown">
                <a class="nav-link px-3 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    APPLICANT
                </a>
                <ul class="dropdown-menu bg-primary">
                    <li><a class="dropdown-item text-white" href="Applicant/applicant_login.php">Login</a></li>
                    <li><a class="dropdown-item text-white" href="Applicant/applicant_register.php">Register</a></li>
                    <li><a class="dropdown-item text-white" href="index.php#aboutus">About Us</a></li>
                    <li><a class="dropdown-item text-white" href="index.php#contact">Contact Us</a></li>
                </ul>
            </div>
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>
            
          
            <!-- Trainings Dropdown -->
            <div class="dropdown">
                <a class="nav-link px-3 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    TRAININGS
                </a>
                <ul class="dropdown-menu bg-primary">
                    <li><a class="dropdown-item text-white" href="training/training_login.php">Welding</a></li>
                    
                    <!-- Wellness-Hilot with nested dropdown -->
                    <li>
                    <a class="dropdown-item text-white" href="training/training_login.php" >Wellness-Hilot</a>
                    </li>                       
                    <li><a class="dropdown-item text-white" href="training/training_login.php">Dressmaking</a></li>
                    <li><a class="dropdown-item text-white" href="training/training_login.php">Computer Literature</a></li>
                </ul>
            </div>
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>
            <!-- OFW Dropdown -->
            <div class="dropdown">
                <a class="nav-link px-3 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    OFW
                </a>
                <ul class="dropdown-menu bg-primary">
                    <li><a class="dropdown-item text-white" href="ofw/ofw_login.php">OFW-Family</a></li>
                    <li><a class="dropdown-item text-white" href="ofw/ofw_benefits.php">OFW him/her self</a></li>
                    
                </ul>
            </div>
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>
            
            <!-- Employer Dropdown -->
            <div class="dropdown">
                <a class="nav-link px-3 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    EMPLOYER
                </a>
                <ul class="dropdown-menu bg-primary">
                    <li><a class="dropdown-item text-white" href="employer/employer_login.php">Local</a></li>
                    <li><a class="dropdown-item text-white" href="employer/employer_login.php">Overseas</a></li>
                    <li><a class="dropdown-item text-white" href="employer/employer_login.php">Direct Hire</a></li>
                    <li><a class="dropdown-item text-white" href="employer/employer_login.php">Agency</a></li>
                </ul>
            </div>
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>
            
            <a href="joblist.php" class="nav-link px-3">JOBS</a>
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>
            <a href="news.php" class="nav-link px-3">NEWS</a>
        </div>
        <div class="ms-auto"></div>
    </div>
</nav>  

<div class="container container-fluid">
    <?php while ($row = $result->fetch_assoc()) { ?>
        <a href="jobdetails.php?id=<?= htmlspecialchars($row['id']) ?>" class="text-decoration-none text-dark">
            <div class="row job-row border rounded mb-3 shadow-sm" style="cursor: pointer;">
                <div class="col-md-2 justify-content-center">
                    <img src="img/mission.png" alt="Profile 1" class="img-fluid" style="width: 100px; height: 100px;">
                </div>
                <div class="col-md-8 row justify-content-start">
                    <div class="col-md-12 pt-3 text-start">
                        <div class="col"><p class="text-start"><i class="bi bi-suitcase-lg"></i> <?= htmlspecialchars($row['job_title']) ?></p></div>
                        <div class="col"><p class="text-start"><i class="bi bi-buildings"></i> <?= htmlspecialchars($row['company_name']) ?></p></div>
                        <div class="col"><p class="text-start"><i class="bi bi-pin-map"></i> <?= htmlspecialchars($row['work_location']) ?></p></div>
                        <div class="col"><p class="text-start"><i class="bi bi-cash"></i> <?= htmlspecialchars($row['salary']) ?></p></div>
                    </div>
                </div>
                <div class="col-md-2 pt-5 text-start">
                    <span class="ms-2 fs-5">
                        <?= htmlspecialchars($row['vacant']) ?> openings
                    </span>
                </div>
            </div>
        </a>
    <?php } ?>
</div>

<!-- Pagination Links -->
<div class="pagination justify-content-center">
    <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>" class="prev">Previous</a>
    <?php endif; ?>

    <span>Page <?= $page ?> of <?= $totalPages ?></span>

    <?php if ($page < $totalPages): ?>
        <a href="?page=<?= $page + 1 ?>" class="next">Next</a>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
