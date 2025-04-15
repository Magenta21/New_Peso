<?php
// Database connection
$db = new mysqli('localhost', 'root', '', 'pesoo');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$training_id = (int)$_GET['training_id'] ?? 0;
$training_table = $_GET['table'] ?? '';

// Get training details
$stmt = $db->prepare("SELECT * FROM skills_training WHERE id = ?");
$stmt->bind_param('i', $training_id);
$stmt->execute();
$result = $stmt->get_result();
$training = $result->fetch_assoc();

if (!$training || empty($training_table)) {
    die("Invalid training specified");
}
?>

<div class="content-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2><?= htmlspecialchars($training['name']) ?> Trainees</h2>
    <a href="?page=training" class="btn-secondary" style="padding: 8px 12px; text-decoration: none;">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="trainees-list">
    <?php
    $query = "SELECT t.*, tr.created_date 
             FROM trainees_profile t
             JOIN $training_table tr ON t.id = tr.trainees_id
             ORDER BY tr.created_date DESC";
    $result = $db->query($query);
    
    if ($result->num_rows > 0) {
        echo '<table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd;">Name</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd;">Contact</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd;">Email</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd;">Enrollment Date</th>
                    </tr>
                </thead>
                <tbody>';
        
        while ($row = $result->fetch_assoc()) {
            echo '<tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 12px; vertical-align: middle;">
                        <div style="display: flex; align-items: center;">
                            <img src="'.htmlspecialchars($row['photo'] ?? 'default-profile.png').'" 
                                 style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; margin-right: 10px;" 
                                 onerror="this.src=\'default-profile.png\'">
                            '.htmlspecialchars($row['lname'].', '.$row['fname'].' '.$row['mname']).'
                        </div>
                    </td>
                    <td style="padding: 12px; vertical-align: middle;">'.htmlspecialchars($row['contact_no'] ?? 'N/A').'</td>
                    <td style="padding: 12px; vertical-align: middle;">'.htmlspecialchars($row['email']).'</td>
                    <td style="padding: 12px; vertical-align: middle;">'.htmlspecialchars($row['created_date']).'</td>
                  </tr>';
        }
        
        echo '</tbody></table>';
    } else {
        echo '<div class="alert" style="padding: 15px; background-color: #e7f5fe; color: #296fa8; border-radius: 4px;">
                No trainees enrolled in this program yet.
              </div>';
    }
    ?>
</div>