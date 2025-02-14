const steps = document.querySelectorAll(".form-step");
const nextBtns = document.querySelectorAll(".next-btn");
const prevBtns = document.querySelectorAll(".prev-btn");
let currentStep = 0;

nextBtns.forEach((button) => {
    button.addEventListener("click", () => {
        if (validateStep(currentStep)) {
            steps[currentStep].classList.remove("active");
            currentStep++;
            steps[currentStep].classList.add("active");
        }
    });
});

prevBtns.forEach((button) => {
    button.addEventListener("click", () => {
        steps[currentStep].classList.remove("active");
        currentStep--;
        steps[currentStep].classList.add("active");
    });
});

// Define the password validation function
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

// Attach validatePassword() to the input fields
document.getElementById("password").addEventListener("keyup", validatePassword);
document.getElementById("confirm_password").addEventListener("keyup", validatePassword);

// Step validation function
function validateStep(stepIndex) {
    let step = steps[stepIndex];
    let inputs = step.querySelectorAll("input[required]");
    let allFilled = Array.from(inputs).every(input => input.value.trim() !== "");

    if (stepIndex === 0) {
        return allFilled && validatePassword();
    }
    return allFilled;
}
