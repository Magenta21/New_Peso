<?php
include 'db.php';

$query = "SELECT id, job_title, company_name, salary, vacant FROM job_post WHERE is_active = 1";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <link rel="stylesheet" href="joblist.css">
    <script src="joblist.js" defer></script>
</head>
<body>
    <h2>Job Listings</h2>
    <table>
        <thead>
            <tr>
                <th>Job Title</th>
                <th>Company Name</th>
                <th>Salary</th>
                <th>Vacancies</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr class="job-row" data-id="<?= $row['id'] ?>">
                    <td><?= htmlspecialchars($row['job_title']) ?></td>
                    <td><?= htmlspecialchars($row['company_name']) ?></td>
                    <td><?= htmlspecialchars($row['salary']) ?></td>
                    <td><?= htmlspecialchars($row['vacant']) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Modal -->
    <div id="jobModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3 id="modalTitle"></h3>
            <p><strong>Company:</strong> <span id="modalCompany"></span></p>
            <p><strong>Job Type:</strong> <span id="modalJobType"></span></p>
            <p><strong>Salary:</strong> <span id="modalSalary"></span></p>
            <p><strong>Vacancies:</strong> <span id="modalVacant"></span></p>
            <p><strong>Location:</strong> <span id="modalLocation"></span></p>
            <p><strong>Education:</strong> <span id="modalEducation"></span></p>
            <p><strong>Description:</strong> <span id="modalDescription"></span></p>
            <p><strong>Requirements:</strong> <span id="modalRequirement"></span></p>
            <p><strong>Posted On:</strong> <span id="modalDate"></span></p>
        </div>
    </div>

</body>
</html>
