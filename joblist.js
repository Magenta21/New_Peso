document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("jobModal");
    const closeModal = document.querySelector(".close");
    const modalContent = document.querySelector(".modal-content");

    // Attach event listener using event delegation
    document.querySelector("tbody").addEventListener("click", function (event) {
        let row = event.target.closest(".job-row");
        if (!row) return; // Ignore clicks outside job rows

        let jobId = row.dataset.id;
        fetch(`get_job.php?id=${jobId}`)
            .then(response => response.json())
            .then(data => {
                if (!data.error) {
                    document.getElementById("modalTitle").textContent = data.job_title;
                    document.getElementById("modalCompany").textContent = data.company_name;
                    document.getElementById("modalJobType").textContent = data.job_type;
                    document.getElementById("modalSalary").textContent = data.salary;
                    document.getElementById("modalVacant").textContent = data.vacant;
                    document.getElementById("modalLocation").textContent = data.work_location;
                    document.getElementById("modalEducation").textContent = data.education;
                    document.getElementById("modalDescription").textContent = data.job_description;
                    document.getElementById("modalRequirement").textContent = data.requirement;
                    document.getElementById("modalDate").textContent = data.date_posted;
                    
                    modal.style.display = "block";
                } else {
                    alert("Job details could not be loaded.");
                }
            })
            .catch(error => console.error("Error fetching job details:", error));
    });

    // Close modal when clicking the close button
    closeModal.addEventListener("click", function () {
        modal.style.display = "none";
    });

    // Close modal when clicking outside the modal content
    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});
