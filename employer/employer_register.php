<?php include('../db.php'); ?>
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
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-2 col-xxl-3 text-start">
                <img src="../img/logolb.png" alt="lblogo" style="height: 50px;">
            </div>
            <div class="col-md-8 col-xxl-6 text-center">
                <h3 style="margin-top: 5px; font-weight: 700; color: #ffffff;">MUNICIPALITY OF LOS BANOS</h3>
            </div>
        </div>
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
            <form id="registrationForm" action="register_process.php" method="POST">
                <!-- Step 1: Email & Password (Now the first step) -->
                <div class="form-step active">
                    <h2>Step 1: Account Details</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="text">Username:</label>
                            <input type="text" id="username" name="username" required>
                            <span class="error-message"></span>
                        </div>

                        <div class="col-md-6">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required>
                            <span class="error-message"></span>
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
                        <button type="button" onclick="nextStep()">Next</button>
                    </div>
                </div>

                <!-- Step 2: Personal Information -->
                <div class="form-step">
                    <h4>Step 2: Personal Information</h4>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="fname">First name:</label>
                            <input type="text" id="fname" name="fname" required>
                            <span class="error-message"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="lname">Last name:</label>
                            <input type="text" id="lname" name="lname" required>
                            <span class="error-message"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="Cnum">Contact Number</label>
                            <input type="number" id="Cnum" name="Cnum" require>
                            <span class="error-message"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" require>
                            <span class="error-message"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md6">
                            <button type="button" onclick="prevStep()">Previous</button>
                            <button type="button" onclick="nextStep()">Next</button>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Address -->
                <div class="form-step">
                    <h2>Step 3: Company details</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="companyname">Company Name</label>
                            <input type="text" id="cname" name="cname"  required>
                            <span class="error-message"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="president">President</label>
                            <input type="text" id="president" name="president"  required>
                            <span class="error-message"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="companyadd">Company Address</label>
                            <input type="text" id="companyadd" name="companyadd"  required>
                            <span class="error-message"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="president">President</label>
                            <input type="text" id="president" name="president"  required>
                            <span class="error-message"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="companynum">Contact Number</label>
                            <input type="text" id="companynum" name="companynum"  required>
                            <span class="error-message"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="companyemail">Email</label>
                            <input type="text" id="companyemail" name="companyemail"  required>
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
                            <label for="pic">Company Picture:</label>
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
