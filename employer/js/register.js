const steps = document.querySelectorAll(".form-step");
const nextBtns = document.querySelectorAll(".next-btn");
const prevBtns = document.querySelectorAll(".prev-btn");
let currentStep = 0;

nextBtns.forEach((button) => {
    button.addEventListener("click", () => {
        steps[currentStep].classList.remove("active");
        currentStep++;
        steps[currentStep].classList.add("active");
    });
});

prevBtns.forEach((button) => {
    button.addEventListener("click", () => {
        steps[currentStep].classList.remove("active");
        currentStep--;
        steps[currentStep].classList.add("active");
    });
});
