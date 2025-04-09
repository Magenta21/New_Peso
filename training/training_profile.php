 <?php
include "../db.php";

session_start();

$applicant_profile = $_SESSION['applicant_id'];
// Check if the employer is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: training_login.php");
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
$preferred = isset($row['preferred_occupation']) ? explode(',', $row['preferred_occupation']): '';
$work = isset($row['work_location']) ? explode(',', $row['work_location']): '';
$passportExpiry = isset($row['passport_expiry']) ? new DateTime($row['passport_expiry']) : null;
$passportExpiryFormatted = $passportExpiry ? $passportExpiry->format('Y-m-d') : '';
if (!$row) {
    die("User not found.");
}

// Training data
$sql_training = "SELECT * FROM training WHERE user_id = ?";
$stmt_training = $conn->prepare($sql_training);
$stmt_training->bind_param("i", $applicant_profile);
$stmt_training->execute();
$result_training = $stmt_training->get_result();

// License data
$sql_license = "SELECT * FROM license WHERE user_id = ?";
$stmt_license = $conn->prepare($sql_license);
$stmt_license->bind_param("i", $applicant_profile);
$stmt_license->execute();
$result_license = $stmt_license->get_result();

// Fetch existing language data for the user
$sql_language = "SELECT * FROM language_proficiency WHERE user_id = ?";
$stmt_language = $conn->prepare($sql_language);
$stmt_language->bind_param("i", $applicant_profile);
$stmt_language->execute();
$result_language = $stmt_language->get_result();

// Fetch data from work_exp table
$sql_work_exp = "SELECT * FROM work_exp WHERE user_id = ?";
$stmt_work_exp = $conn->prepare($sql_work_exp);
$stmt_work_exp->bind_param("i", $applicant_profile);
$stmt_work_exp->execute();
$result_work_exp = $stmt_work_exp->get_result();
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
            /* Remove background and add hover effect to the icon and text */
            .navbar .btn-light {
                background-color: transparent;
                border: none;
                color: #000; /* Default text color */
            }

            .navbar .btn-light i, 
            .navbar .btn-light span {
                color: inherit; /* Inherit text color */
            }
            i, span {
                font-weight: 900;
                font-size: 1em;
            }

            .navbar .btn-light:hover i, 
            .navbar .btn-light:hover span {
                color: #C21807; /* Scarlet or dark red color on hover */
                font-weight: 900;
            }

    </style>
