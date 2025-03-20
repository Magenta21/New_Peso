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
    $name = htmlspecialchars($_POST['company_name']);
    $pres = htmlspecialchars($_POST['president']);
    $add = htmlspecialchars($_POST['company_address']);
    $hr = htmlspecialchars($_POST['hr']);
    $cont = htmlspecialchars($_POST['company_contact']);
    $email = htmlspecialchars($_POST['company_email']);
    $type = htmlspecialchars($_POST['employment_type']);

    // Prepare the SQL query to update the profile
    try {
        $sql = "UPDATE employer SET company_name = :cname, president = :pres, company_address = :adds, hr = :hr, company_contact = :cont, company_email = :email, types_of_employer = :types";
    
        $sql .= " WHERE id = :user_id";  // Assuming user_id is the identifier in the database

        // Prepare the statement
        $stmt = $pdo->prepare($sql);

        // Bind the values to the prepared statement
        $stmt->bindParam(':cname', $name);
        $stmt->bindParam(':pres', $pres);
        $stmt->bindParam(':adds', $add);
        $stmt->bindParam(':hr', $hr);
        $stmt->bindParam(':cont', $cont);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':types', $type);
    

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
