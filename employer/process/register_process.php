<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../../vendor/autoload.php';

// Function to send OTP Email
function sendOtpEmail($email, $otp) {
    $mail = new PHPMailer(true);
    try {
        // SMTP Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'jervinguevarra123@gmail.com'; // Use your Gmail
        $mail->Password = 'wdul asom bddj yhfd'; // Use an App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Sender & Recipient
        $mail->setFrom('jervinguevarra123@gmail.com', 'PESO-lb.ph');
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
    $lname = $_POST['lname'];
    $contact = $_POST['Cnum'];
    $cname = $_POST['cname'];
    $pres = $_POST['president'];
    $companyadd = $_POST['companyadd'];
    $hr = $_POST['hr_manager'];
    $Compphone = $_POST['companynum'];
    $comemail = $_POST['cmail'];
    $employertype = $_POST['employertype'];
    $compic = $_FILES['pic'];

    // Generate OTP
    $otp = rand(100000, 999999);
    $otp_expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

    // Validation
    if (empty($username) || empty($email) || empty($password) || empty($fname) || empty($lname) || empty($contact) || 
        empty($cname) || empty($pres) || empty($companyadd) || empty($hr) || empty($Compphone) || empty($comemail)) {
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
    $uploadDir = "../uploads/" . preg_replace('/[^A-Za-z0-9_\-]/', '_', $cname) . "/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Handle Image Upload
    $picPath = "";
    if ($compic['error'] == 0) {
        $fileName = basename($compic["name"]);
        $targetFilePath = $uploadDir . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Allowed file formats
        $allowedFormats = array("jpg", "jpeg", "png", "gif");
        if (in_array($fileType, $allowedFormats)) {
            if (move_uploaded_file($compic["tmp_name"], $targetFilePath)) {
                $picPath = $targetFilePath;
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
    $dbname = "peso2";
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
        $stmt = $pdo->prepare("INSERT INTO employer (username, email, password, fname, lname, tel_num, company_name, president, company_address, hr, company_contact, company_email, types_of_employer, company_photo, otp, otp_expiry, is_verified) 
        VALUES (:username, :email, :password, :fname, :lname, :contact, :cname, :president, :companyadd, :hr_manager, :companynum, :cmail, :employertype, :pic, :otp, :otp_expiry, 0)");

        // Bind parameters
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':lname', $lname);
        $stmt->bindParam(':contact', $contact);
        $stmt->bindParam(':cname', $cname);
        $stmt->bindParam(':president', $pres);
        $stmt->bindParam(':companyadd', $companyadd);
        $stmt->bindParam(':hr_manager', $hr);
        $stmt->bindParam(':companynum', $Compphone);
        $stmt->bindParam(':cmail', $comemail);
        $stmt->bindParam(':employertype', $employertype);
        $stmt->bindParam(':pic', $picPath);
        $stmt->bindParam(':otp', $otp);
        $stmt->bindParam(':otp_expiry', $otp_expiry);
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
?>
