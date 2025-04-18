<?php
session_start();
if (isset($_SESSION['trainee_id'])) {
    // Redirect to training-specific dashboard
    $training_id = $_SESSION['training_id'];
    header("Location: dashboard.php?training=$training_id");
    exit();
}

// Get training ID from URL if present
$training_id = isset($_GET['training']) ? (int)$_GET['training'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainee Login - Municipality of Los Banos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css" defer>
    <style>
        .training-badge {
            background-color: #0d6efd;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-bottom: 15px;
            display: inline-block;
        }
    </style>
</head>
<body>
    
<div class="header">
    <div class="container-fluid d-flex align-items-center">
        <a href="../index.php" class="back-button me-auto">
            ← Back
        </a>
    </div>
</div>

<div class="container-fluid d-flex justify-content-center align-items-center mt-5">
    <div class="row front-box">
        <div class="col-md-6">
            <div class="form-container">
                <h3>Trainees Login</h3>
                <?php if ($training_id > 0): ?>
                    <?php
                    // Get training name from database
                    require_once('../db.php');
                    $training_query = "SELECT name FROM skills_training WHERE id = $training_id";
                    $training_result = mysqli_query($conn, $training_query);
                    $training_name = mysqli_fetch_assoc($training_result)['name'];
                    ?>
                    <div class="training-badge">
                        Logging in to: <?php echo htmlspecialchars($training_name); ?>
                    </div>
                    <input type="hidden" name="training_id" value="<?php echo $training_id; ?>">
                <?php endif; ?>
                <form action="process/login_process.php" method="POST">
                    <input type="hidden" name="training_id" value="<?php echo $training_id; ?>">
                    <div class="mb-3 mt-3">
                        <input type="text" name="username" class="form-control" placeholder="Username/Email" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                    <p class="mt-3"><a data-toggle="modal" data-target="#forgotPasswordModal1" href="#">Forgot Password?</a></p>
                    <p>Don't have an account? 
                        <a href="Trainees_register.php<?php echo $training_id ? '?training='.$training_id : ''; ?>">
                            Sign Up
                        </a>
                    </p>
                </form>
            </div>
        </div>
        <div class="col-md-6 image-container"></div>
    </div>
</div>

<!-- Forgot Password Modal -->
<div class="modal fade" id="forgotPasswordModal1" tabindex="-1" aria-labelledby="forgotPasswordLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color: black;">Trainee Forgot Password</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="../php/send_reset_link.php" method="POST">
                    <input type="hidden" name="user_type" value="trainee">
                    <div class="form-group">
                        <label for="email" style="color: black;">Enter your email address:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Reset Link</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>