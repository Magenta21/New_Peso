<?php
session_start();

// Database connection
$host = 'localhost';
$dbname = 'pesoo';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Get user ID and username from session
$user_id = $_SESSION['applicant_id'];
$username = $_SESSION['username']; // Ensure session holds username

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $eligibilities = $_POST['documents_name'] ?? [];
    $ratings = $_POST['rating'] ?? [];
    $dates = $_POST['date_upload'] ?? [];
    $files = $_FILES['file'] ?? null;

    // Define user-specific upload directory
    $uploadDir = '../uploads/' . $username . '/';

    // Create folder if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Prepare SQL for insertion
    $sql = "INSERT INTO license (user_id, eligibility, rating, doe, prc_path) 
            VALUES (:user_id, :eligibility, :rating, :doe, :prc_path)";
    $stmt = $pdo->prepare($sql);

    for ($i = 0; $i < count($eligibilities); $i++) {
        $eligibility = $eligibilities[$i];
        $rating = $ratings[$i];
        $doe = $dates[$i];
        $prc_path = '';

        // Handle file upload
        if (!empty($files['name'][$i]) && $files['error'][$i] === UPLOAD_ERR_OK) {
            $originalFileName = basename($files['name'][$i]); // Keep the original filename
            $filePath = $uploadDir . $originalFileName;

            if (move_uploaded_file($files['tmp_name'][$i], $filePath)) {
                $prc_path = 'uploads/' . $username . '/' . $originalFileName;
            } else {
                echo "Error uploading file: " . $files['name'][$i];
                exit;
            }
        }

        // Insert into database only if upload is successful or no file is uploaded
        $stmt->execute([
            ':user_id' => $user_id,
            ':eligibility' => $eligibility,
            ':rating' => $rating,
            ':doe' => $doe,
            ':prc_path' => $prc_path
        ]);
    }

    header('Location: ../applicant_profile.php?success=1');
    exit();
} else {
    header('Location: ../applicant_profile.php');
    exit();
}
?>
