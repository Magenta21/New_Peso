<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
</head>
<body>
    
<nav class="navbar bg-primary text-white py-2">
    <div class="container-fluid">
        <!-- Navigation Links -->
        <div class="ms-auto"></div>
        <div class="d-flex flex-wrap align-items-center">
        <a href="https://www.gov.ph/" target="_blank" class="nav-link px-3 text-white">GOVPH</a>
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>
            <a href="#" class="nav-link px-3">HOME</a>
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>
            
            <!-- Applicant Dropdown -->
            <div class="dropdown">
                <a class="nav-link px-3 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    APPLICANT
                </a>
                <ul class="dropdown-menu bg-primary">
                    <li><a class="dropdown-item text-white" href="Applicant/applicant_login.php">Login</a></li>
                    <li><a class="dropdown-item text-white" href="Applicant/applicant_register.php">Register</a></li>
                    <li><a class="dropdown-item text-white" href="#aboutus">About Us</a></li>
                    <li><a class="dropdown-item text-white" href="#contact">Contact Us</a></li>
                </ul>
            </div>
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>
            
          
            <!-- Trainings Dropdown -->
            <!-- Trainings Dropdown -->
            <div class="dropdown">
                <a class="nav-link px-3 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    TRAININGS
                </a>
                <ul class="dropdown-menu bg-primary">
                    <!-- Welding with submenu -->
                    <li class="dropdown-submenu">
                        <a class="dropdown-item text-white" href="#">Welding</a>
                        <ul class="dropdown-menu bg-primary">
                            <li><a class="dropdown-item text-white" href="training/training_login.php?training=1">Login</a></li>
                            <li><a class="dropdown-item text-white" href="training/Trainees_register.php?training=1">Register</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a class="dropdown-item text-white" href="#">Hilot-Wellness</a>
                        <ul class="dropdown-menu bg-primary">
                            <li><a class="dropdown-item text-white" href="training/training_login.php?training=2">Login</a></li>
                            <li><a class="dropdown-item text-white" href="training/Trainees_register.php?training=2">Register</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a class="dropdown-item text-white" href="#">Dressmaking</a>
                        <ul class="dropdown-menu bg-primary">
                            <li><a class="dropdown-item text-white" href="training/training_login.php?training=3">Login</a></li>
                            <li><a class="dropdown-item text-white" href="training/Trainees_register.php?training=3">Register</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a class="dropdown-item text-white" href="#">Computer Literate</a>
                        <ul class="dropdown-menu bg-primary">
                            <li><a class="dropdown-item text-white" href="training/training_login.php?training=4">Login</a></li>
                            <li><a class="dropdown-item text-white" href="training/Trainees_register.php?training=4">Register</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>
            <!-- OFW Dropdown -->
            <div class="dropdown">
                <a class="nav-link px-3 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    OFW
                </a>
                <ul class="dropdown-menu bg-primary">
                    <li><a class="dropdown-item text-white" href="ofw/ofw_login.php">OFW-Family</a></li>
                    <li><a class="dropdown-item text-white" href="ofw/ofw_login.php">OFW him/her self</a></li>
                    
                </ul>
            </div>
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>
            
            <!-- Employer Dropdown -->
            <div class="dropdown">
                <a class="nav-link px-3 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                   Employer
                </a>
                <ul class="dropdown-menu bg-primary">
                    <!-- Welding with submenu -->
                    <li class="dropdown-submenu">
                        <a class="dropdown-item text-white" href="#">Local</a>
                        <ul class="dropdown-menu bg-primary">
                            <li><a class="dropdown-item text-white" href="employer/employer_login.php">Login</a></li>
                            <li><a class="dropdown-item text-white" href="employer/employer_register.php">Register</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a class="dropdown-item text-white" href="#">Overseas</a>
                        <ul class="dropdown-menu bg-primary">
                            <li><a class="dropdown-item text-white" href="employer/employer_login.php">Login</a></li>
                            <li><a class="dropdown-item text-white" href="employer/employer_register.php">Register</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a class="dropdown-item text-white" href="#">Direct-Hiring</a>
                        <ul class="dropdown-menu bg-primary">
                            <li><a class="dropdown-item text-white" href="employer/employer_login.php">Login</a></li>
                            <li><a class="dropdown-item text-white" href="employer/employer_register.php">Register</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a class="dropdown-item text-white" href="#">Agency</a>
                        <ul class="dropdown-menu bg-primary">
                            <li><a class="dropdown-item text-white" href="employer/employeryer_login.php">Login</a></li>
                            <li><a class="dropdown-item text-white" href="employer/employer_register.php">Register</a></li>
                        </ul>
                    </li>
                    <!-- Other training items with same structure -->
                </ul>
            </div>
            
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>
            
            <a href="joblist.php" class="nav-link px-3">JOBS</a>
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>
            <a href="news.php" class="nav-link px-3">NEWS</a>
        </div>
        <div class="ms-auto">
            
        </div>
    </div>
