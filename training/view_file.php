<?php
include '../db.php';
session_start();

// Check if trainee is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['user_type'] !== 'trainee') {
    header("Location: training_login.php");
    exit();
}

if (isset($_GET['file'])) {
    $file_name = basename($_GET['file']);
    $file_path = '../admin/content/uploads/modules/' . $file_name;
    
    // Check if file exists
    if (file_exists($file_path)) {
        // Get file extension
        $file_ext = pathinfo($file_path, PATHINFO_EXTENSION);
        $content_type = getContentType($file_ext);
        
        // Set headers to display in browser
        header('Content-Type: ' . $content_type);
        header('Content-Disposition: inline; filename="' . $file_name . '"');
        header('Content-Length: ' . filesize($file_path));
        readfile($file_path);
        exit;
    } else {
        // For debugging - remove in production
        die('File not found at: ' . $file_path);
    }
} else {
    die('No file specified');
}

function getContentType($extension) {
    $extension = strtolower($extension);
    switch ($extension) {
        case 'pdf':
            return 'application/pdf';
        case 'doc':
            return 'application/msword';
        case 'docx':
            return 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
        case 'xls':
            return 'application/vnd.ms-excel';
        case 'xlsx':
            return 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
        case 'ppt':
            return 'application/vnd.ms-powerpoint';
        case 'pptx':
            return 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
        case 'jpg':
        case 'jpeg':
            return 'image/jpeg';
        case 'png':
            return 'image/png';
        case 'gif':
            return 'image/gif';
        case 'txt':
            return 'text/plain';
        default:
            return 'application/octet-stream';
    }
}
?>