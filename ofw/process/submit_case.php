<?php
session_start(); // Start session
require '../../db.php';  // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $userId = $_SESSION['ofw_id'];

    // Get username from session or database (assuming you have it)
    $username = $_SESSION['username'] ?? 'user_'.$userId; // Fallback to user_ID if username not available

    // Handle file upload
    $file = null;
    if (!empty($_FILES['file']['name'])) {
        $baseDir = "../uploads/";
        $userDir = $baseDir . $username . '/';
        
        // Create user directory if it doesn't exist
        if (!file_exists($userDir)) {
            mkdir($userDir, 0755, true);
        }

        // Generate unique filename to prevent overwrites
        $fileExtension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $uniqueName = uniqid() . '.' . $fileExtension;
        $targetFilePath = $userDir . $uniqueName;
        
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
            // Store relative path (without ../) in database
            $file = "uploads/" . $username . '/' . $uniqueName;
        } else {
            // Handle upload error
            die("Error uploading file");
        }
    }

    // Insert case into the database
    $stmt = $conn->prepare("INSERT INTO cases (user_id, title, description, file) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $userId, $title, $description, $file);
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Case filed successfully!";
        header("Location: ../ofw_report.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error filing case: " . $stmt->error;
        header("Location: ../ofw_report.php");
        exit();
    }
}
?>