<?php
session_start(); // Start the session to access user_id

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database configuration
$host = 'localhost';
$db = 'pesoo';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// Set up the PDO connection
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$updateSuccess = false;
$errorMessage = '';

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $username = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['pass']);
    $firstName = htmlspecialchars($_POST['fname']);
    $lastName = htmlspecialchars($_POST['lname']);
    $mname = htmlspecialchars($_POST['mname']);
    $contact = htmlspecialchars($_POST['contact']);
    $dob = htmlspecialchars($_POST['dob']);
    $pob = htmlspecialchars($_POST['pob']);
    $religion = htmlspecialchars($_POST['religion']);
    $address = htmlspecialchars($_POST['address']);
    $civilstat = htmlspecialchars($_POST['civil_status']);
    $sex = htmlspecialchars($_POST['sex']);
    $height = htmlspecialchars($_POST['height']);
    $tin = htmlspecialchars($_POST['tin']);
    $gsis = htmlspecialchars($_POST['sss_no']);
    $pagibigno = htmlspecialchars($_POST['pag_ibig_number']);
    $phil = htmlspecialchars($_POST['philhealth_no']);
    $landline = htmlspecialchars($_POST['landline']);
    $pwd = htmlspecialchars($_POST['disability']);
    $fourps = htmlspecialchars($_POST['four_ps']);

    // Calculate age from date of birth
    if (!empty($dob)) {
        $birthDate = new DateTime($dob);  // Convert the birth date to a DateTime object
        $currentDate = new DateTime();    // Get the current date
        $ageInterval = $birthDate->diff($currentDate);  // Calculate the difference between the two dates
        $age = $ageInterval->y;           // Extract the number of years (age)
    } else {
        $age = '';  // In case no date is provided
    }

    // Handle file upload for profile picture
    $profilePic = null;
    $cname = $username;  // Use the username as the folder name
    
    // Define the upload directory
    $uploadDir = "../uploads/" . preg_replace('/[^A-Za-z0-9_\-]/', '_', $cname) . "/";
    $dbPath = "uploads/" . preg_replace('/[^A-Za-z0-9_\-]/', '_', $cname) . "/"; // Relative path to be stored in the database    

    // Create the directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Handle the uploaded file
    if (isset($_FILES['fileInput']) && $_FILES['fileInput']['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($_FILES['fileInput']['name']);
        $targetFilePath = $uploadDir . $fileName;
        $dbFilePath = $dbPath . $fileName;  // This relative path will be stored in the database

        // Check the file type
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $allowedFormats = ["jpg", "jpeg", "png", "gif"];

        if (in_array($fileType, $allowedFormats)) {
            // Move the uploaded file to the correct directory
            if (move_uploaded_file($_FILES['fileInput']['tmp_name'], $targetFilePath)) {
                $profilePic = $dbFilePath; // Store the relative file path
            } else {
                $errorMessage = "Error uploading file!";
            }
        } else {
            $errorMessage = "Invalid file format!";
        }
    } else {
        // No file uploaded or error occurred
        $errorMessage = "No file uploaded or error occurred.";
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL query to update the profile
    try {
        $sql = "UPDATE applicant_profile SET 
                username = ?, 
                email = ?, 
                password = ?, 
                fname = ?, 
                lname = ?, 
                mname = ?, 
                contact_no = ?, 
                dob = ?, 
                pob = ?, 
                age = ?, 
                height = ?, 
                sex = ?, 
                civil_status = ?, 
                landline = ?, 
                present_address = ?, 
                tin = ?, 
                sss_no = ?, 
                pagibig_no = ?, 
                philhealth_no = ?, 
                religion = ?, 
                four_ps = ?";

        // If a new profile picture was uploaded, update it as well
        if ($profilePic) {
            $sql .= ", photo = ?";
        }

        $sql .= " WHERE id = ?";  // Assuming user_id is the identifier in the database

        // Prepare the statement
        $stmt = $pdo->prepare($sql);

        // Bind the values in the correct order
        $params = [
            $username, 
            $email, 
            $hashedPassword,  // Bind the hashed password
            $firstName, 
            $lastName, 
            $mname, 
            $contact, 
            $dob, 
            $pob, 
            $age, 
            $height, 
            $sex, 
            $civilstat, 
            $landline, 
            $address, 
            $tin, 
            $gsis, 
            $pagibigno, 
            $phil, 
            $religion, 
            $fourps
        ];

        // If there's a profile picture, add it to the params array
        if ($profilePic) {
            $params[] = $profilePic;  // Add the profile picture to the parameters array
        }

        // Add the user_id (stored in session) to the params array
        $params[] = $_SESSION['applicant_id'];

        // Execute the statement with the parameters array
        if ($stmt->execute($params)) {
            $updateSuccess = true; // Set success flag
        } else {
            $errorMessage = "Profile update failed.";
        }
    } catch (PDOException $e) {
        $errorMessage = "Error: " . $e->getMessage();
    }

    // Redirect based on success or failure
    if ($updateSuccess) {
        header('Location: ../training_profile.php');
        exit();
    } else {
        // Show error message using JS
        echo "<script>
                alert('$errorMessage');
                window.location.href = '../training_profile.php';
              </script>";
        exit();
    }   
}
?>
