<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernameOrEmail = $_POST['username'];
    $password = $_POST['password'];
    $training_id = isset($_POST['training_id']) ? (int)$_POST['training_id'] : 0;

    // Database connection
    $pdo = new PDO("mysql:host=localhost;dbname=pesoo;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    try {
        // Fetch user details by username or email
        $stmt = $pdo->prepare("SELECT * FROM trainees_profile 
                              WHERE (username = :username OR email = :email) 
                              AND is_verified = 1");
        $stmt->bindParam(':username', $usernameOrEmail);
        $stmt->bindParam(':email', $usernameOrEmail);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Check if user is enrolled in the training they're trying to access
            if ($training_id > 0) {
                $enrollment_stmt = $pdo->prepare("SELECT 1 FROM trainee_trainings 
                                                WHERE trainee_id = :trainee_id 
                                                AND training_id = :training_id");
                $enrollment_stmt->bindParam(':trainee_id', $user['id']);
                $enrollment_stmt->bindParam(':training_id', $training_id);
                $enrollment_stmt->execute();
                
                if (!$enrollment_stmt->fetch()) {
                    die("You are not enrolled in this training program.");
                }
            }

            // Set session variables
            $_SESSION['trainee_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['trainee_name'] = $user['fname'] . ' ' . $user['lname'];
            $_SESSION['training_id'] = $training_id;
            $_SESSION['logged_in'] = true;
            $_SESSION['user_type'] = 'trainee';

            // Redirect to appropriate dashboard
            if ($training_id > 0) {
                // Redirect to training-specific dashboard
                header("Location: ../training_home.php?training=$training_id");
            } else {
                // Redirect to general trainee dashboard
                header("Location: ../trainee_dashboard.php");
            }
            exit();
        } else {
            echo "<script> alert('Invalid username or password'); window.location.href='../training_login.php' </script>";
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    die("Unauthorized access!");
}
?>