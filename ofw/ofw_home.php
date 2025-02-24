<?php
include '../db.php';
session_start();

$employerid = $_SESSION['ofw_id'];
// Check if the employer is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ofw_login.php");
    exit();
}

$sql = "SELECT * FROM ofw_profile WHERE id = ?";
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
    <div class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2">
                    <img src="../img/logolb.png" alt="lblogo" style="height: 50px;">
                </div>
                <div class="col-md-8">
                    <h3 style="margin-top: 5px; font-weight: 900; color: #ffffff;">MUNICIPALITY OF LOS BANOS</h3>
                </div>
                <div class="col-md-2 mt-1 position-relative">
                    <div class="dropdown">
                        <a href="#" class="text-decoration-none mt-5" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php if (!empty($row['profile_image'])): ?>
                                <img id="preview" src="<?php echo $row['profile_image']; ?>" alt="Profile Image" class="img-fluid rounded-circle" style="width: 40px; height: 40px;">
                            <?php else: ?>
                                <img src="../img/user-placeholder.png" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 40px; height: 40px;">
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end text-center mt-2" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-text text-white w-100 text-center">
                <a class="navlink" href="#">Post report</a>
                <a class="navlink" href="#">take a survey</a>
                <a class="navlink" href="#">View report status</a>
                <a class="navlink" href="#about">About Us</a>
            </span>
        </div>
    </nav>
    <div class="banner">
    </div>

    <div class="container mt-4">
        <div class="row mb-4 text-center">
            <div class="col-8 text-center  text-black py-3 border border-5 border-danger p-5 rounded-5">
                It is with great pride and commitment that we introduce the newly developed Public Employment Service Office (PESO) website, a vital step toward enhancing employment opportunities for our community. This platform is designed to connect job seekers with employers, provide access to training programs, and offer essential career guidance to empower our local workforce. As we strive for progress and inclusive growth, this digital initiative ensures that every resident of Los Baños has an accessible, transparent, and efficient employment service. Together, we build a future where opportunities are within reach for all.
            </div>
            <div class="col-md-4">
                <img src="../img/mayor.jpg" alt="Sample Image" class="img-fluid  rounded-circle" style="width: 200px; height: 200px;">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
