document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("jobModal");
    const closeModal = document.querySelector(".close");

    if (!modal || !closeModal) {
        console.error("Modal elements are missing.");
        return;
    }

    // Attach event listener to the entire container
    document.querySelector(".container-fluid").addEventListener("click", function (event) {
        let row = event.target.closest(".job-row");
        if (!row) return; // Ignore clicks outside job rows

        let jobId = row.getAttribute("data-id");
        if (!jobId) {
            console.error("Job ID is missing in row dataset.");
            return;
        }

        // Fetch job details using the job ID
        fetch(`get_job.php?id=${jobId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    alert("Job details could not be loaded.");
                    return;
                }

                // Update modal content
                document.getElementById("modalTitle").textContent = data.job_title || "N/A";
                document.getElementById("modalCompany").textContent = data.company_name || "N/A";
                document.getElementById("modalJobType").textContent = data.job_type || "N/A";
                document.getElementById("modalSalary").textContent = data.salary || "N/A";
                document.getElementById("modalVacant").textContent = data.vacant || "N/A";
                document.getElementById("modalLocation").textContent = data.work_location || "N/A";
                document.getElementById("modalEducation").textContent = data.education || "N/A";
                document.getElementById("modalDescription").textContent = data.job_description || "N/A";
                document.getElementById("modalRequirement").textContent = data.requirement || "N/A";
                document.getElementById("modalDate").textContent = data.date_posted || "N/A";

                // Show the modal
                modal.style.display = "block";
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
