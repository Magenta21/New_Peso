<?php
include '../../db.php'; // Ensure this file contains the DB connection

$user_id = $_POST['user_id'];
$survey_ids = $_POST['survey_ids']; // Array of all survey question IDs

foreach ($survey_ids as $survey_id) {
    $response = $_POST['response'.$survey_id]; // Get the response for each question

    // Check if the user has already submitted a response for this question
    $check_sql = "SELECT * FROM survey_response WHERE user_id = $user_id AND survey_id = $survey_id";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        // Update existing response
        $update_sql = "UPDATE survey_response SET response = '$response' WHERE user_id = $user_id AND survey_id = $survey_id";
        if ($conn->query($update_sql) === TRUE) {
            header("Location: ../ofw_home.php");
        } else {
            echo "Error updating response for survey ID $survey_id: " . $conn->error . "<br>";
        }
    } else {
        // Insert new response
        $insert_sql = "INSERT INTO survey_response (user_id, survey_id, response) VALUES ($user_id, $survey_id, '$response')";
        if ($conn->query($insert_sql) === TRUE) {
            header("Location: ../ofw_home.php");
        } else {
            echo "Error inserting response for survey ID $survey_id: " . $conn->error . "<br>";
        }
    }
}

$conn->close();
?>