</head>
<body>
    <div class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2">
                    <a href="../index.php" style="display: block; text-decoration: none;">
                    <img src="../img/logolb.png" alt="lblogo" style="height: 50px;">
                    </a>
                </div>
                <div class="col-md-8">
                    <h3 style="margin-top: 5px; font-weight: 900; color: #ffffff;">MUNICIPALITY OF LOS BANOS</h3>
                </div>
                <div class="col-md-2 mt-1 position-relative">
                </div>
            </div>
        </div>
    </div>

    <a href="training_list.php" class="btn btn-primary back-btn m-3 ">
        <i class="bi bi-arrow-left"></i> Back
    </a>

    <div class="container-xxl mt-2">
        <div class="card p-4 shadow">
            <div class="row">
                <div class="col-md-3">
                
                    <!-- Vertical List for Tabs (Navigation) -->
                    <div class="list-group">
                        <div class="text-center">
                            <?php if(!empty($row['photo'])): ?>
                                <img src="<?php echo $row['photo']; ?>" alt="Profile Picture" class="profile-pic rounded-circle border mb-5" id="profilePic" onclick="document.getElementById('fileInput').click();">
                            <?php else: ?>
                                <img src="../img/user-placeholder.png" alt="Profile Picture" class="profile-pic rounded-circle border mb-5" id="profilePic" onclick="document.getElementById('fileInput').click();">
                            <?php endif; ?>
                        </div>
                        <button class="list-group-item list-group-item-action active" onclick="switchTab(event, 'profile')">Profile</button>
                        <button class="list-group-item list-group-item-action" onclick="switchTab(event, 'educational_background')">Educational Background</button>
                        <button class="list-group-item list-group-item-action" onclick="switchTab(event, 'employment_status')">Employment Status</button>
                        <button class="list-group-item list-group-item-action" onclick="switchTab(event, 'tvo')">Techinical/ Vocational and Other training</button>
                        <button class="list-group-item list-group-item-action" onclick="switchTab(event, 'ld')">Languange and Dialect</button>
                        <button class="list-group-item list-group-item-action" onclick="switchTab(event, 'ep')">Eligibility and profesional license</button>
                        <button class="list-group-item list-group-item-action" onclick="switchTab(event, 'we')">Work Experience</button>
                        <button class="list-group-item list-group-item-action" onclick="switchTab(event, 'ss')">Skills </button>
                    </div>
                </div>

                <div class="col-md-9">
                    <!-- Content for Tabs -->
                    <div id="profile" class="tab-content" style="display:block;">
                        <form action="process/save_profile1.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                            <div class="text-center">
                                    <!-- <input type="file" id="fileInput" class="d-none" name="fileInput" onchange="updateProfilePic(event)"> -->
                                    <input type="file" id="fileInput" class="d-none" name="fileInput" onchange="updateProfilePic(event)">
                                </div>
                                <div class="row">
                                    
                                    <div class="col-md-12">
                                            <label class="form-label">Email:</label>
                                            <input type="email" name="email" class="form-control" value="<?php echo isset($row['email']) ? htmlspecialchars($row['email']) : ''; ?>" required>
                                    </div>

                                    <div class="col-md-4">
                                            <label class="form-label">First name:</label>
                                            <input type="text" name="fname" class="form-control" value="<?php echo isset($row['fname']) ? htmlspecialchars($row['fname']) : ''; ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                            <label class="form-label">Middle name:</label>
                                            <input type="text" name="mname" class="form-control" value="<?php echo isset($row['mname']) ? htmlspecialchars($row['mname']) : ''; ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                            <label class="form-label">Last name:</label>
                                            <input type="text" name="lname" class="form-control" value="<?php echo isset($row['lname']) ? htmlspecialchars($row['lname']) : ''; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                            <label class="form-label">Contact number:</label>
                                            <input type="tel" name="contact" class="form-control" value="<?php echo isset($row['contact_no']) ? htmlspecialchars($row['contact_no']) : ''; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                            <label class="form-label">Date of Birth:</label>
                                            <input type="date" name="dob" class="form-control" value="<?php echo isset($row['dob']) ? htmlspecialchars($row['dob']) : ''; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                            <label class="form-label">Place Of Birth:</label>
                                            <input type="text" name="pob" class="form-control" value="<?php echo isset($row['pob']) ? htmlspecialchars($row['pob']) : ''; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                            <label class="form-label">Present Address:</label>
                                            <input type="text" name="address" class="form-control" value="<?php echo isset($row['present_address']) ? htmlspecialchars($row['present_address']) : ''; ?>" required>
                                    </div>
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
                                
                                <div class="col-md-6">
                                    <label class="form-label">Nationality</label>
                                    <input type="text" name="nationality" class="form-control" value="<?php echo isset($row['nationality']) ? htmlspecialchars($row['nationality']) : ''; ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                        <label class="form-label">Classification:</label>
                                        <select name="classification" class="form-control" id="classification" required>
                                            <option value="none" <?php echo isset($row['classification']) && $row['classification'] == 'none' ? 'selected' : ''; ?>>None</option>
                                            <option value="visual" <?php echo isset($row['classification']) && $row['classification'] == 'Industry_Workers' ? 'selected' : ''; ?>>Industry Workers</option>
                                            <option value="hearing" <?php echo isset($row['classification']) && $row['classification'] == 'TESDA_Alumni' ? 'selected' : ''; ?>>TESDA Aluumni</option>
                                            <option value="speech" <?php echo isset($row['classification']) && $row['classification'] == 'Displaced_Workers' ? 'selected' : ''; ?>>Displaced Workers</option>
                                            <option value="physical" <?php echo isset($row['classification']) && $row['classification'] == 'Farmers_Fishermen' ? 'selected' : ''; ?>>Farmers and Fishermen</option>
                                            <option value="physical" <?php echo isset($row['classification']) && $row['classification'] == '4Ps_beneficiary' ? 'selected' : ''; ?>>4Ps beneficiary</option>
                                            <option value="physical" <?php echo isset($row['classification']) && $row['classification'] == 'Inmates_Detainees' ? 'selected' : ''; ?>>Inmates & Detainees</option>
                                            <option value="specify" <?php echo isset($row['classification']) && $row['classification'] == 'Specify' ? 'selected' : ''; ?>>Specify</option>
                                        </select>
                                </div>

                                <div class="col-md-6 mt-4" id="classification_specify_container" style="display:none;">
                                    <!-- Text input for specifying 'others' -->
                                    <input type="text" name="classification_specify" id="classification_specify" class="form-control mt-2" placeholder="Please specify" value="<?php echo isset($row['disability_specify']) ? htmlspecialchars($row['disability_specify']) : ''; ?>" />
                                </div>
                            </div>

                                
                            

                            <button type="submit" class="btn btn-primary w-100 mt-4">Save</button>
                        </form>
                    </div>

                    <div id="educational_background" class="tab-content" style="display:none;">
                        <form action="process/save_profile2.php" method="post" class="needs-validation" novalidate>
                           <!-- Educational Background Form -->
                           <h3>Tertiary</h3>    
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">School Name</label>
                                    <input type="text" name="t_school_name" class="form-control" value="<?php echo isset($row['tertiary_school']) ? htmlspecialchars($row['tertiary_school']) : ''; ?>" required>
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
                                    <input type="text" name="t_course" class="form-control" value="<?php echo isset($row['tertiary_course']) ? htmlspecialchars($row['tertiary_course']) : ''; ?>" required>
                                </div>
                            </div>
                            <h3>Graduate Studies</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">School Name</label>
                                    <input type="text" name="g_school_name" class="form-control" value="<?php echo isset($row['college_school']) ? htmlspecialchars($row['college_graduated']) : ''; ?>" required>
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
                                    <input type="text" name="g_course" class="form-control" value="<?php echo isset($row['grad_course']) ? htmlspecialchars($row['grad_course']) : ''; ?>" required>
                                </div>
                            </div>
                                <button type="submit" class="btn btn-primary w-100">Save</button>
                        </form>
                    </div>

                    <div id="employment_status" class="tab-content" style="display:none;">
                        <form action="process/save_profile3.php" method="post" class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="preferred-location" class="form-label">Preferred Work Location:</label>
                                    <select class="form-select" id="preferred-location" name="preferred_work_location" required>
                                        <option value="local" <?php echo isset($row['preferred_work_location']) && $row['preferred_work_location'] == 'local' ? 'selected' : ''; ?>>Local</option>
                                        <option value="overseas" <?php echo isset($row['preferred_work_location']) && $row['preferred_work_location'] == 'overseas' ? 'selected' : ''; ?>>Overseas</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="expected_salary" class="form-label">Expected Salary:</label>
                                    <input type="text" name="expected_salary" class="form-control" value="<?php echo isset($row['expected_salary']) ? htmlspecialchars($row['expected_salary']) : ''; ?>" required>
                                </div>
                            </div>

                            <!-- Local Locations Input Fields (Displayed in a row) -->
                            <div id="local-location-fields" class="row" style="display: <?php echo (isset($row['preferred_work_location']) && $row['preferred_work_location'] == 'local') ? 'block' : 'none'; ?>;">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="local-location-1" class="info">1 - City/Municipality:</label>
                                        <input type="text" class="form-control" id="local-location-1" name="local_location_1" placeholder="City/Municipality" value="<?php echo isset($work[0]) ? htmlspecialchars($work[0]) : ''; ?>" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="local-location-2" class="info">2 - City/Municipality:</label>
                                        <input type="text" class="form-control" id="local-location-2" name="local_location_2" placeholder="City/Municipality" value="<?php echo isset($work[0]) ? htmlspecialchars($work[1]) : ''; ?>" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="local-location-3" class="info">3 - City/Municipality:</label>
                                        <input type="text" class="form-control" id="local-location-3" name="local_location_3" placeholder="City/Municipality" value="<?php echo isset($work[0]) ? htmlspecialchars($work[2]) : ''; ?>" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Overseas Locations Input Fields (Displayed in a row) -->
                            <div id="overseas-location-fields" class="row" style="display: <?php echo (isset($row['preferred_work_location']) && $row['preferred_work_location'] == 'overseas') ? 'block' : 'none'; ?>;">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="overseas-location-1" class="info">1 - Country:</label>
                                        <input type="text" class="form-control" id="overseas-location-1" name="overseas_location_1" placeholder="Country" value="<?php echo isset($work[0]) ? htmlspecialchars($work[0]) : ''; ?>" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="overseas-location-2" class="info">2 - Country:</label>
                                        <input type="text" class="form-control" id="overseas-location-2" name="overseas_location_2" placeholder="Country" value="<?php echo isset($work[1]) ? htmlspecialchars($work[1]) : ''; ?>" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="overseas-location-3" class="info">3 - Country:</label>
                                        <input type="text" class="form-control" id="overseas-location-3" name="overseas_location_3" placeholder="Country" value="<?php echo isset($work[2]) ? htmlspecialchars($work[2]) : ''; ?>" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Preferred Occupation Input Fields in a Row -->
                            <label>Preferred Occupation</label>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <input type="text" class="form-control" id="occupation-1" name="preferred_occupation1" placeholder="1- Occupation" value="<?php echo isset($preferred[0]) ? htmlspecialchars($preferred[0]) : ''; ?>" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <input type="text" class="form-control" id="occupation-2" name="preferred_occupation2" placeholder="2- Occupation" value="<?php echo isset($preferred[1]) ? htmlspecialchars($preferred[1]) : ''; ?>" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <input type="text" class="form-control" id="occupation-3" name="preferred_occupation3" placeholder="3- Occupation" value="<?php echo isset($preferred[2]) ? htmlspecialchars($preferred[2]) : ''; ?>" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <input type="text" class="form-control" id="occupation-4" name="preferred_occupation4" placeholder="4- Occupation" value="<?php echo isset($preferred[3]) ? htmlspecialchars($preferred[3]) : ''; ?>" required>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="passport" class="form-label">Passport Number:</label>
                                    <input type="text" class="form-control" id="passport" name="passport_no" placeholder="" value="<?php echo isset($row['passport_no']) ? htmlspecialchars($row['passport_no']) : ''; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="expiry" class="form-label">Expiry Date:</label>
                                    <input type="date" class="form-control" id="expiry" name="passport_expiry" value="<?php echo $passportExpiryFormatted; ?>">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Save</button>
                        </form>

                    </div>

                    <div id="tvo" class="tab-content" style="display:none;">
                        <div class="card mb-4">
                            <div class="card-header">Documents</div>
                            <div class="card-body">
                                <form action="process/save_profile4.php" method="POST" enctype="multipart/form-data">
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
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control" name="training[]" value="<?php echo isset($row_training['training']) ? htmlspecialchars($row_training['training']) : ''; ?>" placeholder="Vocational/Training" required>
                                                        </div>
                                                    <!-- Start and End Date -->
                                                        <div class="col-md-2">
                                                            <input type="date" class="form-control" name="start_date[]" value="<?php echo isset($row_training['start_date']) ? htmlspecialchars($row_training['start_date']) : ''; ?>" required>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <span class="align-self-center">to</span>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="date" class="form-control" name="end_date[]" value="<?php echo isset($row_training['end_date']) ? htmlspecialchars($row_training['end_date']) : ''; ?>" required>
                                                        </div>
                                                    <!-- Institution -->
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control" name="institution[]" value="<?php echo isset($row_training['institution']) ? htmlspecialchars($row_training['institution']) : ''; ?>" placeholder="Institution" required>
                                                        </div>
                                                    <!-- Certificate Upload -->
                                                        <div class="col-md-2 mt-4">
                                                            <?php if (!empty($row_training['certificate_path'])): ?>
                                                                <a href="<?php echo htmlspecialchars($row_training['certificate_path']); ?>" target="_blank">View Certificate</a>
                                                            <?php else: ?>
                                                                No certificate uploaded.
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                <?php endwhile; ?>
                                            <?php else: ?>
                                            <!-- No training records found, show an empty row for new input -->
                                            <?php endif; ?>
                                        </div>
                                                
                                        <!-- Button to Add Another Training Set -->
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <button type="button" class="btn btn-primary" onclick="addTrainingGroup()">Add Another Training Set</button>
                                            </div>
                                        </div>

                                    <button type="submit" class="btn btn-primary w-100 mt-4">Save Documents</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div id="ld" class="tab-content" style="display:none;">
                        <div class="card mb-4">
                            <div class="card-header">Language/Dialect Proficiency</div>
                            <div class="card-body">
                                <form action="process/save_profile5.php" method="POST" enctype="multipart/form-data">
                                    <div class="row fw-bold text-center mb-2">
                                        <div class="col-2">Language</div>
                                        <div class="col-2">Read</div>
                                        <div class="col-2">Write</div>
                                        <div class="col-2">Speak</div>
                                        <div class="col-2">Understand</div>
                                        <div class="col-2">Action</div>
                                    </div>

                                    <div id="language-container">
                                        <?php if ($result_language->num_rows > 0): ?>
                                            <?php while ($row_language = $result_language->fetch_assoc()): ?>
                                                <div class="row text-center align-items-center mb-2">
                                                    <div class="col-2">
                                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($row_language['language_p']); ?>" readonly>
                                                    </div>
                                                    <div class="col-2">
                                                        <input type="checkbox" <?php echo $row_language['read_i'] == 1 ? 'checked' : ''; ?> readonly>
                                                    </div>
                                                    <div class="col-2">
                                                        <input type="checkbox" <?php echo $row_language['write_i'] == 1 ? 'checked' : ''; ?> readonly>
                                                    </div>
                                                    <div class="col-2">
                                                        <input type="checkbox" <?php echo $row_language['speak_i'] == 1 ? 'checked' : ''; ?> readonly>
                                                    </div>
                                                    <div class="col-2">
                                                    <input type="checkbox" <?php echo $row_language['understand_i'] == 1 ? 'checked' : ''; ?> readonly>
                                                    </div>
                                                </div>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                        <?php endif; ?>
                                    </div>

                                    <div class="text-start mt-3">
                                        <button type="button" class="btn btn-primary" onclick="addLanguageGroup()">Add Language</button>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 mt-4">Save Documents</button>
                                </form>
                            </div>
                        </div>
                    </div>


                    <div id="ep" class="tab-content" style="display:none;">
                        <div class="card mb-4">
                            <div class="card-header">Eligibility and Professional License</div>
                            <div class="card-body">
                                <form action="process/save_profile6.php" method="POST" enctype="multipart/form-data">
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
                                                                <a href="<?php echo htmlspecialchars($row_license['prc_path']); ?>" class="form-control" target="_blank">View License</a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                <?php endwhile; ?>
                                            <?php endif; ?>

                                            <!-- Empty row for new inputs -->
                                                <!-- Button to Add Another Training Set -->
                                                <div class="row">
                                                    <div class="col-md-12 text-right">
                                                        <button type="button" class="btn btn-primary" onclick="addInputGroup()">Add Another</button>
                                                    </div>
                                                </div>
                                        </div>
                                    <button type="submit" class="btn btn-primary w-100 mt-4">Save Documents</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div id="we" class="tab-content" style="display:none;">
                        <div class="card mb-4">
                            <div class="card-header"><h4>Work Experience (Limit to 10-year period)</h4></div>
                            <div class="card-body">
                                <form action="process/save_profile7.php" method="POST" enctype="multipart/form-data">
                                    <div class="row mb-2 text-center fw-bold">
                                        <div class="col-md-2">Company Name</div>
                                        <div class="col-md-3">Address</div>
                                        <div class="col-md-2">Position</div>
                                        <div class="col-md-3">Inclusive Dates</div>
                                        <div class="col-md-2">Status</div>
                                    </div>

                                    <?php if ($result_work_exp->num_rows > 0): ?>
                                        <?php while ($row_work_exp = $result_work_exp->fetch_assoc()): ?>
                                            <div class="row mb-2">
                                                <div class="col-md-2">
                                                    <p><?php echo htmlspecialchars($row_work_exp['company_name']); ?></p>
                                                </div>
                                                <div class="col-md-3">
                                                    <p><?php echo htmlspecialchars($row_work_exp['address']); ?></p>
                                                </div>
                                                <div class="col-md-2">
                                                    <p><?php echo htmlspecialchars($row_work_exp['position']); ?></p>
                                                </div>
                                                <div class="col-md-3">
                                                    <p><?php echo htmlspecialchars($row_work_exp['started_date']); ?> to <?php echo htmlspecialchars($row_work_exp['termination_date']); ?></p>
                                                </div>
                                                <div class="col-md-2">
                                                    <p><?php echo htmlspecialchars($row_work_exp['status']); ?></p>
                                                </div>
                                            </div>
                                        <?php endwhile; ?>
                                    <?php endif; ?>

                                    <!-- New Input Group -->
                                    <div id="work-experience-container">
                                        <!-- <div class="row mb-3">
                                            <div class="col-md-2"><input type="text" class="form-control" name="company[]" placeholder="Company Name"></div>
                                            <div class="col-md-3"><input type="text" class="form-control" name="address[]" placeholder="Address"></div>
                                            <div class="col-md-2"><input type="text" class="form-control" name="position[]" placeholder="Position"></div>
                                            <div class="col-md-3">
                                                <div class="d-flex">
                                                    <input type="date" class="form-control" name="start_date[]">
                                                    <span class="mx-2 align-self-center">to</span>
                                                    <input type="date" class="form-control" name="end_date[]">
                                                </div>
                                            </div>
                                            <div class="col-md-2"><input type="text" class="form-control" name="status[]" placeholder="Status"></div>
                                        </div> -->
                                    </div>

                                    <div class="text-start">
                                        <button type="button" class="btn btn-primary" onclick="addWorkExperienceGroup()">Add Experience</button>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 mt-4">Save Documents</button>
                                </form>
                            </div>
                        </div>
                    </div>
