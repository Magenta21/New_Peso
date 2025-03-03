<?php
include '../db.php';

session_start();

$employerid = $_SESSION['employer_id'];
// Check if the employer is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: employer_login.php");
    exit();
}

// Define the number of results per page
$limit = 5;

// Get the current page number from URL, default is page 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch total number of jobs
$totalQuery = "SELECT COUNT(id) AS total FROM current_employee WHERE employer_id = $employerid";
$totalResult = $conn->query($totalQuery);
$totalRow = $totalResult->fetch_assoc();
$totalemployee = $totalRow['total'];

// Calculate total pages
$totalPages = ceil($totalemployee / $limit);

// Fetch jobs with limit and offset
$query = "SELECT * FROM current_employee WHERE employer_id = $employerid ORDER BY date_posted DESC LIMIT $start, $limit";
$result = $conn->query($query);


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
    <title>Job Listings</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/joblist.css">
</head>
<body>

<div class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2">
                    <img src="../img/logolb.png" alt="lblogo" style="height: 50px;">
                </div>
                <div class="col-md-8">
                    <h3 style="margin-top: 5px; font-weight: 900; color: #ffffff;">MUNICIPALITY OF LOS BANOS</h3>
                </div>
                <div class="col-md-2 mt-1 position-relative">
                    <div class="dropdown">
                        <a href="#" class="text-decoration-none mt-5" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php if (!empty($row_emp['company_photo'])): ?>
                                <img id="preview" src="<?php echo $row_emp['company_photo']; ?>" alt="Profile Image" class="img-fluid rounded-circle" style="width: 40px; height: 40px;">
                            <?php else: ?>
                                <img src="../img/user-placeholder.png" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 40px; height: 40px;">
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end text-center mt-2" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-text text-white w-100 text-center">
                <a class="navlink" href="employer_home.php">Home</a>
                <a class="navlink" href="post_job.php">Job Post</a>
                <a class="navlink" href="job_list.php">Job list</a>
                <a class="navlink" href="employees.php">Employers</a>
            </span>
        </div>
    </nav>

<div class="container container-fluid">
    <?php while ($row = $result->fetch_assoc()) { ?>
        <a href="jobdetails.php?id=<?= urlencode(base64_encode($row['id'])) ?>" class="text-decoration-none text-dark">
            <div class="row job-row border rounded mb-3 shadow-sm" style="cursor: pointer;">
                <div class="col-md-6 row justify-content-start">
                    <div class="col-md-12 pt-3 text-start">
                        <div class="col"><p class="text-start"><i class="bi bi-suitcase-lg"></i> <?= htmlspecialchars($row['']) ?></p></div>
                        <div class="col"><p class="text-start"><i class="bi bi-buildings"></i> <?= htmlspecialchars($row['company_name']) ?></p></div>
                        <div class="col"><p class="text-start"><i class="bi bi-pin-map"></i> <?= htmlspecialchars($row['work_location']) ?></p></div>
                        <div class="col"><p class="text-start"><i class="bi bi-cash"></i> <?= htmlspecialchars($row['salary']) ?></p></div>
                    </div>
                </div>

                <div class="col-md-4 pt-5 text-start">
                    <span class="ms-5 fs-5">
                        <?= htmlspecialchars($row['vacant']) ?> openings
                    </span>
                </div>
                
                <div class="col-md-2 pt-5 text-start">
                <form action="process/hide.php" method="post">
                    <input type="hidden" name="job_id" value="<?= $row['id'] ?>">
                    <button type="submit" class="btn btn-sm <?= $row['is_active'] == 1 ? 'btn-success' : 'btn-danger' ?> toggle-status"
                        data-id="<?= $row['id'] ?>" 
                        data-status="<?= $row['is_active'] ?>">
                        <?= $row['is_active'] == 1 ? 'Active' : 'Inactive' ?>
                    </button>
                </form>
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

</body>
</html>
