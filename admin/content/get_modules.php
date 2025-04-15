<?php
$db = new mysqli('localhost', 'root', '', 'pesoo');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$training = isset($_GET['training']) ? $_GET['training'] : '';
$valid_trainings = ['computer_lit', 'dressmaking', 'hilot_wellness', 'welding'];

if (!in_array($training, $valid_trainings)) {
    die("Invalid training specified");
}

// Get training name for display
$training_names = [
    'computer_lit' => 'Computer Literacy',
    'dressmaking' => 'Dressmaking',
    'hilot_wellness' => 'Hilot Wellness',
    'welding' => 'Welding'
];

$training_name = $training_names[$training];
?>

<div class="content-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2><?= htmlspecialchars($training_name) ?> Modules</h2>
    <button class="btn-secondary" onclick="document.getElementById('dynamic-content').style.display='none'" style="padding: 8px 12px;">
        <i class="fas fa-arrow-left"></i> Back
    </button>
</div>

<div class="action-bar" style="margin-bottom: 20px;">
    <button class="btn-primary" onclick="document.getElementById('trainingType').value='<?= $training ?>'; document.getElementById('moduleForm').reset(); document.getElementById('moduleId').value=''; document.getElementById('createModuleModal').style.display='block'" style="padding: 8px 12px;">
        <i class="fas fa-plus"></i> Add New Module
    </button>
</div>

<div class="modules-list">
    <?php
    $query = "SELECT * FROM modules WHERE module_name LIKE ? ORDER BY date_created DESC";
    $stmt = $db->prepare($query);
    $search_term = "%$training_name%";
    $stmt->bind_param('s', $search_term);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo '<table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd;">Module Name</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd;">Date Created</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd;">Actions</th>
                    </tr>
                </thead>
                <tbody>';
        
        while ($row = $result->fetch_assoc()) {
            echo '<tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 12px; vertical-align: middle;">'.htmlspecialchars($row['module_name']).'</td>
                    <td style="padding: 12px; vertical-align: middle;">'.htmlspecialchars($row['date_created']).'</td>
                    <td style="padding: 12px; vertical-align: middle;">
                        <a href="'.htmlspecialchars($row['files']).'" target="_blank" class="btn-primary" style="padding: 5px 10px; text-decoration: none; display: inline-block;">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <button onclick="editModule('.$row['id'].', \''.$training.'\')" class="btn-warning" style="padding: 5px 10px;">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button onclick="deleteModule('.$row['id'].')" class="btn-danger" style="padding: 5px 10px;">
                            <i class="fas fa-trash"></i> Delete
                        </button>
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