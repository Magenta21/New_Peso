<?php
include "db.php";

// Pagination settings
$limit = 6; // Number of news per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch total number of records
$result = $conn->query("SELECT COUNT(id) AS total FROM news");
$row = $result->fetch_assoc();
$total = $row['total'];
$pages = ceil($total / $limit);

// Fetch news
$sql = "SELECT * FROM news ORDER BY schedule_date DESC LIMIT $start, $limit";
$result = $conn->query($sql);

// Pagination display limit
$max_pages_display = 6;
$start_page = max(1, $page - floor($max_pages_display / 2));
$end_page = min($pages, $start_page + $max_pages_display - 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="news.css">
</head>
<body>


<nav class="navbar bg-primary text-white py-2">
    <div class="container-fluid">
        <!-- Navigation Links -->
        <div class="ms-auto"></div>
        <div class="d-flex flex-wrap align-items-center">
           <a href="https://www.gov.ph/" target="_blank" class="nav-link px-3 text-white">GOVPH</a>
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>
            <a href="index.php" class="nav-link px-3">HOME</a>
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>
            
            <!-- Applicant Dropdown -->
            <div class="dropdown">
                <a class="nav-link px-3 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    APPLICANT
                </a>
                <ul class="dropdown-menu bg-primary">
                    <li><a class="dropdown-item text-white" href="Applicant/applicant_login.php">Login</a></li>
                    <li><a class="dropdown-item text-white" href="Applicant/applicant_register.php">Register</a></li>
                    <li><a class="dropdown-item text-white" href="index.php#aboutus">About Us</a></li>
                    <li><a class="dropdown-item text-white" href="index.php#contact">Contact Us</a></li>
                </ul>
            </div>
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>
            
          
            <!-- Trainings Dropdown -->
            <div class="dropdown">
                <a class="nav-link px-3 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    TRAININGS
                </a>
                <ul class="dropdown-menu bg-primary">
                    <li><a class="dropdown-item text-white" href="training/training_login.php">Welding</a></li>
                    
                    <!-- Wellness-Hilot with nested dropdown -->
                    <li>
                    <a class="dropdown-item text-white" href="training/training_login.php" >Wellness-Hilot</a>
                    </li>                       
                    <li><a class="dropdown-item text-white" href="training/training_login.php">Dressmaking</a></li>
                    <li><a class="dropdown-item text-white" href="training/training_login.php">Computer Literature</a></li>
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
                    <li><a class="dropdown-item text-white" href="ofw/ofw_benefits.php">OFW him/her self</a></li>
                    
                </ul>
            </div>
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>
            
            <!-- Employer Dropdown -->
            <div class="dropdown">
                <a class="nav-link px-3 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    EMPLOYER
                </a>
                <ul class="dropdown-menu bg-primary">
                    <li><a class="dropdown-item text-white" href="employer/employer_login.php">Local</a></li>
                    <li><a class="dropdown-item text-white" href="employer/employer_login.php">Overseas</a></li>
                    <li><a class="dropdown-item text-white" href="employer/employer_login.php">Direct Hire</a></li>
                    <li><a class="dropdown-item text-white" href="employer/employer_login.php">Agency</a></li>
                </ul>
            </div>
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>
            
            <a href="joblist.php" class="nav-link px-3">JOBS</a>
            <div class="vr d-none d-sm-flex mx-2" style="height: 40px; opacity: 0.5;"></div>
            <a href="news.php" class="nav-link px-3">NEWS</a>
        </div>
        <div class="ms-auto"></div>
    </div>
</nav>  

<div class="container mt-5">
    <h2 class="mb-4">Latest News</h2>
    
    <?php if ($result->num_rows > 0): ?>
        <div class="row">
            <?php while ($news = $result->fetch_assoc()): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card news-card">
                        <?php if ($news['image']): ?>
                            <img src="<?php echo htmlspecialchars($news['image']); ?>" class="card-img-top news-img" alt="<?php echo htmlspecialchars($news['title']); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($news['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars(substr($news['description'], 0, 150)); ?>...</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="news-date">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    <?php echo date('M j, Y', strtotime($news['schedule_date'])); ?>
                                </small>
                                <button class="btn btn-primary read-more-btn" data-bs-toggle="modal" data-bs-target="#newsModal" 
                                    data-title="<?php echo htmlspecialchars($news['title']); ?>"
                                    data-image="<?php echo htmlspecialchars($news['image']); ?>"
                                    data-description="<?php echo htmlspecialchars($news['description']); ?>"
                                    data-content="<?php echo htmlspecialchars($news['content']); ?>"
                                    data-date="<?php echo date('F j, Y', strtotime($news['schedule_date'])); ?>">
                                    Read More
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        
        <!-- Pagination -->
        <?php if ($pages > 1): ?>
            <nav aria-label="News pagination">
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $pages; $i++): ?>
                        <li class="page-item <?php if ($page == $i) echo 'active'; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    
                    <?php if ($page < $pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
        
    <?php else: ?>
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle me-2"></i> No news articles available at the moment.
        </div>
    <?php endif; ?>
</div>

<!-- News Modal -->
<div class="modal fade" id="newsModal" tabindex="-1" aria-labelledby="newsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newsModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modalNewsImageContainer">
                    <img id="modalNewsImage" class="modal-news-img" src="" alt="">
                </div>
                <p class="text-muted mb-3"><i class="far fa-calendar-alt me-1"></i> <span id="modalNewsDate"></span></p>
                <div id="modalNewsDescription" class="mb-3"></div>
                <div id="modalNewsContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Handle modal content population
    document.addEventListener('DOMContentLoaded', function() {
        const newsModal = document.getElementById('newsModal');
        if (newsModal) {
            newsModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const title = button.getAttribute('data-title');
                const image = button.getAttribute('data-image');
                const description = button.getAttribute('data-description');
                const content = button.getAttribute('data-content');
                const date = button.getAttribute('data-date');
                
                document.getElementById('newsModalLabel').textContent = title;
                document.getElementById('modalNewsDate').textContent = date;
                document.getElementById('modalNewsDescription').textContent = description;
                document.getElementById('modalNewsContent').innerHTML = content || description;
                
                const imageContainer = document.getElementById('modalNewsImageContainer');
                const imgElement = document.getElementById('modalNewsImage');
                
                if (image) {
                    imgElement.src = image;
                    imgElement.alt = title;
                    imageContainer.style.display = 'block';
                } else {
                    imageContainer.style.display = 'none';
                }
            });
        }
    });
</script>
</body>
</html>

<?php
$conn->close();
?>