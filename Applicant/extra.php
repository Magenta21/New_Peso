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

//training
$sql_training = "SELECT * FROM training WHERE user_id = ?";
$stmt_training = $conn->prepare($sql_training);
$stmt_training->bind_param("i", $applicant_profile);
$stmt_training->execute();
$result_training = $stmt_training->get_result();

// Fetch data from license table
$sql_license = "SELECT * FROM license WHERE user_id = ?";
$stmt_license = $conn->prepare($sql_license);
$stmt_license->bind_param("i", $userId);
$stmt_license->execute();
$result_license = $stmt_license->get_result();

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

<div class="container-xxl mt-2">
        <div class="card p-4 shadow">
            <div class="row">
                <div class="col-md-3">
                    <!-- Vertical List for Tabs (Navigation) -->
                    <div class="list-group">
                        <button class="list-group-item list-group-item-action active" onclick="switchTab(event, 'profile')">Profile</button>
                        <button class="list-group-item list-group-item-action" onclick="switchTab(event, 'educational_background')">Educational Background</button>
                        <button class="list-group-item list-group-item-action" onclick="switchTab(event, 'employment_status')">Employment Status</button>
                        <button class="list-group-item list-group-item-action" onclick="switchTab(event, 'documents')">Documents</button>
                    </div>
                </div>

                <div class="col-md-9">
                    <!-- Content for Tabs -->
                    <div id="profile" class="tab-content" style="display:block;">
                        <form action="process/save_profile.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                                <div class="text-center">
                                    <input type="file" id="fileInput" class="d-none" name="fileInput" onchange="updateProfilePic(event)">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                            <label class="form-label">Username:</label>
                                            <input type="text" name="name" class="form-control" value="<?php echo isset($row['username']) ? htmlspecialchars($row['username']) : ''; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                            <label class="form-label">Email:</label>
                                            <input type="email" name="email" class="form-control" value="<?php echo isset($row['email']) ? htmlspecialchars($row['email']) : ''; ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                            <label class="form-label">Password:</label>
                                            <input type="password" name="pass" class="form-control" value="<?php echo isset($row['password']) ? htmlspecialchars($row['password']) : ''; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                            <label class="form-label">First name:</label>
                                            <input type="text" name="fname" class="form-control" value="<?php echo isset($row['fname']) ? htmlspecialchars($row['fname']) : ''; ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                            <label class="form-label">Last name:</label>
                                            <input type="text" name="lname" class="form-control" value="<?php echo isset($row['lname']) ? htmlspecialchars($row['lname']) : ''; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                            <label class="form-label">Contact number:</label>
                                            <input type="tel" name="contact" class="form-control" value="<?php echo isset($row['contact_no']) ? htmlspecialchars($row['contact_no']) : ''; ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                            <label class="form-label">Date of Birth:</label>
                                            <input type="date" name="dob" class="form-control" value="<?php echo isset($row['dob']) ? htmlspecialchars($row['dob']) : ''; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                            <label class="form-label">Place Of Birth:</label>
                                            <input type="text" name="pob" class="form-control" value="<?php echo isset($row['pob']) ? htmlspecialchars($row['pob']) : ''; ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                            <label class="form-label">Religion:</label>
                                            <input type="text" name="religion" class="form-control" value="<?php echo isset($row['religion']) ? htmlspecialchars($row['religion']) : ''; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                            <label class="form-label">Present Address:</label>
                                            <input type="text" name="address" class="form-control" value="<?php echo isset($row['present_address']) ? htmlspecialchars($row['religion']) : ''; ?>" required>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                            <label class="form-label">Civil Status:</label>
                                            <select name="civil_status" class="form-control" required>
                                                <option value="single" <?php echo isset($row['civil_status']) && $row['civil_status'] == 'single' ? 'selected' : ''; ?>>Single</option>
                                                <option value="married" <?php echo isset($row['civil_status']) && $row['civil_status'] == 'married' ? 'selected' : ''; ?>>Married</option>
                                                <option value="widowed" <?php echo isset($row['civil_status']) && $row['civil_status'] == 'widowed' ? 'selected' : ''; ?>>Widowed</option>
                                                <option value="separated" <?php echo isset($row['civil_status']) && $row['civil_status'] == 'separated' ? 'selected' : ''; ?>>Separated</option>
                                                <option value="live_in" <?php echo isset($row['civil_status']) && $row['civil_status'] == 'live_in' ? 'selected' : ''; ?>>Live-In</option>
                                            </select>
                                    </div>

                                    <div class="col-md-6">
                                            <label class="form-label">Sex:</label>
                                            <select name="sex" class="form-control" required>
                                                <option value="male" <?php echo isset($row['sex']) && $row['sex'] == 'male' ? 'selected' : ''; ?>>Male</option>
                                                <option value="female" <?php echo isset($row['sex']) && $row['sex'] == 'female' ? 'selected' : ''; ?>>Female</option>
                                            </select>
                                    </div>
                                </div>

                                <div class="row">
                                <div class="col-md-6">
                                        <label class="form-label">Height:</label>
                                        <input type="text" name="height" class="form-control" value="<?php echo isset($row['height']) ? htmlspecialchars($row['lname']) : ''; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                        <label class="form-label">Tin:</label>
                                        <input type="tel" name="tin" class="form-control" value="<?php echo isset($row['tin']) ? htmlspecialchars($row['contact_no']) : ''; ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                        <label class="form-label">GSIS/SSS Number.:</label>
                                        <input type="text" name="sss_no" class="form-control" value="<?php echo isset($row['sss_no']) ? htmlspecialchars($row['lname']) : ''; ?>" required>
                                </div>
                                <div class="col-md-6">
                                        <label class="form-label">Pag Ibig Number:</label>
                                        <input type="text" name="pag_ibig_number" class="form-control" value="<?php echo isset($row['pagibig_no']) ? htmlspecialchars($row['contact_no']) : ''; ?>" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                        <label class="form-label">PhilHealth Number:</label>
                                        <input type="text" name="philhealth_no" class="form-control" value="<?php echo isset($row['philhealth_no']) ? htmlspecialchars($row['lname']) : ''; ?>" required>
                                </div>
                                <div class="col-md-6">
                                        <label class="form-label">Landline:</label>
                                        <input type="text" name="landline" class="form-control" value="<?php echo isset($row['landline']) ? htmlspecialchars($row['contact_no']) : ''; ?>" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
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

                                <div class="col-md-6 mt-4" id="disability_specify_container" style="display:none;">
                                    <!-- Text input for specifying 'others' -->
                                    <input type="text" name="disability_specify" id="disability_specify" class="form-control mt-2" placeholder="Please specify" value="<?php echo isset($row['disability_specify']) ? htmlspecialchars($row['disability_specify']) : ''; ?>" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                        <label class="form-label">Are you a 4Ps beneficiary?:</label>
                                        <select name="four_ps" class="form-control" id="four_ps" required>
                                            <option value="yes" <?php echo isset($row['four_ps']) && $row['four_ps'] == 'yes' ? 'selected' : ''; ?>>Yes</option>
                                            <option value="no" <?php echo isset($row['four_ps']) && $row['four_ps'] == 'no' ? 'selected' : ''; ?>>No</option>
                                        </select>
                                </div>

                                <div class="col-md-6" id="household_id_container" style="display:none;">
                                        <label class="form-label">If yes, Household ID No.:</label>
                                        <input type="tel" name="household_id" class="form-control" value="<?php echo isset($row['household_id']) ? htmlspecialchars($row['household_id']) : ''; ?>" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Save</button>
                        </form>
                    </div>

                    <div id="educational_background" class="tab-content" style="display:none;">
                        <form action="process/save_educational_background.php" method="post" class="needs-validation" novalidate>
                             <!-- Educational Background Form -->
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

                    <div id="employment_status" class="tab-content" style="display:none;">
                        <form action="process/save_employment_status.php" method="post" class="needs-validation" novalidate>
                            <!-- Employment Status Form -->
                            <div class="row">
                                    <div class="col-md-12">   
                                        <label for="employment-status" class="info">Employment Status:</label>
                                    </div>
                                    <!-- Preferred Work Location Dropdown -->
                                    <div class="col-md-6 mb-3">
                                        <label for="preferred-location" class="info">Preferred Work Location:</label>
                                        <select class="form-select" id="preferred-location" name="preferred_work_location" required>
                                            <option value="">Select</option>
                                            <option value="local" <?php echo (isset($row['preferred_work_location']) && $row['preferred_work_location'] == 'local') ? 'selected' : ''; ?>>Local, specify cities/municipalities</option>
                                            <option value="overseas" <?php echo (isset($row['preferred_work_location']) && $row['preferred_work_location'] == 'overseas') ? 'selected' : ''; ?>>Overseas, specify country</option>
                                        </select>
                                    </div>
                                    <div class=col-md-6>
                                        <label for="employment-status" class="info">expected salary:</label>
                                        <input type="text" name="expected_salary" class="form-control" value="<?php echo isset($row['expected_salary']) ? htmlspecialchars($row['expected_salary']) : ''; ?>" required>
                                    </div>
                            </div>

                            <!-- Local Locations Input Fields (Displayed in a row) -->
                            <div id="local-location-fields" class="row" style="display:none;">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="local-location-1" class="info">1 - City/Municipality:</label>
                                        <input type="text" class="form-control" id="local-location-1" name="local_location_1" placeholder="City/Municipality" value="<?php echo isset($row['local_location_1']) ? htmlspecialchars($row['local_location_1']) : ''; ?>" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="local-location-2" class="info">2 - City/Municipality:</label>
                                        <input type="text" class="form-control" id="local-location-2" name="local_location_2" placeholder="City/Municipality" value="<?php echo isset($row['local_location_2']) ? htmlspecialchars($row['local_location_2']) : ''; ?>" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="local-location-3" class="info">3 - City/Municipality:</label>
                                        <input type="text" class="form-control" id="local-location-3" name="local_location_3" placeholder="City/Municipality" value="<?php echo isset($row['local_location_3']) ? htmlspecialchars($row['local_location_3']) : ''; ?>" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Overseas Locations Input Fields (Displayed in a row) -->
                            <div id="overseas-location-fields" class="row" style="display:none;">
                                <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="overseas-location-1" class="info">1 - Country:</label>
                                            <input type="text" class="form-control" id="overseas-location-1" name="overseas_location_1" placeholder="Country" value="<?php echo isset($row['overseas_location_1']) ? htmlspecialchars($row['overseas_location_1']) : ''; ?>" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="overseas-location-2" class="info">2 - Country:</label>
                                            <input type="text" class="form-control" id="overseas-location-2" name="overseas_location_2" placeholder="Country" value="<?php echo isset($row['overseas_location_2']) ? htmlspecialchars($row['overseas_location_2']) : ''; ?>" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="overseas-location-3" class="info">3 - Country:</label>
                                            <input type="text" class="form-control" id="overseas-location-3" name="overseas_location_3" placeholder="Country" value="<?php echo isset($row['overseas_location_3']) ? htmlspecialchars($row['overseas_location_3']) : ''; ?>" required>
                                        </div>
                                </div>
                            </div>
                            
                            <!-- Preferred Occupation Input Fields in a Row -->
                                Preferred Occupation
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <input type="text" class="form-control" id="occupation-1" name="preferred_occupation1" placeholder="1- Occupation" value="<?php echo isset($row['preferred_occupation1']) ? htmlspecialchars($row['preferred_occupation1']) : ''; ?>" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <input type="text" class="form-control" id="occupation-2" name="preferred_occupation2" placeholder="2- Occupation" value="<?php echo isset($row['preferred_occupation2']) ? htmlspecialchars($row['preferred_occupation2']) : ''; ?>" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <input type="text" class="form-control" id="occupation-3" name="preferred_occupation3" placeholder="3- Occupation" value="<?php echo isset($row['preferred_occupation3']) ? htmlspecialchars($row['preferred_occupation3']) : ''; ?>" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <input type="text" class="form-control" id="occupation-4" name="preferred_occupation4" placeholder="4- Occupation" value="<?php echo isset($row['preferred_occupation4']) ? htmlspecialchars($row['preferred_occupation4']) : ''; ?>" required>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        Passport Number
                                        <input type="text" class="form-control" id="passport" name="passport_no" placeholder="" value="<?php echo isset($row['passport_no']) ? htmlspecialchars($row['passport_no']) : ''; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <h5>Expiry Date</h5>
                                        <input type="date" class="form-control" id="expiry" name="passport_expiry" placeholder="" value="<?php echo isset($row['passport_expiry']) ? htmlspecialchars($row['passport_expiry']) : ''; ?>">
                                    </div>
                                </div> 

                            <!-- Other Skills Acquired Without Formal Training Card -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h4>Skills Acquired Without Formal Training</h4>
                                        </div>

                                            <!-- New Option Section -->
                                            <div id="newOptionContainer" class="mt-3">
                                                <input type="text" id="newOption" placeholder="Enter Skills acquired:" class="form-control mb-2">
                                                <button id="addButton" type="button" class="btn btn-primary">Submit</button>
                                            </div>
                                            <input type="hidden" name="selectedOptions" id="selectedOptionsHidden">
                                            <!-- Display Selected Skills -->
                                            <div id="selectedOptionsContainer" class="mt-3">
                                                <h5>Selected Skills:</h5>
                                                <ul id="selectedOptionsList">
                                                    <!-- Dynamically generated list items for selected skills -->
                                                </ul>
                                            </div>  
                                        </div>
                                    </div>

                    <!-- Training Container -->
                        <div id="training-container">
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <h4>Technical/Vocational and Other Training</h4>
                                    </div>
                                </div>
                            <?php if ($result_training->num_rows > 0): ?>
                                <?php while ($row_training = $result_training->fetch_assoc()): ?>
                                    <div class="row mb-4 mt-4">
                                    <!-- Training Name -->
                                        <div class="col-md-5">
                                            <input type="text" class="form-control m-5" name="training[]" value="" placeholder="Vocational/Training" required>
                                        </div>
                                    <!-- Start and End Date -->
                                        <div class="col-md-3">
                                            <input type="date" class="form-control m-5" name="start_date[]" value="" required>
                                        </div>
                                        <div class="col-md-1">
                                            <span class="align-self-center">to</span>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="date" class="form-control" name="end_date[]" value="" required>
                                        </div>
                                    </div>

                                    <div class="row-mb-4">
                                    <!-- Institution -->
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="institution[]" value="" placeholder="Institution" required>
                                        </div>
                                    <!-- Certificate Upload -->
                                        <div class="col-md-6 mt-4">
                                            <?php if (!empty($row_training['certificate_path'])): ?>
                                                <a href="" class="form-control" target="_blank">View Certificate</a>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-6 mt-4">
                                            <input type="file" class="form-control" name="certificate[]">
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                            <!-- No training records found, show an empty row for new input -->
                                <div class="row mb-4">
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="training[]" placeholder="Training/Vocational" required>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <input type="date" class="form-control" name="start_date[]" required>
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <span>to</span>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <input type="date" class="form-control" name="end_date[]" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        <input type="text" class="form-control" name="institution[]" placeholder="Institution" required>
                                    </div>
                                    <div class="col-md-6 text-center">
                                        <input type="file" class="form-control" name="certificate[]">
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <button type="button" class="btn btn-danger" onclick="removeTrainingGroup(this)">Remove</button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                                
                        <!-- Button to Add Another Training Set -->
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button type="button" class="btn btn-primary" onclick="addTrainingGroup()">Add Another Training Set</button>
                            </div>
                        </div>

                                    <!-- Eligibility/Professional License Card -->
                                    <div id="eligibility-container">
                                        <div class="row mb-4">
                                            <div class="col-md-12">
                                                    <h4>Eligibility/Professional License</h4>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                    <div class="col-md-2 text-center">
                                                        <label>Eligibility (Civil Service)</label>
                                                    </div>
                                                    <div class="col-md-2 text-center">
                                                        <label>Rating</label>
                                                    </div>
                                                    <div class="col-md-2 text-center">
                                                        <label>Date of Examination</label>
                                                    </div>
                                                    <div class="col-md-4 text-center">
                                                        <label>Professional License (PRC) (upload file)</label>
                                                    </div>
                                                    <div class="col-md-1 text-center">
                                                        <label>Action</label>
                                                    </div>
                                            </div>

                                                <!-- Loop through the result set and display existing data as read-only -->
                                                <?php if ($result_license->num_rows > 0): ?>
                                                <?php while ($row_license = $result_license->fetch_assoc()): ?>
                                                <div class="row mb-2">
                                                    <div class="col-md-2">
                                                        <!-- Display existing eligibility -->
                                                        <p><?php echo htmlspecialchars($row_license['eligibility']); ?></p>
                                                        <input type="hidden" name="existing_eligibility[]" value="<?php echo htmlspecialchars($row_license['eligibility']); ?>">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <!-- Display existing rating -->
                                                        <p><?php echo htmlspecialchars($row_license['rating']); ?></p>
                                                        <input type="hidden" name="existing_rating[]" value="<?php echo htmlspecialchars($row_license['rating']); ?>">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <!-- Display existing date of examination -->
                                                        <p><?php echo htmlspecialchars($row_license['doe']); ?></p>
                                                        <input type="hidden" name="existing_doe[]" value="<?php echo htmlspecialchars($row_license['doe']); ?>">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <!-- Display existing PRC path (with link to the file) -->
                                                        <?php if (!empty($row_license['prc_path'])): ?>
                                                        <a href="../../php/applicant/<?php echo htmlspecialchars($row_license['prc_path']); ?>" class="form-control" target="_blank">View License</a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <?php endwhile; ?>
                                                <?php endif; ?>

                                                <!-- Empty row for new inputs -->
                                                <div id="input-container">
                                                    <div class="row mb-2">
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control " name="eligibility[]" placeholder="Eligibility" required>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control " name="rating[]" placeholder="Rating" required>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="date" class="form-control" name="exam_date[]" required>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="file" class="form-control" name="license[]" required>
                                                        </div>
                                                        <div class="col-md-1 text-center">
                                                            <button type="button" class="btn btn-danger" onclick="removeInputGroup(this)">Remove</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Button to Add Another Training Set -->
                                                <div class="row">
                                                    <div class="col-md-12 text-right">
                                                        <button type="button" class="btn btn-primary" onclick="addInputGroup()">Add Another Set</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Save Button with Spacing -->
                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary w-100">Save</button>
                                            </div>
                                        </div>
                                    </div>
                        </form>
                    </div>

                    <div id="ss" class="tab-content" style="display:none;">
                        <div class="card mb-4">
                            <div class="card-header">Documents</div>
                            <div class="card-body">
                                <form action="process/save_data.php" method="POST" enctype="multipart/form-data">
                                    <!-- New Option Section -->
                                    <div id="newOptionContainer" class="mt-3">
                                        <input type="text" id="newOption" placeholder="Enter Skills acquired:" class="form-control mb-2">
                                        <button id="addButton" type="button" class="btn btn-primary">Submit</button>
                                    </div>
                                    <input type="hidden" name="selectedOptions" id="selectedOptionsHidden">
                                    <!-- Display Selected Skills -->
                                    <div id="selectedOptionsContainer" class="mt-3">
                                        <h5>Selected Skills:</h5>
                                        <ul id="selectedOptionsList">
                                            <!-- Dynamically generated list items for selected skills -->
                                        </ul>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 mt-4">Save Documents</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <script>
        function switchTab(event, tabName) {
            // Hide all tab content
            document.querySelectorAll('.tab-content').forEach(tab => tab.style.display = 'none');

            // Show the selected tab's content
            document.getElementById(tabName).style.display = 'block';

            // Remove 'active' class from all buttons
            document.querySelectorAll('.list-group-item').forEach(btn => btn.classList.remove('active'));

            // Add 'active' class to the clicked button
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
    
     // Show the appropriate input fields based on the selected location
     document.getElementById('preferred-location').addEventListener('change', function() {
        var locationType = this.value;
        var localFields = document.getElementById('local-location-fields');
        var overseasFields = document.getElementById('overseas-location-fields');

        // Show Local fields and hide Overseas fields
        if (locationType === 'local') {
            localFields.style.display = 'block'; // Show local input fields
            overseasFields.style.display = 'none'; // Hide overseas input fields
        }
        // Show Overseas fields and hide Local fields
        else if (locationType === 'overseas') {
            localFields.style.display = 'none'; // Hide local input fields
            overseasFields.style.display = 'block'; // Show overseas input fields
        } else {
            localFields.style.display = 'none'; // Hide both if no option selected
            overseasFields.style.display = 'none'; // Hide both if no option selected
        }
    });     

    function addTrainingGroup() {
        // Get the training container where rows are added
        const container = document.getElementById('training-container');

        // Create a new div element for the row
        const newRow = document.createElement('div');
        newRow.classList.add('row', 'mb-4');

        // Set the inner HTML of the new row
        newRow.innerHTML = `
            <!-- Training Name -->
            <div class="col-md-5">
                <input type="text" class="form-control" name="training[]" placeholder="Vocational/Training" required>
            </div>
            <!-- Start and End Date -->
            <div class="col-md-3 text-center">
                <input type="date" class="form-control" name="start_date[]" required>
            </div>
            <div class="col-md-1 text-center">
                <span>to</span>
            </div>
            <div class="col-md-3 text-center">
                <input type="date" class="form-control" name="end_date[]" required>
            </div>
            <!-- Institution -->
            <div class="col-md-4">
                <input type="text" class="form-control" name="institution[]" placeholder="Institution" required>
            </div>
            <!-- Certificate Upload -->
            <div class="col-md-6">
                <input type="file" class="form-control" name="certificate[]">
            </div>
            <!-- Remove Button -->
            <div class="col-md-1 text-center">
                <button type="button" class="btn btn-danger" onclick="removeTrainingGroup(this)">Remove</button>
            </div>
        `;

        // Append the newly created row to the container
        container.appendChild(newRow);
    }

    // Function to remove a training row when the remove button is clicked
    function removeTrainingGroup(button) {
        // Find the parent row of the clicked remove button and remove it
        button.closest('.row').remove();
    }

      // Get elements from the DOM
      const selectBox = document.getElementById('dynamicSelect');
    const newOptionInput = document.getElementById('newOption');
    const addButton = document.getElementById('addButton');
    const selectedOptionsList = document.getElementById('selectedOptionsList');
    const selectedOptionsHidden = document.getElementById('selectedOptionsHidden');

    // Array to store selected options
    let selectedOptions = [];

    // Function to update the hidden input field
    function updateHiddenField() {
        selectedOptionsHidden.value = selectedOptions.join(', ');
    }

    // Add new option to the list
    addButton.addEventListener('click', function() {
        const newSkill = newOptionInput.value.trim();
        
        if (newSkill && !selectedOptions.includes(newSkill)) {
            selectedOptions.push(newSkill);

            // Add to the selected options list
            const li = document.createElement('li');
            li.textContent = newSkill;
            
            // Create the remove button
            const removeBtn = document.createElement('button');
            removeBtn.textContent = 'Remove';
            removeBtn.classList.add('btn', 'btn-danger', 'btn-sm', 'ms-2');
            removeBtn.onclick = () => removeSkill(newSkill, li);
            li.appendChild(removeBtn);

            selectedOptionsList.appendChild(li);

            // Clear the input field
            newOptionInput.value = '';
            updateHiddenField();
        }
    });

    // Handle select box change
    selectBox.addEventListener('change', function() {
        // Get the selected options
        const selected = Array.from(selectBox.selectedOptions)
            .filter(option => option.value !== 'add')
            .map(option => option.value);

        // Add the selected options to the list dynamically
        selected.forEach(skill => {
            if (!selectedOptions.includes(skill)) {
                selectedOptions.push(skill);

                const li = document.createElement('li');
                li.textContent = skill;

                // Create the remove button
                const removeBtn = document.createElement('button');
                removeBtn.textContent = 'Remove';
                removeBtn.classList.add('btn', 'btn-danger', 'btn-sm', 'ms-2');
                removeBtn.onclick = () => removeSkill(skill, li);
                li.appendChild(removeBtn);

                selectedOptionsList.appendChild(li);
            }
        });

        // Update the hidden field with selected skills
        updateHiddenField();
    });

    // Remove skill from the list and hidden field
    function switchTab(event, tabName) {
            // Hide all tab content
            document.querySelectorAll('.tab-content').forEach(tab => tab.style.display = 'none');

            // Show the selected tab's content
            document.getElementById(tabName).style.display = 'block';

            // Remove 'active' class from all buttons
            document.querySelectorAll('.list-group-item').forEach(btn => btn.classList.remove('active'));

            // Add 'active' class to the clicked button
            event.target.classList.add('active');
        }

    // Update the selected options list on page load (if any options are pre-selected)
    document.addEventListener('DOMContentLoaded', function() {
        if (selectedOptions.length > 0) {
            selectedOptions.forEach(skill => {
                const li = document.createElement('li');
                li.textContent = skill;

                // Create the remove button
                const removeBtn = document.createElement('button');
                removeBtn.textContent = 'Remove';
                removeBtn.classList.add('btn', 'btn-danger', 'btn-sm', 'ms-2');
                removeBtn.onclick = () => removeSkill(skill, li);
                li.appendChild(removeBtn);

                selectedOptionsList.appendChild(li);
            });
        }
    });
     
    // Function to add a new set of inputs
    function addInputGroup() {
        const container = document.getElementById('input-container');
        
        const newRow = document.createElement('div');
        newRow.classList.add('row', 'mb-3');

        newRow.innerHTML = `
            <div class="col-md-2">
                <input type="text" class="form-control" name="eligibility[]" placeholder="Eligibility" required>
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="rating[]" placeholder="Rating" required>
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control" name="exam_date[]" required>
            </div>
            <div class="col-md-3">
                <input type="file" class="form-control" name="license[]" required>
            </div>
            <div class="col-md-1 text-center">
                <button type="button" class="btn btn-danger" onclick="removeInputGroup(this)">Remove</button>
            </div>
        `;
        
        container.appendChild(newRow);
    }

    // Function to remove an input group
    function removeInputGroup(button) {
        const row = button.closest('.row');
        row.remove();
    }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
