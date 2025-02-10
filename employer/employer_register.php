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
                <!-- First Column: Aligned to the left -->
                <div class="col-md-2 col-xxl-3 text-start">
                    <img src="../img/logolb.png" alt="lblogo" style="height: 50px;">
                </div>
                <!-- Second Column: Centered -->
                <div class="col-md-8 col-xxl-6 text-center">
                    <h3 style="margin-top: 5px; font-weight: 700; color: #ffffff;">MUNICIPALITY OF LOS BANOS</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-md-5">
        <div class="row justify-content-center sm-margin">
            <div class="form-container">
                <form id="registrationForm" method="POST" action="process/register_process.php">
                    <!-- Step 1 -->

                    
                    <div class="form-step active">
                        <h2>Step 1: Personal Information</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="first_name" placeholder="First Name" required>
                            </div>

                            <div class="col-md-6">
                                <input type="text" name="last_name" placeholder="Last Name" required>
                            </div> 
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="first_name" placeholder="First Name" required>
                            </div>

                            <div class="col-md-6">
                                <input type="text" name="last_name" placeholder="Last Name" required>
                            </div> 
                        </div>
                        <button type="button" class="next-btn">Next</button>
                    </div>

                    <!-- Step 2 -->
                    <div class="form-step">
                        <div class=row> 
                        <div class="col-md-12">
                        <h2>Step 2: Contact Details</h2>
                        <input type="email" name="email" placeholder="Email" required>
                        <button type="button" class="prev-btn">Previous</button>
                        <button type="button" class="next-btn">Next</button>
                        </div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="form-step">
                        <h2>Step 3: Security</h2>
                        <input type="password" name="password" placeholder="Password" required>
                        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                        <button type="button" class="prev-btn">Previous</button>
                        <button type="button" class="next-btn">Next</button>
                    </div>

                    <div class="form-step">
                    <h2>Step 4: Company Information </h2>
                        <div class="row">
                            <div class="col-md-6">
                                <h6> Company Name</h6>
                                <input type="text" name="Company_Name" placeholder="Company Name" required>
                            </div>

                            <div class="col-md-6">
                                <h6>Company President</h6>
                                <input type="text" name="Company_President" placeholder="Company President" required>
                            </div> 
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h6>Company Address</h6>
                                <input type="text" name="Company_Address" placeholder="Company Address" required>
                            </div>
                        </div>

                             
                        <div class="row">
                            <div class="col-md-6">
                                <h6>HR Official Email</h6>
                                <input type="text" name="HR_Email" placeholder="HR Official Email" required>
                            </div>
                            
                            <div class="col-md-6">
                                <h6>HR Manager</h6>
                                <input type="text" name="HR_Manager" placeholder="Hr Manager Name" required>
                            </div>

                            <div class="col-md-6">
                                <h6>Company Contact Number</h6>
                                <input type="text" name="Contact_Number" placeholder="Company Contact Number" required>
                            </div>

                            <div class="col-md-6">
                                <h6>Company Email</h6>
                                <input type="text" name="Company_Email" placeholder="Company Email" required>
                                
                            </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="prev-btn">Previous</button>
                                <button type="button" class="next-btn">Next</button>
                            </div>
                        </div>   
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="form-step">
                        <h2>Step 4: Review & Submit</h2>
                        <p>Review your information and click "Submit" to complete registration.</p>
                        <button type="button" class="prev-btn">Previous</button>
                        <button type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="js/register.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
