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

<div class="container-fluid mt-md-3">
    <div class="row justify-content-center sm-margin">
        <div class="form-container">
            <form id="registrationForm" method="POST" action="process/register_process.php">
                
                <!-- Step 1 -->
                <div class="form-step active">
                    <h2>Step 1: Login Credentials</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Username</h6>
                            <input type="text" name="Username" placeholder="Enter Username" required>
                        </div>
                        <div class="col-md-6">
                            <h6>Email</h6>
                            <input type="email" name="email" placeholder="Enter Email" required>
                        </div>
                        <div class="col-md-6">
                            <h6>Password</h6>
                            <input type="password" id="password" name="Password" placeholder="Enter Password" required>
                            <p id="passwordWarning" style="color: red; display: none;">Password must contain at least one numeric character.</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Confirm Password</h6>
                            <input type="password" id="confirm_password" name="Confirm_Password" placeholder="Confirm Password" required>
                            <p id="confirmPasswordWarning" style="color: red; display: none;">Passwords do not match.</p>
                        </div>
                    </div>
                    <button type="button" class="next-btn" disabled>Next</button>
                    <p class="mt-3 text-center">Already have an account? <a href="employer_login.php">Sign In</a></p>
                </div>
                
                <!-- Step 2 -->
                <div class="form-step">
                    <h2>Step 2: Personal Information</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>First Name</h6>
                            <input type="text" name="first_name" placeholder="First Name" required>
                        </div>
                        <div class="col-md-6">
                            <h6>Last Name</h6>
                            <input type="text" name="last_name" placeholder="Last Name" required>
                        </div> 
                    </div>
                    <button type="button" class="prev-btn">Previous</button>
                    <button type="button" class="next-btn" disabled>Next</button>
                </div>
                
                <!-- Step 3 -->
                <div class="form-step">
                    <h2>Step 3: Company Information</h2>
                    <button type="button" class="prev-btn">Previous</button>
                    <button type="button" class="next-btn" disabled>Next</button>
                </div>
                
                <!-- Step 4 -->
                <div class="form-step">
                    <h2>Step 4: Review & Submit</h2>
                    <button type="button" class="prev-btn">Previous</button>
                    <button type="submit" id="submit-btn" disabled>Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const formSteps = document.querySelectorAll(".form-step");
    const nextBtns = document.querySelectorAll(".next-btn");
    const prevBtns = document.querySelectorAll(".prev-btn");
    const submitBtn = document.getElementById("submit-btn");

    let currentStep = 0;

    function showStep(stepIndex) {
        formSteps.forEach((step, index) => {
            step.style.display = index === stepIndex ? "block" : "none";
        });
    }

    // Ensure validatePassword() is properly defined
    function validatePassword() {
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirm_password").value;
        const passwordWarning = document.getElementById("passwordWarning");
        const confirmPasswordWarning = document.getElementById("confirmPasswordWarning");

        let passwordValid = /\d/.test(password);
        let passwordsMatch = password === confirmPassword && password !== "";

        passwordWarning.style.display = passwordValid ? "none" : "block";
        confirmPasswordWarning.style.display = passwordsMatch ? "none" : "block";

        return passwordValid && passwordsMatch;
    }

    function validateStep(stepIndex) {
        let step = formSteps[stepIndex];
        let inputs = step.querySelectorAll("input[required]");
        let allFilled = Array.from(inputs).every(input => input.value.trim() !== "");

        if (stepIndex === 0) {
            return allFilled && validatePassword();
        }
        return allFilled;
    }

    nextBtns.forEach((button) => {
        button.addEventListener("click", function () {
            if (validateStep(currentStep)) {
                currentStep++;
                showStep(currentStep);
            }
        });
    });

    prevBtns.forEach((button) => {
        button.addEventListener("click", function () {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });
    });

    showStep(currentStep);
});
</script>

</body>
</html>
