<?php
include "../db.php";

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/profile.css">
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
                            <?php if (!empty($row['company_photo'])): ?>
                                <img id="preview" src="<?php echo $row['company_photo']; ?>" alt="Profile Image" class="profile-pic img-fluid rounded-circle" style="width: 40px; height: 40px;">
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

    <div class="container mt-2">
        <div class="card p-4 shadow">
        <div class="tabs d-flex justify-content-center mb-3">
                <button class="btn btn-outline-primary me-2 active" onclick="switchTab(event, 'profile')">Profile</button>
                <button class="btn btn-outline-primary me-2" onclick="switchTab(event, 'company_details')">Company Detais</button>
                <button class="btn btn-outline-primary" onclick="switchTab(event, 'documents')">Documents</button>
            </div>
            <div id="profile" class="tab-content">
                <form action="save_profile.php" method="post" class="needs-validation" novalidate>
                    <div class="text-center">
                        <input type="file" id="fileInput" class="d-none" onchange="updateProfilePic(event)">
                        <?php if (!empty($row['company_photo'])): ?>
                            <img src="<?php echo $row['company_photo']; ?>" alt="Profile Picture" class="profile-pic rounded-circle border" id="profilePic" onclick="document.getElementById('fileInput').click();">
                        <?php else: ?>
                            <img src="../img/user-placeholder.png" alt="Profile Picture" class="profile-pic rounded-circle border" id="profilePic" onclick="document.getElementById('fileInput').click();">
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username:</label>
                        <input type="text" name="name" class="form-control" value="<?php echo isset($row['username']) ? htmlspecialchars($row['username']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email:</label>
                        <input type="email" name="email" class="form-control" value="<?php echo isset($row['email']) ? htmlspecialchars($row['email']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password:</label>
                        <input type="password" name="pass" class="form-control" value="<?php echo isset($row['password']) ? htmlspecialchars($row['password']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">First name:</label>
                        <input type="text" name="website" class="form-control" value="<?php echo isset($row['fname']) ? htmlspecialchars($row['fname']) : ''; ?>" require >
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Last name:</label>
                        <input type="password" name="password" class="form-control" value="<?php echo isset($row['lname']) ? htmlspecialchars($row['lname']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact number:</label>
                        <input type="tel" name="contact" class="form-control" value="<?php echo isset($row['company_contact']) ? htmlspecialchars($row['company_contact']) : ''; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Save</button>
                </form>
            </div>
            
            <div id="company_details" class="tab-content" style="display:none;">
                <form action="save_company_details.php" method="post" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Company Name:</label>
                        <input type="text" name="company_name" class="form-control" value="<?php echo isset($row['company_name']) ? htmlspecialchars($row['company_name']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">President</label>
                        <input type="text" name="company_address" class="form-control" value="<?php echo isset($row['president']) ? htmlspecialchars($row['president']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Company Address:</label>
                        <input type="text" name="company_address" class="form-control" value="<?php echo isset($row['company_address']) ? htmlspecialchars($row['company_address']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Human Resource Manager</label>
                        <input type="text" name="company_address" class="form-control" value="<?php echo isset($row['hr']) ? htmlspecialchars($row['hr']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact Number</label>
                        <input type="text" name="company_address" class="form-control" value="<?php echo isset($row['company_contact']) ? htmlspecialchars($row['company_contact']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Company Email </label>
                        <input type="text" name="company_address" class="form-control" value="<?php echo isset($row['company_email']) ? htmlspecialchars($row['company_name']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Employment Type:</label>
                        <select name="employment_type" class="form-control" required>
                            <option value="Local Agencies" <?php echo (isset($row['type_of_employer']) && $row['type_of_employer'] == 'local_agencies') ? 'selected' : ''; ?>>Local Agencies </option>           
                            <option value="Local Lb" <?php echo (isset($row['type_of_employer']) && $row['type_of_employer'] == 'local_lb') ? 'selected' : ''; ?>>Los banos Agencies </option>
                            <option value="Overseas" <?php echo (isset($row['type_of_employer']) && $row['type_of_employer'] == 'Overseas') ? 'selected' : ''; ?>>Overseas</option>
                            <option value="Direct Hire" <?php echo (isset($row['type_of_employer']) && $row['type_of_employer'] == 'direct_hire') ? 'selected' : ''; ?>>Overseas</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">Save</button>
                </form>
            </div>
            
            <div id="documents" class="tab-content" style="display:none;">
                <form action="upload_documents.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Upload Resume:</label>
                        <input type="file" name="resume" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Upload Cover Letter:</label>
                        <input type="file" name="cover_letter" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Upload</button>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function switchTab(event, tabName) {
            document.querySelectorAll('.tab-content').forEach(tab => tab.style.display = 'none');
            document.getElementById(tabName).style.display = 'block';
            document.querySelectorAll('.btn-outline-primary').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
        }
        
        function updateProfilePic(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profilePic').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
