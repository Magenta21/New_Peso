<?php
// Start output buffering at the VERY TOP
ob_start();

// Database connection
$db = new mysqli('localhost', 'root', '', 'pesoo');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$training_id = (int)$_GET['training_id'] ?? 0;

// Get training details
$stmt = $db->prepare("SELECT * FROM skills_training WHERE id = ?");
$stmt->bind_param('i', $training_id);
$stmt->execute();
$result = $stmt->get_result();
$training = $result->fetch_assoc();

if (!$training) {
    die("Invalid training specified");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $module_name = trim($_POST['module_name']);
    $module_description = trim($_POST['module_description'] ?? '');
    
    // Validate inputs
    if (empty($module_name) || empty($_FILES['module_file']['name'])) {
        $error = "Module name and file are required";
    } else {
        // Handle file upload
        $upload_dir = 'uploads/modules/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_name = basename($_FILES['module_file']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['pdf', 'doc', 'docx', 'ppt', 'pptx'];

        if (!in_array($file_ext, $allowed_ext)) {
            $error = "Invalid file type. Only PDF, DOC, DOCX, PPT, PPTX are allowed";
        } else {
            $new_file_name = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9\.]/', '_', $file_name);
            $target_path = $upload_dir . $new_file_name;

            if (move_uploaded_file($_FILES['module_file']['tmp_name'], $target_path)) {
                // Insert into database with training_id
                $query = "INSERT INTO modules (training_id, module_name, module_description, files, date_created) VALUES (?, ?, ?, ?, NOW())";
                $stmt = $db->prepare($query);
                $stmt->bind_param('isss', $training_id, $module_name, $module_description, $target_path);
                
                if ($stmt->execute()) {
                    // Clear buffer before header redirect
                    ob_end_clean();
                    header("Location: ?page=training&action=view_modules&training_id=$training_id&success=Module created successfully");
                    exit;
                } else {
                    unlink($target_path);
                    $error = "Database error: " . $db->error;
                }
            } else {
                $error = "File upload failed. Check directory permissions";
            }
        }
    }
}
// End output buffering and send content
ob_end_flush();
?>

<div class="content-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Add New Module for <?= htmlspecialchars($training['name']) ?></h2>
    <a href="?page=training&action=view_modules&training_id=<?= $training_id ?>" class="btn-secondary" style="padding: 8px 12px; text-decoration: none;">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<?php if (isset($error)): ?>
    <div class="alert alert-danger" style="padding: 15px; background-color: #f8d7da; color: #721c24; border-radius: 4px; margin-bottom: 20px;">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <div style="margin-bottom: 15px;">
        <label for="moduleName" style="display: block; margin-bottom: 5px; font-weight: bold;">Module Name</label>
        <input type="text" id="moduleName" name="module_name" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label for="moduleDescription" style="display: block; margin-bottom: 5px; font-weight: bold;">Description</label>
        <textarea id="moduleDescription" name="module_description" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; min-height: 100px;"></textarea>
    </div>
    
    <div style="margin-bottom: 15px;">
        <label for="moduleFile" style="display: block; margin-bottom: 5px; font-weight: bold;">Module File</label>
        <input type="file" id="moduleFile" name="module_file" required accept=".pdf,.doc,.docx,.ppt,.pptx" style="width: 100%;">
        <p style="font-size: 12px; color: #666;">Accepted formats: PDF, DOC, DOCX, PPT, PPTX</p>
    </div>
    
    <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
        <a href="?page=training&action=view_modules&training_id=<?= $training_id ?>" class="btn-secondary" style="padding: 10px 15px; text-decoration: none;">
            Cancel
        </a>
        <button type="submit" class="btn-primary" style="padding: 10px 15px;">
            Save Module
        </button>
    </div>
</form>