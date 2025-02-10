<!-- applicant_login.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <!-- First Column: Aligned to the left -->
                <div class="col-md-2 col-xxl-3 text-start">
                    <img src="../img/logolb.png" alt="lblogo" style="height: 50px;">
                </div>
                <!-- Second Column: Centered -->
                <div class="col-md-8 col-xxl-6 text-center">
                    <h3 style="margin-top: 5px; font-weight: 700; color: #ffffff;">MUNICIPALITY OF LOS BANOS</h3>
                </div>
            </div>
        </div>
    </div>


    <div class="container mt-md-4">
        <div class="row justify-content-center sm-margin">
            <div class="col-md-8 col-xxl-10 marg-large">
                <div class="card login-form">
                    <div class="card-body p-5">
                        <h2 class="card-title text-center">Applicant Login</h2>
                        <div class="logol">
                            <img src="../img/logo_peso.png" alt="Logo">
                        </div>

                        <form action="../php/login.php" method="POST">
                            <div class="form-group">
                                <p>Please sign in</p>
                                <input type="text" name="user_input" class="form-control mb-3 " placeholder="Username/Email">
                                <input type="password" name="password" class="form-control" placeholder="Password">
                            </div>
                            <div class="forgot mt-3">
                                <a data-toggle="modal" data-target="#forgotPasswordModal1" href="#">Forgot Password?</a>
                            </div>
                            <button type="submit" class="btn btn-primary sign mb-3">Login</button>
                            <div class="form-group">
                                <p class="signup">Don't have an account? <a href="applicant_register.php">Signup</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div class="modal fade" id="forgotPasswordModal1" tabindex="-1" aria-labelledby="forgotPasswordLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="color: black;">Applicant Forgot Password</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="../php/send_reset_link.php" method="POST">
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
</body>
</html>
