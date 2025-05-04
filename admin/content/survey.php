<?php
// content/survey.php
require_once '../db.php';

// Handle printing before any output
if (isset($_GET['print']) && $_GET['print'] === 'responses') {
    ob_start(); // Start output buffering
    
    $responses = $conn->query("
        SELECT sr.*, sf.questions, sf.category, 
               CONCAT(op.first_name, ' ', op.last_name) AS ofw_name
        FROM survey_response sr
        JOIN survey_form sf ON sr.survey_id = sf.id
        JOIN ofw_profile op ON sr.user_id = op.id
        ORDER BY op.last_name, sf.category
    ");
    
    // Clear any existing output
    ob_end_clean();
    
    // Generate the print-only content
    $print_content = '<!DOCTYPE html>
    <html>
    <head>
        <title>Survey Responses Report</title>
        <style>
            body { font-family: Arial; margin: 20px; }
            h1 { color: #2c3e50; text-align: center; }
            .report-date { text-align: center; margin-bottom: 20px; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background-color: #3498db; color: white; }
            .ofw-section { margin-top: 30px; page-break-inside: avoid; }
            .ofw-name { font-weight: bold; margin-bottom: 10px; }
        </style>
    </head>
    <body>
        <h1>OFW Survey Responses Report</h1>
        <div class="report-date">Generated on: '.date('F j, Y').'</div>';
    
    $current_ofw = null;
    while ($row = $responses->fetch_assoc()) {
        if ($current_ofw !== $row['ofw_name']) {
            if ($current_ofw !== null) $print_content .= '</tbody></table></div>';
            $current_ofw = $row['ofw_name'];
            $print_content .= '
            <div class="ofw-section">
                <div class="ofw-name">OFW: '.htmlspecialchars($current_ofw).'</div>
                <table>
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Question</th>
                            <th>Response</th>
                        </tr>
                    </thead>
                    <tbody>';
        }
        $print_content .= '
                        <tr>
                            <td>'.htmlspecialchars($row['category']).'</td>
                            <td>'.htmlspecialchars($row['questions']).'</td>
                            <td>'.htmlspecialchars($row['response']).'</td>
                        </tr>';
    }
    if ($current_ofw !== null) $print_content .= '</tbody></table></div>';
    
    $print_content .= '
        <script>
            window.onload = function() {
                window.print();
                setTimeout(function() {
                    window.close();
                }, 1000);
            };
        </script>
    </body>
    </html>';
    
    // Output only the print content
    echo $print_content;
    exit;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_question'])) {
        $question = $conn->real_escape_string($_POST['question']);
        $category = $conn->real_escape_string($_POST['category']);
        $conn->query("INSERT INTO survey_form (questions, category) VALUES ('$question', '$category')");
    } elseif (isset($_POST['delete_question'])) {
        $id = intval($_POST['question_id']);
        $conn->query("DELETE FROM survey_form WHERE id = $id");
    }
}

// Get all survey questions
$questions = $conn->query("SELECT * FROM survey_form ORDER BY category, id");
?>

<!-- Main Survey Management Page -->
<style>
    .survey-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
    }
    .survey-header {
        text-align: center;
        margin-bottom: 30px;
        color: #2c3e50;
    }
    .survey-form {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .survey-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    .survey-table th, .survey-table td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }
    .survey-table th {
        background-color: #3498db;
        color: white;
    }
    .survey-table tr:hover {
        background-color: #f1f1f1;
    }
    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }
    .btn-primary {
        background-color: #3498db;
        color: white;
    }
    .btn-danger {
        background-color: #e74c3c;
        color: white;
    }
    .btn-success {
        background-color: #2ecc71;
        color: white;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-control {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .print-section {
        text-align: right;
        margin-bottom: 15px;
    }
</style>

<div class="survey-container">
    <div class="survey-header">
        <h1><i class="fas fa-poll"></i> Survey Management</h1>
    </div>

    <div class="survey-form">
        <h3>Add New Question</h3>
        <form method="POST">
            <div class="form-group">
                <label>Question:</label>
                <input type="text" name="question" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Category:</label>
                <input type="text" name="category" class="form-control" required>
            </div>
            <button type="submit" name="add_question" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Question
            </button>
        </form>
    </div>

    <div class="print-section">
        <a href="?page=survey&print=responses" class="btn btn-success" target="_blank">
            <i class="fas fa-print"></i> Print All Responses
        </a>
    </div>

    <table class="survey-table">
        <thead>
            <tr>
                <th>Category</th>
                <th>Question</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($q = $questions->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($q['category']) ?></td>
                <td><?= htmlspecialchars($q['questions']) ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="question_id" value="<?= $q['id'] ?>">
                        <button type="submit" name="delete_question" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>