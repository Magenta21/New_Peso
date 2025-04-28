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
                <button class="btn btn-outline-primary me-2" onclick="switchTab(event, 'information2')">Additional information</button>
            </div>
            <div id="profile" class="tab-content">
                <form action="process/save_profile.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <div class="text-center">
                        <input type="file" id="fileInput" class="d-none" name="fileInput" onchange="updateProfilePic(event)">
                        <?php if (!empty($row['profile_image'])): ?>
                            <img src="<?php echo $row['profile_image']; ?>" alt="Profile Picture" class="profile-pic rounded-circle border" id="profilePic" onclick="document.getElementById('fileInput').click();">
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
                        <label class="form-label">First name:</label>
                        <input type="text" name="fname" class="form-control" value="<?php echo isset($row['fname']) ? htmlspecialchars($row['fname']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Middle name:</label>
                        <input type="text" name="mname" class="form-control" value="<?php echo isset($row['mname']) ? htmlspecialchars($row['mname']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Last name:</label>
                        <input type="text" name="lname" class="form-control" value="<?php echo isset($row['lname']) ? htmlspecialchars($row['lname']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact number:</label>
                        <input type="tel" name="contact" class="form-control" value="<?php echo isset($row['contact_no']) ? htmlspecialchars($row['contact_no']) : ''; ?>" required>
                    </div>
                    <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Sex:</label>
                                <select name="sex" class="form-control" required>
                                    <option value="">Select Sex</option>
                                    <option value="Male" <?php echo (isset($row['sex']) && $row['sex'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?php echo (isset($row['sex']) && $row['sex'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Date of Birth:</label>
                                <input type="date" name="dob" class="form-control" value="<?php echo isset($row['dob']) ? htmlspecialchars($row['dob']) : ''; ?>" required>
                            </div>
                    </div>
                    <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Address:</label>
                                <input type="text" name="address" class="form-control" value="<?php echo isset($row['house_address']) ? htmlspecialchars($row['house_address']) : ''; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">SSS Number:</label>
                                <input type="text" name="sss" class="form-control" value="<?php echo isset($row['sss_no']) ? htmlspecialchars($row['sss_no']) : ''; ?>">
                            </div>
                    </div>
                    <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Pag-IBIG Number:</label>
                                <input type="text" name="pagibig" class="form-control" value="<?php echo isset($row['pagibig_no']) ? htmlspecialchars($row['pagibig_no']) : ''; ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">PhilHealth Number:</label>
                                <input type="text" name="philhealth" class="form-control" value="<?php echo isset($row['philhealth_no']) ? htmlspecialchars($row['philhealth_no']) : ''; ?>">
                            </div>
                    </div>
                    <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Passport Number:</label>
                                <input type="text" name="passport" class="form-control" value="<?php echo isset($row['passport_no']) ? htmlspecialchars($row['passport_no']) : ''; ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Immigration Status:</label>
                                <select name="immigration_status" class="form-control" required>
                                    <option value="">Select Status</option>
                                    <option value="Documented" <?php echo (isset($row['immigration_status']) && $row['immigration_status'] == 'Documented') ? 'selected' : ''; ?>>Documented</option>
                                    <option value="Undocumented" <?php echo (isset($row['immigration_status']) && $row['immigration_status'] == 'Undocumented') ? 'selected' : ''; ?>>Undocumented</option>
                                    <option value="Returning" <?php echo (isset($row['immigration_status']) && $row['immigration_status'] == 'Returning') ? 'selected' : ''; ?>>Returning</option>
                                    <option value="Repatriated" <?php echo (isset($row['immigration_status']) && $row['immigration_status'] == 'Repatriated') ? 'selected' : ''; ?>>Repatriated</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Educational Attaintment:</label>
                                <select name="immigration_status" class="form-control" required>
                                    <option value="">Select Status</option>
                                    <option value="Documented" <?php echo (isset($row['educational_background']) && $row['educational_background'] == 'Elementary Undergraduate') ? 'selected' : ''; ?>>Elementary Undergraduate</option>
                                    <option value="Undocumented" <?php echo (isset($row['educational_background']) && $row['educational_background'] == 'Elementary Graduate') ? 'selected' : ''; ?>>Elementary Graduate</option>
                                    <option value="Returning" <?php echo (isset($row['educational_background']) && $row['educational_background'] == 'High School Undergraduate') ? 'selected' : ''; ?>>High School Undergraduate</option>
                                    <option value="Repatriated" <?php echo (isset($row['educational_background']) && $row['educational_background'] == 'High School Graduate') ? 'selected' : ''; ?>>High School Graduate</option>
                                    <option value="Documented" <?php echo (isset($row['educational_background']) && $row['educational_background'] == 'College Undergraduate') ? 'selected' : ''; ?>>College Undergraduate</option>
                                    <option value="Undocumented" <?php echo (isset($row['educational_background']) && $row['educational_background'] == 'College Graduate') ? 'selected' : ''; ?>>College Graduate</option>
                                    <option value="Returning" <?php echo (isset($row['educational_background']) && $row['educational_background'] == 'Vocational') ? 'selected' : ''; ?>>Vocational</option>
                            
                                </select>
                            </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Save</button>
                </form>

            </div>
            
            <div id="information2" class="tab-content" style="display:none;">
                <form action="process/save_company_details.php" method="post" class="needs-validation" novalidate>
                    <div class="row mb-3">
                            <div class="mb-3">
                                <label class="form-label">Spouse's Name:</label>
                                <input type="text" name="spouse_name" class="form-control" value="<?php echo isset($row['spouse_name']) ? htmlspecialchars($row['spouse_name']) : ''; ?>">
                            </div>

                            <!-- Father -->
                            <div class="mb-3">
                                <label class="form-label">Father's Name:</label>
                                <input type="text" name="father_name" class="form-control" value="<?php echo isset($row['father_name']) ? htmlspecialchars($row['father_name']) : ''; ?>">
                            </div>

                            <!-- Mother -->
                            <div class="mb-3">
                                <label class="form-label">Mother's Name:</label>
                                <input type="text" name="mother_name" class="form-control" value="<?php echo isset($row['mother_name']) ? htmlspecialchars($row['mother_name']) : ''; ?>">
                            </div>

                            <!-- Emergency Contact -->
                            <div class="mb-3">
                                <label class="form-label">In Case of Emergency, Contact Person:</label>
                                <input type="text" name="emergency_contact" class="form-control" value="<?php echo isset($row['emergency_contact']) ? htmlspecialchars($row['emergency_contact']) : ''; ?>">
                            </div>

                            <!-- Spouse Contact -->
                            <div class="mb-3">
                                <label class="form-label">Spouse's Contact No.:</label>
                                <input type="text" name="spouse_contact" class="form-control" value="<?php echo isset($row['spouse_contact']) ? htmlspecialchars($row['spouse_contact']) : ''; ?>">
                            </div>

                            <!-- Father Address -->
                            <div class="mb-3">
                                <label class="form-label">Father's Address:</label>
                                <input type="text" name="father_address" class="form-control" value="<?php echo isset($row['father_address']) ? htmlspecialchars($row['father_address']) : ''; ?>">
                            </div>

                            <!-- Mother Address -->
                            <div class="mb-3">
                                <label class="form-label">Mother's Address:</label>
                                <input type="text" name="mother_address" class="form-control" value="<?php echo isset($row['mother_address']) ? htmlspecialchars($row['mother_address']) : ''; ?>">
                            </div>

                            <!-- Emergency Contact No -->
                            <div class="mb-3">
                                <label class="form-label">Contact No.:</label>
                                <input type="text" name="emergency_contact_no" class="form-control" value="<?php echo isset($row['emergency_contact_no']) ? htmlspecialchars($row['emergency_contact_no']) : ''; ?>">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Save</button>
                </form>

            </div>

            <div id="documents1" class="tab-content" style="display:none;">
                <div class="card mb-4">
                    <div class="card-header">Documents</div>
                        <div class="card-body">
                            <form action="process/save_data2.php" method="POST" enctype="multipart/form-data">
                                <div id="eligibility-container">
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
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
