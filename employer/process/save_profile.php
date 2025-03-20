<?php
session_start(); // Start the session to access user_id

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
    $contact = htmlspecialchars($_POST['contact']);
    
    // Handle file upload for profile picture
    $profilePic = null;
    $cname = $username;  // Use the username as the folder name or adjust accordingly
    
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

    // Prepare the SQL query to update the profile
    try {
        $sql = "UPDATE employer SET username = :username, email = :email, password = :password, fname = :fname, lname = :lname, company_contact = :contact";
        
        // If a new profile picture was uploaded, update it as well
        if ($profilePic) {
            $sql .= ", company_photo = :company_photo";
        }
        $sql .= " WHERE id = :user_id";  // Assuming user_id is the identifier in the database

        // Prepare the statement
        $stmt = $pdo->prepare($sql);

        // Bind the values to the prepared statement
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':fname', $firstName);
        $stmt->bindParam(':lname', $lastName);
        $stmt->bindParam(':contact', $contact);
        
        // If there's a profile picture, bind it
        if ($profilePic) {
            $stmt->bindParam(':company_photo', $profilePic);
        }

        // Bind the user ID (you would get this from session or other means)
        $user_id = $_SESSION['employer_id']; // Assuming user ID is stored in session
        $stmt->bindParam(':user_id', $user_id);

        // Execute the statement
        if ($stmt->execute()) {
            $updateSuccess = true; // Set success flag
        } else {
            $errorMessage = "Profile update failed.";
        }
    } catch (PDOException $e) {
        $errorMessage = "Error: " . $e->getMessage();
    }

    // Redirect based on success or failure
    if ($updateSuccess) {
        header('Location: ../employer_profile.php');
        exit();
    } else {
        // Show error message using JS
        echo "<script>
                alert('$errorMessage');
                window.location.href = '../employer_profile.php';
              </script>";
        exit();
    }
}
?>
