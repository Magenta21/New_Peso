<?php
include '../../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employer_id = $_POST['employer_id'];
    $fname = trim($_POST['fname']);
    $mname = trim($_POST['mname']);
    $lname = trim($_POST['lname']);
    $gender = trim($_POST['gender']);
    $contact = trim($_POST['contact']);
    $bday = $_POST['bday'];
    $address = trim($_POST['address']);
    $position = trim($_POST['position']);

    // Calculate age based on birthday
    $dob = new DateTime($bday);
    $today = new DateTime();
    $age = $today->diff($dob)->y; // Computes age in years

    // Correct SQL syntax for MySQLi (use ? placeholders)
    $sql = "INSERT INTO current_employee (employer_id, fname, mname, lname, age, gender, contact, bday, houseaddress, position) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // Bind parameters (MySQLi uses `bind_param` with `s` (string) and `i` (integer) types)
        $stmt->bind_param("isssisssss", $employer_id, $fname, $mname, $lname, $age, $gender, $contact, $bday, $address, $position);
        $stmt->execute();
        $stmt->close();

        $_SESSION['success_message'] = "Employee added successfully!";
        header("Location: ../employees.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error preparing statement: " . $conn->error;
        header("Location: ../employees.php");
        exit();
    }
} else {
    header("Location: ../employees.php");
    exit();
}
?>
