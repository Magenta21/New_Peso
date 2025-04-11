<?php
include "db.php";

// Pagination settings
$limit = 1; // Number of news per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch total number of records
$result = $conn->query("SELECT COUNT(id) AS total FROM news");
$row = $result->fetch_assoc();
$total = $row['total'];
$pages = ceil($total / $limit);

// Fetch news
$sql = "SELECT * FROM news ORDER BY schedule_date DESC LIMIT $start, $limit";
$result = $conn->query($sql);

// Pagination display limit
$max_pages_display = 6;
$start_page = max(1, $page - floor($max_pages_display / 2));
$end_page = min($pages, $start_page + $max_pages_display - 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="news.css">
</head>
<body>


<nav class="navbar bg-primary text-white py-2">
    <div class="container-fluid">
        <!-- Navigation Links -->
        <div class="ms-auto"></div>
        <div class="d-flex flex-wrap align-items-center">
            <span class="d-flex flex-wrap align-items-center justify-content-center mx-auto">GOVPH</span>
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
                    <li><a class="dropdown-item text-white" href="#aboutus">About Us</a></li>
                    <li><a class="dropdown-item text-white" href="#contact">Contact Us</a></li>
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
                    <li class="dropdown-submenu position-relative">
                    <a class="dropdown-item text-white" href="training/training_login.php" id="wellnessHilotTrigger">Wellness-Hilot</a>
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

    <div class="container mt-5">
        <h2 class="mb-4">Latest News</h2>
        <div class="row">
            <?php while ($news = $result->fetch_assoc()): ?>
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <img src="<?php echo $news['image']; ?>" class="card-img-top" alt="News Image" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $news['title']; ?></h5>
                            <p class="card-text"><?php echo substr($news['description'], 0, 150); ?>...</p>
                            <p class="text-muted"><small>Scheduled on: <?php echo $news['schedule_date']; ?></small></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        
        <!-- Pagination -->
        <nav>
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                    </li>
                <?php endif; ?>
                
                <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                    <li class="page-item <?php if ($page == $i) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                
                <?php if ($page < $pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
</body>
</html>

<?php
$conn->close();
?>
