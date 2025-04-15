<?php
include '../db.php';
session_start();

$employerid = $_SESSION['ofw_id'];
// Check if the employer is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ofw_login.php");
    exit();
}

$sql = "SELECT * FROM ofw_profile WHERE id = ?";
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
    <title>Layout Design</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
<nav class="navbar bg-primary text-white py-2">
    <div class="container-fluid">
        <!-- Navigation Links -->
        <img src="../img/logolb.png" alt="lblogo" style="height: 50px;">
        <div class="ms-auto">        
                   
        </div>
        
        <div class="d-flex flex-wrap align-items-center">
        <div class="dropdown">
                <a class="nav-link px-3 " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Home
                </a>
               
            </div>

            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"> </div>
                <a href="#" class="nav-link px-3">Post Report</a>
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>
            
            <!-- Applicant Dropdown -->
            

            <div class="dropdown">
                <a class="nav-link px-3 " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Take a Survey
                </a>
               
            </div>
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>
            
          
            <!-- Trainings Dropdown -->
            <div class="dropdown">
                <a class="nav-link px-3 " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    View Report Status
                </a>
                
            </div>
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>
            <!-- OFW Dropdown -->
            <div class="dropdown">
                <a class="nav-link px-3" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    About Us
                </a>
                
            </div>
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>
            
        </div>
        <div class="ms-auto">
            <div class="dropdown">
                <a href="#" class="text-decoration-none mt-5" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php if (!empty($row['profile_image'])): ?>
                        <img id="preview" src="<?php echo $row['profile_image']; ?>" alt="Profile Image" class="img-fluid rounded-circle" style="width: 40px; height: 40px;">
                    <?php else: ?>
                        <img src="../img/user-placeholder.png" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 40px; height: 40px;">
                    <?php endif; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end text-center mt-2" aria-labelledby="profileDropdown">
                    <li><a class="dropdown-item" href="ofw_profile.php">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

    
    <div class="banner">
    </div>

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
