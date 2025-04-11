<?php
// Start session and check admin authentication
session_start();
if (!isset($_SESSION['logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

// Set default page to dashboard if not specified
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// List of valid admin pages
$valid_pages = ['dashboard', 'users', 'content', 'settings', 'reports', 'messages'];

// Validate the requested page
if (!in_array($page, $valid_pages)) {
    $page = 'dashboard';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f5f5f5;
        }
        
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            padding: 20px 0;
            height: 100vh;
            position: fixed;
        }
        
        .profile {
            display: flex;
            align-items: center;
            padding: 0 20px 20px;
            border-bottom: 1px solid #34495e;
            margin-bottom: 20px;
        }
        
        .profile-pic {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #3498db;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: auto;
            color: white;
            font-weight: bold;
            font-size: 18px;
            background-image: url('<?= isset($_SESSION['admin_avatar']) ? $_SESSION['admin_avatar'] : '' ?>');
            background-size: cover;
        }
        
        .admin-name {
            margin-right: 15px;
            text-align: right;
        }
        
        .admin-name h3 {
            font-size: 16px;
            margin-bottom: 3px;
        }
        
        .admin-name p {
            font-size: 12px;
            color: #bdc3c7;
        }
        
        .nav-links {
            list-style: none;
        }
        
        .nav-links li {
            margin-bottom: 5px;
        }
        
        .nav-links a {
            display: block;
            color: #ecf0f1;
            text-decoration: none;
            padding: 12px 20px;
            transition: all 0.3s;
        }
        
        .nav-links a:hover {
            background-color: #34495e;
            border-left: 4px solid #3498db;
            padding-left: 16px;
        }
        
        .nav-links a.active {
            background-color: #34495e;
            border-left: 4px solid #3498db;
        }
        
        .nav-links i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
        }
        
        .content-area {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            min-height: calc(100vh - 40px);
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .page-header h1 {
            font-size: 24px;
            color: #2c3e50;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            
            body {
                flex-direction: column;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .profile {
                justify-content: flex-end;
            }
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="content-area">
            <?php include "content/$page.php"; ?>
        </div>
    </div>

    <script>
        // Function to update date and time
        function updateDateTime() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };
            document.querySelectorAll('.date-time').forEach(el => {
                el.textContent = now.toLocaleDateString('en-US', options);
            });
        }
        
        // Update date time immediately and then every minute
        updateDateTime();
        setInterval(updateDateTime, 60000);
    </script>
</body>
</html>