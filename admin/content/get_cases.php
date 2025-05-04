<?php
require_once '../../db.php';

header('Content-Type: text/html');

if (!isset($_GET['ofw_id']) || !is_numeric($_GET['ofw_id'])) {
    echo '<tr><td colspan="5" class="text-center text-danger py-4">Invalid request</td></tr>';
    exit;
}

$ofw_id = intval($_GET['ofw_id']);

$query = "SELECT * FROM cases WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $ofw_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo '<tr><td colspan="5" class="text-center py-4">No cases found for this OFW</td></tr>';
    exit;
}

while ($case = $result->fetch_assoc()) {
    $status_class = 'status-' . str_replace(' ', '_', $case['status']);
    $file_link = $case['file'] ? 
        '<a href="../ofw/' . htmlspecialchars($case['file']) . '" class="file-link" target="_blank"><i class="fas fa-file-download mr-1"></i>Download</a>' : 
        '<span class="text-muted">No file attached</span>';
    
    echo '<tr>
            <td>' . htmlspecialchars($case['title']) . '</td>
            <td>' . htmlspecialchars($case['description']) . '</td>
            <td>' . $file_link . '</td>
            <td><span class="status-badge ' . $status_class . '">' . ucwords($case['status']) . '</span></td>
            <td>';
    
    if ($case['status'] === 'filed') {
        echo '<button class="btn btn-info btn-sm update-status mr-1" 
                data-case-id="' . $case['id'] . '" 
                data-new-status="in_progress">
                <i class="fas fa-spinner mr-1"></i>In Progress
              </button>';
    } elseif ($case['status'] === 'in progress') {
        echo '<button class="btn btn-success btn-sm update-status" 
                data-case-id="' . $case['id'] . '" 
                data-new-status="resolved">
                <i class="fas fa-check-circle mr-1"></i>Resolved
              </button>';
    }
    
    echo '</td></tr>';
}

$stmt->close();
?>