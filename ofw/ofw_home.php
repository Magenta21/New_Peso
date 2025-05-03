<?php
include '../db.php';
session_start();

$ofwid = $_SESSION['ofw_id'];
// Check if the employer is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ofw_login.php");
    exit();
}

$sql = "SELECT * FROM ofw_profile WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ofwid);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Invalid query: " . $conn->error); 
}

$row = $result->fetch_assoc();
if (!$row) {
    die("User not found.");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layout Design</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
<nav class="navbar bg-primary text-white py-2">
    <div class="container-fluid">
        <!-- Navigation Links -->
        <img src="../img/logolb.png" alt="lblogo" style="height: 50px;">
        <div class="ms-auto">        
                   
        </div>
        
        <div class="d-flex flex-wrap align-items-center">
        <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"> </div>
                <a href="ofw_home.php" class="nav-link px-3">Home</a>
                
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>

                <a href="ofw_report.php" class="nav-link px-3">Post Report</a>

            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>

                <a href="ofw_report.php" class="nav-link px-3">View Report Status</a>

            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"> </div>
            
        </div>
        <div class="ms-auto">
            <div class="dropdown">
                <a href="#" class="text-decoration-none mt-5" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php if (!empty($row['profile_image'])): ?>
                        <img id="preview" src="<?php echo $row['profile_image']; ?>" alt="Profile Image" class="img-fluid rounded-circle" style="width: 40px; height: 40px;">
                    <?php else: ?>
                        <img src="../img/user-placeholder.png" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 40px; height: 40px;">
                    <?php endif; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end text-center mt-2" aria-labelledby="profileDropdown">
                    <li><a class="dropdown-item" href="ofw_profile.php">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="form-container">
          <table class="table table-hover">
              <thead>
                  <th class="text-center">Question</th>
                  <th class="text-center">Never</th>
                  <th class="text-center">Often</th>
                  <th class="text-center">Sometimes</th>
                  <th class="text-center">Always</th>
              </thead>

        <form action='process/survey_response.php' method='POST' onsubmit='submitSurvey()'>
            <?php
              $sql = "SELECT * FROM survey_form ORDER BY category";
              $result = $conn->query($sql);

              // Initialize variable to track the current category
              $current_category = '';

              if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Fetch the user's previous response for the current survey question
                    $survey_id = $row['id'];
                    $response_sql = "SELECT response FROM survey_response WHERE user_id = $ofwid AND survey_id = $survey_id";
                    $response_result = $conn->query($response_sql);
                    $previous_response = '';
                
                    // Get the previous response if it exists
                    if ($response_result->num_rows > 0) {
                        $response_row = $response_result->fetch_assoc();
                        $previous_response = $response_row['response'];
                    }
                
                    // Check if we are in a new category
                    if ($current_category != $row['category']) {
                        // If it's a new category, print it as a heading row
                        echo "<thead><th colspan='5'>" . $row['category'] . "</th></thead>";
                        // Update current category tracker
                        $current_category = $row['category'];
                    }
                
                    // Print the survey question with radio button options
                    echo "<tr>
                            <td style='width: 300px; text-align: justify;'>" . $row["questions"] . "</td>
                            <input type='hidden' name='survey_ids[]' value='" . $row['id'] . "'>
                            <input type='hidden' name='user_id' value='" . $ofwid  . "'>
                            <td>
                              <div class='form-check d-flex justify-content-center'>
                                <input class='form-check-input' type='radio' name='response" . $row['id'] . "' value='Never' " . ($previous_response == 'Never' ? 'checked' : '') . ">
                              </div>
                            </td>
                            <td>
                              <div class='form-check d-flex justify-content-center'>
                                <input class='form-check-input' type='radio' name='response" . $row['id'] . "' value='Often' " . ($previous_response == 'Often' ? 'checked' : '') . ">
                              </div>
                            </td>
                            <td>
                              <div class='form-check d-flex justify-content-center'>
                                <input class='form-check-input' type='radio' name='response" . $row['id'] . "' value='Sometimes' " . ($previous_response == 'Sometimes' ? 'checked' : '') . ">
                              </div>
                            </td>
                            <td>
                              <div class='form-check d-flex justify-content-center'>
                                <input class='form-check-input' type='radio' name='response" . $row['id'] . "' value='Always' " . ($previous_response == 'Always' ? 'checked' : '') . ">
                              </div>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No questions found</td></tr>";
            }
            ?>
            </table>
                  <input class="btn btn-primary" type="submit" value="Submit">
              </form>
          
          
        </div>

    

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
