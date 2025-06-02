<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.1/css/mdb.min.css">
    
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
    <div id="welcomeCarousel" class="carousel slide shadow-lg" data-bs-ride="carousel" data-bs-interval="5000" data-bs-pause="false">
        <!-- Indicators -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="2"></button>
        </div>
        
        <div class="carousel-inner rounded-4 overflow-hidden" style="transition: transform 1s ease-in-out;">
            <!-- Slide 1 - Welcome Message -->
            <div class="carousel-item active">
                <div class="row g-0 h-100">
                    <div class="col-md-8 bg-light p-5 d-flex align-items-center position-relative">
                        <div class="text-center text-md-start slide-content">
                            <h2 class="text-danger mb-4 slide-title">Welding</h2>
                            <p class="lead slide-text">
                              The Public Employment Service Office (PESO) in Batong Malake, Los Banos, may offer welding programs, particularly Shielded Metal Arc Welding (SMAW), through their training initiatives. These programs are often designed to enhance job skills and provide additional income opportunities for individuals. PESO, as a multi-service facility, is a strategic mechanism for government-initiated employment programs and activities. 
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 bg-danger d-flex align-items-center justify-content-center p-4 position-relative">
                        <img src="img/welding.jpeg" alt="welding" class="img-fluid rounded-circle border border-4 border-white slide-image" style="width: 200px; height: 200px; object-fit: cover;">
                    </div>
                </div>
            </div>
            
            <!-- Slide 2 - Community Impact -->
            <div class="carousel-item">
                <div class="row g-0 h-100">
                    <div class="col-md-8 bg-light p-5 d-flex align-items-center position-relative">
                        <div class="text-center text-md-start slide-content">
                            <h2 class="text-danger mb-4 slide-title">Hilot-Wellness</h2>
                            <p class="lead slide-text">
                              Hilot wellness massage services offered in Public Employment Service Offices (PESOs) provide traditional Filipino therapeutic massage aimed at promoting relaxation, relieving stress, and improving overall well-being for clients, while also supporting employment and livelihood opportunities for trained massage therapists.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 bg-primary d-flex align-items-center justify-content-center p-4 position-relative">
                        <img src="img/hilot.jpeg" alt="Community Photo" class="img-fluid rounded-3 slide-image" style="max-height: 300px; object-fit: cover;">
                    </div>
                </div>
            </div>
            
            <!-- Slide 3 - Employment Services -->
            <div class="carousel-item">
                <div class="row g-0 h-100">
                    <div class="col-md-8 bg-light p-5 d-flex align-items-center position-relative">
                        <div class="text-center text-md-start slide-content">
                            <h2 class="text-danger mb-4 slide-title">Dressmaking</h2>
                            <p class="lead slide-text">
                               Dressmaking services offered in Public Employment Service Offices (PESOs) involve the creation, alteration, and repair of clothing and garments, providing clients with custom-fit apparel while also serving as a livelihood and skills development opportunity for trained dressmakers.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 bg-success d-flex align-items-center justify-content-center p-4 position-relative">
                        <img src="img/dressmaking.jpeg" alt="Services Photo" class="img-fluid rounded-3 slide-image" style="max-height: 300px; object-fit: cover;">
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="row g-0 h-100">
                    <div class="col-md-8 bg-light p-5 d-flex align-items-center position-relative">
                        <div class="text-center text-md-start slide-content">
                            <h2 class="text-danger mb-4 slide-title">Computer Literate</h2>
                            <p class="lead slide-text">
                              Computer literacy programs offered in Public Employment Service Offices (PESOs) aim to equip individuals with essential digital skills, including basic computer operation, word processing, and internet navigation, to enhance their employability and adapt to the demands of a technology-driven workplace.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 bg-success d-flex align-items-center justify-content-center p-4 position-relative">
                        <img src="img/computer.jpeg" alt="Services Photo" class="img-fluid rounded-3 slide-image" style="max-height: 300px; object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Controls -->
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
      <!-- Grid row -->
            <div class="row">
           
                <!-- Grid column -->
                <div class="col-md-12">
           
                    <!--Footer-->
                    <footer class="page-footer blue text-center text-md-left mt-0">

                        <!--Footer Links-->
                        <div class="container-fluid">
                            <div class="row">

                                <!--First column-->
                                <div class="col-md-6">
                                    <h5 class="title mb-3">PESO Los Baños</h5>
                                    <p style="text-align: justify; ">PESO Los Baños offers various employment and livelihood programs, including Livelihood Training to enhance skills for income generation, the Special Program for the Employment of Students (SPES) to support working students, Local Recruitment Activities (LRA) to connect job seekers with local employers, and Job Fairs to provide immediate employment opportunities. These initiatives aim to boost employment and economic growth in Los Baños, Laguna.</p>
                                </div>
                                <!--/.First column-->

                                <!--Second column-->
                                <div class="col-md-6">
                                    <h5 class="title mb-3">Tie-Up Governments Links</h5>
                                    <ul><li><a href="https://apps.ncr.dole.gov.ph" target="_blank" rel="noopener noreferrer" style="font-style: italic;">Department of Labor and Employment</a></li>
                                       <ul><li><a href="https://owwa.gov.ph/" target="_blank" rel="noopener noreferrer" style="font-style: italic;">Overseas Workers Welfare Administration</a></li>
                                       <ul><li><a href="https://dmw.gov.ph/" target="_blank" rel="noopener noreferrer" style="font-style: italic;"> Department of Migrant Workers</a></li>
                                    <ul><li><a href="https://cfo.gov.ph/home" target="_blank" rel="noopener noreferrer" style="font-style: italic;"> Commission on Filipinos Overseas</a></li>
                                    </ul>
                                </div>
                                <!--/.Second column-->
                            </div>
                        </div>
                        <!--/.Footer Links-->

                        <!--Copyright-->
                        <div class="footer-copyright">
                            <div class="container-fluid">
                                © 2015 Copyright: <a href="https://www.MDBootstrap.com"> MDBootstrap.com </a>

                            </div>
                        </div>
                        <!--/.Copyright-->

                    </footer>
                    <!--/.Footer-->
           
                </div>
                <!-- Grid column -->
           
            </div>
            <!-- Grid row -->
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
        
  // Enhance carousel transitions
    document.addEventListener('DOMContentLoaded', function() {
        const carousel = document.getElementById('welcomeCarousel');
        
        // Pause animation on hover
        carousel.addEventListener('mouseenter', function() {
            this.setAttribute('data-bs-pause', 'hover');
        });
        
        carousel.addEventListener('mouseleave', function() {
            this.setAttribute('data-bs-pause', 'false');
        });
        
        // Smooth transition between slides
        carousel.addEventListener('slide.bs.carousel', function(e) {
            const activeItem = this.querySelector('.carousel-item.active');
            const nextItem = this.querySelectorAll('.carousel-item')[e.to];
            
            // Reset animations for incoming slide
            if (nextItem) {
                nextItem.querySelector('.slide-content').style.opacity = '0';
                nextItem.querySelector('.slide-content').style.transform = 'translateY(20px)';
                nextItem.querySelector('.slide-image').style.opacity = '0';
                nextItem.querySelector('.slide-image').style.transform = 'scale(0.9)';
            }
        });
        
        carousel.addEventListener('slid.bs.carousel', function(e) {
            const activeItem = this.querySelector('.carousel-item.active');
            
            // Trigger animations for new active slide
            if (activeItem) {
                activeItem.querySelector('.slide-content').style.opacity = '1';
                activeItem.querySelector('.slide-content').style.transform = 'translateY(0)';
                activeItem.querySelector('.slide-image').style.opacity = '1';
                activeItem.querySelector('.slide-image').style.transform = 'scale(1)';
            }
        });
    });

    </script>
    
</body>
</html>