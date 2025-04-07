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
    <title>Module Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .header {
            background-color: #343a40;
            padding: 10px 0;
            color: white;
        }
        .content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }
        .module-container {
            max-width: 800px;
            width: 100%;
            margin: auto;
            padding: 20px;
        }
        .module-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .module-title {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }
        .view-more-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 5px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .view-more-btn:hover {
            background-color: #218838;
        }
        .locked-module {
            opacity: 0.6;
        }
        .locked-text {
            color: #6c757d;
        }
    </style>
</head>
<body>
<div class="header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-2">
                <a href="../index.php" style="display: block; text-decoration: none;">
                    <img src="../img/logolb.png" alt="lblogo" style="height: 50px;">
                </a>
            </div>
            <div class="col-md-8 text-center">
                <h3 style="margin-top: 5px; font-weight: 900; color: #ffffff;">MUNICIPALITY OF LOS BANOS</h3>
            </div>
            <div class="col-md-2 col-xxl-3 p-1">
                <div class="dropdown">
                    <a href="#" class="text-decoration-none" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php if (!empty($row_emp['photo'])): ?>
                            <img id="preview" src="<?php echo $row_emp['photo']; ?>" alt="Profile Image" class="img-fluid rounded-circle" style="width: 40px; height: 40px;">
                        <?php else: ?>
                            <img src="../img/user-placeholder.png" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 40px; height: 40px;">
                        <?php endif; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-center mt-2" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="training_profile.php">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content-wrapper">
    <div class="module-container">
        <div class="module-card">
            <h3 class="module-title">Frying</h3>
            <a href="#" class="view-more-btn">View More</a>
        </div>

        <div class="module-card locked-module">
            <h3 class="module-title locked-text">Grilling</h3>
            <span class="locked-text">Locked</span>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 