<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pesoo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$user_id = $_GET['employer_id'];
$document_id = $_GET['id'];

$sql = "UPDATE documents SET is_verified = 'verified' WHERE id = '$document_id'";

if ($conn->query($sql) === TRUE) {
    echo "Document verified successfully!";
    header("Location: ../admin_home.php?page=users");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>