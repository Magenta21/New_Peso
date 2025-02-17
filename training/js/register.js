let currentStep = 0;
const formSteps = document.querySelectorAll(".form-step");
const stepIndicators = document.querySelectorAll(".step");

function showStep(step) {
    formSteps.forEach((formStep, index) => {
        formStep.style.display = index === step ? "block" : "none";
    });

    stepIndicators.forEach((indicator, index) => {
        indicator.classList.toggle("active", index === step);
    });
}

window.nextStep = function () {
    const inputs = formSteps[currentStep].querySelectorAll("input, select");
    let valid = true;

    inputs.forEach((input) => {
        const errorMessage = input.nextElementSibling;
        if (errorMessage) {
            errorMessage.textContent = ""; // Clear previous error
        }

        if (!input.value.trim()) {
            if (errorMessage) {
                errorMessage.textContent = "This field is required.";
            }
            valid = false;
        } else if (input.type === "email" && !/^\S+@\S+\.\S+$/.test(input.value)) {
            errorMessage.textContent = "Invalid email format.";
            valid = false;
        } else if (input.id === "password") {
            if (!/^(?=.*\d).{8,}$/.test(input.value)) {
                errorMessage.textContent = "Password must be at least 8 characters long and include at least one number.";
                valid = false;
            }
        } else if (input.id === "confirmPassword") {
            const password = document.getElementById("password").value;
            if (input.value !== password) {
                errorMessage.textContent = "Passwords do not match.";
                valid = false;
            }
        } else if (input.id === "Cnum" && !/^\d{10,}$/.test(input.value)) {
            errorMessage.textContent = "Invalid phone number format.";
            valid = false;
        } else if (input.tagName.toLowerCase() === "select" && input.value === "") {
            errorMessage.textContent = "Please select an option.";
            valid = false;
        } else if (input.type === "file" && input.files.length === 0) {
            errorMessage.textContent = "Please upload a file.";
            valid = false;
        }
    });

    if (valid) {
        if (currentStep < formSteps.length - 1) {
            currentStep++;
            showStep(currentStep);
        }
    }
};

window.prevStep = function () {
    if (currentStep > 0) {
        currentStep--;
        showStep(currentStep);
    }
};

// Ensure only one step is shown at a time
document.addEventListener("DOMContentLoaded", () => {
    formSteps.forEach((formStep, index) => {
        formStep.style.display = index === 0 ? "block" : "none";
    });
});
