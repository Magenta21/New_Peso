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
    $present_address = $_POST['present_address'];
    $nationality = $_POST['nationality'];
    $civil_stat = $_POST['civil_stat'];
    $educ = $_POST['educ'];
    $parent = $_POST['parent'];
    $classification = $_POST['classification'];
    $disability = $_POST['disability'];
    $training_id = $_POST['training_id'];
    $pic = $_FILES['pic'];

    // Validation
    $required_fields = [
        $username, $email, $password, $fname, $lname, $contact, 
        $dob, $sex, $present_address, $nationality, $civil_stat,
        $educ, $parent, $classification, $training_id
    ];
    
    foreach ($required_fields as $field) {
        if (empty($field)) {
            echo "All required fields must be filled!";
            exit;
        }
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

    // Create a folder for the trainee's uploads
    $uploadDir = "../uploads/trainees/" . preg_replace('/[^A-Za-z0-9_\-]/', '_', $username) . "/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Handle Image Upload
    $picPath = "";
    if ($pic['error'] == 0) {
        $fileName = uniqid() . '_' . basename($pic["name"]); // Add unique ID to filename
        $targetDir = "uploads/trainees/" . preg_replace('/[^A-Za-z0-9_\-]/', '_', $username) . "/";
        
        // Create directory if it doesn't exist (relative to the script location)
        if (!is_dir("../" . $targetDir)) {
            mkdir("../" . $targetDir, 0777, true);
        }
        
        $targetFilePath = "../" . $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Allowed file formats
        $allowedFormats = array("jpg", "jpeg", "png", "gif");
        if (in_array($fileType, $allowedFormats)) {
            if (move_uploaded_file($pic["tmp_name"], $targetFilePath)) {
                // Store only the relative path in database (without ../)
                $picPath = $targetDir . $fileName;
            } else {
                echo "Error uploading file!";
                exit;
            }
        } else {
            echo "Invalid file format! Only JPG, JPEG, PNG & GIF are allowed.";
            exit;
        }
    } else {
        echo "Profile picture is required!";
        exit;
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

        // Begin transaction
        $pdo->beginTransaction();

        // 1. Insert into trainees_profile
        $stmt = $pdo->prepare("INSERT INTO trainees_profile (
            username, email, password, fname, mname, lname, 
            address, contact_no, nationality, sex, civil_status, 
            employment, dob, educ_attain, parent, classification, 
            disability, photo, otp, otp_expiry, is_verified
        ) VALUES (
            :username, :email, :password, :fname, :mname, :lname, 
            :present_address, :contact, :nationality, :sex, :civil_stat, 
            :classification, :dob, :educ, :parent, :classification, 
            :disability, :photo, :otp, :otp_expiry, 0
        )");

        // Bind parameters
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':mname', $mname);
        $stmt->bindParam(':lname', $lname);
        $stmt->bindParam(':present_address', $present_address);
        $stmt->bindParam(':contact', $contact);
        $stmt->bindParam(':nationality', $nationality);
        $stmt->bindParam(':sex', $sex);
        $stmt->bindParam(':civil_stat', $civil_stat);
        $stmt->bindParam(':classification', $classification);
        $stmt->bindParam(':dob', $dob);
        $stmt->bindParam(':educ', $educ);
        $stmt->bindParam(':parent', $parent);
        $stmt->bindParam(':disability', $disability);
        $stmt->bindParam(':photo', $picPath);
        $stmt->bindParam(':otp', $otp);
        $stmt->bindParam(':otp_expiry', $otp_expiry);

        if (!$stmt->execute()) {
            throw new Exception("Error creating trainee profile");
        }

        // Get the last inserted ID
        $trainee_id = $pdo->lastInsertId();

        // 2. Insert into trainee_trainings (enrollment record)
        $enrollment_stmt = $pdo->prepare("INSERT INTO trainee_trainings (trainee_id, training_id) VALUES (:trainee_id, :training_id)");
        $enrollment_stmt->bindParam(':trainee_id', $trainee_id);
        $enrollment_stmt->bindParam(':training_id', $training_id);

        if (!$enrollment_stmt->execute()) {
            throw new Exception("Error enrolling trainee in training program");
        }

        // Commit transaction
        $pdo->commit();

        // Send OTP email
        if (sendOtpEmail($email, $otp)) {
            // Redirect to OTP verification page with email and training ID
            header("Location: ../otp_verification.php?email=" . urlencode($email) . "&training_id=" . $training_id);
            exit();
        } else {
            throw new Exception("Failed to send OTP email");
        }

    } catch (PDOException $e) {
        // Rollback transaction on error
        if (isset($pdo) && $pdo->inTransaction()) {
            $pdo->rollBack();
        }
        // Delete uploaded file if registration failed
        if (!empty($picPath) && file_exists($picPath)) {
            unlink($picPath);
        }
        die("Database error: " . $e->getMessage());
    } catch (Exception $e) {
        // Delete uploaded file if registration failed
        if (!empty($picPath) && file_exists($picPath)) {
            unlink($picPath);
        }
        die("Error: " . $e->getMessage());
    }
}
?>