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
    <title>Employees</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/employees.css">
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
                <a href="employer_home.php" class="nav-link px-3">Home</a>
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
                    <?php if (!empty($row_emp['company_photo'])): ?>
                        <img id="preview" src="<?php echo $row_emp['company_photo']; ?>" alt="Profile Image" class="img-fluid rounded-circle" style="width: 40px; height: 40px;">
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


    
    </nav>
    <div class="container mt-4">
        <div class="container mt-4 mb-3">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="toggleButton" href="#" role="tab">Male employees</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="toggleButton2" href="#" role="tab">Female employees</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="toggleButton4" href="#" role="tab">Add employees</a>
                </li>
            </ul>
        </div>





        <div class="row align-items-start"  style="margin-top:-1.6rem;">
            <div id="maleemployerlist" class="employers">
                <?php 
                    error_reporting(E_ALL);
                    ini_set('display_errors', 1);
                    include 'employees/maleemployees_list.php'; 
                ?>
            </div>

            <div id="femaleemployerlist" class="employers">
                <?php 
                    error_reporting(E_ALL);
                    ini_set('display_errors', 1);
                    include 'employees/femaleemployees_list.php'; 
                ?>
            </div>

            <div id="addemployerlist" class="employers">
                <?php 
                    error_reporting(E_ALL);
                    ini_set('display_errors', 1);
                    include 'employees/addemployees.php'; 
                ?>
            </div>
        </div>
    </div>


    <script>
        // Hide all job lists initially
        document.querySelectorAll('.employers').forEach(function (list) {
            list.style.display = 'none';
        });

        // Show the job list by default
        document.getElementById('maleemployerlist').style.display = 'block';

        // Button event listeners for showing the respective job list
        document.getElementById('toggleButton').addEventListener('click', function (event) {
            event.preventDefault(); // Prevent default anchor click behavior
            toggleJobList('maleemployerlist', this);
        });

        document.getElementById('toggleButton2').addEventListener('click', function (event) {
            event.preventDefault(); // Prevent default anchor click behavior
            toggleJobList('femaleemployerlist', this);
        });

        document.getElementById('toggleButton4').addEventListener('click', function (event) {
            event.preventDefault(); // Prevent default anchor click behavior
            toggleJobList('addemployerlist', this);
        });

        // Function to toggle job lists
        function toggleJobList(containerId, button) {
            document.querySelectorAll('.employers').forEach(function(list) {
                list.style.display = 'none';
            });
            document.getElementById(containerId).style.display = 'block';
            document.querySelectorAll('.nav-link').forEach(function(navLink) {
                navLink.classList.remove('active');
            });
            button.classList.add('active');
        }
    </script>
</body>
</html>
