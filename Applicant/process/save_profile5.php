<?php
session_start();

// Database connection (adjust these parameters as necessary)
$host = 'localhost'; // Database host
$dbname = 'pesoo'; // Database name
$username = 'root'; // Database username
$password = ''; // Database password

try {
    // Establish PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Get the user ID from session
$user_id = $_SESSION['applicant_id']; // Assuming the user's ID is stored in the session

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the language data from the form
    $languages = $_POST['language'] ?? [];
    $read = $_POST['read'] ?? [];
    $write = $_POST['write'] ?? [];
    $speak = $_POST['speak'] ?? [];
    $understand = $_POST['understand'] ?? [];

    // Prepare the SQL query for insertion
    $sql = "INSERT INTO language_proficiency (user_id, language_p, read_i, write_i, speak_i, understand_i) 
            VALUES (:user_id, :language, :read_l, :write_l, :speak_l, :understand_l)";

    $stmt = $pdo->prepare($sql);

    // Loop through each language and insert the data into the database
    foreach ($languages as $language) {
        // Check if the language is selected in each proficiency array
        $read_l = in_array($language, $read) ? 1 : 0; // If the language is in the 'read' array, mark as 1, else 0
        $write_l = in_array($language, $write) ? 1 : 0;
        $speak_l = in_array($language, $speak) ? 1 : 0;
        $understand_l = in_array($language, $understand) ? 1 : 0;

        // Bind values and execute the statement
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':language', $language);
        $stmt->bindParam(':read_l', $read_l);
        $stmt->bindParam(':write_l', $write_l);
        $stmt->bindParam(':speak_l', $speak_l);
        $stmt->bindParam(':understand_l', $understand_l);
        $stmt->execute();
    }

    // Redirect to a success page or the same page after saving data
    header('Location: ../applicant_profile.php'); // Reload the page to show updated data
    exit();
}

?>
