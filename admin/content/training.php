<?php
// Enable full error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection with detailed error handling
try {
    $db = new mysqli('localhost', 'root', '', 'pesoo');
    if ($db->connect_error) {
        throw new Exception("Database connection failed: " . $db->connect_error);
    }
} catch (Exception $e) {
    die("<div class='alert alert-danger'><strong>Database Error:</strong> " . htmlspecialchars($e->getMessage()) . "</div>");
}

// Helper functions with validation
function getTrainingIcon($name)
{
    if (empty($name)) {
        error_log("Empty training name passed to getTrainingIcon");
        return 'fas fa-book';
    }

    $icons = [
        'Computer Literacy' => 'fas fa-laptop-code',
        'Dressmaking' => 'fas fa-tshirt',
        'Hilot Wellness' => 'fas fa-spa',
        'Welding' => 'fas fa-tools'
    ];

    return $icons[$name] ?? 'fas fa-book';
}

function getTrainingColor($name)
{
    if (empty($name)) {
        error_log("Empty training name passed to getTrainingColor");
        return '#2c3e50';
    }

    $colors = [
        'Computer Literacy' => '#3498db',
        'Dressmaking' => '#e74c3c',
        'Hilot Wellness' => '#2ecc71',
        'Welding' => '#f39c12'
    ];

    return $colors[$name] ?? '#2c3e50';
}

// Get all trainings from database with error handling
try {
    $trainings = [];
    $result = $db->query("SELECT * FROM skills_training");

    if (!$result) {
        throw new Exception("Query failed: " . $db->error);
    }

    if ($result->num_rows === 0) {
        error_log("No training programs found in skills_training table");
    }

    while ($row = $result->fetch_assoc()) {
        if (empty($row['id'])) {
            error_log("Training record with empty ID found");
            continue;
        }

        $trainings[] = [
            'id' => (int)$row['id'],
            'name' => htmlspecialchars($row['name']),
            'icon' => getTrainingIcon($row['name']),
            'color' => getTrainingColor($row['name'])
        ];
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    $trainings = [];
}
?>

<div class="page-header">
    <h1>Training Management</h1>
    <div class="date-time"></div>
</div>

<div class="training-management-content">
    <?php if (isset($error)): ?>
        <div class="alert alert-danger" style="padding: 15px; background-color: #f8d7da; color: #721c24; border-radius: 4px; margin-bottom: 20px;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div class="alert alert-success" style="padding: 15px; background-color: #d4edda; color: #155724; border-radius: 4px; margin-bottom: 20px;">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <?php if (empty($trainings)): ?>
        <div class="alert alert-warning">
            <strong>Warning:</strong> No training programs found in the system. Please check your database.
        </div>
    <?php endif; ?>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Training Programs</h2>
        <small class="text-muted">Showing <?= count($trainings) ?> programs</small>
    </div>

    <div class="training-cards" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
        <?php foreach ($trainings as $training): ?>
            <?php
            // Count trainees using trainee_trainings table
            $trainee_count = 0;
            try {
                $count_query = "SELECT COUNT(*) FROM trainee_trainings WHERE training_id = ? AND status = 'accepted'";
                $count_stmt = $db->prepare($count_query);
                $count_stmt->bind_param('i', $training['id']);
                $count_stmt->execute();
                $count_result = $count_stmt->get_result();

                if ($count_result) {
                    $trainee_count = $count_result->fetch_row()[0];
                } else {
                    error_log("Failed to count trainees for training ID {$training['id']}: " . $db->error);
                }
            } catch (Exception $e) {
                error_log("Error counting trainees: " . $e->getMessage());
            }
            ?>

            <div class="training-card" style="background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); overflow: hidden;">
                <div class="training-header" style="background: <?= $training['color'] ?>; padding: 15px; color: white; display: flex; align-items: center;">
                    <i class="<?= $training['icon'] ?>" style="font-size: 24px; margin-right: 10px;"></i>
                    <h3 style="margin: 0;"><?= $training['name'] ?></h3>
                </div>
                <div class="training-body" style="padding: 20px;">
                    <p style="margin-bottom: 15px;"><strong>Enrolled Trainees:</strong> <?= $trainee_count ?></p>
                    <div style="display: flex; gap: 10px;">
                        <a href="?page=training&action=view_trainees&training_id=<?= $training['id'] ?>"
                            class="btn-primary"
                            style="background-color: <?= $training['color'] ?>; color: white; text-decoration: none; padding: 8px 12px; border-radius: 4px; text-align: center; flex: 1;">
                            View Trainees
                        </a>
                        <a href="?page=training&action=view_modules&training_id=<?= $training['id'] ?>"
                            class="btn-secondary"
                            style="background-color: #2c3e50; color: white; text-decoration: none; padding: 8px 12px; border-radius: 4px; text-align: center; flex: 1;">
                            View Modules
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        $training_id = isset($_GET['training_id']) ? (int)$_GET['training_id'] : 0;

        try {
            $valid_actions = ['view_trainees', 'view_modules', 'add_module', 'edit_module'];
            if (!in_array($action, $valid_actions)) {
                throw new Exception("Invalid action specified");
            }

            $action_file = 'content/' . $action . '.php';
            if (!file_exists($action_file)) {
                throw new Exception("Action file not found: " . $action_file);
            }

            include $action_file;
        } catch (Exception $e) {
            echo "<div class='alert alert-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
            error_log($e->getMessage());
        }
    }
    ?>
</div>