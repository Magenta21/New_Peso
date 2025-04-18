<?php


$db = new mysqli('localhost', 'root', '', 'pesoo');
$enrollment_id = (int)$_GET['enrollment_id'] ?? 0;

$query = "SELECT tsh.*, a.username as admin_name 
          FROM trainee_status_history tsh
          LEFT JOIN admin_users a ON tsh.changed_by = a.id
          WHERE tsh.trainee_training_id = ?
          ORDER BY tsh.changed_at DESC";
$stmt = $db->prepare($query);
$stmt->bind_param('i', $enrollment_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo '<table class="table table-sm">';
    echo '<tr><th>Date</th><th>From</th><th>To</th><th>By</th><th>Notes</th></tr>';
    
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars(date('M d, Y H:i', strtotime($row['changed_at']))) . '</td>';
        echo '<td><span class="badge bg-secondary">' . htmlspecialchars(ucfirst($row['old_status'])) . '</span></td>';
        echo '<td><span class="badge bg-primary">' . htmlspecialchars(ucfirst($row['new_status'])) . '</span></td>';
        echo '<td>' . htmlspecialchars($row['admin_name'] ?? 'System') . '</td>';
        echo '<td>' . nl2br(htmlspecialchars($row['notes'] ?? '')) . '</td>';
        echo '</tr>';
    }
    
    echo '</table>';
} else {
    echo '<div class="alert alert-info">No status history found</div>';
}
?>