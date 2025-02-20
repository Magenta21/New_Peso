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
        } else if (input.tagName.toLowerCase() === "select" && input.value === "") {
            errorMessage.textContent = "Please select an option.";
            valid = false;
        }
    });

    if (valid && currentStep === 0) {
        // Check if username and email are taken
        const username = document.getElementById("username").value;
        const email = document.getElementById("email").value;

        fetch("process/check_availability.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `username=${encodeURIComponent(username)}&email=${encodeURIComponent(email)}`,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.usernameTaken) {
                    document.getElementById("username").nextElementSibling.textContent = "Username is already taken.";
                } else if (data.emailTaken) {
                    document.getElementById("email").nextElementSibling.textContent = "Email is already registered.";
                } else {
                    // Move to next step if username and email are available
                    currentStep++;
                    showStep(currentStep);
                }
            })
            .catch((error) => console.error("Error:", error));
    } else if (valid) {
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
