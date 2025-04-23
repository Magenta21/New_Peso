<?php
include '../db.php';

session_start();

// Check if trainee is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['user_type'] !== 'trainee') {
    header("Location: training_login.php");
    exit();
}

$trainee_id = $_SESSION['trainee_id'];
$training_id = $_SESSION['training_id'];

// Get trainee info
$trainee_query = "SELECT * FROM trainees_profile WHERE id = ?";
$stmt = $conn->prepare($trainee_query);
$stmt->bind_param("i", $trainee_id);
$stmt->execute();
$trainee_result = $stmt->get_result();
$trainee = $trainee_result->fetch_assoc();

// Get training info
$training_query = "SELECT * FROM skills_training WHERE id = ?";
$stmt = $conn->prepare($training_query);
$stmt->bind_param("i", $training_id);
$stmt->execute();
$training_result = $stmt->get_result();
$training = $training_result->fetch_assoc();

// Get modules for this training
$modules_query = "SELECT * FROM modules WHERE training_id = ? ORDER BY date_created";
$stmt = $conn->prepare($modules_query);
$stmt->bind_param("i", $training_id);
$stmt->execute();
$modules_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($training['name']); ?> - My Modules</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }
        
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .header {
            height: 50px;
            width: 100%;
            text-align: center;
        }

        .training-banner {
            background-color: #ffd580;
            color: black;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .module-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px 0;
        }
        
        .module-card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            background-color: white;
            overflow: hidden;
        }
        
        .module-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        
        .module-header {
            background-color: #006e90;
            color: white;
            padding: 15px;
        }
        
        .module-body {
            padding: 20px;
        }
        
        .module-title {
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .module-description {
            color: var(--secondary-color);
            margin-bottom: 15px;
        }
        
        .file-badge {
            background-color: #e9ecef;
            color: var(--dark-color);
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            margin-right: 5px;
            margin-bottom: 5px;
            display: inline-block;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .file-badge:hover {
            background-color: #d1d7dc;
        }
        
        .no-modules {
            grid-column: 1 / -1;
            text-align: center;
            padding: 40px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .file-icons-container {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .file-icon {
            font-size: 1.5rem;
            color: var(--primary-color);
            cursor: pointer;
            transition: transform 0.2s;
        }
        .file-icon:hover {
            transform: scale(1.2);
        }
    </style>
</head>
<body>
<nav class="navbar bg-primary text-white py-2">
    <div class="container-fluid">
        <!-- Navigation Links -->
        <img src="../img/logolb.png" alt="lblogo" style="height: 50px;">
        <div class="ms-auto">           
        </div>
        <div class="d-flex flex-wrap align-items-center">

        </div>
        <div class="ms-auto">
            <div class="dropdown">
                <a href="#" class="text-decoration-none mt-5" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php if (!empty($trainee['photo'])): ?>
                        <img id="preview" src="<?php echo $trainee['photo']; ?>" alt="Profile Image" class="img-fluid rounded-circle" style="width: 40px; height: 40px;">
                    <?php else: ?>
                        <img src="../img/user-placeholder.png" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 40px; height: 40px;">
                    <?php endif; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end text-center mt-2" aria-labelledby="profileDropdown">
                    <li><a class="dropdown-item" href="training_profile.php">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="training-banner">
        <h2><i class="bi bi-book"></i> <?php echo htmlspecialchars($training['name']); ?></h2>
        <p class="mb-0">Welcome to your training dashboard</p>
    </div>

    <h3 class="mb-3">Training Modules</h3>
    
    <div class="module-container">
        <?php if ($modules_result->num_rows > 0): ?>
            <?php while ($module = $modules_result->fetch_assoc()): ?>
                <div class="module-card">
                    <div class="module-header">
                        <h4 class="module-title"><?php echo htmlspecialchars($module['module_name']); ?></h4>
                    </div>
                    <div class="module-body">
                        <p class="module-description"><?php echo htmlspecialchars($module['module_description']); ?></p>
                        
                        <?php if (!empty($module['files'])): ?>
                            <h6 class="mt-3">Files:</h6>
                            <div class="file-icons-container">
                                <?php 
                                $files = explode(',', $module['files']);
                                foreach ($files as $file): 
                                    if (!empty(trim($file))):
                                        $file_path = '../admin/content/uploads/modules/' . trim($file);
                                        $file_ext = pathinfo($file, PATHINFO_EXTENSION);
                                        $icon_class = getFileIconClass($file_ext);
                                ?>
                                    <a href="view_file.php?file=<?php echo urlencode(trim($file)); ?>" 
                                    target="_blank" 
                                    class="text-decoration-none"
                                    title="<?php echo htmlspecialchars(trim($file)); ?>">
                                        <i class="bi <?php echo $icon_class; ?> file-icon me-2"></i>
                                    </a>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            </div>
                        <?php endif; ?>
                                                
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <small class="text-muted">
                                <?php echo date('M d, Y', strtotime($module['date_created'])); ?>
                            </small> 
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-modules">
                <i class="bi bi-journal-x" style="font-size: 3rem; color: var(--secondary-color);"></i>
                <h4>No Modules Available Yet</h4>
                <p class="text-muted">Your instructor hasn't added any modules to this training yet.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php
function getFileIconClass($extension) {
    $extension = strtolower($extension);
    switch ($extension) {
        case 'pdf':
            return 'bi-file-earmark-pdf';
        case 'doc':
        case 'docx':
            return 'bi-file-earmark-word';
        case 'xls':
        case 'xlsx':
            return 'bi-file-earmark-excel';
        case 'ppt':
        case 'pptx':
            return 'bi-file-earmark-ppt';
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
            return 'bi-file-earmark-image';
        case 'txt':
            return 'bi-file-earmark-text';
        case 'zip':
        case 'rar':
            return 'bi-file-earmark-zip';
        default:
            return 'bi-file-earmark';
    }
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>