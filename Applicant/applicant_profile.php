<?php
include "../db.php";

session_start();

$applicant_profile = $_SESSION['applicant_id'];
// Check if the employer is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: applicant_login.php");
    exit();
}

$sql = "SELECT * FROM applicant_profile WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $applicant_profile);
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                            <?php if (!empty($row['photo'])): ?>
                                <img id="preview" src="<?php echo $row['photo']; ?>" alt="Profile Image" class="profile-pic img-fluid rounded-circle" style="width: 40px; height: 40px;">
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
                <button class="btn btn-outline-primary me-2" onclick="switchTab(event, 'educational_background')">Educational Background</button>
                <button class="btn btn-outline-primary" onclick="switchTab(event, 'documents')">Documents</button>
            </div>
            <div id="profile" class="tab-content">
                <form action="process/save_profile.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <div class="text-center">
                            <input type="file" id="fileInput" class="d-none" name="fileInput" onchange="updateProfilePic(event)">
                            <?php if (!empty($row['photo'])): ?>
                                <img src="<?php echo $row['photo']; ?>" alt="Profile Picture" class="profile-pic rounded-circle border" id="profilePic" onclick="document.getElementById('fileInput').click();">
                            <?php else: ?>
                                <img src="../img/user-placeholder.png" alt="Profile Picture" class="profile-pic rounded-circle border" id="profilePic" onclick="document.getElementById('fileInput').click();">
                            <?php endif; ?>
                        </div>
                        <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Username:</label>
                                <input type="text" name="name" class="form-control" value="<?php echo isset($row['username']) ? htmlspecialchars($row['username']) : ''; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email:</label>
                                <input type="email" name="email" class="form-control" value="<?php echo isset($row['email']) ? htmlspecialchars($row['email']) : ''; ?>" required>
                            </div>
                        </div>
                    

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Password:</label>
                                <input type="password" name="pass" class="form-control" value="<?php echo isset($row['password']) ? htmlspecialchars($row['password']) : ''; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">First name:</label>
                                <input type="text" name="fname" class="form-control" value="<?php echo isset($row['fname']) ? htmlspecialchars($row['fname']) : ''; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Last name:</label>
                                <input type="text" name="lname" class="form-control" value="<?php echo isset($row['lname']) ? htmlspecialchars($row['lname']) : ''; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Contact number:</label>
                                <input type="tel" name="contact" class="form-control" value="<?php echo isset($row['contact_no']) ? htmlspecialchars($row['contact_no']) : ''; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Date of Birth:</label>
                                <input type="date" name="dob" class="form-control" value="<?php echo isset($row['dob']) ? htmlspecialchars($row['dob']) : ''; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Place Of Birth:</label>
                                <input type="text" name="pob" class="form-control" value="<?php echo isset($row['pob']) ? htmlspecialchars($row['pob']) : ''; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Religion:</label>
                                <input type="text" name="religion" class="form-control" value="<?php echo isset($row['religion']) ? htmlspecialchars($row['religion']) : ''; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Present Address:</label>
                                <input type="text" name="address" class="form-control" value="<?php echo isset($row['present_address']) ? htmlspecialchars($row['religion']) : ''; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Civil Status:</label>
                                <select name="civil_status" class="form-control" required>
                                    <option value="single" <?php echo isset($row['civil_status']) && $row['civil_status'] == 'single' ? 'selected' : ''; ?>>Single</option>
                                    <option value="married" <?php echo isset($row['civil_status']) && $row['civil_status'] == 'married' ? 'selected' : ''; ?>>Married</option>
                                    <option value="widowed" <?php echo isset($row['civil_status']) && $row['civil_status'] == 'widowed' ? 'selected' : ''; ?>>Widowed</option>
                                    <option value="separated" <?php echo isset($row['civil_status']) && $row['civil_status'] == 'separated' ? 'selected' : ''; ?>>Separated</option>
                                    <option value="live_in" <?php echo isset($row['civil_status']) && $row['civil_status'] == 'live_in' ? 'selected' : ''; ?>>Live-In</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Sex:</label>
                            <select name="sex" class="form-control" required>
                                <option value="male" <?php echo isset($row['sex']) && $row['sex'] == 'male' ? 'selected' : ''; ?>>Male</option>
                                <option value="female" <?php echo isset($row['sex']) && $row['sex'] == 'female' ? 'selected' : ''; ?>>Female</option>
                            </select>
                        </div>
                    </div>
                </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Height:</label>
                                <input type="text" name="height" class="form-control" value="<?php echo isset($row['height']) ? htmlspecialchars($row['lname']) : ''; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tin:</label>
                                <input type="tel" name="tin" class="form-control" value="<?php echo isset($row['tin']) ? htmlspecialchars($row['contact_no']) : ''; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">GSIS/SSS Number.:</label>
                                <input type="text" name="sss_no" class="form-control" value="<?php echo isset($row['sss_no']) ? htmlspecialchars($row['lname']) : ''; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Pag Ibig Number:</label>
                                <input type="text" name="pag_ibig_number" class="form-control" value="<?php echo isset($row['pagibig_no']) ? htmlspecialchars($row['contact_no']) : ''; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">PhilHealth Number:</label>
                                <input type="text" name="philhealth_no" class="form-control" value="<?php echo isset($row['philhealth_no']) ? htmlspecialchars($row['lname']) : ''; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Landline:</label>
                                <input type="text" name="landline" class="form-control" value="<?php echo isset($row['landline']) ? htmlspecialchars($row['contact_no']) : ''; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Disability:</label>
                                <select name="disability" class="form-control" id="disability" required>
                                    <option value="none" <?php echo isset($row['disability']) && $row['disability'] == 'none' ? 'selected' : ''; ?>>None</option>
                                    <option value="visual" <?php echo isset($row['disability']) && $row['disability'] == 'visual' ? 'selected' : ''; ?>>Visual</option>
                                    <option value="hearing" <?php echo isset($row['disability']) && $row['disability'] == 'hearing' ? 'selected' : ''; ?>>Hearing</option>
                                    <option value="speech" <?php echo isset($row['disability']) && $row['disability'] == 'speech' ? 'selected' : ''; ?>>Speech</option>
                                    <option value="physical" <?php echo isset($row['disability']) && $row['disability'] == 'physical' ? 'selected' : ''; ?>>Physical</option>
                                    <option value="others" <?php echo isset($row['disability']) && $row['disability'] == 'others' ? 'selected' : ''; ?>>Specify</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mt-4" id="disability_specify_container" style="display:none;">
                            <!-- Text input for specifying 'others' -->
                            <input type="text" name="disability_specify" id="disability_specify" class="form-control mt-2" placeholder="Please specify" value="<?php echo isset($row['disability_specify']) ? htmlspecialchars($row['disability_specify']) : ''; ?>" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Are you a 4Ps beneficiary?:</label>
                                <select name="four_ps" class="form-control" id="four_ps" required>
                                    <option value="yes" <?php echo isset($row['four_ps']) && $row['four_ps'] == 'yes' ? 'selected' : ''; ?>>Yes</option>
                                    <option value="no" <?php echo isset($row['four_ps']) && $row['four_ps'] == 'no' ? 'selected' : ''; ?>>No</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6" id="household_id_container" style="display:none;">
                            <div class="mb-3">
                                <label class="form-label">If yes, Household ID No.:</label>
                                <input type="tel" name="household_id" class="form-control" value="<?php echo isset($row['household_id']) ? htmlspecialchars($row['household_id']) : ''; ?>" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Save</button>
                </form>
            </div>

            <div id="educational_background" class="tab-content" style="display:none;">
                <form action="process/save_educational_background.php" method="post" class="needs-validation" novalidate>
                 <h3>Tertiary</h3>   
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">School Name</label>
                        <input type="text" name="school_name" class="form-control" value="<?php echo isset($row['tertiary_school']) ? htmlspecialchars($row['tertiary_school']) : ''; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Year Graduated</label>
                        <input type="date" name="tertiary_graduated" class="form-control" value="<?php echo isset($row['tertiary_graduated']) ? htmlspecialchars($row['tertiary_graduated']) : ''; ?>" required>
                    </div>
               
                    <div class="col-md-6">
                        <label class="form-label">Award Recieved</label>
                        <input type="text" name="award_recieved" class="form-control" value="<?php echo isset($row['tertiary_award']) ? htmlspecialchars($row['tertiary_award']) : ''; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Course</label>
                        <input type="text" name="course" class="form-control" value="<?php echo isset($row['course']) ? htmlspecialchars($row['course']) : ''; ?>" required>
                    </div>
                </div>
                <h3>Graduate Studies</h3>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">School Name</label>
                        <input type="text" name="school_name" class="form-control" value="<?php echo isset($row['college_school']) ? htmlspecialchars($row['college_graduated']) : ''; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Year Graduated</label>
                        <input type="date" name="college_graduated" class="form-control" value="<?php echo isset($row['college_graduated']) ? htmlspecialchars($row['college_graduated']) : ''; ?>" required>
                    </div>
               
                    <div class="col-md-6">
                        <label class="form-label">Award Recieved</label>
                        <input type="text" name="college_award" class="form-control" value="<?php echo isset($row['college_award']) ? htmlspecialchars($row['college_award']) : ''; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Course</label>
                        <input type="text" name="course" class="form-control" value="<?php echo isset($row['course']) ? htmlspecialchars($row['course']) : ''; ?>" required>
                    </div>
                </div>
                    <button type="submit" class="btn btn-primary w-100">Save</button>
                </form>
            </div>
            
            <div id="documents" class="tab-content" style="display:none;">
                <div class="card mb-4">
                    <div class="card-header">Documents</div>
                        <div class="card-body">
                            <form action="process/save_data.php" method="POST" enctype="multipart/form-data">
                                <div id="eligibility-container">
                                    <?php 
                                    // Loop through the fetched documents and display them in the form
                                    foreach ($documents as $index => $doc) { 
                                    ?>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="documents_name[]" value="<?php echo htmlspecialchars($doc['document_type']); ?>" placeholder="Document Name" required>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="date" class="form-control" name="date_upload[]" value="<?php echo isset($row['created_at']) ? htmlspecialchars($row['created_at']) : ''; ?>" required>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="file" class="form-control" name="file[]">
                                            <!-- If there's an existing file, show a link to it -->
                                            <?php if (!empty($doc['document_file'])): ?>
                                                <a href="process/<?php echo $doc['document_file']; ?>" target="_blank">View File</a>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-1 text-center">
                                            <button type="button" class="btn btn-danger" onclick="removeInputGroup(this)">Remove</button>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                                <button type="button" class="btn btn-primary" onclick="addInputGroup()">Add Another Set</button>
                                <button type="submit" class="btn btn-success">Save Eligibility</button>
                            </form>
                        </div>
                </div>
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

        function addInputGroup() {
            const container = $("#eligibility-container");
            const newRow = $(`
                <div class="row mb-3">
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="documents_name[]" placeholder="Document Name" required>
                    </div>
                    <div class="col-md-3">
                        <input type="date" class="form-control" name="date_upload[]" required>
                    </div>
                    <div class="col-md-3">
                        <input type="file" class="form-control" name="file[]" required>
                    </div>
                    <div class="col-md-1 text-center">
                        <button type="button" class="btn btn-danger" onclick="removeInputGroup(this)">Remove</button>
                    </div>
                </div>
            `);
            container.append(newRow);
        }

        function removeInputGroup(button) {
            $(button).closest('.row').remove();
        }

         // Show/Hide the text input based on the selected disability
    document.getElementById('disability').addEventListener('change', function() {
        var disabilitySelect = this.value;
        var disabilitySpecifyContainer = document.getElementById('disability_specify_container');
        
        if (disabilitySelect === 'others') {
            disabilitySpecifyContainer.style.display = 'block'; // Show input if 'Others' is selected
        } else {
            disabilitySpecifyContainer.style.display = 'none'; // Hide input if another option is selected
        }
    });

    // Check initial selected value and show the text input if needed
    if (document.getElementById('disability').value === 'others') {
        document.getElementById('disability_specify_container').style.display = 'block';
    }

    // Show/Hide the Household ID input field based on the selection
    document.getElementById('four_ps').addEventListener('change', function() {
        var fourPsSelect = this.value;
        var householdIdContainer = document.getElementById('household_id_container');
        
        if (fourPsSelect === 'yes') {
            householdIdContainer.style.display = 'block'; // Show input if 'Yes' is selected
        } else {
            householdIdContainer.style.display = 'none'; // Hide input if 'No' is selected
        }
    });

    // Check initial selected value and show the Household ID input if needed
    if (document.getElementById('four_ps').value === 'yes') {
        document.getElementById('household_id_container').style.display = 'block';
    }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
