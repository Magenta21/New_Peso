<?php
session_start();

// Ensure the user is logged in and employer_id exists in the session.
if (!isset($_SESSION['employer_id'])) {
    die("Access denied. Please log in.");
}

$employer_id = $_SESSION['employer_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection parameters
    $host    = 'localhost';
    $db      = 'pesoo';
    $user    = 'root';
    $pass    = '';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        // Create a new PDO instance
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }

    // First, check if all required documents are verified
    $docCheckSql = "SELECT COUNT(*) as unverified_count FROM documents 
                   WHERE employer_id = :employer_id AND (is_verified IS NULL OR is_verified != 'verified')";
    $docStmt = $pdo->prepare($docCheckSql);
    $docStmt->bindParam(':employer_id', $employer_id);
    $docStmt->execute();
    $result = $docStmt->fetch();
    
    if ($result['unverified_count'] > 0) {
        // Redirect back with error message if documents aren't verified
        header("Location: ../post_job.php?error=unverified_documents");
        exit();
    }

    // If documents are verified, proceed with job posting
    // Retrieve values from the form
    $job_title      = $_POST['job_title'];
    $company_name   = $_POST['company_name'];
    $job_type       = $_POST['job_type'];
    $salary         = $_POST['salary'];
    $job_description= $_POST['job_description'];
    $skills         = $_POST['skills'];  // Comma-separated skills from tags input
    $vacant         = $_POST['vacant'];
    $requirement    = $_POST['requirement'];
    $work_location  = $_POST['work_location'];
    $education      = $_POST['education'];
    $remarks        = $_POST['remarks'];
    $date_posted    = $_POST['date_posted'];
    $is_active      = $_POST['is_active'];

    // Prepare the INSERT query
    $sql = "INSERT INTO job_post 
            (employer_id, job_title, company_name, job_type, salary, job_description, selected_option, vacant, requirement, work_location, education, remarks, date_posted, is_active)
            VALUES 
            (:employer_id, :job_title, :company_name, :job_type, :salary, :job_description, :selected_option, :vacant, :requirement, :work_location, :education, :remarks, :date_posted, :is_active)";
    
    $stmt = $pdo->prepare($sql);

    // Bind parameters to the query
    $stmt->bindParam(':employer_id', $employer_id);
    $stmt->bindParam(':job_title', $job_title);
    $stmt->bindParam(':company_name', $company_name);
    $stmt->bindParam(':job_type', $job_type);
    $stmt->bindParam(':salary', $salary);
    $stmt->bindParam(':job_description', $job_description);
    $stmt->bindParam(':selected_option', $skills);
    $stmt->bindParam(':vacant', $vacant);
    $stmt->bindParam(':requirement', $requirement);
    $stmt->bindParam(':work_location', $work_location);
    $stmt->bindParam(':education', $education);
    $stmt->bindParam(':remarks', $remarks);
    $stmt->bindParam(':date_posted', $date_posted);
    $stmt->bindParam(':is_active', $is_active);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        header("Location: ../post_job.php?success=job_posted");
    } else {
        header("Location: ../post_job.php?error=posting_failed");
    }
}
?>