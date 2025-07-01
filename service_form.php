<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pesoo";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Validation functions
    function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function validateDate($date)
    {
        return (bool)strtotime($date);
    }

    function validatePhone($phone)
    {
        return preg_match('/^[0-9]{10,15}$/', $phone);
    }

    // Sanitize and validate inputs
    $service_type = $conn->real_escape_string($_POST['service_type'] ?? '');
    $first_name = $conn->real_escape_string($_POST['first_name'] ?? '');
    $last_name = $conn->real_escape_string($_POST['last_name'] ?? '');
    $middle_name = $conn->real_escape_string($_POST['middle_name'] ?? '');
    $suffix = $conn->real_escape_string($_POST['suffix'] ?? '');
    $birthdate = $conn->real_escape_string($_POST['birthdate'] ?? '');
    $gender = $conn->real_escape_string($_POST['gender'] ?? '');
    $address = $conn->real_escape_string($_POST['address'] ?? '');
    $email = $conn->real_escape_string($_POST['email'] ?? '');
    $phone = $conn->real_escape_string($_POST['phone'] ?? '');
    $id_type = $conn->real_escape_string($_POST['id_type'] ?? '');
    $id_number = $conn->real_escape_string($_POST['id_number'] ?? '');
    $purpose = $conn->real_escape_string($_POST['purpose'] ?? '');
    $agree_terms = isset($_POST['agree_terms']) ? 1 : 0;

    // Validate required fields
    if (empty($first_name)) $errors[] = "First name is required";
    if (empty($last_name)) $errors[] = "Last name is required";
    if (empty($birthdate)) $errors[] = "Birthdate is required";
    if (empty($gender)) $errors[] = "Gender is required";
    if (empty($address)) $errors[] = "Address is required";
    if (empty($email)) $errors[] = "Email is required";
    if (empty($phone)) $errors[] = "Phone is required";
    if (empty($id_type)) $errors[] = "ID type is required";
    if (empty($id_number)) $errors[] = "ID number is required";
    if (empty($purpose)) $errors[] = "Purpose is required";
    if ($agree_terms !== 1) $errors[] = "You must agree to the terms";

    // Validate formats
    if (!validateEmail($email)) $errors[] = "Invalid email format";
    if (!validateDate($birthdate)) $errors[] = "Invalid date format";
    if (!validatePhone($phone)) $errors[] = "Phone should be 10-15 digits";

    // If no errors, insert to database
    if (empty($errors)) {
        $sql = "INSERT INTO service_applications (
            service_type, first_name, last_name, middle_name, suffix,
            birthdate, gender, address, email, phone, id_type, id_number,
            purpose, agree_terms
        ) VALUES (
            '$service_type', '$first_name', '$last_name', '$middle_name', '$suffix',
            '$birthdate', '$gender', '$address', '$email', '$phone', '$id_type', '$id_number',
            '$purpose', $agree_terms
        )";

        if ($conn->query($sql) === TRUE) {
            $success = true;
            $reference = strtoupper(substr($service_type, 0, 3)) . '-' . rand(1000, 9999);
        } else {
            $errors[] = "Database error: " . $conn->error;
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Application - PESO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .form-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .required-field::after {
            content: " *";
            color: #dc3545;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">PESO Services</a>
        </div>
    </nav>

    <div class="container my-4">
        <div class="form-container">
            <h2 class="text-center mb-4"><i class="fas fa-file-alt me-2"></i>Service Application Form</h2>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <h5><i class="fas fa-exclamation-triangle me-2"></i>Error</h5>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php elseif (isset($success) && $success): ?>
                <div class="alert alert-success">
                    <h5><i class="fas fa-check-circle me-2"></i>Success!</h5>
                    <p>Your application for <strong><?php echo htmlspecialchars($service_type); ?></strong> was submitted successfully.</p>
                    <p>Reference Number: <strong><?php echo $reference; ?></strong></p>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <input type="hidden" name="service_type" value="<?php echo htmlspecialchars($_GET['service'] ?? ''); ?>">

                <div class="mb-3">
                    <label class="form-label required-field">Service Selected</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($_GET['service'] ?? ''); ?>" readonly>
                </div>

                <h5 class="border-bottom pb-2 mt-4"><i class="fas fa-user me-2"></i>Personal Information</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="firstName" class="form-label required-field">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="first_name" value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="lastName" class="form-label required-field">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="last_name" value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-2">
                        <label for="middleName" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="middleName" name="middle_name" value="<?php echo htmlspecialchars($_POST['middle_name'] ?? ''); ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="suffix" class="form-label">Suffix</label>
                        <input type="text" class="form-control" id="suffix" name="suffix" value="<?php echo htmlspecialchars($_POST['suffix'] ?? ''); ?>">
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-3">
                        <label for="birthdate" class="form-label required-field">Date of Birth</label>
                        <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($_POST['birthdate'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label for="gender" class="form-label required-field">Gender</label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="" disabled selected>Select Gender</option>
                            <option value="Male" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                            <option value="Other" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                </div>

                <h5 class="border-bottom pb-2 mt-4"><i class="fas fa-address-book me-2"></i>Contact Information</h5>
                <div class="mb-3">
                    <label for="address" class="form-label required-field">Complete Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3" required><?php echo htmlspecialchars($_POST['address'] ?? ''); ?></textarea>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label required-field">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label required-field">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>" required>
                    </div>
                </div>

                <h5 class="border-bottom pb-2 mt-4"><i class="fas fa-id-card me-2"></i>Identification</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="idType" class="form-label required-field">Valid ID Type</label>
                        <select class="form-select" id="idType" name="id_type" required>
                            <option value="" disabled selected>Select ID Type</option>
                            <option value="Passport" <?php echo (isset($_POST['id_type']) && $_POST['id_type'] === 'Passport') ? 'selected' : ''; ?>>Passport</option>
                            <option value="Driver's License" <?php echo (isset($_POST['id_type']) && $_POST['id_type'] === "Driver's License") ? 'selected' : ''; ?>>Driver's License</option>
                            <option value="SSS/UMID" <?php echo (isset($_POST['id_type']) && $_POST['id_type'] === 'SSS/UMID') ? 'selected' : ''; ?>>SSS/UMID</option>
                            <option value="PhilHealth ID" <?php echo (isset($_POST['id_type']) && $_POST['id_type'] === 'PhilHealth ID') ? 'selected' : ''; ?>>PhilHealth ID</option>
                            <option value="TIN ID" <?php echo (isset($_POST['id_type']) && $_POST['id_type'] === 'TIN ID') ? 'selected' : ''; ?>>TIN ID</option>
                            <option value="Postal ID" <?php echo (isset($_POST['id_type']) && $_POST['id_type'] === 'Postal ID') ? 'selected' : ''; ?>>Postal ID</option>
                            <option value="Voter's ID" <?php echo (isset($_POST['id_type']) && $_POST['id_type'] === "Voter's ID") ? 'selected' : ''; ?>>Voter's ID</option>
                            <option value="Barangay ID" <?php echo (isset($_POST['id_type']) && $_POST['id_type'] === 'Barangay ID') ? 'selected' : ''; ?>>Barangay ID</option>
                            <option value="School ID" <?php echo (isset($_POST['id_type']) && $_POST['id_type'] === 'School ID') ? 'selected' : ''; ?>>School ID</option>
                            <option value="Other" <?php echo (isset($_POST['id_type']) && $_POST['id_type'] === 'Other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="idNumber" class="form-label required-field">Valid ID Number</label>
                        <input type="text" class="form-control" id="idNumber" name="id_number" value="<?php echo htmlspecialchars($_POST['id_number'] ?? ''); ?>" required>
                    </div>
                </div>

                <h5 class="border-bottom pb-2 mt-4"><i class="fas fa-edit me-2"></i>Application Details</h5>
                <div class="mb-3">
                    <label for="purpose" class="form-label required-field">Purpose of Application</label>
                    <textarea class="form-control" id="purpose" name="purpose" rows="3" required><?php echo htmlspecialchars($_POST['purpose'] ?? ''); ?></textarea>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="agreeTerms" name="agree_terms" <?php echo isset($_POST['agree_terms']) ? 'checked' : ''; ?> required>
                    <label class="form-check-label required-field" for="agreeTerms">
                        I certify that the information provided is true and correct.
                    </label>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary px-4 py-2">
                        <i class="fas fa-paper-plane me-2"></i>Submit Application
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Client-side validation for phone number
        document.getElementById('phone').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>

</html>