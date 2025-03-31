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

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the training data
    $trainings = $_POST['training'] ?? [];
    $start_dates = $_POST['start_date'] ?? [];
    $end_dates = $_POST['end_date'] ?? [];
    $institutions = $_POST['institution'] ?? [];
    $certificates = $_FILES['certificate']['name'] ?? [];
    $applicantid = $_SESSION['applicant_id'];

    // Create the username-based folder in the root directory
    $username = $_SESSION['username']; // Assuming the session holds the username
    $target_dir = "../uploads/" . $username . "/"; // Folder path based on the username
    
    // Check if the folder exists, if not, create it
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true); // Create the folder with appropriate permissions
    }

    // Prepare the SQL query for insertion
    $sql = "INSERT INTO training (user_id, training, start_date, end_date, institution, certificate_path) 
            VALUES (:applicant_id, :training_name, :start_date, :end_date, :institution, :certificate_path)";

    $stmt = $pdo->prepare($sql);

    // Loop through each training and insert the data into the database
    foreach ($trainings as $index => $training_name) {
        $start_date = $start_dates[$index];
        $end_date = $end_dates[$index];
        $institution = $institutions[$index];
        $certificate_path = '';

        // Handle file upload (if any)
        if (!empty($certificates[$index])) {
            $target_file = $target_dir . basename($certificates[$index]);

            // Move the uploaded file to the specific folder
            if (move_uploaded_file($_FILES['certificate']['tmp_name'][$index], $target_file)) {
                // Store only the relative path in the database (excluding the root folder)
                $certificate_path = "uploads/" . $username . "/" . basename($certificates[$index]);
            }
        }

        // Bind values and execute the statement
        $stmt->bindParam(':training_name', $training_name);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->bindParam(':institution', $institution);
        $stmt->bindParam(':certificate_path', $certificate_path);
        $stmt->bindParam(':applicant_id', $applicantid);
        $stmt->execute();
    }

    header('Location: ../applicant_profile.php');  // Redirect to profile page after successful update
}
?>
