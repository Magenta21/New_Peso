<?php
include '../db.php';
session_start();

$employerid = $_SESSION['employer_id'];
// Check if the employer is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: employer_login.php");
    exit();
}

$sql = "SELECT * FROM employer WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $employerid);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Invalid query: " . $conn->error); 
}

$row = $result->fetch_assoc();
if (!$row) {
    die("User not found.");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layout Design</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
<nav class="navbar bg-primary text-white py-2">
    <div class="container-fluid">
        <!-- Navigation Links -->
        <img src="../img/logolb.png" alt="lblogo" style="height: 50px;">
        <div class="ms-auto">           
        </div>
        <div class="d-flex flex-wrap align-items-center">
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"> </div>
                <a href="#" class="nav-link px-3">Home</a>
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>
            
            <div class="dropdown">
                <a class="nav-link px-3" href="post_job.php">
                    Job Post
                </a>
            </div>
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>

            <div class="dropdown">
                 <a class="nav-link px-3" href="job_list.php">
                    Job List
                </a> 
            </div>

            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>

            <div class="dropdown">
                <a class="nav-link px-3" href="employees.php">
                    Employer
                </a>
                
            </div>
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>

        </div>
        <div class="ms-auto">
            <div class="dropdown">
                <a href="#" class="text-decoration-none mt-5" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php if (!empty($row['company_photo'])): ?>
                        <img id="preview" src="<?php echo $row['company_photo']; ?>" alt="Profile Image" class="img-fluid rounded-circle" style="width: 40px; height: 40px;">
                    <?php else: ?>
                        <img src="../img/user-placeholder.png" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 40px; height: 40px;">
                    <?php endif; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end text-center mt-2" aria-labelledby="profileDropdown">
                    <li><a class="dropdown-item" href="employer_profile.php">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

    <div class="banner">
    </div>

    <<div class="container mt-4">
    <div id="welcomeCarousel" class="carousel slide shadow-lg" data-bs-ride="carousel">
        <div class="carousel-inner rounded-4 overflow-hidden">
            <!-- Slide 1 - Welcome Message -->
            <div class="carousel-item active">
                <div class="row g-0">
                    <div class="col-md-8 bg-light p-5 d-flex align-items-center">
                        <div class="text-center text-md-start">
                            <h2 class="text-danger mb-4">Welcome to PESO Los Baños</h2>
                            <p class="lead">
                                It is with great pride and commitment that we introduce the newly developed Public Employment Service Office (PESO) website, a vital step toward enhancing employment opportunities for our community. This platform is designed to connect job seekers with employers, provide access to training programs, and offer essential career guidance to empower our local workforce.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 bg-danger d-flex align-items-center justify-content-center p-4">
                        <img src="../img/mayor.jpg" alt="Mayor's Photo" class="img-fluid rounded-circle border border-4 border-white" style="width: 200px; height: 200px; object-fit: cover;">
                    </div>
                </div>
            </div>
            
            <!-- Slide 2 - Community Impact -->
            <div class="carousel-item">
                <div class="row g-0">
                    <div class="col-md-8 bg-light p-5 d-flex align-items-center">
                        <div class="text-center text-md-start">
                            <h2 class="text-danger mb-4">Building Our Community</h2>
                            <p class="lead">
                                As we strive for progress and inclusive growth, this digital initiative ensures that every resident of Los Baños has an accessible, transparent, and efficient employment service. Together, we build a future where opportunities are within reach for all.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 bg-primary d-flex align-items-center justify-content-center p-4">
                        <img src="../img/community.jpg" alt="Community Photo" class="img-fluid rounded-3" style="max-height: 300px; object-fit: cover;">
                    </div>
                </div>
            </div>
            
            <!-- Slide 3 - Employment Services -->
            <div class="carousel-item">
                <div class="row g-0">
                    <div class="col-md-8 bg-light p-5 d-flex align-items-center">
                        <div class="text-center text-md-start">
                            <h2 class="text-danger mb-4">Our Services</h2>
                            <p class="lead">
                                PESO Los Baños offers comprehensive employment services including job matching, career counseling, skills training, and livelihood programs. We bridge the gap between employers and job seekers to create a thriving local economy.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 bg-success d-flex align-items-center justify-content-center p-4">
                        <img src="../img/services.jpg" alt="Services Photo" class="img-fluid rounded-3" style="max-height: 300px; object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Carousel Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#welcomeCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#welcomeCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
        
        <div class="col mb-3 justify-content-center">
        </div>

        <div class="row mb-4 text-center">
            <div class="col-md-4">
                <div class="profile">
                    <img src="../img/mission.png" alt="Profile 1" class="img-fluid" style="width: 100px; height: 100px;">
                    <div><br><h3>Mission<h3></div>
                    <div>To carry out full employment and equality of employment opportunities for all, and for this purpose, strengthen and expand the existing employment facilitation service machinery.</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="profile">
                    <img src="../img/vision.png" alt="Profile 2" class="img-fluid" style="width: 100px; height: 100px;">
                    <div><br><h3>Vission<h3></div>
                    <div>HANAPBUHAY PARA SA LAHAT TUNGO SA MAUNLAD, MASAGANA AT MASAYANG LOS BAÑOS</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="profile">
                    <img src="../img/values.png" alt="Profile 3" class="img-fluid" style="width: 100px; height: 100px;">
                    <div><br><h3>Values<h3></div>
                    <div>Integrity / Honesty / Teamwork
                        Innovation / Cooperation / Diversity / Trust
                        Passion / Respect / Accountability</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="block mb-4">
                    <h3 id="about"> ABOUT PESO </h3> 
                    The Public Employment Service Office (PESO) is a multi-service facility designed to offer employment information and assistance to clients 
                    of the Department of Labor and Employment (DOLE) and the constituents of Local Government Units (LGUs). PESO consolidates various employment 
                    promotion programs and services from DOLE and other government agencies, making it easier for all types of clientele to access information 
                    and seek the specific assistance they need.
                </div>
                <div class="block mb-2">
                    <h2>Objectives of PESO</h2>
                    <div class="row mb-3 text-center">
                        <div class="col-6">
                            <div class="obejective">
                                <div><br><h3>General Objectives<h3></div>
                                <div>Ensure the prompt, timely and efficient delivery of employment service and provision of information on the other DOLE programs.</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="obejective">
                                <div><br><h3>Specific Objectives<h3></div>
                                
                                    <ul class="a">
                                        <li>Provide a venue where people could explore simultaneously various employment options and actually seek assistance they prefer;</li>
                                        <li>Serve as referral and information center for the various services and programs of DOLE and other government agencies present in the area;</li>
                                        <li>Provide clients with adequate information on employment and labor market situation in the area; and</li>
                                        <li>Network with other PESOs within the region on employment for job exchange purposes.</li>
                                    </ul>
                                
                            </div>
                        </div>

                    </div>

                </div>
                <div class="block mb-4">
                    <h3>Organizatinal Outcome</h3>
                        <ul class="b">
                            <li>Full employment opportunities for all</li>
                            <li>Capable and empowered citizenry through skills training</li>
                            <li>Efficient OFW and Migration Development Center</li>
                            <li>Enterprise Community through incubation and livelihood development</li>
                        </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mt-2">
                    <h6>REPUBLIC OF THE PHILIPPINES</h6>
                    <p>All content is in the publick domain unless otherwise stated</p>
                </div>
                <div class="col-md-4 mt-2">
                <h6>CONTACT US</h6>
                </div>
                <div class="col-md-4 mt-2">
                <h6>GOVERNMENT LINKS</h6>
                </div>
            </div>
        </div>
        <script>
            // Function to add an initial bullet point when the page loads
            function addInitialBullet() {
                const textarea = document.getElementById('req');
                textarea.value = '• '; // Add a bullet point
                textarea.setSelectionRange(2, 2); // Set the cursor position right after the bullet
            }

            // Call the function when the DOM is fully loaded
            document.addEventListener('DOMContentLoaded', function () {
                addInitialBullet();
            });

            document.getElementById('req').addEventListener('keydown', function (event) {
                // Check if the "Enter" key was pressed
                if (event.key === 'Enter') {
                    const textarea = event.target;
                    const cursorPosition = textarea.selectionStart; // Get cursor position

                    // Split the content into lines by the newline character
                    const beforeText = textarea.value.slice(0, cursorPosition);
                    const afterText = textarea.value.slice(cursorPosition);

                    // Add a bullet point at the new line
                    textarea.value = `${beforeText}\n• ` + afterText;

                    // Prevent default behavior (such as a plain new line without a bullet)
                    event.preventDefault();

                    // Move the cursor right after the bullet point
                    textarea.setSelectionRange(cursorPosition + 3, cursorPosition + 3);
                }
            });
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
