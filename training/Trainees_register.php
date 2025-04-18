<?php 
include('../db.php');

// Get the training ID from URL parameter
$training_id = isset($_GET['training']) ? (int)$_GET['training'] : 0;

// Validate training ID
$valid_trainings = [1, 2, 3, 4]; // IDs from your skills_training table
if (!in_array($training_id, $valid_trainings)) {
    die("Invalid training selection");
}

// Get training name from database
$training_query = "SELECT name FROM skills_training WHERE id = $training_id";
$training_result = mysqli_query($conn, $training_query);
$training_row = mysqli_fetch_assoc($training_result);
$training_name = $training_row['name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>4-Step Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/register.css">
</head>
<body>

<div class="header">
        <div class="container-fluid d-flex align-items-center">
            <button onclick="window.history.back()" class="back-button me-auto">
                ← Back
            </button>
        </div>
    </div>

<!-- Step Progress Bar -->
<div class="step-container">
    <div class="step active">Step 1</div>
    <div class="step">Step 2</div>
    <div class="step">Step 3</div>
    <div class="step">Step 4</div>
</div>

<div class="container-fluid mt-md-3">
    <div class="row justify-content-center sm-margin">
        <div class="container">
            <form id="registrationForm" action="process/register_process.php" method="POST" enctype="multipart/form-data">
                <!-- Step 1: Email & Password (Now the first step) -->
                <div class="form-step active">
                    <h2>Step 1: Account Details</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="text">Username:</label>
                            <input type="text" id="username" name="username" required>
                            <span class="error-message" id="username-error"></span>
                        </div>

                        <div class="col-md-6">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required>
                            <span class="error-message" id="email-error"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" required>
                            <span class="error-message"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="confirmPassword">Confirm Password:</label>
                            <input type="password" id="confirmPassword" name="confirmPassword" required>
                            <span class="error-message"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" onclick="nextStep()">Next</button>
                        </div>
                    </div>
                </div>

                    <!-- Step 2: Personal Information -->
                    <div class="form-step">
                        <h4>Step 2: Personal Information</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="fname">First name:</label>
                                <input type="text" id="fname" name="fname" required>
                                <span class="error-message"></span>
                            </div>

                            <div class="col-md-4">
                                <label for="mname">Middle name:</label>
                                <input type="text" id="mname" name="mname">
                                <span class="error-message"></span>
                            </div>

                            <div class="col-md-4">
                                <label for="lname">Last name:</label>
                                <input type="text" id="lname" name="lname" required>
                                <span class="error-message"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label for="Cnum">Contact Number:</label>
                                <input type="number" id="Cnum" name="Cnum" required>
                                <span class="error-message"></span>
                            </div>

                            <div class="col-md-4">
                                <label for="dob">Date of Birth:</label>
                                <input type="date" id="dob" name="dob" required>
                                <span class="error-message"></span>
                            </div>

                            <div class="col-md-4">
                                    <label for="sex">Sex:</label>
                                    <select id="sex" name="sex" required>
                                        <option value="">Select</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                    <span class="error-message"></span>
                            </div>
                        </div>  

                        <div class="row">
                            <div class="col-md-12"> 
                                <label for="Present_Address">Present Address:</label>
                                <input type="text" id="Present_Address" name="present_address" required>
                                <span class="error-message"></span>
                            </div>
                        </div>

                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" onclick="prevStep()">Previous</button>
                            <button type="button" onclick="nextStep()">Next</button>
                        </div>
                    </div>
                </div>


                <!-- Step 3: Address -->
                <div class="form-step">
                    <h2>Step 3: Additional Information</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="tertiary_school_name">Nationality</label>
                            <input type="text" id="nationality" name="nationality"  required>
                            <span class="error-message"></span>
                        </div>
                

                        <div class="col-md-6">
                            <label for="civil_stat">Civil status:</label>
                            <select id="civil_stat" name="civil_stat" required>
                                <option value="">Select</option>
                                <option value="male">Married</option>
                                <option value="female">Single</option>
                                <option value="male">Widow</option>
                                <option value="female">Divorced</option>
                                <option value="male">Separated</option>
                            </select>
                            <span class="error-message"></span>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                            <label for="educ">Educational attainment:</label>
                            <select id="educ" name="educ" required>
                                <option value="">Select</option>
                                <option value="hug">Highschool under graduate</option>
                                <option value="hg">Highschool graduate</option>
                                <option value="cug">College under graduate</option>
                                <option value="cg">College graduate</option>
                            </select>
                            <span class="error-message"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="graduated_school_name">Parent Name</label>
                            <input type="text" id="parent" name="parent"  required>
                            <span class="error-message"></span>
                        </div>
                
                        <div class="col-md-6">
                            <label for="classification">Classification:</label>
                            <select id="classification" name="classification" required>
                                <option value="">Select</option>
                                <option value="unemployed">Unemployed</option>
                                <option value="employed">Employed</option>
                                <option value="bo">Business Owner</option>
                                <option value="sp">Service provider</option>
                                <option value="student">Student</option>
                            </select>
                            <span class="error-message"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="award_recieved2">Disability</label>
                            <input type="text" id="disability" name="disability">
                            <input type="hidden" name="training_id" value="<?php echo $training_id; ?>">
                            <span class="error-message"></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" onclick="prevStep()">Previous</button>
                            <button type="button" onclick="nextStep()">Next</button>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Phone Number -->
                <div class="form-step">
                    <h2>Step 4: Picture</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="pic">Profile  Picture:</label>
                            <input type="file" id="pic" name="pic" required>
                            <span class="error-message"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <button type="button" onclick="prevStep()">Previous</button>
                            <button type="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="js/register.js"></script>
</body>
</html>
