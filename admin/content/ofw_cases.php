<?php
$db = new mysqli('localhost', 'root', '', 'pesoo');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
$valid_pages = ['dashboard', 'users', 'training', 'ofw_cases', 'reports', 'messages'];
if (!in_array($page, $valid_pages)) {
    $page = 'dashboard';}
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        
        /* OFW Cases Specific Styles */
        .ofw-profile-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-filed {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-in_progress {
            background-color: #cce5ff;
            color: #004085;
        }
        
        .status-resolved {
            background-color: #d4edda;
            color: #155724;
        }
        
        .file-link {
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
        }
        
        .file-link:hover {
            text-decoration: underline;
        }
        
        /* Modal Styles */
        .cases-modal .modal-content {
            border-radius: 10px;
        }
        
        .cases-modal .modal-header {
            background-color: #3498db;
            color: white;
            border-radius: 10px 10px 0 0;
        }
        
        .loading-spinner {
            display: inline-block;
            width: 2rem;
            height: 2rem;
            vertical-align: text-bottom;
            border: 0.25em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            animation: spinner-border .75s linear infinite;
        }
        
        @keyframes spinner-border {
            to { transform: rotate(360deg); }
        }
        
        /* Responsive Table */
        @media (max-width: 768px) {
            .table-responsive table thead {
                display: none;
            }
            
            .table-responsive table tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid #dee2e6;
                border-radius: 0.25rem;
            }
            
            .table-responsive table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-bottom: 1px solid #dee2e6;
            }
            
            .table-responsive table td::before {
                content: attr(data-label);
                font-weight: bold;
                padding-right: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="content-area">
        <?php if ($page === 'ofw_cases'): ?>
            <div class="page-header">
                <h1><i class="fas fa-briefcase mr-2"></i>OFW Cases Management</h1>
                <div class="date-time"></div>
            </div>

            <?php
            $query = "SELECT id, CONCAT(first_name, ' ', last_name) AS full_name, profile_image, contact_no, email 
                     FROM ofw_profile";
            $result = $db->query($query);
            ?>
            
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="ofwTable">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Full Name</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($ofw = $result->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <img src="../ofw/<?= htmlspecialchars($ofw['profile_image']) ?>" 
                                         class="ofw-profile-img" 
                                         alt="Profile"
                                         onerror="this.src='default-profile.png'">
                                </td>
                                <td><?= htmlspecialchars($ofw['full_name']) ?></td>
                                <td><?= htmlspecialchars($ofw['contact_no']) ?></td>
                                <td><?= htmlspecialchars($ofw['email']) ?></td>
                                <td>
                                    <button class="btn btn-primary btn-sm view-cases" 
                                            data-ofw-id="<?= $ofw['id'] ?>"
                                            data-ofw-name="<?= htmlspecialchars($ofw['full_name']) ?>">
                                        <i class="fas fa-eye mr-1"></i> View Cases
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Cases Modal -->
            <div class="modal fade cases-modal" id="casesModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fas fa-folder-open mr-2"></i>Cases for <span id="ofwName"></span>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="casesLoading" class="text-center py-4">
                                <div class="loading-spinner text-primary"></div>
                                <p class="mt-2">Loading cases...</p>
                            </div>
                            <div id="noCases" class="text-center py-4" style="display: none;">
                                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                <h5>No cases found</h5>
                                <p>This OFW has no recorded cases</p>
                            </div>
                            <div class="table-responsive" id="casesTableContainer" style="display: none;">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>File</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="casesTableBody"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Update Modal -->
            <div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fas fa-sync-alt mr-2"></i>Update Case Status
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to update this case status to <strong id="newStatusText"></strong>?</p>
                            <input type="hidden" id="caseIdToUpdate">
                            <input type="hidden" id="newStatusValue">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="confirmStatusUpdate">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
            $(document).ready(function() {
                // Initialize DataTable
                $('#ofwTable').DataTable({
                    responsive: true,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Search OFWs...",
                        lengthMenu: "Show _MENU_ entries",
                        info: "Showing _START_ to _END_ of _TOTAL_ entries"
                    }
                });

                // View cases button click handler
                $(document).on('click', '.view-cases', function() {
                    const ofwId = $(this).data('ofw-id');
                    const ofwName = $(this).data('ofw-name');
                    
                    $('#ofwName').text(ofwName);
                    $('#casesLoading').show();
                    $('#casesTableContainer').hide();
                    $('#noCases').hide();
                    
                    // Initialize modal
                    const casesModal = new bootstrap.Modal(document.getElementById('casesModal'));
                    casesModal.show();
                    
                    loadCases(ofwId);
                });

                // Load cases via AJAX
                function loadCases(ofwId) {
                    $.ajax({
                        url: 'content/get_cases.php',
                        type: 'GET',
                        data: { ofw_id: ofwId },
                        success: function(response) {
                            $('#casesLoading').hide();
                            
                            if (response.trim() === '' || response.includes('No cases found')) {
                                $('#noCases').show();
                            } else {
                                $('#casesTableBody').html(response);
                                $('#casesTableContainer').show();
                            }
                        },
                        error: function(xhr, status, error) {
                            $('#casesLoading').hide();
                            $('#noCases').show().html(`
                                <div class="alert alert-danger">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    Error loading cases: ${error}
                                </div>
                            `);
                        }
                    });
                }

                // Status update button click handler
                $(document).on('click', '.update-status', function() {
                    const caseId = $(this).data('case-id');
                    const newStatus = $(this).data('new-status');
                    let statusText = '';
                    
                    switch(newStatus) {
                        case 'in_progress':
                            statusText = 'In Progress';
                            break;
                        case 'resolved':
                            statusText = 'Resolved';
                            break;
                        default:
                            statusText = 'Filed';
                    }
                    
                    $('#caseIdToUpdate').val(caseId);
                    $('#newStatusValue').val(newStatus);
                    $('#newStatusText').text(statusText);
                    
                    const statusModal = new bootstrap.Modal(document.getElementById('statusModal'));
                    statusModal.show();
                });

                // Confirm status update
                $('#confirmStatusUpdate').click(function() {
                    const caseId = $('#caseIdToUpdate').val();
                    const newStatus = $('#newStatusValue').val();
                    
                    $.ajax({
                        url: 'content/update_case_status.php',
                        type: 'POST',
                        data: { 
                            case_id: caseId,
                            new_status: newStatus
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Status Updated',
                                    text: 'Case status has been updated successfully',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                
                                // Reload cases for the current OFW
                                const ofwId = $('.view-cases.active').data('ofw-id');
                                if (ofwId) {
                                    loadCases(ofwId);
                                }
                                
                                $('#statusModal').modal('hide');
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Update Failed',
                                    text: response.message || 'Error updating case status'
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred while updating the status'
                            });
                        }
                    });
                });
            });
            </script>

        <?php elseif ($page === 'users'): ?>
            <!-- Your existing employer management code -->
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

                closeModuleBtn.addEventListener('click', function() {
                    documentsModal.style.display = 'none';
                });

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