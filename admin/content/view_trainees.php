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

// Handle status change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_status'])) {
    $trainee_id = (int)$_POST['trainee_id'];
    $new_status = $_POST['new_status'];
    $valid_statuses = ['active', 'accepted', 'graduated', 'next_batch'];

    if (in_array($new_status, $valid_statuses)) {
        // Update status in database
        $update_stmt = $db->prepare("UPDATE trainee_trainings SET status = ? WHERE trainee_id = ? AND training_id = ?");
        $update_stmt->bind_param('sii', $new_status, $trainee_id, $training_id);
        
        if ($update_stmt->execute()) {
            // Get trainee email
            $email_stmt = $db->prepare("SELECT email, fname, lname FROM trainees_profile WHERE id = ?");
            $email_stmt->bind_param('i', $trainee_id);
            $email_stmt->execute();
            $email_result = $email_stmt->get_result();
            $trainee = $email_result->fetch_assoc();
            
            if ($trainee) {
              // 4. Send email notification (using PHPMailer in production)
              require_once '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
              require_once '../vendor/phpmailer/phpmailer/src/SMTP.php';
              
              $mail = new PHPMailer\PHPMailer\PHPMailer();
              $mail->isSMTP();
              $mail->Host = 'smtp.gmail.com';
              $mail->SMTPAuth = true;
              $mail->Username = 'pesolosbanos4@gmail.com';
              $mail->Password = 'rooy awbq emme qqyt';
              $mail->SMTPSecure = 'tls';
              $mail->Port = 587;
              
              $mail->setFrom('jervinguevarra123@gmail.com', 'PESO Training System');
              $mail->addAddress($trainee['email'], $trainee['fname'] . ' ' . $trainee['lname']);
              $mail->isHTML(true);
              
              $mail->Subject = 'Training Status Update: ' . $training['name'];
              
              // HTML email template
              $mail->Body = "
                  <h2>Training Status Update</h2>
                  <p>Dear " . htmlspecialchars($trainee['fname']) . ",</p>
                  <p>Your status for the <strong>" . htmlspecialchars($training['name']) . "</strong> training has been updated:</p>
                  <p><strong>You have been</strong> " . ucfirst($new_status) . "</p>
              ";
              
              // Plain text version
              $mail->AltBody = "Dear " . $trainee['fname'] . ",\n\n" .
                               "Your status for the " . $training['name'] . " training has been updated to: " . ucfirst($new_status) . ".\n\n" .
                               "Thank you,\nThe Training Team";
              
              if (!$mail->send()) {
                  throw new Exception("Status updated but failed to send email: " . $mail->ErrorInfo);
              }
            }
        } else {
            $error = "Failed to update status: " . $db->error;
        }
    } else {
        $error = "Invalid status selected";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainee Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --success-color: #28a745;
            --info-color: #17a2b8;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .card {
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: none;
        }
        
        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }
        
        .table thead th {
            background-color: #2c3e50;
            color: white;
            font-weight: 500;
            padding: 12px 15px;
        }
        
        .table td {
            vertical-align: middle;
            padding: 12px 15px;
        }
        
        .status-badge {
            font-weight: 500;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
        }
        
        .badge-active {
            background-color: var(--primary-color);
        }
        
        .badge-accepted {
            background-color: var(--success-color);
        }
        
        .badge-graduated {
            background-color: var(--info-color);
        }
        
        .badge-next_batch {
            background-color: var(--warning-color);
        }
        
        .trainee-avatar {
            width: 40px;
            height: 40px;
            object-fit: cover;
        }
        
        .action-form {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .status-select {
            min-width: 120px;
        }
        
        .btn-update {
            white-space: nowrap;
        }
        
        @media (max-width: 768px) {
            .action-form {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .status-select {
                width: 100%;
            }
            
            .btn-update {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">
                <i class="fas fa-users me-2"></i>
                <?= htmlspecialchars($training['name']) ?> Trainees
            </h2>
            <a href="?page=training" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
        </div>

        <?php if (isset($success)): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>
                <?= htmlspecialchars($success) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Trainee</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Enrolled</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT t.*, tt.enrollment_date, tt.status 
                                     FROM trainees_profile t
                                     JOIN trainee_trainings tt ON t.id = tt.trainee_id
                                     WHERE tt.training_id = ?
                                     ORDER BY tt.enrollment_date DESC";
                            $stmt = $db->prepare($query);
                            $stmt->bind_param('i', $training_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $status_class = [
                                        'active' => 'badge-active',
                                        'accepted' => 'badge-accepted',
                                        'graduated' => 'badge-graduated',
                                        'next_batch' => 'badge-next_batch'
                                    ][$row['status']] ?? 'badge-secondary';
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="../training/<?= htmlspecialchars($row['photo'] ?? 'default-profile.png') ?>" 
                                                     class="rounded-circle trainee-avatar me-3" 
                                                     onerror="this.src='default-profile.png'">
                                                <div>
                                                    <?= htmlspecialchars($row['lname'] . ', ' . $row['fname'] . ' ' . $row['mname']) ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($row['contact_no'] ?? 'N/A') ?></td>
                                        <td><?= htmlspecialchars($row['email']) ?></td>
                                        <td><?= date('M d, Y', strtotime($row['enrollment_date'])) ?></td>
                                        <td>
                                            <span class="status-badge <?= $status_class ?>">
                                                <?= ucfirst($row['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <form method="POST" class="action-form">
                                                <input type="hidden" name="trainee_id" value="<?= $row['id'] ?>">
                                                <select name="new_status" class="form-select form-select-sm status-select">
                                                    <option value="accepted">Accepted</option>
                                                    <option value="graduated">Graduated</option>
                                                    <option value="next_batch">Next Batch</option>
                                                </select>
                                                <button type="submit" name="change_status" class="btn btn-sm btn-primary btn-update">
                                                    <i class="fas fa-save me-1"></i> Update
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr><td colspan="6" class="text-center py-4">No trainees enrolled in this program yet.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Confirm before changing status
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to change this trainee\'s status? An email notification will be sent.')) {
                e.preventDefault();
            }
        });
    });
    </script>
</body>
</html>