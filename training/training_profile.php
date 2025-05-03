<?php
include "../db.php";

session_start();

$trainingid = $_SESSION['trainee_id'];
// Check if the employer is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: training_login.php");
    exit();
}

$sql = "SELECT * FROM trainees_profile WHERE id = ?";
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

if (isset($_SESSION['success_message'])) {
    echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']);
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
            <a href="training_home.php" class="back-button me-auto">
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
                <form action="process/save_profile1.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <div class="text-center">
                        <input type="file" id="fileInput" class="d-none" name="fileInput" onchange="updateProfilePic(event)">
                        <?php if (!empty($row['photo'])): ?>
                            <img src="<?php echo $row['photo']; ?>" alt="Profile Picture" class="profile-pic rounded-circle border" id="profilePic" onclick="document.getElementById('fileInput').click();">
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
                    <button type="submit" class="btn btn-primary w-100">Save</button>
                </form>

            </div>
            
            <div id="information2" class="tab-content" style="display:none;">
                <form action="process/save_profile2.php" method="post" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Nationality</label>
                        <input type="text" name="nationality" class="form-control" value="<?php echo isset($row['nationality']) ? htmlspecialchars($row['nationality']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date of birth</label>
                        <input type="date" name="dob" class="form-control" value="<?php echo isset($row['dob']) ? htmlspecialchars($row['dob']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Place of birth</label>
                        <input type="date" name="pob" class="form-control" value="<?php echo isset($row['pob']) ? htmlspecialchars($row['pob']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Civil Status</label>
                        <select name="civil_status" class="form-control" required>
                            <option value="Single" <?php echo (isset($row['civil_status']) && $row['civil_status'] == 'Single') ? 'selected' : ''; ?>>Single</option>           
                            <option value="Married" <?php echo (isset($row['civil_status']) && $row['civil_status'] == 'Married') ? 'selected' : ''; ?>>Married</option>
                            <option value="Divorce" <?php echo (isset($row['civil_status']) && $row['civil_status'] == 'Divorce') ? 'selected' : ''; ?>>Divorce</option>           
                            <option value="Widow" <?php echo (isset($row['civil_status']) && $row['civil_status'] == 'Widow') ? 'selected' : ''; ?>>Widow</option>
                            <option value="Live-in" <?php echo (isset($row['civil_status']) && $row['civil_status'] == 'Live-in') ? 'selected' : ''; ?>>Live-in</option>           
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sex</label>
                        <select name="sex" class="form-control" required>
                            <option value="Male" <?php echo (isset($row['sex']) && $row['sex'] == 'Male') ? 'selected' : ''; ?>>Male</option>           
                            <option value="Female" <?php echo (isset($row['sex']) && $row['sex'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Employment(before the training)</label>
                        <select name="employment" class="form-control" required>
                            <option value="Wage - Employed" <?php echo (isset($row['employment']) && $row['employment'] == 'Wage - Employed') ? 'selected' : ''; ?>>Wage - Employed</option>           
                            <option value="Underemployed" <?php echo (isset($row['employment']) && $row['employment'] == 'Underemployed') ? 'selected' : ''; ?>>Underemployed</option>
                            <option value="Self - Employed" <?php echo (isset($row['employment']) && $row['employment'] == 'Self - Employed') ? 'selected' : ''; ?>>Self - Employed</option>           
                            <option value="Unemployed" <?php echo (isset($row['employment']) && $row['employment'] == 'Unemployed') ? 'selected' : ''; ?>>Unemployed</option>        
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Educational Attainment (before the training)</label>
                        <select name="educ_attain" class="form-control" required>
                            <option value="No Grade Completed" <?php echo (isset($row['educ_attain']) && $row['educ_attain'] == 'No Grade Completed') ? 'selected' : ''; ?>>No Grade Completed</option>           
                            <option value="Elementary Undergraduate" <?php echo (isset($row['educ_attain']) && $row['educ_attain'] == 'Elementary Undergraduate') ? 'selected' : ''; ?>>Elementary Undergraduate</option>
                            <option value="Elementary Graduate" <?php echo (isset($row['educ_attain']) && $row['educ_attain'] == 'Elementary Graduate') ? 'selected' : ''; ?>>Elementary Graduate</option>           
                            <option value="High School Undergraduate" <?php echo (isset($row['educ_attain']) && $row['educ_attain'] == 'High School Undergraduate') ? 'selected' : ''; ?>>High School Undergraduate</option> 
                            <option value="High School Graduate" <?php echo (isset($row['educ_attain']) && $row['educ_attain'] == 'High School Graduate') ? 'selected' : ''; ?>>High School Graduate</option>           
                            <option value="Junior High (k-12)" <?php echo (isset($row['educ_attain']) && $row['educ_attain'] == 'Junior High (k-12)') ? 'selected' : ''; ?>>Junior High (k-12)</option>
                            <option value="Senior High (k-12)" <?php echo (isset($row['educ_attain']) && $row['educ_attain'] == 'Senior High (k-12)') ? 'selected' : ''; ?>>Senior High (k-12)</option>           
                            <option value="Technical Vocational Course Undergraduate" <?php echo (isset($row['educ_attain']) && $row['educ_attain'] == 'Technical Vocational Course Undergraduate') ? 'selected' : ''; ?>>Technical Vocational Course Undergraduate</option>
                            <option value="Technical Vocational Course Graduate" <?php echo (isset($row['educ_attain']) && $row['educ_attain'] == 'Technical Vocational Course Graduate') ? 'selected' : ''; ?>>Technical Vocational Course Graduate</option> 
                            <option value="College Undergraduate" <?php echo (isset($row['educ_attain']) && $row['educ_attain'] == 'College Undergraduate') ? 'selected' : ''; ?>>College Undergraduate</option>           
                            <option value="College Graduate" <?php echo (isset($row['educ_attain']) && $row['educ_attain'] == 'College Graduate') ? 'selected' : ''; ?>>College Graduate</option>
                            <option value="Masteral" <?php echo (isset($row['educ_attain']) && $row['educ_attain'] == 'Masteral') ? 'selected' : ''; ?>>Masteral</option>           
                            <option value="Doctorate" <?php echo (isset($row['educ_attain']) && $row['educ_attain'] == 'Doctorate') ? 'selected' : ''; ?>>Doctorate</option>         
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Guardian Name</label>
                        <input type="text" name="parent" class="form-control" value="<?php echo isset($row['parent']) ? htmlspecialchars($row['parent']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Trainees Classification</label>
                        <select name="classification" class="form-control" required>
                            <option value="4Ps Beneficiary" <?php echo (isset($row['classification']) && $row['classification'] == '4Ps Beneficiary') ? 'selected' : ''; ?>>4Ps Beneficiary</option>           
                            <option value="Displaced Workers" <?php echo (isset($row['classification']) && $row['classification'] == 'Displaced Workers') ? 'selected' : ''; ?>>Displaced Workers</option>
                            <option value="Family Members of AFP and PNP Wounded in-Action" <?php echo (isset($row['classification']) && $row['classification'] == 'Family Members of AFP and PNP Wounded in-Action') ? 'selected' : ''; ?>>Family Members of AFP and PNP Wounded in-Action</option>           
                            <option value="Industry Workers" <?php echo (isset($row['classification']) && $row['classification'] == 'Industry Workers') ? 'selected' : ''; ?>>Industry Workers</option> 
                            <option value="Out-of-School-Youth" <?php echo (isset($row['classification']) && $row['classification'] == 'Out-of-School-Youth') ? 'selected' : ''; ?>>Out-of-School-Youth</option>           
                            <option value="Decommissioned Combatants" <?php echo (isset($row['classification']) && $row['classification'] == 'Decommissioned Combatants') ? 'selected' : ''; ?>>Decommissioned Combatants</option>           
                            <option value="TESTDA Alumni" <?php echo (isset($row['classification']) && $row['classification'] == 'TESTDA Alumni') ? 'selected' : ''; ?>>TESTDA Alumni</option>
                            <option value="Victim of Natural Disasters and Calamities" <?php echo (isset($row['classification']) && $row['classification'] == 'Victim of Natural Disasters and Calamities') ? 'selected' : ''; ?>>Victim of Natural Disasters and Calamities</option> 

                            <option value="Agrarian Reform Beneficiary" <?php echo (isset($row['classification']) && $row['classification'] == 'Agrarian Reform Beneficiary') ? 'selected' : ''; ?>>Agrarian Reform Beneficiary</option>           
                            <option value="Drug Dependents Surrenderees/Surrenderers" <?php echo (isset($row['classification']) && $row['classification'] == 'Drug Dependents Surrenderees/Surrenderers') ? 'selected' : ''; ?>>Drug Dependents Surrenderees/Surrenderers</option>
                            <option value="Farmers and Fishermen" <?php echo (isset($row['classification']) && $row['classification'] == 'Farmers and Fishermen') ? 'selected' : ''; ?>>Farmers and Fishermen</option>           
                            <option value="Inmates and Detainees" <?php echo (isset($row['classification']) && $row['classification'] == 'Inmates and Detainees') ? 'selected' : ''; ?>>Inmates and Detainees</option>
                            <option value="Overseas Filipino Workers (OFW) Dependent" <?php echo (isset($row['classification']) && $row['classification'] == 'Overseas Filipino Workers (OFW) Dependent') ? 'selected' : ''; ?>>Overseas Filipino Workers (OFW) Dependent</option>           
                            <option value="Return/Repatriated Overseas Filipino Worker (OFW)" <?php echo (isset($row['classification']) && $row['classification'] == 'Return/Repatriated Overseas Filipino Worker (OFW)') ? 'selected' : ''; ?>>Return/Repatriated Overseas Filipino Worker (OFW)</option>
                            <option value="TVET Trainers" <?php echo (isset($row['classification']) && $row['classification'] == 'TVET Trainers') ? 'selected' : ''; ?>>TVET Trainers</option>           
                            <option value="Wounded-in-Action AFP & PNP Personnel" <?php echo (isset($row['classification']) && $row['classification'] == 'Wounded-in-Action AFP & PNP Personnel') ? 'selected' : ''; ?>>Wounded-in-Action AFP & PNP Personnel</option>
                            
                            <option value="Balik Probinsya" <?php echo (isset($row['classification']) && $row['classification'] == 'Balik Probinsya') ? 'selected' : ''; ?>>Balik Probinsya</option>           
                            <option value="Famili Members of AFP and PNP Killed-in-Action" <?php echo (isset($row['classification']) && $row['classification'] == 'Famili Members of AFP and PNP Killed-in-Action') ? 'selected' : ''; ?>>Famili Members of AFP and PNP Killed-in-Action</option>
                            <option value="Indigenous People & Cultural Communities" <?php echo (isset($row['classification']) && $row['classification'] == 'Indigenous People & Cultural Communities') ? 'selected' : ''; ?>>Indigenous People & Cultural Communities</option>           
                            <option value="MILF Beneficiary" <?php echo (isset($row['classification']) && $row['classification'] == 'MILF Beneficiary') ? 'selected' : ''; ?>>MILF Beneficiary</option>
                            <option value="RCEF-RESP" <?php echo (isset($row['classification']) && $row['classification'] == 'RCEF-RESP') ? 'selected' : ''; ?>>RCEF-RESP</option>           
                            <option value="Students" <?php echo (isset($row['classification']) && $row['classification'] == 'Students') ? 'selected' : ''; ?>>Students</option>
                            <option value="Uniformed Personnel" <?php echo (isset($row['classification']) && $row['classification'] == 'Uniformed Personnel') ? 'selected' : ''; ?>>Uniformed Personnel</option>           
                            <option value="Others:" <?php echo (isset($row['classification']) && $row['classification'] == 'Others:') ? 'selected' : ''; ?>>Others:</option> 
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Disability:</label>
                        <select name="disability" class="form-control" required>
                            <option value="Mental/Intellectual" <?php echo (isset($row['disability']) && $row['disability'] == 'Mental/Intellectual') ? 'selected' : ''; ?>>Mental/Intellectual</option>           
                            <option value="Hearing Disability" <?php echo (isset($row['disability']) && $row['disability'] == 'Hearing Disability') ? 'selected' : ''; ?>>Hearing Disability</option>
                            <option value="Psychosocial Disability" <?php echo (isset($row['disability']) && $row['disability'] == 'Psychosocial Disability') ? 'selected' : ''; ?>>Psychosocial Disability</option>
                            <option value="Visual Disability" <?php echo (isset($row['disability']) && $row['disability'] == 'Visual Disability') ? 'selected' : ''; ?>>Visual Disability</option>
                            <option value="Speech Impairment" <?php echo (isset($row['disability']) && $row['disability'] == 'local_agencies') ? 'selected' : ''; ?>>Speech Impairment</option>           
                            <option value="Disability Due to Chronic Illness" <?php echo (isset($row['disability']) && $row['disability'] == 'Disability Due to Chronic Illness') ? 'selected' : ''; ?>>Disability Due to Chronic Illness</option>
                            <option value="Orthopedic (Musculoskeletal) Disability" <?php echo (isset($row['disability']) && $row['disability'] == 'Orthopedic (Musculoskeletal) Disability') ? 'selected' : ''; ?>>Orthopedic (Musculoskeletal) Disability</option>
                            <option value="Multiple Disabilities" <?php echo (isset($row['disability']) && $row['disability'] == 'Multiple Disabilities') ? 'selected' : ''; ?>>Multiple Disabilities</option>
                            <option value="Learning Disability" <?php echo (isset($row['disability']) && $row['disability'] == 'Learning Disability') ? 'selected' : ''; ?>>Learning Disability</option>
                            
                        </select>
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
