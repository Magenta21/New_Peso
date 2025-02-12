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
                    
                    <!-- Step 1 (Previously Step 2) -->
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
                                <input type="password" id="password" name="Password" placeholder="Enter Password" required onkeyup="validatePassword()">
                                <p id="passwordWarning" style="color: red; display: none;">Password must contain at least one numeric character.</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Confirm Password</h6>
                                <input type="password" id="confirm_password" name="Confirm_Password" placeholder="Confirm Password" required onkeyup="validatePassword()">
                                <p id="confirmPasswordWarning" style="color: red; display: none;">Passwords do not match.</p>
                            </div>
                        </div>
                        <button type="button" class="next-btn" disabled>Next</button>
                        <p class="mt-3 text-center">Already have an account? <a href="employer_login.php">Sign In</a></p>
                    </div>
                    
                    <!-- Step 2 (Previously Step 1) -->
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
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Birth date</h6>
                                <input type="date" name="birth_date" required>
                            </div>
                            <div class="col-md-6">
                                <h6>Contact Number</h6>
                                <input type="text" name="Contact_Number" placeholder="Contact Number" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h6>Gender</h6>
                                <div class="form-group d-flex align-items-center gap-3">
                                    <div>
                                        <input type="radio" id="male" name="gender" value="Male" required>
                                        <label for="male">Male</label>
                                    </div>
                                    <div>
                                        <input type="radio" id="female" name="gender" value="Female" required>
                                        <label for="female">Female</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="prev-btn">Previous</button>
                        <button type="button" class="next-btn" disabled>Next</button>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="form-step">
                        <h2>Step 3: Company Information</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Company Name</h6>
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
                                <input type="text" name="Company_add" placeholder="Company add" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Human Resource Manager</h6>
                                <input type="text" name="hr_Name" placeholder="hr Name" required>
                            </div>
                            <div class="col-md-6">
                                <h6>Human Resource Contact</h6>
                                <input type="number" name="hr_contact" placeholder="hr Contact" min="1" max="11" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h6>Company Email</h6>
                                <input type="text" name="Company_email" placeholder="Company email" required>
                            </div>
                        </div>
                        <button type="button" class="prev-btn">Previous</button>
                        <button type="button" class="next-btn" disabled>Next</button>
                    </div>
                    
                    <!-- Step 4 -->
                    <div class="form-step">
                        <h2>Step 4: Review & Submit</h2>
                        <p>Review your information and click "Submit" to complete registration.</p>
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
        validateStep(stepIndex); // Validate inputs in the current step
    }

    function validateStep(stepIndex, showWarnings = false) {
        let step = formSteps[stepIndex];
        let inputs = step.querySelectorAll("input[required]");
        let allFilled = Array.from(inputs).every(input => input.value.trim() !== "");

        // If in Step 2, validate passwords
        if (stepIndex === 1) {
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirm_password").value;
            const passwordWarning = document.getElementById("passwordWarning");
            const confirmPasswordWarning = document.getElementById("confirmPasswordWarning");

            let passwordValid = /\d/.test(password); // Check if password contains a numeric character
            let passwordsMatch = password === confirmPassword && password !== "";

            // Show warnings only when the Next button is clicked or triggered
            if (showWarnings) {
                passwordWarning.style.display = passwordValid ? "none" : "block";
                confirmPasswordWarning.style.display = passwordsMatch ? "none" : "block";
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
    }

    // Attach event listener to dynamically check input values
    document.querySelectorAll("input[required]").forEach(input => {
        input.addEventListener("input", () => {
            validateStep(currentStep); // Validate the current step as the user types
        });
    });

    nextBtns.forEach((button) => {
        button.addEventListener("click", function () {
            let step = formSteps[currentStep];

            // Trigger validation with warnings for Step 2
            if (currentStep === 0) {
                validateStep(currentStep, true);
            }

            let inputs = step.querySelectorAll("input[required]");
            let allFilled = Array.from(inputs).every(input => input.value.trim() !== "");

            // Extra validation for Step 2
            if (currentStep === 0) {
                const password = document.getElementById("password").value;
                const confirmPassword = document.getElementById("confirm_password").value;
                let passwordValid = /\d/.test(password);
                let passwordsMatch = password === confirmPassword && password !== "";

                allFilled = allFilled && passwordValid && passwordsMatch;
            }

            if (allFilled && currentStep < formSteps.length - 1) {
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

    // Initialize by showing the first step
    showStep(currentStep);
});
</script>


    </body>
    </html>
