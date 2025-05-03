<?php 
include '../db.php';

function checkSession() {
    session_start();
    if (!isset($_SESSION['ofw_id'])) {
        header("Location: ../login.html");
        exit();
    } else {
        return $_SESSION['ofw_id'];
    }
}

$userId = checkSession();
$sql = "SELECT * FROM cases WHERE user_id = $userId ORDER BY created_at DESC";
$result = $conn->query($sql);


$new_sql = "SELECT * FROM ofw_profile WHERE id = ?";
$new_stmt = $conn->prepare($new_sql);
$new_stmt->bind_param("i", $userId);
$new_stmt->execute();
$new_result = $new_stmt->get_result();

if (!$new_result) {
    die("Invalid query: " . $conn->error); 
}

$new_row = $new_result->fetch_assoc();
if (!$new_row) {
    die("User not found.");
}

?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>My Cases - OFW Portal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #f8f9fa;
            --accent-color: #e74c3c;
            --text-color: #333;
            --light-text: #6c757d;
            --border-color: #dee2e6;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: var(--text-color);
        }
        
        .navbar {
            background-color: var(--primary-color);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .navbar-brand {
            font-weight: 600;
        }
        
        .container-main {
            margin-top: 30px;
            margin-bottom: 50px;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-resolved {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-processing {
            background-color: #cce5ff;
            color: #004085;
        }
        
        .btn-view {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-view:hover {
            background-color: #2980b9;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px;
            color: var(--light-text);
        }
        
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: var(--light-text);
        }
        
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }
        
        .table thead th {
            background-color: var(--primary-color);
            color: white;
            border-bottom: none;
        }
        
        .table tbody tr:hover {
            background-color: rgba(52, 152, 219, 0.05);
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar bg-primary text-white py-2">
    <div class="container-fluid">
        <!-- Navigation Links -->
        <img src="../img/logolb.png" alt="lblogo" style="height: 50px;">
        <div class="ms-auto">        
                   
        </div>
        
        <div class="d-flex flex-wrap align-items-center">
        <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"> </div>
                <a href="ofw_home.php" class="nav-link px-3">Home</a>
                
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>

                <a href="ofw_report.php" class="nav-link px-3">Post Report</a>

            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>

                <a href="ofw_report.php" class="nav-link px-3">View Report Status</a>

            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"> </div>
            
        </div>
        <div class="ms-auto">
            <div class="dropdown">
                <a href="#" class="text-decoration-none mt-5" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php if (!empty($new_row['profile_image'])): ?>
                        <img id="preview" src="<?php echo $new_row['profile_image']; ?>" alt="Profile Image" class="img-fluid rounded-circle" style="width: 40px; height: 40px;">
                    <?php else: ?>
                        <img src="../img/user-placeholder.png" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 40px; height: 40px;">
                    <?php endif; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end text-center mt-2" aria-labelledby="profileDropdown">
                    <li><a class="dropdown-item" href="ofw_profile.php">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
    <!-- Main Content -->
    <div class="container container-main">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2><i class="fas fa-file-alt me-2"></i>My Cases</h2>
            </div>
            <div class="col-md-6 text-end">
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i>Case List</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Case ID</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Filed Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td>#<?= $row['id'] ?></td>
                                        <td><?= htmlspecialchars($row['title']) ?></td>
                                        <td><?= htmlspecialchars(substr($row['description'], 0, 50)) ?>...</td>
                                        <td>
                                            <?php 
                                            $statusClass = '';
                                            switch(strtolower($row['status'])) {
                                                case 'pending':
                                                    $statusClass = 'status-pending';
                                                    break;
                                                case 'resolved':
                                                    $statusClass = 'status-resolved';
                                                    break;
                                                case 'processing':
                                                    $statusClass = 'status-processing';
                                                    break;
                                                default:
                                                    $statusClass = 'status-pending';
                                            }
                                            ?>
                                            <span class="status-badge <?= $statusClass ?>">
                                                <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
                                                <?= ucfirst($row['status']) ?>
                                            </span>
                                        </td>
                                        <td><?= date('M d, Y', strtotime($row['created_at'])) ?></td>
                                        <td>
                                            <a href="view_case.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-view">
                                                <i class="fas fa-eye me-1"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <i class="far fa-folder-open"></i>
                                            <h4>No Cases Found</h4>
                                            <p>You haven't filed any cases yet. Click the button above to file your first case.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-light py-4 mt-5">
        <div class="container text-center">
            <p class="text-muted mb-0">© <?= date('Y') ?> OFW Case Management System. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>