</nav>


    <div class="banner">
    </div>

    <div class="container mt-4">
    <div id="welcomeCarousel" class="carousel slide shadow-lg" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner rounded-4 overflow-hidden">
            <!-- Slide 1 - Welcome Message -->
            <div class="carousel-item active">
                <div class="row g-0">
                    <div class="col-md-8 bg-light p-5 d-flex align-items-center">
                        <div class="text-center text-md-start">
                            <h2 class="text-danger mb-4 animate__animated animate__fadeInDown">Welcome to PESO Los Baños</h2>
                            <p class="lead animate__animated animate__fadeIn animate__delay-1s">
                                It is with great pride and commitment that we introduce the newly developed Public Employment Service Office (PESO) website, a vital step toward enhancing employment opportunities for our community. This platform is designed to connect job seekers with employers, provide access to training programs, and offer essential career guidance to empower our local workforce.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 bg-danger d-flex align-items-center justify-content-center p-4">
                        <img src="../img/mayor.jpg" alt="Mayor's Photo" class="img-fluid rounded-circle border border-4 border-white animate__animated animate__zoomIn" style="width: 200px; height: 200px; object-fit: cover;">
                    </div>
                </div>
            </div>
            
            <!-- Slide 2 - Community Impact -->
            <div class="carousel-item">
                <div class="row g-0">
                    <div class="col-md-8 bg-light p-5 d-flex align-items-center">
                        <div class="text-center text-md-start">
                            <h2 class="text-danger mb-4 animate__animated animate__fadeInDown">Building Our Community</h2>
                            <p class="lead animate__animated animate__fadeIn animate__delay-1s">
                                As we strive for progress and inclusive growth, this digital initiative ensures that every resident of Los Baños has an accessible, transparent, and efficient employment service. Together, we build a future where opportunities are within reach for all.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 bg-primary d-flex align-items-center justify-content-center p-4">
                        <img src="../img/community.jpg" alt="Community Photo" class="img-fluid rounded-3 animate__animated animate__zoomIn" style="max-height: 300px; object-fit: cover;">
                    </div>
                </div>
            </div>
            
            <!-- Slide 3 - Employment Services -->
            <div class="carousel-item">
                <div class="row g-0">
                    <div class="col-md-8 bg-light p-5 d-flex align-items-center">
                        <div class="text-center text-md-start">
                            <h2 class="text-danger mb-4 animate__animated animate__fadeInDown">Our Services</h2>
                            <p class="lead animate__animated animate__fadeIn animate__delay-1s">
                                PESO Los Baños offers comprehensive employment services including job matching, career counseling, skills training, and livelihood programs. We bridge the gap between employers and job seekers to create a thriving local economy.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 bg-success d-flex align-items-center justify-content-center p-4">
                        <img src="../img/services.jpg" alt="Services Photo" class="img-fluid rounded-3 animate__animated animate__zoomIn" style="max-height: 300px; object-fit: cover;">
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
        <div class="row mb-4 mt-4 text-center">
            <div class="col-md-4">
                <div class="profile">
                    <img src="img/mission.png" alt="Profile 1" class="img-fluid" style="width: 100px; height: 100px;">
                    <div><br><h3>Mission<h3></div>
                    <div>To carry out full employment and equality of employment opportunities for all, and for this purpose, strengthen and expand the existing employment facilitation service machinery.</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="profile">
                    <img src="img/vision.png" alt="Profile 2" class="img-fluid" style="width: 100px; height: 100px;">
                    <div><br><h3>Vission<h3></div>
                    <div>HANAPBUHAY PARA SA LAHAT TUNGO SA MAUNLAD, MASAGANA AT MASAYANG LOS BAÑOS</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="profile">
                    <img src="img/values.png" alt="Profile 3" class="img-fluid" style="width: 100px; height: 100px;">
                    <div><br><h3>Values<h3></div>
                    <div>Integrity / Honesty / Teamwork
                        Innovation / Cooperation / Diversity / Trust
                        Passion / Respect / Accountability</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="block mb-4" id="aboutus">
                    <h3> ABOUT PESO </h3> 
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
                <div class="block block-bg mb-4">
                    <h3>Organizational Outcome</h3>
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
                <h6 id="contact">CONTACT US</h6>
                </div>
                <div class="col-md-4 mt-2">
                <h6>GOVERNMENT LINKS</h6>
                </div>
            </div>
        </div>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
         // Initialize Bootstrap dropdowns
        document.addEventListener('DOMContentLoaded', function() {
            var dropdownElements = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
            dropdownElements.map(function (dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl)
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
        const carousel = document.querySelector('#welcomeCarousel');
        
        // Add animation when slide changes
        carousel.addEventListener('slide.bs.carousel', function (e) {
            const nextSlide = e.relatedTarget;
            const elements = nextSlide.querySelectorAll('.animate__animated');
            
            // Reset animations
            elements.forEach(el => {
                el.classList.remove('animate__fadeIn', 'animate__fadeInDown', 'animate__zoomIn');
                void el.offsetWidth; // Trigger reflow
            });
            
            // Add animations with delays
            setTimeout(() => {
                const headings = nextSlide.querySelectorAll('h2');
                const paragraphs = nextSlide.querySelectorAll('p');
                const images = nextSlide.querySelectorAll('img');
                
                headings.forEach(h => h.classList.add('animate__fadeInDown'));
                paragraphs.forEach(p => p.classList.add('animate__fadeIn'));
                images.forEach(img => img.classList.add('animate__zoomIn'));
            }, 50);
        });
    });

    </script>
    
</body>
</html>
