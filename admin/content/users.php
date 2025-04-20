<?php
$db = new mysqli('localhost', 'root', '', 'pesoo');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
$valid_pages = ['dashboard', 'users', 'training', 'settings', 'reports', 'messages'];
if (!in_array($page, $valid_pages)) {
    $page = 'dashboard';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/modal_form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
        }
        
        .content-area {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px;
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        /* Document Modal Styles */
        .doc-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.7);
        }
        
        .doc-modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 90%;
            max-width: 800px;
            border-radius: 5px;
        }
        
        .close-doc-modal {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .doc-status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: bold;
        }
        
        .status-pending {
            background-color: #FFC107;
            color: #000;
        }
        
        .status-verified {
            background-color: #28A745;
            color: #FFF;
        }
        
        .status-rejected {
            background-color: #DC3545;
            color: #FFF;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        
        /* Employer Table Styles */
        .employer-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .employer-table th, .employer-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .employer-table th {
            background-color: #f2f2f2;
        }
        
        .view-docs-btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="content-area">
        <?php if ($page === 'users'): ?>
            <div class="page-header">
                <h1>Employer Management</h1>
                <div class="date-time"></div>
            </div>

            <h2>All Employers</h2>
            
            <?php
            $query = "SELECT id, CONCAT(fname, ' ', lname) as full_name, email, company_name, company_photo 
                     FROM employer 
                     ORDER BY company_name";
            $result = $db->query($query);
            
            if ($result->num_rows > 0): ?>
                <table class="employer-table">
                    <thead>
                        <tr>
                            <th>Company</th>
                            <th>Representative</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center;">
                                        <img src="../employer/<?= htmlspecialchars($row['company_photo']) ?>" 
                                             style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; margin-right: 10px;" 
                                             onerror="this.src='default-company.png'">
                                        <?= htmlspecialchars($row['company_name']) ?>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($row['full_name']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td>
                                    <a class="view-docs-btn openEmployersBtn" href='#'
                                            data-employer-id="<?= htmlspecialchars($row['id']) ?>">
                                        View Documents
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No employers found.</p>
            <?php endif; ?>

            <!-- Document Verification Modal -->
            <div id="documentsModal" class="doc-modal">
                <div class="doc-modal-content">
                    <span class="closBtn">&times;</span>
                    <h2 id="modalTitle">Documents</h2>
                    <div id="documentsContainer"></div>
                </div>
            </div>

            <script>  
                const documentsModal = document.getElementById('documentsModal');
                const closeModuleBtn = document.querySelector('.closBtn');
                // Open profile modal and load data via AJAX
                $(document).on('click', '.openEmployersBtn', function(e) {
                    e.preventDefault();
                    const employerId = $(this).data('employer-id');

                    $.ajax({
                        url: 'content/get_documents.php',
                        method: 'GET',
                        data: { employer_id: employerId },
                        success: function(response) {
                            $('#documentsContainer').html(response);
                            documentsModal.style.display = 'flex';
                        }
                    });
                });

                // Close profile modal when 'x' is clicked
                closeModuleBtn.addEventListener('click', function() {
                    documentsModal.style.display = 'none';
                });

                // Close profile modal when clicking outside the modal content
                window.addEventListener('click', function(event) {
                    if (event.target === documentsModal) {
                        documentsModal.style.display = 'none';
                    }
                });
        </script>
        <?php else: ?>
            <?php include "content/$page.php"; ?>
        <?php endif; ?>
    </div>
</body>
</html>