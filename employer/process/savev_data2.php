<?php
include "../../db.php";
session_start();

$employerid = $_SESSION['employer_id'];
// Check if the employer is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: employer_login.php");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['file'])) {
    $documents_name = $_POST['documents_name'];  // Document names
    $date_upload = $_POST['date_upload'];        // Upload dates
    $files = $_FILES['file'];                    // Files

    // Check if files are uploaded
    for ($i = 0; $i < count($documents_name); $i++) {
        $doc_name = $documents_name[$i];
        $upload_date = $date_upload[$i];
        $file_name = $files['name'][$i];
        $file_tmp_name = $files['tmp_name'][$i];
        
        // Directory to save the files
        $upload_dir = "documents/";
        $target_file = $upload_dir . basename($file_name);

        // Check if file upload is successful
        if (move_uploaded_file($file_tmp_name, $target_file)) {
            // Insert the document data into the database
            $sql = "INSERT INTO documents (employer_id, document_type, created_at, document_file) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $employerid, $doc_name, $upload_date, $target_file);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "Failed to upload file: $file_name";
        }
    }
    
    header("Location: ../employer_profile.php");
}

$conn->close();
?>
