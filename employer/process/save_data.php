<?php
include "../../db.php";
session_start();

$employerid = $_SESSION['employer_id'];
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: employer_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $documents_name = $_POST['documents_name'] ?? [];
    $date_upload = $_POST['date_upload'] ?? [];
    $document_ids = $_POST['document_ids'] ?? [];
    $can_update = $_POST['can_update'] ?? [];
    $files = $_FILES['file'] ?? [];

    $upload_dir = "documents/";
    
    for ($i = 0; $i < count($documents_name); $i++) {
        // Only process documents that can be updated (rejected ones)
        if ($can_update[$i] != '1') continue;
        
        $doc_name = $documents_name[$i];
        $upload_date = $date_upload[$i];
        $document_id = $document_ids[$i];
        
        // Prepare base update query (without file)
        $sql = "UPDATE documents SET 
                document_type = ?, 
                created_at = ?, 
                is_verified = NULL, 
                comment = '' 
                WHERE id = ? AND employer_id = ?";
        
        $params = [$doc_name, $upload_date, $document_id, $employerid];
        $types = "ssii";
        
        // Check if file was uploaded for this document
        if (!empty($files['name'][$i])) {
            $file_name = $files['name'][$i];
            $file_tmp_name = $files['tmp_name'][$i];
            $target_file = $upload_dir . basename($file_name);
            
            if (move_uploaded_file($file_tmp_name, $target_file)) {
                // Update query with file
                $sql = "UPDATE documents SET 
                        document_type = ?, 
                        created_at = ?, 
                        document_file = ?, 
                        is_verified = NULL, 
                        comment = '' 
                        WHERE id = ? AND employer_id = ?";
                $types = "sssii";
                array_splice($params, 2, 0, $target_file);
            }
        }
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $stmt->close();
    }
    
    header("Location: ../employer_profile.php");
    exit();
}

$conn->close();
?>