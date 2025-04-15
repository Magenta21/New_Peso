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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Create Job Post</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: Arial, sans-serif;
    }
    .form-container {
      margin-top: 50px;
      padding: 30px;
      background: #ffffff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 {
      margin-bottom: 30px;
    }
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    }

    .header {
        background: linear-gradient(to right, #8B0000 30%, #FF0000 80%, #FFC0CB 100%);
        color: white;
        height: 50px;
        width: 100%;
        text-align: center;
    }
    a.navlink {
	color: #ffffff;
	position: relative;
	text-decoration: none;
	margin-left: 20px;
    }
    
    a.navlink::before {
        content: '';
        position: absolute;
        width: 100%;
        height: 4px;
        border-radius: 4px;
        background-color: #ffffff;
        bottom: 0;
        left: 0;
        transform-origin: right;
        transform: scaleX(0);
        transition: transform .3s ease-in-out;
    }
    
    a.navlink:hover::before {
        transform-origin: left;
        transform: scaleX(1);
    }
        /* Fix for bootstrap-tagsinput */
        .bootstrap-tagsinput {
      width: 100%;
      line-height: 2.2;
    }
    .bootstrap-tagsinput .tag {
      margin-right: 2px;
      color: white;
      background-color: #007bff;
      padding: 0.2rem;
      border-radius: 0.2rem;
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
                    <?php if (!empty($row['company_photo'])): ?>
                        <img id="preview" src="<?php echo $row['company_photo']; ?>" alt="Profile Image" class="img-fluid rounded-circle" style="width: 40px; height: 40px;">
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

    <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 form-container">
        <h2 class="text-center">Create Job Post</h2>
        <form action="process/job_process.php" method="post">
          <!-- Job Title -->
          <div class="form-group">
            <label for="job_title">Job Title:</label>
            <input type="text" class="form-control" id="job_title" name="job_title" required>
          </div>
          <!-- Company Name -->
            <input type="hidden" class="form-control" id="company_name" name="company_name" value="<?php echo $row['company_name']; ?>" required>
          <!-- Job Type -->
          <div class="form-group">
            <label for="job_type">Job Type:</label>
            <select id="job_type" name="job_type" class="form-control" required>
              <option value="">Select Job Type</option>
              <option value="full_time">Full Time</option>
              <option value="part_time">Part Time</option>
              <option value="contract">Contract</option>
              <option value="temporary">Temporary</option>
              <option value="internship">Internship</option>
            </select>
          </div>
          <!-- Salary -->
          <div class="form-group">
            <label for="salary">Salary:</label>
            <input type="number" class="form-control" id="salary" name="salary" step="0.01">
          </div>
          <!-- Job Description -->
          <div class="form-group">
            <label for="job_description">Job Description:</label>
            <textarea class="form-control" id="job_description" name="job_description" rows="5"></textarea>
          </div>
          <!-- Skills Input -->
          <div class="form-group">
            <label for="skills">Skills (add multiple skills):</label>
            <input type="text" class="form-control" id="skills" name="skills" data-role="tagsinput" placeholder="Add a skill and press enter">
          </div>
          <!-- Vacancies -->
          <div class="form-group">
            <label for="vacant">Number of Vacancies:</label>
            <input type="number" class="form-control" id="vacant" name="vacant" min="1">
          </div>
          <!-- Requirement -->
          <div class="form-group">
            <label for="requirement">Requirement:</label>
            <textarea class="form-control" id="requirement" name="requirement" rows="3"></textarea>
          </div>
          <!-- Work Location -->
          <div class="form-group">
            <label for="work_location">Work Location:</label>
            <input type="text" class="form-control" id="work_location" name="work_location">
          </div>
          <!-- Education -->
          <div class="form-group">
            <label for="education">Education:</label>
            <input type="text" class="form-control" id="education" name="education">
          </div>
          <!-- Remarks -->
          <div class="form-group">
            <label for="remarks">Remarks:</label>
            <textarea class="form-control" id="remarks" name="remarks" rows="2"></textarea>
          </div>
          <!-- Date Posted -->
            <input type="hidden" class="form-control" id="date_posted" name="date_posted" value="<?php echo date('Y-m-d'); ?>" required>
          <!-- Is Active -->
            <input type="hidden" name="is_active" value="1">
          <!-- Note: employer_id is set in the backend using session data -->
          <button type="submit" class="btn btn-primary btn-block">Submit Job Post</button>
        </form>
      </div>
    </div>
  </div>
  <!-- jQuery, Popper.js, and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- Bootstrap Tags Input JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
