<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../../vendor/autoload.php';


// Function to send registration email
function sendRegistrationEmail($email, $userData, $otp) {
    $mail = new PHPMailer(true);
    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'jervinguevarra123@gmail.com';
        $mail->Password = 'wdul asom bddj yhfd'; // Use app-specific password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('jervinguevarra123@gmail.com', 'PESO Los Baños');
        $mail->addAddress($email); 

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Admin Registration';
        
        $body = '<h2>New Admin Registration Details</h2>';
        $body .= '<p><strong>Username:</strong> ' . htmlspecialchars($userData['username']) . '</p>';
        $body .= '<p><strong>Name:</strong> ' . htmlspecialchars($userData['fname']) . ' ' . htmlspecialchars($userData['mname']) . ' ' . htmlspecialchars($userData['lname']) . '</p>';
        $body .= '<p><strong>Email:</strong> ' . htmlspecialchars($userData['email']) . '</p>';
        $body .= '<p><strong>Contact Number:</strong> ' . htmlspecialchars($userData['contact']) . '</p>';
        $body .= '<p><strong>Registration Date:</strong> ' . date('Y-m-d H:i:s') . '</p>';
        $body .= '<p><strong>OTP for email verification is: <b>' . $otp. '</strong> </p>';
        
        $mail->Body = $body;

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
    $age = $_POST['age'];
    $address = $_POST['add'];
    $pic = $_FILES['pic'];

    // Validation
    if (empty($username) || empty($email) || empty($password) || empty($fname) || empty($mname) || empty($lname) || empty($contact) || empty($address) || empty($pic)) {
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

        // Prepare SQL statement
        // Store OTP and expiry in the database
        $stmt = $pdo->prepare("INSERT INTO admin_profile (Username, Email, passwords, Fname, Mname, Lname, Age, Cnumber, Haddress, photo, otp, is_verified) 
        VALUES (:username, :email, :passwords, :fname, :mname, :lname, :age, :contact, :haddress, :pic, :otp, 0)");


        // Bind parameters
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':passwords', $hashed_password);
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':mname', $mname); // Fixed
        $stmt->bindParam(':lname', $lname);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':contact', $contact);
        $stmt->bindParam(':haddress', $address);
        $stmt->bindParam(':pic', $picPath);
        $stmt->bindParam(':otp', $otp);
        

        // Execute query
        if ($stmt->execute()) {
            $userData = [
                'username' => $username,
                'fname' => $fname,
                'mname' => $mname,
                'lname' => $lname,
                'email' => $email,
                'contact' => $contact
            ];

            if (sendRegistrationEmail($email, $userData, $otp)) {
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