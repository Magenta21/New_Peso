<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Verify session
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || !isset($_SESSION['ofw_id'])) {
    $_SESSION['error_message'] = "Please log in to continue";
    header("Location: ../ofw_login.php");
    exit();
}

include "../db.php";

$ofw_id = $_SESSION['ofw_id'];
$updateSuccess = false;
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input data
    $input = filter_input_array(INPUT_POST, [
        'name' => FILTER_SANITIZE_STRING,
        'email' => FILTER_SANITIZE_EMAIL,
        'first_name' => FILTER_SANITIZE_STRING,
        'last_name' => FILTER_SANITIZE_STRING,
        'contact' => FILTER_SANITIZE_STRING,
        'dob' => FILTER_SANITIZE_STRING,
        'address' => FILTER_SANITIZE_STRING,
        'sex' => FILTER_SANITIZE_STRING,
        'sss' => FILTER_SANITIZE_STRING,
        'pagibig' => FILTER_SANITIZE_STRING,
        'philhealth' => FILTER_SANITIZE_STRING,
        'passport' => FILTER_SANITIZE_STRING,
        'immigration_status' => FILTER_SANITIZE_STRING,
        'educational_background' => FILTER_SANITIZE_STRING
    ]);

    // Validate required fields
    $requiredFields = ['name', 'email', 'first_name', 'last_name', 'contact', 'dob', 'address', 'sex'];
    foreach ($requiredFields as $field) {
        if (empty($input[$field])) {
            $errorMessage = "Required field '$field' is missing";
            break;
        }
    }

    // Calculate age if DOB is valid
    $age = null;
    if (empty($errorMessage)) {
        try {
            $dob = new DateTime($input['dob']);
            $now = new DateTime();
            $age = $now->diff($dob)->y;
        } catch (Exception $e) {
            $errorMessage = "Invalid date of birth format";
        }
    }

    // Handle file upload if no errors so far
    $profilePic = null;
    if (empty($errorMessage) && isset($_FILES['fileInput']) && $_FILES['fileInput']['error'] !== UPLOAD_ERR_NO_FILE) {
        $file = $_FILES['fileInput'];
        
        if ($file['error'] === UPLOAD_ERR_OK) {
            // Validate file
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $maxSize = 2 * 1024 * 1024; // 2MB
            
            $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($fileInfo, $file['tmp_name']);
            finfo_close($fileInfo);
            
            if (!in_array($mimeType, $allowedTypes)) {
                $errorMessage = "Only JPG, PNG, and GIF files are allowed";
            } elseif ($file['size'] > $maxSize) {
                $errorMessage = "File size must be less than 2MB";
            } else {
                // Create upload directory if needed
                $uploadDir = "../uploads/ofw_{$ofw_id}/";
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                // Generate unique filename
                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = "profile_" . time() . "." . $extension;
                $targetPath = $uploadDir . $filename;
                
                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    $profilePic = "uploads/ofw_{$ofw_id}/{$filename}";
                } else {
                    $errorMessage = "Failed to upload file";
                }
            }
        } else {
            $errorMessage = "File upload error: " . $file['error'];
        }
    }

    // Update database if no errors
    if (empty($errorMessage)) {
        try {
            // Prepare base SQL
            $sql = "UPDATE ofw_profile SET 
                    username = :username, 
                    email = :email, 
                    first_name = :first_name, 
                    last_name = :last_name,
                    contact_no = :contact_no, 
                    dob = :dob, 
                    age = :age, 
                    sex = :sex, 
                    house_address = :house_address,
                    sss_no = :sss_no, 
                    pagibig_no = :pagibig_no, 
                    philhealth_no = :philhealth_no, 
                    passport_no = :passport_no,
                    immigration_status = :immigration_status, 
                    educational_background = :educational_background";
            
            // Add profile image if uploaded
            if ($profilePic) {
                $sql .= ", profile_image = :profile_image";
            }
            
            $sql .= " WHERE id = :id";
            
            $stmt = $conn->prepare($sql);
            
            // Bind parameters
            $stmt->bindParam(':username', $input['name']);
            $stmt->bindParam(':email', $input['email']);
            $stmt->bindParam(':first_name', $input['first_name']);
            $stmt->bindParam(':last_name', $input['last_name']);
            $stmt->bindParam(':contact_no', $input['contact']);
            $stmt->bindParam(':dob', $input['dob']);
            $stmt->bindParam(':age', $age);
            $stmt->bindParam(':sex', $input['sex']);
            $stmt->bindParam(':house_address', $input['address']);
            $stmt->bindParam(':sss_no', $input['sss']);
            $stmt->bindParam(':pagibig_no', $input['pagibig']);
            $stmt->bindParam(':philhealth_no', $input['philhealth']);
            $stmt->bindParam(':passport_no', $input['passport']);
            $stmt->bindParam(':immigration_status', $input['immigration_status']);
            $stmt->bindParam(':educational_background', $input['educational_background']);
            
            if ($profilePic) {
                $stmt->bindParam(':profile_image', $profilePic);
            }
            
            $stmt->bindParam(':id', $ofw_id);
            
            $updateSuccess = $stmt->execute();
            
            if (!$updateSuccess) {
                $errorMessage = "Failed to update profile";
            }
        } catch (PDOException $e) {
            $errorMessage = "Database error: " . $e->getMessage();
        }
    }

    // Handle redirect with appropriate message
    if ($updateSuccess) {
        $_SESSION['success_message'] = "Profile updated successfully";
        header("Location: ../ofw_profile.php");
    } else {
        $_SESSION['error_message'] = $errorMessage ?: "Failed to update profile";
        header("Location: ../ofw_profile.php");
    }
    exit();
} else {
    // Not a POST request
    header("Location: ../ofw_profile.php");
    exit();
}