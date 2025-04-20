<?php
// view_documents.php

// Basic security checks
if (!isset($_GET['file_path']) || empty($_GET['file_path'])) {
    die('No file specified');
}

// Sanitize the file path
$file = basename($_GET['file_path']);
$document_root = $_SERVER['DOCUMENT_ROOT'];
$base_path = '/peso/employer/process/documents/';
$file_path = $document_root . $base_path . $file;

// Verify the file exists and is readable
if (!file_exists($file_path) || !is_readable($file_path)) {
    header("HTTP/1.0 404 Not Found");
    die('File not found or inaccessible: ' . htmlspecialchars($file));
}

// Get file extension
$file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

// Set content types for browser viewing
$viewable_types = [
    'pdf' => 'application/pdf',
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png' => 'image/png',
    'gif' => 'image/gif',
    'txt' => 'text/plain',
    'html' => 'text/html',
    'htm' => 'text/html',
];

// For Office documents - these typically need to be downloaded
$download_types = [
    'doc' => 'application/msword',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'xls' => 'application/vnd.ms-excel',
    'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'ppt' => 'application/vnd.ms-powerpoint',
    'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
];

if (isset($viewable_types[$file_extension])) {
    // Files we want to display in the browser
    header('Content-Type: ' . $viewable_types[$file_extension]);
    header('Content-Disposition: inline; filename="' . basename($file_path) . '"');
    header('Content-Length: ' . filesize($file_path));
    readfile($file_path);
} elseif (isset($download_types[$file_extension])) {
    // Files we want to force download
    header('Content-Type: ' . $download_types[$file_extension]);
    header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
    header('Content-Length: ' . filesize($file_path));
    readfile($file_path);
} else {
    // Default behavior for unknown types - download
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
    header('Content-Length: ' . filesize($file_path));
    readfile($file_path);
}

exit;
?>