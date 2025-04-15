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

// Fetch documents related to the employer
$sql_new = "SELECT * FROM documents WHERE employer_id = ?";  // Change employer_id as per your database structure
$stmt_new = $conn->prepare($sql_new);
$stmt_new->bind_param("i", $employerid);
$stmt_new->execute();
$result_new = $stmt_new->get_result();

// Fetch all rows
$documents = [];
while ($row_new = $result_new->fetch_assoc()) {
    $documents[] = $row_new;
}

$stmt_new->close();
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
            <a href="employer_home.php" class="back-button me-auto">
            ← Back
            </a>
        </div>
    </div>
    <div class="container mt-2">
        <div class="card p-4 shadow">
        <div class="tabs d-flex justify-content-center mb-3">
                <button class="btn btn-outline-primary me-2 active" onclick="switchTab(event, 'profile')">Profile</button>
                <button class="btn btn-outline-primary me-2" onclick="switchTab(event, 'company_details')">Company Detais</button>
                <button class="btn btn-outline-primary" onclick="switchTab(event, 'documents')">Documents</button>
            </div>
            <div id="profile" class="tab-content">
                <form action="process/save_profile.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <div class="text-center">
                        <input type="file" id="fileInput" class="d-none" name="fileInput" onchange="updateProfilePic(event)">
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
                        <input type="text" name="fname" class="form-control" value="<?php echo isset($row['fname']) ? htmlspecialchars($row['fname']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Last name:</label>
                        <input type="text" name="lname" class="form-control" value="<?php echo isset($row['lname']) ? htmlspecialchars($row['lname']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact number:</label>
                        <input type="tel" name="contact" class="form-control" value="<?php echo isset($row['company_contact']) ? htmlspecialchars($row['company_contact']) : ''; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Save</button>
                </form>

            </div>
            
            <div id="company_details" class="tab-content" style="display:none;">
                <form action="process/save_company_details.php" method="post" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Company Name:</label>
                        <input type="text" name="company_name" class="form-control" value="<?php echo isset($row['company_name']) ? htmlspecialchars($row['company_name']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">President</label>
                        <input type="text" name="president" class="form-control" value="<?php echo isset($row['president']) ? htmlspecialchars($row['president']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Company Address:</label>
                        <input type="text" name="company_address" class="form-control" value="<?php echo isset($row['company_address']) ? htmlspecialchars($row['company_address']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Human Resource Manager</label>
                        <input type="text" name="hr" class="form-control" value="<?php echo isset($row['hr']) ? htmlspecialchars($row['hr']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact Number</label>
                        <input type="text" name="company_contact" class="form-control" value="<?php echo isset($row['company_contact']) ? htmlspecialchars($row['company_contact']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Company Email</label>
                        <input type="text" name="company_email" class="form-control" value="<?php echo isset($row['company_email']) ? htmlspecialchars($row['company_email']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Employment Type:</label>
                        <select name="employment_type" class="form-control" required>
                            <option value="Local Agencies" <?php echo (isset($row['type_of_employer']) && $row['type_of_employer'] == 'local_agencies') ? 'selected' : ''; ?>>Local Agencies</option>           
                            <option value="Local Lb" <?php echo (isset($row['type_of_employer']) && $row['type_of_employer'] == 'local_lb') ? 'selected' : ''; ?>>Los Banos Agencies</option>
                            <option value="Overseas" <?php echo (isset($row['type_of_employer']) && $row['type_of_employer'] == 'Overseas') ? 'selected' : ''; ?>>Overseas</option>
                            <option value="Direct Hire" <?php echo (isset($row['type_of_employer']) && $row['type_of_employer'] == 'direct_hire') ? 'selected' : ''; ?>>Direct Hire</option>
                        </select>
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
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
