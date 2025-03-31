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
    $tertiarySchool = htmlspecialchars($_POST['t_school_name']);
    $tertiaryGraduated = htmlspecialchars($_POST['tertiary_graduated']);
    $tertiaryAward = htmlspecialchars($_POST['award_recieved']);
    $tertiaryCourse = htmlspecialchars($_POST['t_course']);
    
    $gradSchool = htmlspecialchars($_POST['g_school_name']);
    $gradGraduated = htmlspecialchars($_POST['college_graduated']);
    $gradAward = htmlspecialchars($_POST['college_award']);
    $gradCourse = htmlspecialchars($_POST['g_course']);

    // Prepare the SQL query to insert or update the educational background
    try {
        $sql = "UPDATE applicant_profile SET 
                tertiary_school = ?, 
                tertiary_graduated = ?, 
                tertiary_award = ?, 
                tertiary_course = ?, 
                college_school = ?, 
                college_graduated = ?, 
                college_award = ?, 
                grad_course = ?
                WHERE id = ?"; // Assuming you have applicant_id stored in the session

        // Prepare the statement
        $stmt = $pdo->prepare($sql);

        // Bind the values using an indexed array for ? placeholders
        $params = [
            $tertiarySchool, 
            $tertiaryGraduated, 
            $tertiaryAward, 
            $tertiaryCourse, 
            $gradSchool, 
            $gradGraduated, 
            $gradAward, 
            $gradCourse,
            $_SESSION['applicant_id']  // Assuming user ID is stored in session
        ];

        // Execute the statement with the parameters array
        if ($stmt->execute($params)) {
            $updateSuccess = true; // Set success flag
        } else {
            $errorMessage = "Failed to update educational background.";
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
