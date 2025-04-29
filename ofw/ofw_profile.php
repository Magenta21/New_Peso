<?php
include "../db.php";

session_start();

$trainingid = $_SESSION['ofw_id'];
// Check if the employer is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ofw_login.php");
    exit();
}

$sql = "SELECT * FROM ofw_profile WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $trainingid);
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
<div class="#">
        <div class="container-fluid d-flex ">
            <a href="ofw_home.php" class="back-button me-auto">
            ← Back
            </a>
        </div>
    </div>
        <div class="container mt-2">
            <div class="card p-4 shadow">
            <div class="tabs d-flex justify-content-center mb-3">
                    <button class="btn btn-outline-primary me-2 active" onclick="switchTab(event, 'profile')">Profile</button>
                    <button class="btn btn-outline-primary me-2" onclick="switchTab(event, 'information2')">Family Information</button>
                    <button class="btn btn-outline-primary me-2" onclick="switchTab(event, 'Employment_Details')">Employment Details</button>
            </div>
                        <div id="profile" class="tab-content">
                     <form action="process/save_profile.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <div class="text-center mb-4">
                        <input type="file" id="fileInput" class="d-none" name="fileInput" onchange="updateProfilePic(event)">
                        <?php if (!empty($row['profile_image'])): ?>
                            <img src="<?php echo $row['profile_image']; ?>" alt="Profile Picture" class="profile-pic rounded-circle border" id="profilePic" onclick="document.getElementById('fileInput').click();">
                        <?php else: ?>
                            <img src="../img/user-placeholder.png" alt="Profile Picture" class="profile-pic rounded-circle border" id="profilePic" onclick="document.getElementById('fileInput').click();">
                        <?php endif; ?>
                    </div>

                    <!-- Basic Information Row -->
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Username:</label>
                            <input type="text" name="name" class="form-control" value="<?php echo isset($row['username']) ? htmlspecialchars($row['username']) : ''; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email:</label>
                            <input type="email" name="email" class="form-control" value="<?php echo isset($row['email']) ? htmlspecialchars($row['email']) : ''; ?>" required>
                        </div>
                    </div>

                    <!-- Name Row -->
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">First name:</label>
                            <input type="text" name="fname" class="form-control" value="<?php echo isset($row['fname']) ? htmlspecialchars($row['fname']) : ''; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Last name:</label>
                            <input type="text" name="lname" class="form-control" value="<?php echo isset($row['lname']) ? htmlspecialchars($row['lname']) : ''; ?>" required>
                        </div>
                    </div>

                    <!-- Contact & Personal Info Row -->
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contact number:</label>
                            <input type="tel" name="contact" class="form-control" value="<?php echo isset($row['contact_no']) ? htmlspecialchars($row['contact_no']) : ''; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Address:</label>
                            <input type="text" name="address" class="form-control" value="<?php echo isset($row['house_address']) ? htmlspecialchars($row['house_address']) : ''; ?>" required>
                        </div>
                    </div>

                    <!-- Sex & DOB Row -->
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sex:</label>
                            <select name="sex" class="form-control" required>
                                <option value="">Select Sex</option>
                                <option value="Male" <?php echo (isset($row['sex']) && $row['sex'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo (isset($row['sex']) && $row['sex'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date of Birth:</label>
                            <input type="date" name="dob" class="form-control" value="<?php echo isset($row['dob']) ? htmlspecialchars($row['dob']) : ''; ?>" required>
                        </div>
                    </div>

                    <!-- Government IDs Row 1 -->
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">SSS Number:</label>
                            <input type="text" name="sss" class="form-control" value="<?php echo isset($row['sss_no']) ? htmlspecialchars($row['sss_no']) : ''; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pag-IBIG Number:</label>
                            <input type="text" name="pagibig" class="form-control" value="<?php echo isset($row['pagibig_no']) ? htmlspecialchars($row['pagibig_no']) : ''; ?>">
                        </div>
                    </div>

                    <!-- Government IDs Row 2 -->
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">PhilHealth Number:</label>
                            <input type="text" name="philhealth" class="form-control" value="<?php echo isset($row['philhealth_no']) ? htmlspecialchars($row['philhealth_no']) : ''; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Passport Number:</label>
                            <input type="text" name="passport" class="form-control" value="<?php echo isset($row['passport_no']) ? htmlspecialchars($row['passport_no']) : ''; ?>">
                        </div>
                    </div>

                    <!-- Immigration & Education Row -->
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Immigration Status:</label>
                            <select name="immigration_status" class="form-control" required>
                                <option value="">Select Status</option>
                                <option value="Documented" <?php echo (isset($row['immigration_status']) && $row['immigration_status'] == 'Documented') ? 'selected' : ''; ?>>Documented</option>
                                <option value="Undocumented" <?php echo (isset($row['immigration_status']) && $row['immigration_status'] == 'Undocumented') ? 'selected' : ''; ?>>Undocumented</option>
                                <option value="Returning" <?php echo (isset($row['immigration_status']) && $row['immigration_status'] == 'Returning') ? 'selected' : ''; ?>>Returning</option>
                                <option value="Repatriated" <?php echo (isset($row['immigration_status']) && $row['immigration_status'] == 'Repatriated') ? 'selected' : ''; ?>>Repatriated</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Educational Attainment:</label>
                            <select name="educational_background" class="form-control" required>
                                <option value="">Select Education</option>
                                <option value="Elementary Undergraduate" <?php echo (isset($row['educational_background']) && $row['educational_background'] == 'Elementary Undergraduate') ? 'selected' : ''; ?>>Elementary Undergraduate</option>
                                <option value="Elementary Graduate" <?php echo (isset($row['educational_background']) && $row['educational_background'] == 'Elementary Graduate') ? 'selected' : ''; ?>>Elementary Graduate</option>
                                <option value="High School Undergraduate" <?php echo (isset($row['educational_background']) && $row['educational_background'] == 'High School Undergraduate') ? 'selected' : ''; ?>>High School Undergraduate</option>
                                <option value="High School Graduate" <?php echo (isset($row['educational_background']) && $row['educational_background'] == 'High School Graduate') ? 'selected' : ''; ?>>High School Graduate</option>
                                <option value="College Undergraduate" <?php echo (isset($row['educational_background']) && $row['educational_background'] == 'College Undergraduate') ? 'selected' : ''; ?>>College Undergraduate</option>
                                <option value="College Graduate" <?php echo (isset($row['educational_background']) && $row['educational_background'] == 'College Graduate') ? 'selected' : ''; ?>>College Graduate</option>
                                <option value="Vocational" <?php echo (isset($row['educational_background']) && $row['educational_background'] == 'Vocational') ? 'selected' : ''; ?>>Vocational</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Save</button>
                </form>
            </div>
            
            <div id="information2" class="tab-content" style="display:none;">
                <form action="process/save_company_details.php" method="post" class="needs-validation" novalidate>
                <div class="row mb-3">
                        <div class="col-md-6 mb-1">
                            <label class="form-label">Spouse's Name:</label>
                            <input type="text" name="spouse_name" class="form-control" value="<?php echo isset($row['spouse_name']) ? htmlspecialchars($row['spouse_name']) : ''; ?>">
                        </div>
                        <div class="col-md-6 mb-1">
                            <label class="form-label">Spouse's Contact No:</label>
                            <input type="text" name="spouse_contact" class="form-control" value="<?php echo isset($row['spouse_contact']) ? htmlspecialchars($row['spouse_contact']) : ''; ?>">
                        </div>
                 </div>

                 <div class="row mb-3">
                 <div class="col-md-6 mb-1">
                            <label class="form-label">Father's Name:</label>
                            <input type="text" name="fathers_name" class="form-control" value="<?php echo isset($row['fathers_name']) ? htmlspecialchars($row['fathers_name']) : ''; ?>">
                        </div>
                        <div class="col-md-6 mb-1">
                            <label class="form-label">Father's Address:</label>
                            <input type="text" name="fathers_address" class="form-control" value="<?php echo isset($row['fathers_address']) ? htmlspecialchars($row['fathers_address']) : ''; ?>">
                        </div>
                 </div>

                 <div class="row mb-3">
                        <div class="col-md-6 mb-1">
                            <label class="form-label">Mother's Name:</label>
                            <input type="text" name="mothers_name" class="form-control" value="<?php echo isset($row['mothers_name']) ? htmlspecialchars($row['mothers_name']) : ''; ?>">
                        </div>
                        <div class="col-md-6 mb-1">
                            <label class="form-label">Mother's Address:</label>
                            <input type="text" name="mothers_address" class="form-control" value="<?php echo isset($row['mothers_address']) ? htmlspecialchars($row['mothers_address']) : ''; ?>">
                        </div>
                 </div>

                 <div class="row mb-3">
                        <div class="col-md-6 mb-1">
                            <label class="form-label">In Case of Emergency, Contact Person</label>
                            <input type="text" name="emergency_contact_name" class="form-control" value="<?php echo isset($row['emergency_contact_name']) ? htmlspecialchars($row['emergency_contact_name']) : ''; ?>">
                        </div>
                        <div class="col-md-6 mb-1">
                            <label class="form-label">Contact No</label>
                            <input type="text" name="emergency_contact_number" class="form-control" value="<?php echo isset($row['emergency_contact_number']) ? htmlspecialchars($row['emergency_contact_number']) : ''; ?>">
                        </div>
                 </div>

                    <button type="submit" class="btn btn-primary w-100">Save</button>
                </form>

            </div>

                <div id="Employment_Details" class="tab-content" style="display:none;">
                    <form action="process/save_company_details.php" method="post" class="needs-validation" novalidate>
                        <!-- Occupation Row -->
                        <div class="row mb-3">
                            <div class="col-md-6 mb-1">
                                <label class="form-label">Occupation:</label>
                                <select name="occupation" class="form-control" id="occupationSelect" onchange="toggleOtherOccupation()">
                                    <option value="">Select Occupation</option>
                                    <option value="Administrative Work" <?php echo (isset($row['occupation']) && $row['occupation'] == 'Administrative Work') ? 'selected' : ''; ?>>Administrative Work</option>
                                    <option value="Engineering" <?php echo (isset($row['occupation']) && $row['occupation'] == 'Engineering') ? 'selected' : ''; ?>>Engineering</option>
                                    <option value="Medical Work" <?php echo (isset($row['occupation']) && $row['occupation'] == 'Medical Work') ? 'selected' : ''; ?>>Medical Work</option>
                                    <option value="Factory Work" <?php echo (isset($row['occupation']) && $row['occupation'] == 'Factory Work') ? 'selected' : ''; ?>>Factory Work</option>
                                    <option value="Farmers" <?php echo (isset($row['occupation']) && $row['occupation'] == 'Farmers') ? 'selected' : ''; ?>>Farmers</option>
                                    <option value="Others" <?php echo (isset($row['occupation']) && $row['occupation'] == 'Others') ? 'selected' : ''; ?>>Others</option>
                                </select>
                                <div id="otherOccupationContainer" style="display: none;" class="mt-2">
                                    <label class="form-label">Specify Occupation:</label>
                                    <input type="text" name="other_occupation" class="form-control" value="<?php echo (isset($row['occupation']) && $row['occupation'] == 'Others') ? htmlspecialchars($row['other_occupation']) : ''; ?>">
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label class="form-label">Average Income Per Month:</label>
                                <input type="text" name="income" class="form-control" value="<?php echo isset($row['income']) ? htmlspecialchars($row['income']) : ''; ?>">
                            </div>
                        </div>

                        <!-- Land/Sea Based Row -->
                        <div class="row mb-3">
                            <div class="col-md-6 mb-1">
                                <label class="form-label">Land-Based or Sea-Based:</label>
                                <select name="employment_type" class="form-control">
                                    <option value="">Select Type</option>
                                    <option value="Land-Based" <?php echo (isset($row['employment_type']) && $row['employment_type'] == 'Land-Based') ? 'selected' : ''; ?>>Land-Based</option>
                                    <option value="Sea-Based" <?php echo (isset($row['employment_type']) && $row['employment_type'] == 'Sea-Based') ? 'selected' : ''; ?>>Sea-Based</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label class="form-label">Country of Destination:</label>
                                <input type="text" name="country" class="form-control" value="<?php echo isset($row['country']) ? htmlspecialchars($row['country']) : ''; ?>">
                            </div>
                        </div>

                        <!-- Forms of Employment Row -->
                        <div class="row mb-3">
                            <div class="col-md-6 mb-1">
                                <label class="form-label">Forms of Employment:</label>
                                <select name="employment_form" class="form-control">
                                    <option value="">Select Type</option>
                                    <option value="Recruitment Agency" <?php echo (isset($row['employment_form']) && $row['employment_form'] == 'Recruitment Agency') ? 'selected' : ''; ?>>Recruitment Agency</option>
                                    <option value="Government Hire" <?php echo (isset($row['employment_form']) && $row['employment_form'] == 'Government Hire') ? 'selected' : ''; ?>>Government Hire</option>
                                    <option value="Name Hire" <?php echo (isset($row['employment_form']) && $row['employment_form'] == 'Name Hire') ? 'selected' : ''; ?>>Name Hire</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label class="form-label">Contact Number:</label>
                                <input type="text" name="aborad_contact" class="form-control" value="<?php echo isset($row['aborad_contact']) ? htmlspecialchars($row['aborad_contact']) : ''; ?>">
                            </div>
                        </div>

                        <!-- Employer/Company Row -->
                        <div class="row mb-3">
                            <div class="col-md-6 mb-1">
                                <label class="form-label">Name of Employer/Company:</label>
                                <input type="text" name="employer_abroad" class="form-control" value="<?php echo isset($row['employer_abroad']) ? htmlspecialchars($row['employer_abroad']) : ''; ?>">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label class="form-label">Address of Employer/Company:</label>
                                <input type="text" name="employer_address" class="form-control" value="<?php echo isset($row['employer_address']) ? htmlspecialchars($row['employer_address']) : ''; ?>">
                            </div>
                        </div>

                        <!-- Local Agency Row -->
                        <div class="row mb-3">
                            <div class="col-md-6 mb-1">
                                <label class="form-label">Name of Local Agency:</label>
                                <input type="text" name="name_local_agency" class="form-control" value="<?php echo isset($row['name_local_agency']) ? htmlspecialchars($row['name_local_agency']) : ''; ?>">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label class="form-label">Address of Local Agency:</label>
                                <input type="text" name="address_local" class="form-control" value="<?php echo isset($row['address_local']) ? htmlspecialchars($row['address_local']) : ''; ?>">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                        <div class="col-md-6 mb-1">
                            <label class="form-label">Date of Departure from Philippines:</label>
                            <input type="date" name="departure_date" class="form-control" 
                                value="<?php echo isset($row['departure_date']) ? htmlspecialchars($row['departure_date']) : ''; ?>">
                        </div>
                        <div class="col-md-6 mb-1">
                            <label class="form-label">Date of Arrival:</label>
                            <input type="date" name="arrival_date" class="form-control" 
                                value="<?php echo isset($row['arrival_date']) ? htmlspecialchars($row['arrival_date']) : ''; ?>">
                        </div>

                        
                        <button type="submit" class="btn btn-primary w-100">Save</button>
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
        function toggleOtherOccupation() {
    const occupationSelect = document.getElementById('occupationSelect');
    const otherOccupationContainer = document.getElementById('otherOccupationContainer');
    
    if (occupationSelect.value === 'Others') {
        otherOccupationContainer.style.display = 'block';
    } else {
        otherOccupationContainer.style.display = 'none';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleOtherOccupation();
});
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
