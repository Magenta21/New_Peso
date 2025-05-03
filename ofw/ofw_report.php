<?php
include '../db.php';
session_start();

$ofwid = $_SESSION['ofw_id'];
// Check if the employer is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ofw_login.php");
    exit();
}

$sql = "SELECT * FROM ofw_profile WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ofwid);
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
    <title>Submit Case - OFW Portal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .form-container {
            max-width: 700px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .form-header {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
        }
        .form-header h2 {
            font-weight: 600;
        }
        .form-group label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 8px;
        }
        .form-control {
            padding: 10px 15px;
            border-radius: 4px;
            border: 1px solid #ced4da;
            transition: border-color 0.3s;
        }
        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }
        .btn-primary {
            background-color: #3498db;
            border: none;
            padding: 10px 25px;
            font-weight: 500;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #2980b9;
        }
        .file-upload-info {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 5px;
        }
    </style>
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
                <a href="ofw_home.php" class="nav-link px-3">Home</a>
                
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>

                <a href="ofw_report.php" class="nav-link px-3">Post Report</a>

            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>

                <a href="ofw_files.php" class="nav-link px-3">View Report Status</a>

            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"> </div>
            
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


    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <h2>Submit New Case</h2>
                <p>Please provide details about your case to get assistance</p>
            </div>
            
            <form action="process/submit_case.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="userid" id="ofwId">
                
                <div class="form-group mb-4">
                    <label for="title">Case Title</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Brief title describing your case" required>
                </div>
                
                <div class="form-group mb-4">
                    <label for="description">Case Description</label>
                    <textarea name="description" id="description" class="form-control" rows="5" placeholder="Provide detailed information about your case including relevant dates, locations, and other important details" required></textarea>
                </div>
                
                <div class="form-group mb-4">
                    <label for="file">Upload Supporting Documents</label>
                    <input type="file" name="file" id="file" class="form-control">
                    <div class="file-upload-info">(Optional) Upload any supporting documents like contracts, photos, or other evidence (Max 5MB)</div>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="submit" class="btn btn-primary px-4 py-2">Submit Case</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>