<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "peso";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pagination settings
$jobs_per_page = 2;
$max_pages_shown = 1;

// Get current page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);

// Count total jobs
$total_jobs_query = "SELECT COUNT(*) AS total FROM job_postings";
$result = $conn->query($total_jobs_query);
$total_jobs = $result->fetch_assoc()['total'];

$total_pages = ceil($total_jobs / $jobs_per_page);
$start = ($page - 1) * $jobs_per_page;

// Fetch jobs for current page
$jobs_query = "SELECT * FROM job_postings LIMIT $start, $jobs_per_page";
$jobs_result = $conn->query($jobs_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .job-listing { border-bottom: 1px solid #ddd; padding: 10px; }
        .pagination { margin-top: 20px; }
        .pagination a { padding: 5px 10px; border: 1px solid #ddd; text-decoration: none; margin-right: 5px; }
        .pagination a.active { background: #007bff; color: white; }
    </style>
</head>
<body>
    <h1>Job Listings</h1>
    <div id="jobs">
        <?php while ($job = $jobs_result->fetch_assoc()): ?>
            <div class="job-listing">
                <h3><?php echo htmlspecialchars($job['job_title']); ?></h3>
                <p><?php echo htmlspecialchars($job['job_description']); ?></p>
            </div>
        <?php endwhile; ?>
    </div>
    
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>">Previous</a>
        <?php endif; ?>
        
        <?php
        $start_page = max(1, $page - floor($max_pages_shown / 2));
        $end_page = min($total_pages, $start_page + $max_pages_shown - 1);
        
        for ($i = $start_page; $i <= $end_page; $i++): ?>
            <a href="?page=<?php echo $i; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
        
        <?php if ($total_pages > $end_page): ?>
            <a href="?page=<?php echo $page + 1; ?>">Next</a>
        <?php endif; ?>
    </div>
</body>
</html>

<?php $conn->close(); ?>
