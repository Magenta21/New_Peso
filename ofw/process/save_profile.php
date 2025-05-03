<?php
session_start();

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include database connection
include "../../db.php";

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || !isset($_SESSION['ofw_id'])) {
    header("Location: ofw_login.php");
    exit();
}

// Initialize variables
$updateSuccess = false;
$errorMessage = '';

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data with proper sanitization
    $username = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $firstName = $conn->real_escape_string($_POST['first_name']);
    $lastName = $conn->real_escape_string($_POST['last_name']);
    $mname = $conn->real_escape_string($_POST['mname']);
    $contact = $conn->real_escape_string($_POST['contact']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $address = $conn->real_escape_string($_POST['address']);
    $sex = $conn->real_escape_string($_POST['sex']);
    $sss = $conn->real_escape_string($_POST['sss']);
    $pagibig = $conn->real_escape_string($_POST['pagibig']);
    $philhealth = $conn->real_escape_string($_POST['philhealth']);
    $passport = $conn->real_escape_string($_POST['passport']);
    $immigration_status = $conn->real_escape_string($_POST['immigration_status']);
    $educational_background = $conn->real_escape_string($_POST['educational_background']);

    // Calculate age from DOB
    $age = '';
    if (!empty($dob)) {
        $birthDate = new DateTime($dob);
        $currentDate = new DateTime();
        $age = $birthDate->diff($currentDate)->y;
    }

    // Handle file upload
    $profilePic = null;
    if (isset($_FILES['fileInput']) && $_FILES['fileInput']['error'] === UPLOAD_ERR_OK) {
        $folderName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $username);
        $uploadDir = "../uploads/$folderName/";
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = basename($_FILES['fileInput']['name']);
        $targetFilePath = $uploadDir . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $allowedFormats = ["jpg", "jpeg", "png", "gif"];

        if (in_array($fileType, $allowedFormats)) {
            if (move_uploaded_file($_FILES['fileInput']['tmp_name'], $targetFilePath)) {
                $profilePic = "uploads/$folderName/$fileName";
            } else {
                $errorMessage = "Error uploading file!";
            }
        } else {
            $errorMessage = "Invalid file format! Only JPG, JPEG, PNG, GIF are allowed.";
        }
    }

    // Prepare SQL statement
    $sql = "UPDATE ofw_profile SET 
            username = ?,
            email = ?,
            first_name = ?,
            last_name = ?,
            middle_name = ?,
            contact_no = ?,
            dob = ?,
            age = ?,
            sex = ?,
            house_address = ?,
            passport_no = ?,
            sss_no = ?,
            pagibig_no = ?,
            philhealth_no = ?,
            immigration_status = ?,
            educational_background = ?";

    if ($profilePic) {
        $sql .= ", profile_image = ?";
    }

    $sql .= " WHERE id = ?";

    $stmt = $conn->prepare($sql);

    // Debugging: Count the number of parameters
    $paramCount = substr_count($sql, '?');
    $bindParams = [
        $username, $email, $firstName, $lastName, $mname, 
        $contact, $dob, $age, $sex, $address, 
        $passport, $sss, $pagibig, $philhealth, 
        $immigration_status, $educational_background
    ];
    
    if ($profilePic) {
        $bindParams[] = $profilePic;
    }
    
    $bindParams[] = $_SESSION['ofw_id'];

    // Create type string dynamically
    $types = str_repeat('s', count($bindParams));

    // Bind parameters
    $stmt->bind_param($types, ...$bindParams);

    if ($stmt->execute()) {
        $updateSuccess = true;
    } else {
        $errorMessage = "Profile update failed: " . $stmt->error;
    }

    $stmt->close();
}

// Redirect with proper error handling
if ($updateSuccess) {
    header('Location: ../ofw_profile.php');
    exit();
} else {
    // Store error in session and redirect
    $_SESSION['profile_update_error'] = $errorMessage ?: 'Unknown error occurred during profile update';
    header('Location: ../ofw_profile.php');
    exit();
}
?>