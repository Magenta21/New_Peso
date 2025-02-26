<?php
include '../db.php';
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

    // Update the job post in the database using PDO
    $query = "UPDATE job_post SET job_title = :job_title, company_name = :company_name, job_type = :job_type, salary = :salary, 
              work_location = :work_location, job_description = :job_description, requirement = :requirement, date_posted = :date_posted 
              WHERE id = :job_id AND employer_id = :employer_id";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':job_title', $jobTitle);
    $stmt->bindParam(':company_name', $companyName);
    $stmt->bindParam(':job_type', $jobType);
    $stmt->bindParam(':salary', $salary);
    $stmt->bindParam(':work_location', $workLocation);
    $stmt->bindParam(':job_description', $jobDescription);
    $stmt->bindParam(':requirement', $requirement);
    $stmt->bindParam(':date_posted', $datePosted);
    $stmt->bindParam(':job_id', $jobId, PDO::PARAM_INT);
    $stmt->bindParam(':employer_id', $employerid, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: joblist.php?success=Job updated successfully");
        exit();
    } else {
        echo "<p>Error updating job post.</p>";
    }
}
?>
