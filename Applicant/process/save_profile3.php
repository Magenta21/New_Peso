<?php
session_start(); // Start the session to access user_id

// Enable error reporting for debugging
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
    echo "Connection failed: " . $e->getMessage();
    exit();
}

$updateSuccess = false;
$errorMessage = '';

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $preferredWorkLocation = htmlspecialchars($_POST['preferred_work_location']);
    $expectedSalary = htmlspecialchars($_POST['expected_salary']);

    // Prepare local or overseas location based on the preferred work location
    if ($preferredWorkLocation == 'local') {
        $localLocations = [];
        if (!empty($_POST['local_location_1'])) {
            $localLocations[] = htmlspecialchars($_POST['local_location_1']);
        }
        if (!empty($_POST['local_location_2'])) {
            $localLocations[] = htmlspecialchars($_POST['local_location_2']);
        }
        if (!empty($_POST['local_location_3'])) {
            $localLocations[] = htmlspecialchars($_POST['local_location_3']);
        }
        $preferredLocation = implode(', ', $localLocations);
    } else {
        $overseasLocations = [];
        if (!empty($_POST['overseas_location_1'])) {
            $overseasLocations[] = htmlspecialchars($_POST['overseas_location_1']);
        }
        if (!empty($_POST['overseas_location_2'])) {
            $overseasLocations[] = htmlspecialchars($_POST['overseas_location_2']);
        }
        if (!empty($_POST['overseas_location_3'])) {
            $overseasLocations[] = htmlspecialchars($_POST['overseas_location_3']);
        }
        $preferredLocation = implode(', ', $overseasLocations);
    }

    // Preferred Occupation
    $preferredOccupations = [];
    if (!empty($_POST['preferred_occupation1'])) {
        $preferredOccupations[] = htmlspecialchars($_POST['preferred_occupation1']);
    }
    if (!empty($_POST['preferred_occupation2'])) {
        $preferredOccupations[] = htmlspecialchars($_POST['preferred_occupation2']);
    }
    if (!empty($_POST['preferred_occupation3'])) {
        $preferredOccupations[] = htmlspecialchars($_POST['preferred_occupation3']);
    }
    if (!empty($_POST['preferred_occupation4'])) {
        $preferredOccupations[] = htmlspecialchars($_POST['preferred_occupation4']);
    }
    $preferredOccupation = implode(', ', $preferredOccupations);

    // Passport number and expiry
    $passportNo = isset($_POST['passport_no']) ? htmlspecialchars($_POST['passport_no']) : null;
    $passportExpiry = isset($_POST['passport_expiry']) ? htmlspecialchars($_POST['passport_expiry']) : null;

    // Prepare the SQL query to insert or update the employment status
    try {
        $sql = "UPDATE applicant_profile SET 
                preferred_work_location = ?, 
                expected_salary = ?, 
                work_location = ?, 
                preferred_occupation = ?, 
                passport_no = ?, 
                passport_expiry = ?
                WHERE id = ?"; // Assuming you have applicant_id stored in the session

        // Prepare the statement
        $stmt = $pdo->prepare($sql);

        // Bind the values using an indexed array for ? placeholders
        $params = [
            $preferredWorkLocation,    // preferred_work_location
            $expectedSalary,           // expected_salary
            $preferredLocation,        // preferred_location (comma-separated)
            $preferredOccupation,      // preferred_occupation (comma-separated)
            $passportNo,               // passport_no
            $passportExpiry,           // passport_expiry
            $_SESSION['applicant_id']  // user_id
        ];

        // Execute the statement with the parameters array
        if ($stmt->execute($params)) {
            $updateSuccess = true; // Set success flag
        } else {
            $errorMessage = "Failed to update employment status.";
        }
    } catch (PDOException $e) {
        // Log or display the error message
        $errorMessage = "Error: " . $e->getMessage();
        echo "<pre>" . print_r($e, true) . "</pre>";  // Output the exception details for debugging
    }

    // Redirect based on success or failure
    if ($updateSuccess) {
        header('Location: ../applicant_profile.php');  // Redirect to profile page after successful update
        exit();
    } else {
        // Show error message using JS
        echo "<script>
                alert('$errorMessage');
                window.location.href = '../applicant_profile.php';
              </script>";
        exit();
    }
}
?>
