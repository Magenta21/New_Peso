let currentStep = 0;
const formSteps = document.querySelectorAll(".form-step");
const stepIndicators = document.querySelectorAll(".step");

function showStep(step) {
    formSteps.forEach((formStep, index) => {
        formStep.classList.toggle("active", index === step);
    });

    stepIndicators.forEach((indicator, index) => {
        indicator.classList.toggle("active", index === step);
    });
}

window.nextStep = function () {
    const inputs = formSteps[currentStep].querySelectorAll("input");
    let valid = true;

    inputs.forEach((input) => {
        const errorMessage = input.nextElementSibling;
        errorMessage.textContent = "";

        if (!input.value.trim()) {
            errorMessage.textContent = "This field is required.";
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
        } else if (input.type === "tel" && !/^\d{10}$/.test(input.value)) {
            errorMessage.textContent = "Invalid phone number.";
            valid = false;
        }
    });

    if (valid) {
        currentStep++;
        showStep(currentStep);
    }
};

window.prevStep = function () {
    if (currentStep > 0) {
        currentStep--;
        showStep(currentStep);
    }
};

document.addEventListener("DOMContentLoaded", () => showStep(currentStep));
