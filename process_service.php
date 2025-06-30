<?php
session_start();
require_once 'db.php';
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Invalid request method');
}

// Validate required fields
$required = [
    'service_type',
    'first_name',
    'last_name',
    'birthdate',
    'gender',
    'address',
    'email',
    'phone',
    'id_type',
    'id_number',
    'purpose'
];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        jsonResponse(false, "Please fill in all required fields");
    }
}

// Sanitize and validate inputs
$service_type = sanitizeInput($_POST['service_type']);
$email = sanitizeInput($_POST['email']);
$phone = sanitizeInput($_POST['phone']);

if (!validateEmail($email)) {
    jsonResponse(false, "Invalid email format");
}

if (!validatePhone($phone)) {
    jsonResponse(false, "Phone number should be 10-15 digits");
}

if (!validateDate($_POST['birthdate'])) {
    jsonResponse(false, "Invalid date format (YYYY-MM-DD)");
}

// Prepare statement
try {
    $stmt = $conn->prepare("INSERT INTO service_applications (...) VALUES (...)");
    $stmt->bind_param(
        "sssssssssssssi",
        $service_type,
        sanitizeInput($_POST['first_name']),
        sanitizeInput($_POST['last_name']),
        !empty($_POST['middle_name']) ? sanitizeInput($_POST['middle_name']) : null,
        !empty($_POST['suffix']) ? sanitizeInput($_POST['suffix']) : null,
        $_POST['birthdate'],
        sanitizeInput($_POST['gender']),
        sanitizeInput($_POST['address']),
        $email,
        $phone,
        sanitizeInput($_POST['id_type']),
        sanitizeInput($_POST['id_number']),
        sanitizeInput($_POST['purpose']),
        isset($_POST['agree_terms']) ? 1 : 0
    );

    if ($stmt->execute()) {
        jsonResponse(true, 'Application submitted successfully', [
            'service' => $service_type,
            'reference' => strtoupper(substr($service_type, 0, 3)) . '-' . rand(1000, 9999)
        ]);
    } else {
        throw new Exception("Database error: " . $stmt->error);
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    jsonResponse(false, "There was an error processing your application");
}
