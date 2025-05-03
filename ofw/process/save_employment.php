<?php
session_start();
include "../../db.php";

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ofw_login.php");
    exit();
}

$trainingid = $_SESSION['ofw_id'];

// Handle occupation (including "Others" option)
$occupation = $_POST['occupation'];
if ($occupation === 'Others' && !empty($_POST['other_occupation'])) {
    $occupation = $_POST['other_occupation'];
}

// Prepare SQL statement
$sql = "UPDATE ofw_profile SET 
        occupation = ?,
        income = ?,
        employment_type = ?,
        country = ?,
        employment_form = ?,
        contact_abroad = ?,
        employer_abroad = ?,
        employer_address = ?,
        name_local_agency = ?,
        address_local = ?,
        departure_date = ?,
        arrival_date = ?
        WHERE id = ?";

// Prepare the statement
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    $_SESSION['error_message'] = "Error preparing statement: " . $conn->error;
    header("Location: ../ofw_profile.php");
    exit();
}

// Bind parameters
$stmt->bind_param("ssssssssssssi",
    $occupation,
    $_POST['income'],
    $_POST['employment_type'],
    $_POST['country'],
    $_POST['employment_form'],
    $_POST['aborad_contact'],
    $_POST['employer_abroad'],
    $_POST['employer_address'],
    $_POST['name_local_agency'],
    $_POST['address_local'],
    $_POST['departure_date'],
    $_POST['arrival_date'],
    $trainingid
);

// Execute the statement
if ($stmt->execute()) {
    $_SESSION['success_message'] = "Employment details updated successfully!";
} else {
    $_SESSION['error_message'] = "Error updating employment details: " . $stmt->error;
}

$stmt->close();
$conn->close();

// Redirect back to profile page
header("Location: ../ofw_profile.php");
exit();
?>