,
                    <div id="ss" class="tab-content" style="display:none;">
                        <div class="card mb-4 mt-4">
                            <div class="card-header">Skills Acquired</div>
                            <div class="card-body">
                                <form action="process/save_profile8.php" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <label for="dynamicSelect">Choose acquired Skills:</label>
                                        <select id="dynamicSelect" name="other_skills[]" multiple class="form-select">
                                        <option value="add">Add a new skills</option>
                                        <option value="Auto Mechanic">Auto Mechanic</option>
                                        <option value="Beautician">Beautician</option>
                                        <option value="Carpentry Work">Carpentry Work</option>
                                        <option value="Computer Literate">Computer Literate</option>
                                        <option value="Domestic Chores">Domestic Chores</option>
                                        <option value="Driver">Driver</option>
                                        <option value="Electrician">Electrician</option>
                                        <option value="Embroidery">Embroidery</option>
                                        <option value="Gardening">Gardening</option>
                                        <option value="Masonry">Masonry</option>
                                        <option value="Painter/Artist">Painter/Artist</option>
                                        <option value="Painting Jobs">Painting Jobs</option>
                                        <option value="Photography">Photography</option>
                                        <option value="Plumbing">Plumbing</option>
                                        <option value="Sewing">Sewing Dresses</option>
                                        <option value="Stenography">Stenography</option>
                                        <option value="Tailoring">Tailoring</option>
                                        </select>

                                        <div id="newOptionContainer" class="mt-3">
                                        <input type="text" id="newOption" placeholder="Enter new option" class="form-control mb-2">
                                        <button id="addButton" type="button" class="btn btn-primary">Add Option</button>
                                        </div>

                                        <input type="hidden" name="selectedOptions" id="selectedOptionsHidden">
                                        <div id="selectedOptionsContainer" class="mt-3">
                                        <h5>Selected Skills:</h5>
                                        <ul id="selectedOptionsList">
                                            <?php if (!empty($otherSkills)): ?>
                                            <?php foreach ($otherSkills as $skill): ?>
                                                <li><?php echo htmlspecialchars(trim($skill)); ?></li>
                                            <?php endforeach; ?>
                                            <?php else: ?>
                                            <li>No skills found.</li>
                                            <?php endif; ?>
                                        </ul>
                                        </div>
                                    </div>
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

        //selection option
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

            //classification option
                // Show/Hide the text input based on the selected disability
                document.getElementById('classification').addEventListener('change', function() {
                var classificationSelect = this.value;
                var classificationSpecifyContainer = document.getElementById('classification_specify_container');
                
                if (classificationSelect === 'specify') {
                    classificationSpecifyContainer.style.display = 'block'; // Show input if 'Others' is selected
                } else {
                    classificationSpecifyContainer.style.display = 'none'; // Hide input if another option is selected
                }
            });

            // Check initial selected value and show the text input if needed
            if (document.getElementById('classification').value === 'specify') {
                document.getElementById('classification_specify_container').style.display = 'block';
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
            
            //training information
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

            //eligibility and professional license
            function addInputGroup() {
                const container = $("#eligibility-container");
                const newRow = $(`
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="documents_name[]" placeholder="Document Name" required>
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control " name="rating[]" placeholder="Rating" required>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" name="date_upload[]" required>
                        </div>
                        <div class="col-md-2">
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

            //skills
            document.addEventListener('DOMContentLoaded', function() {
                const selectElement = document.getElementById('dynamicSelect');
                const newOptionInput = document.getElementById('newOption');
                const addButton = document.getElementById('addButton');
                const newOptionContainer = document.getElementById('newOptionContainer');
                const selectedOptionsList = document.getElementById('selectedOptionsList');
                const form = document.getElementById('optionsForm');
                const selectedOptionsHidden = document.getElementById('selectedOptionsHidden'); // The hidden input field

                let selectedOptions = new Set(); // Use a Set to store unique selected options

                // Function to update the displayed selected options
                function updateSelectedOptions() {
                    selectedOptionsList.innerHTML = ''; // Clear the current list
                    
                    // Loop through selected options and display them
                    selectedOptions.forEach(optionValue => {
                        const listItem = document.createElement('li');
                        listItem.textContent = optionValue;
                        listItem.addEventListener('click', function() {
                            removeOption(optionValue); // Allow removing option on click
                        });
                        selectedOptionsList.appendChild(listItem);
                    });

                    // Update the hidden field with selected options
                    updateHiddenField();
            }

            // Remove option from the selected options
            function removeOption(optionValue) {
                selectedOptions.delete(optionValue); // Remove from set
                updateSelectedOptions(); // Update display
            }

            // Toggle option in the selected options
            function toggleOption(optionValue) {
                if (selectedOptions.has(optionValue)) {
                    removeOption(optionValue); // If already selected, remove it
                } else {
                    selectedOptions.add(optionValue); // If not selected, add it
                }
                updateSelectedOptions(); // Update display
            }

            // Show the input field when "Add a new option..." is selected
            selectElement.addEventListener('change', function() {
                const selectedValue = selectElement.value;

                if (selectedValue === 'add') {
                    newOptionContainer.style.display = 'block';
                    newOptionInput.focus(); // Focus on the input field
                } else {
                    newOptionContainer.style.display = 'none';
                    toggleOption(selectedValue); // Toggle the selection state of the option
                    selectElement.value = ''; // Reset the select value
                }
            });

            // Add new option to the select when the button is clicked
            addButton.addEventListener('click', function() {
                const newOptionValue = newOptionInput.value.trim();
                if (newOptionValue) {
                    // Create a new option element
                    const newOption = document.createElement('option');
                    newOption.value = newOptionValue;
                    newOption.textContent = newOptionValue;
                    
                    // Add the new option to the select element
                    selectElement.appendChild(newOption);

                    // Automatically add and select the newly added option
                    toggleOption(newOptionValue);
                    selectElement.value = ''; // Reset the select value

                    // Clear the input field and hide it again
                    newOptionInput.value = '';
                    newOptionContainer.style.display = 'none';

                    updateSelectedOptions(); // Update the displayed options
                } else {
                    alert('Please enter a valid option.');
                }
            });

            // Function to update the hidden input field with selected options
            function updateHiddenField() {
                selectedOptionsHidden.value = Array.from(selectedOptions).join(','); // Convert Set to comma-separated string
            }

            // Update the hidden input field before form submission
            form.addEventListener('submit', function(event) {
                updateHiddenField(); // Make sure the hidden field is updated before submission
                console.log("Selected options: " + selectedOptionsHidden.value); // Debugging output
            });
        });

        let languageCount = 0; // Unique index for each language entry

        function addLanguageGroup() {
            const container = document.getElementById('language-container');

            // Increment index for unique names
            languageCount++;

            // Create a new row for language input
            const newRow = document.createElement('div');
            newRow.classList.add('row', 'text-center', 'align-items-center', 'mb-2');

            newRow.innerHTML = `
                <div class="col-md-2">
                    <input type="text" class="form-control" name="language[${languageCount}]" placeholder="Language" required>
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="read[${languageCount}]" value="1">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="write[${languageCount}]" value="1">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="speak[${languageCount}]" value="1">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="understand[${languageCount}]" value="1">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger" onclick="removeLanguageGroup(this)">Remove</button>
                </div>
            `;

            // Append the new row to the container
            container.appendChild(newRow);
        }

        function removeLanguageGroup(button) {
            // Remove the parent row
            button.closest('.row').remove();
        }

            // Function to add a new work experience row dynamically
            function addWorkExperienceGroup() {
                // Get the input container for Work Experience
                const container = document.getElementById('work-experience-container');

                // Create a new row for work experience input group
                const newRow = document.createElement('div');
                newRow.classList.add('row', 'mb-3');

                // Add the new input fields for work experience
                newRow.innerHTML = `
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="company[]" placeholder="Company Name">
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="address[]" placeholder="Address">
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="position[]" placeholder="Position">
                    </div>
                    <div class="col-md-2 text-center">
                        <div class="justify-content-center">
                            <input type="date" class="form-control" name="start_date[]">
                            <span class="mx-2 align-self-center">to</span>
                            <input type="date" class="form-control" name="end_date[]">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="status[]" placeholder="Status">
                    </div>
                    <div class="col-md-1 text-center">
                        <button type="button" class="btn btn-danger" onclick="removeWorkExperienceGroup(this)">Remove</button>
                    </div>
                `;

                // Append the new row to the container
                container.appendChild(newRow);
            }

            function removeInputGroup(button) {
                // Remove the row that contains the clicked button
                button.parentElement.parentElement.remove();
            }

            function removeWorkExperienceGroup(button) {
                // Remove the row that contains the clicked button
                button.parentElement.parentElement.remove();
            }
         

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
