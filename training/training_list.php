<?php
include '../db.php';

session_start();

$applicantid = $_SESSION['applicant_id'];
// Check if the employer is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: applicant_login.php");
    exit();
}

$sql = "SELECT * FROM applicant_profile WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $applicantid);
$stmt->execute();
$result_emp = $stmt->get_result();

if (!$result_emp) {
    die("Invalid query: " . $conn->error); 
}

$row_emp = $result_emp->fetch_assoc();
if (!$row_emp) {
    die("User not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/training_list.css">
    
</head>
<body>
<div class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                
                 <img src="../img/logolb.png" alt="lblogo" style="height: 50px;">
                
            </div>
            <div class="col-md-8">
                
            </div>
            <div class="col-md-2 col-xxl-3 p-1">
                <div class="dropdown">
                    <a href="#" class="text-decoration-none" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php if (!empty($row_emp['photo'])): ?>
                            <img id="preview" src="<?php echo $row_emp['photo']; ?>" alt="Profile Image" class="img-fluid rounded-circle" style="width: 40px; height: 40px;">
                        <?php else: ?>
                            <img src="../img/user-placeholder.png" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 40px; height: 40px;">
                        <?php endif; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-center mt-2" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="training_profile.php">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">
    <header>
        <h3 class="h3">Course List</h3>
    </header>

    <div class="card-container">
        <!-- Course Item 1 -->
        <div class="card custom-card">
            <div class="card-img-top">
                <i class="bi bi-book" style="font-size: 4rem;"></i>
            </div>
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Sewing</h5>
                <p class="card-text">Sewing is the craft of fastening or attaching objects using stitches made with a needle...</p>
                <button type="button" class="btn btn-link p-1" data-bs-toggle="modal" data-bs-target="#descModal-1">Read more</button>
                <a href="modules_list.php?course_id=1" class="btn btn-primary mt-auto">Go to course</a>
            </div>
        </div>

        <!-- Course Item 2 -->
        <div class="card custom-card">
            <div class="card-img-top">
                <i class="bi bi-book" style="font-size: 4rem;"></i>
            </div>
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Cookery</h5>
                <p class="card-text">This course is designed to equip individuals with essential culinary skills and knowledge...</p>
                <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#descModal-2">Read more</button>
                <a href="modules_list.php?course_id=2" class="btn btn-primary mt-auto">Go to course</a>
            </div>
        </div>

        <!-- Course Item 3 -->
        <div class="card custom-card">
            <div class="card-img-top">
                <i class="bi bi-book" style="font-size: 4rem;"></i>
            </div>
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">New Course</h5>
                <p class="card-text">This course is designed to provide hands-on learning experience for the participants in various fields...</p>
                <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#descModal-3">Read more</button>
                <a href="modules_list.php?course_id=3" class="btn btn-primary mt-auto">Go to course</a>
            </div>
        </div>

        <!-- Course Item 4 -->
        <div class="card custom-card">
            <div class="card-img-top">
                <i class="bi bi-book" style="font-size: 4rem;"></i>
            </div>
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Course 4</h5>
                <p class="card-text">This course is designed to provide hands-on learning experience for the participants in various fields...</p>
                <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#descModal-4">Read more</button>
                <a href="modules_list.php?course_id=4" class="btn btn-primary mt-auto">Go to course</a>
            </div>
        </div>

        <!-- Course Item 5 -->
        <div class="card custom-card">
            <div class="card-img-top">
                <i class="bi bi-book" style="font-size: 4rem;"></i>
            </div>
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Course 5</h5>
                <p class="card-text">This course is designed to provide hands-on learning experience for the participants in various fields...</p>
                <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#descModal-5">Read more</button>
                <a href="modules_list.php?course_id=5" class="btn btn-primary mt-auto">Go to course</a>
            </div>
        </div>

        <!-- Course Item 6 -->
        <div class="card custom-card">
            <div class="card-img-top">
                <i class="bi bi-book" style="font-size: 4rem;"></i>
            </div>
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Course 6</h5>
                <p class="card-text">This course is designed to provide hands-on learning experience for the participants in various fields...</p>
                <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#descModal-6">Read more</button>
                <a href="modules_list.php?course_id=6" class="btn btn-primary mt-auto">Go to course</a>
            </div>
        </div>

        <!-- Course Item 7 -->
        <div class="card custom-card">
            <div class="card-img-top">
                <i class="bi bi-book" style="font-size: 4rem;"></i>
            </div>
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Course 7</h5>
                <p class="card-text">This course is designed to provide hands-on learning experience for the participants in various fields...</p>
                <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#descModal-7">Read more</button>
                <a href="modules_list.php?course_id=7" class="btn btn-primary mt-auto">Go to course</a>
            </div>
        </div>

        <!-- Course Item 8 -->
        <div class="card custom-card">
            <div class="card-img-top">
                <i class="bi bi-book" style="font-size: 4rem;"></i>
            </div>
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Course 8</h5>
                <p class="card-text">This course is designed to provide hands-on learning experience for the participants in various fields...</p>
                <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#descModal-8">Read more</button>
                <a href="modules_list.php?course_id=8" class="btn btn-primary mt-auto">Go to course</a>
            </div>
        </div>
    </div>

    <!-- Modal for Course 1 -->
    <div class="modal fade" id="descModal-1" tabindex="-1" aria-labelledby="descModalLabel-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="descModalLabel-1">Sewing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Sewing is the craft of fastening or attaching objects using stitches made with a needle and thread...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Course 2 -->
    <div class="modal fade" id="descModal-2" tabindex="-1" aria-labelledby="descModalLabel-2" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="descModalLabel-2">Cookery</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    This course is designed to equip individuals with essential culinary skills and knowledge in preparing...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Course 3 -->
    <div class="modal fade" id="descModal-3" tabindex="-1" aria-labelledby="descModalLabel-3" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="descModalLabel-3">New Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    This course is designed to provide hands-on learning experience for the participants in various fields...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Course 4 -->
    <div class="modal fade" id="descModal-4" tabindex="-1" aria-labelledby="descModalLabel-4" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="descModalLabel-4">Course 4</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    This course is designed to provide hands-on learning experience for the participants in various fields...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Course 5 -->
    <div class="modal fade" id="descModal-5" tabindex="-1" aria-labelledby="descModalLabel-5" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="descModalLabel-5">Course 5</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    This course is designed to provide hands-on learning experience for the participants in various fields...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Course 6 -->
    <div class="modal fade" id="descModal-6" tabindex="-1" aria-labelledby="descModalLabel-6" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="descModalLabel-6">Course 6</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    This course is designed to provide hands-on learning experience for the participants in various fields...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Course 7 -->
    <div class="modal fade" id="descModal-7" tabindex="-1" aria-labelledby="descModalLabel-7" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="descModalLabel-7">Course 7</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    This course is designed to provide hands-on learning experience for the participants in various fields...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Course 8 -->
    <div class="modal fade" id="descModal-8" tabindex="-1" aria-labelledby="descModalLabel-8" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="descModalLabel-8">Course 8</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    This course is designed to provide hands-on learning experience for the participants in various fields...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional: Add Bootstrap JS for Modal functionality -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
