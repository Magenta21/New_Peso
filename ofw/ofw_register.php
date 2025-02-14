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
                
                <!-- Step 1: Login Credentials -->
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
                            <input type="password" id="password" name="Password" class="form-control"
                                   placeholder="Enter Password" required data-bs-toggle="popover"
                                   data-bs-trigger="manual" data-bs-content="Password must be at least 8 characters, contain at least one letter and one number.">
                        </div>
                        <div class="col-md-6">
                            <h6>Confirm Password</h6>
                            <input type="password" id="confirm_password" name="Confirm_Password" class="form-control"
                                   placeholder="Confirm Password" required data-bs-toggle="popover"
                                   data-bs-trigger="manual" data-bs-content="Passwords do not match.">
                        </div>
                    </div>
                    <button type="button" class="next-btn" disabled>Next</button>
                    <p class="mt-3 text-center">Already have an account? <a href="training_login.php">Sign In</a></p>
                </div>
                
                <!-- Step 2: Personal Information -->
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
                        <div class="col-md-12">
                            <h6>Address</h6>
                            <input type="text" name="Address" placeholder="Enter Address">
                        </div>
                        <div class="col-md-6">
                            <h6>Date of Birth</h6>
                            <input type="date" name="Date_of_birth"> 
                        </div>
                    <button type="button" class="prev-btn">Previous</button>
                    <button type="button" class="next-btn disabled">Next</button>
                </div>
                
                <!-- Step 3: Review & Submit -->
                <div class="form-step">
                    <h2>Step 3: Review & Submit</h2>
                    <p>Review your information and click "Submit" to complete registration.</p>
                    <button type="button" class="prev-btn">Previous</button>
                    <button type="submit" id="submit-btn" disabled>Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const formSteps = document.querySelectorAll(".form-step");
    const nextBtns = document.querySelectorAll(".next-btn");
    const prevBtns = document.querySelectorAll(".prev-btn");
    const submitBtn = document.getElementById("submit-btn");

    // Password validation elements
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirm_password");

    // Initialize Bootstrap Popovers
    var passwordPopover = new bootstrap.Popover(password, { trigger: "manual", placement: "right" });
    var confirmPasswordPopover = new bootstrap.Popover(confirmPassword, { trigger: "manual", placement: "right" });

    let currentStep = 0;

    function showStep(stepIndex) {
        formSteps.forEach((step, index) => {
            step.style.display = index === stepIndex ? "block" : "none";
        });
    }

    function validateStep(stepIndex, showWarnings = false) {
        let step = formSteps[stepIndex];
        let inputs = step.querySelectorAll("input[required]");
        let allFilled = Array.from(inputs).every(input => input.value.trim() !== "");

        if (stepIndex === 0) {
            const passwordValue = password.value;
            const confirmPasswordValue = confirmPassword.value;

            // Ensure password contains at least one letter, one number, and is at least 8 characters long
            const alphanumericPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
            let passwordValid = alphanumericPattern.test(passwordValue);
            let passwordsMatch = passwordValue === confirmPasswordValue && confirmPasswordValue !== "";

            if (showWarnings) {
                if (!passwordValid) {
                    passwordPopover.show();
                } else {
                    passwordPopover.hide();
                }

                if (!passwordsMatch) {
                    confirmPasswordPopover.show();
                } else {
                    confirmPasswordPopover.hide();
                }
            }

            allFilled = allFilled && passwordValid && passwordsMatch;
        }

        let nextBtn = step.querySelector(".next-btn");
        if (nextBtn) {
            nextBtn.disabled = !allFilled;
        }

        if (stepIndex === formSteps.length - 1) {
            submitBtn.disabled = !allFilled;
        }

        return allFilled;
    }

    nextBtns.forEach((button) => {
        button.addEventListener("click", function () {
            let isValid = validateStep(currentStep, true);

            if (isValid && currentStep < formSteps.length - 1) {
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

    // Validate passwords dynamically while typing
    password.addEventListener("input", function () {
        validateStep(0, false);
    });

    confirmPassword.addEventListener("input", function () {
        validateStep(0, false);
    });

    // Initialize by showing the first step
    showStep(currentStep);
});
</script>
</body>
</html>
