<?php
include '../db.php';
session_start();

// Ensure the request is of type 'documents'
if ($_POST['type'] == "documents") {
    $name = $_POST['documents_name']; // Name of the document
    $upload_date = $_POST['upload_date']; // Upload date
    $company_name = $_SESSION['company_name']; // Get company name dynamically
    $document_file = $_FILES['file']['name']; // Uploaded file name

    // Define the directory structure: documents/company_name/
    $base_dir = "documents/";
    $company_dir = $base_dir . $company_name . "/";

    // Check if the 'documents' folder exists, if not, create it
    if (!file_exists($base_dir)) {
        mkdir($base_dir, 0777, true);
    }

    // Check if the company folder exists, if not, create it
    if (!file_exists($company_dir)) {
        mkdir($company_dir, 0777, true);
    }

    // Move the uploaded file into the company folder
    $target_file = $company_dir . basename($document_file);
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        // Insert into the database
        $sql = "INSERT INTO documents (company_name, document_name, upload_date, file_path) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $company_name, $name, $upload_date, $target_file);
        
        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "File upload failed.";
    }
}

$conn->close();
?>
