<?php
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

// Handle success message
$success = $_GET['success'] ?? '';
?>

<div class="content-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2><?= htmlspecialchars($training['name']) ?> Modules</h2>
    <a href="?page=training" class="btn-secondary" style="padding: 8px 12px; text-decoration: none;">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<?php if ($success): ?>
    <div class="alert alert-success" style="padding: 15px; background-color: #d4edda; color: #155724; border-radius: 4px; margin-bottom: 20px;">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<div class="action-bar" style="margin-bottom: 20px;">
    <a href="?page=training&action=add_module&training_id=<?= $training_id ?>" class="btn-primary" style="padding: 8px 12px; text-decoration: none;">
        <i class="fas fa-plus"></i> Add New Module
    </a>
</div>

<div class="modules-list">
    <?php
    $query = "SELECT * FROM modules WHERE training_id = ? ORDER BY date_created DESC";
    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $training_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd;">Module Name</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd;">Description</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd;">Date Created</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd;">Actions</th>
                    </tr>
                </thead>
                <tbody>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 12px; vertical-align: middle;">' . htmlspecialchars($row['module_name']) . '</td>
                    <td style="padding: 12px; vertical-align: middle;">' . htmlspecialchars($row['module_description']) . '</td>
                    <td style="padding: 12px; vertical-align: middle;">' . htmlspecialchars($row['date_created']) . '</td>
                    <td style="padding: 12px; vertical-align: middle;">
                        <a href="' . htmlspecialchars($row['files']) . '" target="_blank" class="btn-primary" style="padding: 5px 10px; text-decoration: none; display: inline-block;">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="?page=training&action=edit_module&training_id=' . $training_id . '&id=' . $row['id'] . '" class="btn-warning" style="padding: 5px 10px; text-decoration: none; display: inline-block;">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="content/delete_module.php?id=' . $row['id'] . '&training_id=' . $training_id . '" class="btn-danger" style="padding: 5px 10px; text-decoration: none; display: inline-block;" onclick="return confirm(\'Are you sure you want to delete this module?\')">
                            <i class="fas fa-trash"></i> Delete
                        </a>
                    </td>
                  </tr>';
        }

        echo '</tbody></table>';
    } else {
        echo '<div class="alert" style="padding: 15px; background-color: #e7f5fe; color: #296fa8; border-radius: 4px;">
                No modules available for this training yet.
              </div>';
    }
    ?>
</div>