<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../../vendor/autoload.php';

// Function to send OTP Email
function sendOtpEmail($email, $otp)
{
    $mail = new PHPMailer(true);
    try {
        // SMTP Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'pesolosbanos4@gmail.com'; // Use your Gmail
        $mail->Password = 'rooy awbq emme qqyt'; // Use an App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Sender & Recipient
        $mail->setFrom('pesolosbanos4@gmail.com', 'PESO-lb.ph');
        $mail->addAddress($email);

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = 'OTP Verification';
        $mail->Body = 'Your OTP for email verification is: <b>' . $otp . '</b>. It will expire in 10 minutes.';

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Check if the request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $contact = $_POST['Cnum'];
    $dob = $_POST['dob'];
    $sex = $_POST['sex'];
    $presentadd = $_POST['present_address'];
    $tertiary_school = $_POST['school_name1'];
    $tertiary_graduate = $_POST['year_graduated1'];
    $tertiary_award = $_POST['award_recieved1'];
    $college_school = $_POST['school_name2'];
    $college_graduate = $_POST['year_graduated2'];
    $college_award = $_POST['award_recieved2'];
    $user_type = $_POST['applicanttype'];
    $pic = $_FILES['pic'];

    // Validation
    if (
        empty($username) || empty($email) || empty($password) || empty($fname) || empty($mname) || empty($lname) || empty($contact) ||
        empty($dob) || empty($sex) || empty($presentadd) || empty($tertiary_school) || empty($tertiary_graduate) ||
        empty($college_school) || empty($college_graduate) || empty($user_type) || empty($pic)
    ) {
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

    // Hash the password before storing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Create a folder for the company
    $uploadDir = "../uploads/" . preg_replace('/[^A-Za-z0-9_\-]/', '_', $username) . "/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Handle Image Upload
    $picPath = "";
    if ($pic['error'] == 0) {
        $fileName = basename($pic["name"]);
        $targetFilePath = $uploadDir . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Allowed file formats
        $allowedFormats = array("jpg", "jpeg", "png", "gif");
        if (in_array($fileType, $allowedFormats)) {
            if (move_uploaded_file($pic["tmp_name"], $targetFilePath)) {
                // Remove the ../ from the path for database storage
                $picPath = "uploads/" . preg_replace('/[^A-Za-z0-9_\-]/', '_', $username) . "/" . $fileName;
            } else {
                echo "Error uploading file!";
                exit;
            }
        } else {
            echo "Invalid file format!";
            exit;
        }
    }

    // Database connection using PDO
    $host = "localhost";
    $dbname = "pesoo";
    $db_username = "root";
    $db_password = "";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $db_username, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Set timezone to Manila, Philippines
        date_default_timezone_set('Asia/Manila');

        // Generate OTP
        $otp = rand(100000, 999999);
        $otp_expiry = date('Y-m-d H:i:s', strtotime('+10 minutes')); // Expiry in Manila Time

        // Prepare SQL statement
        // Store OTP and expiry in the database
        $stmt = $pdo->prepare("INSERT INTO applicant_profile (username, email, password, fname, mname, lname, contact_no, dob, sex, present_address, 
        tertiary_school, tertiary_graduated, tertiary_award, college_school, college_graduated, college_award, applicant_type, photo, otp, otp_expiry, is_verified) 
        VALUES (:username, :email, :password, :fname, :mname, :lname, :contact, :dob, :sex, :presentadd, :tertiary_school, :tertiary_graduate, 
        :tertiary_award, :college_school, :college_graduate, :college_award, :user_type, :pic, :otp, :otp_expiry, 0)");


        // Bind parameters
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':mname', $mname); // Fixed
        $stmt->bindParam(':lname', $lname);
        $stmt->bindParam(':contact', $contact);
        $stmt->bindParam(':dob', $dob);
        $stmt->bindParam(':sex', $sex);
        $stmt->bindParam(':presentadd', $presentadd); // Corrected variable name
        $stmt->bindParam(':tertiary_school', $tertiary_school);
        $stmt->bindParam(':tertiary_graduate', $tertiary_graduate);
        $stmt->bindParam(':tertiary_award', $tertiary_award);
        $stmt->bindParam(':college_school', $college_school);
        $stmt->bindParam(':college_graduate', $college_graduate);
        $stmt->bindParam(':college_award', $college_award);
        $stmt->bindParam(':user_type', $user_type);
        $stmt->bindParam(':pic', $picPath);
        $stmt->bindParam(':otp', $otp);
        $stmt->bindParam(':otp_expiry', $otp_expiry);


        // Execute query
        if ($stmt->execute()) {
            if (sendOtpEmail($email, $otp)) {
                // Redirect to OTP verification page
                header("Location: ../otp_verification.php?email=" . urlencode($email));
                exit();
            } else {
                echo "Failed to send OTP email!";
            }
        } else {
            echo "Error in registration!";
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
