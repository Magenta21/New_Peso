<?php
// save_profile2.php - For the second tab (Additional Information)
include "../../db.php";

session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in'])) {
    header("Location: training_login.php");
    exit();
}

$trainingid = $_SESSION['trainee_id'];

// Prepare update query
$sql = "UPDATE trainees_profile SET 
        nationality = ?, 
        dob = ?, 
        pob = ?, 
        civil_status = ?, 
        sex = ?, 
        employment = ?, 
        educ_attain = ?, 
        parent = ?, 
        classification = ?, 
        disability = ? 
        WHERE id = ?";

$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param("ssssssssssi", 
    $_POST['nationality'],
    $_POST['dob'],
    $_POST['pob'],
    $_POST['civil_status'],
    $_POST['sex'],
    $_POST['employment'],
    $_POST['educ_attain'],
    $_POST['parent'],
    $_POST['classification'],
    $_POST['disability'],
    $trainingid
);

// Execute query
if ($stmt->execute()) {
    $_SESSION['success_message'] = "Additional information updated successfully!";
} else {
    $_SESSION['error_message'] = "Error updating information: " . $conn->error;
}

$stmt->close();
$conn->close();

header("Location: ../training_profile.php");
exit();
?>