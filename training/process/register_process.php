<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    if (empty($fullname) || empty($email) || empty($password) || empty($address) || empty($phone) || empty($username)) {
        echo "All fields are required!";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format!";
        exit;
    }

    if (strlen($password) < 6) {
        echo "Password must be at least 6 characters!";
        exit;
    }

    if (!preg_match("/^\d{10}$/", $phone)) {
        echo "Invalid phone number!";
        exit;
    }

    echo "Registration Successful!";
}
?>
