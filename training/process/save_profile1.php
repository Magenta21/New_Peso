<?php
// save_profile1.php - For the first tab (Profile)
include "../../db.php";

session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in'])) {
    header("Location: training_login.php");
    exit();
}

$trainingid = $_SESSION['trainee_id'];

// Handle file upload
if (!empty($_FILES['fileInput']['name'])) {
    $targetDir = "../uploads/profile_pics/";
    $fileName = basename($_FILES["fileInput"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    
    // Allow certain file formats
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    if (in_array($fileType, $allowTypes)) {
        // Upload file to server
        if (move_uploaded_file($_FILES["fileInput"]["tmp_name"], $targetFilePath)) {
            $photo = $targetFilePath;
        }
    }
}

// Prepare update query
$sql = "UPDATE trainees_profile SET 
        username = ?, 
        email = ?, 
        fname = ?, 
        mname = ?, 
        lname = ?, 
        contact_no = ?";

// Add photo to query if uploaded
if (isset($photo)) {
    $sql .= ", photo = ?";
}

$sql .= " WHERE id = ?";

$stmt = $conn->prepare($sql);

// Bind parameters
if (isset($photo)) {
    $stmt->bind_param("sssssssi", 
        $_POST['name'],
        $_POST['email'],
        $_POST['fname'],
        $_POST['mname'],
        $_POST['lname'],
        $_POST['contact'],
        $photo,
        $trainingid
    );
} else {
    $stmt->bind_param("ssssssi", 
        $_POST['name'],
        $_POST['email'],
        $_POST['fname'],
        $_POST['mname'],
        $_POST['lname'],
        $_POST['contact'],
        $trainingid
    );
}

// Execute query
if ($stmt->execute()) {
    $_SESSION['success_message'] = "Profile updated successfully!";
} else {
    $_SESSION['error_message'] = "Error updating profile: " . $conn->error;
}

$stmt->close();
$conn->close();

header("Location: ../training_profile.php");
exit();
?>