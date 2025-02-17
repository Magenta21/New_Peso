<?php
include "db.php";

// Pagination settings
$limit = 5; // Number of news per page
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
<div class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <a href="index.php" style="display: block; text-decoration: none;">
                    <img src="img/logolb.png" alt="lblogo" style="height: 50px;">
                </a>
            </div>
            <div class="col-md-8">
                <h3 style="margin-top: 5px; font-weight: 900; color: #ffffff;">Job Listings</h3>
            </div>
        </div>
    </div>
</div>
<nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-text text-white w-100 text-center">
                <a class="navlink" href="index.php">HOME</a>
                <a class="navlink" href="Applicant/applicant_login.php">APPLICANT</a>
                <a class="navlink" href="training/training_login.php">TRAININGS</a>
                <a class="navlink" href="ofw/ofw_login.php">OFW</a>
                <a class="navlink" href="employer/employer_login.php">EMPLOYER</a>
                <a class="navlink" href="institutions/institution_login.php">EDUCATIONAL INSTITUTIONS</a>
                <a class="navlink" href="joblist.php">JOBS</a>
                <a class="navlink" href="news.php">News</a>
            </span>
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
