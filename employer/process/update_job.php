<?php
include '../../db.php';
session_start();

$employerid = $_SESSION['employer_id'];
// Check if the employer is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: employer_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $jobId = $_POST['job_id'];
    $jobTitle = $_POST['job_title'];
    $companyName = $_POST['company_name'];
    $jobType = $_POST['job_type'];
    $salary = $_POST['salary'];
    $workLocation = $_POST['work_location'];
    $jobDescription = $_POST['job_description'];
    $requirement = $_POST['requirement'];
    $datePosted = $_POST['date_posted'];

    // Prepare SQL query using '?' placeholders for mysqli
    $query = "UPDATE job_post SET job_title = ?, company_name = ?, job_type = ?, salary = ?, 
              work_location = ?, job_description = ?, requirement = ?, date_posted = ? 
              WHERE id = ? AND employer_id = ?";

    if ($stmt = $conn->prepare($query)) {
        // Bind parameters with correct data types
        $stmt->bind_param("ssssssssii", $jobTitle, $companyName, $jobType, $salary, 
                          $workLocation, $jobDescription, $requirement, $datePosted, $jobId, $employerid);

        // Execute the statement
        if ($stmt->execute()) {
            header("Location: ../job_list.php?success=Job updated successfully");
            exit();
        } else {
            echo "<p>Error updating job post: " . $stmt->error . "</p>";
        }

        // Close statement
        $stmt->close();
    } else {
        echo "<p>SQL Error: " . $conn->error . "</p>";
    }

    // Close connection
    $conn->close();
}
?>
