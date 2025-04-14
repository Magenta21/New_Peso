<div class="sidebar">
    <div class="profile">
        <div class="admin-name">
            <h3><?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></h3>
            <p>Administrator</p>
        </div>
        <div class="profile-pic">
            <?= isset($_SESSION['admin_avatar']) ? '' : substr($_SESSION['admin_name'] ?? 'A', 0, 1) ?>
        </div>
    </div>
    
    <ul class="nav-links">
        <li>
            <a href="?page=dashboard" class="<?= $page === 'dashboard' ? 'active' : '' ?>">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="?page=users" class="<?= $page === 'users' ? 'active' : '' ?>">
                <i class="fas fa-users"></i> Employer Management
            </a>Z
        </li>
        <li>
            <a href="?page=content" class="<?= $page === 'content' ? 'active' : '' ?>">
                <i class="fas fa-file-alt"></i> Content Management
            </a>
        </li>
        <li>
            <a href="?page=settings" class="<?= $page === 'settings' ? 'active' : '' ?>">
                <i class="fas fa-cog"></i> Settings
            </a>
        </li>
        <li>
            <a href="?page=reports" class="<?= $page === 'reports' ? 'active' : '' ?>">
                <i class="fas fa-chart-bar"></i> Reports
            </a>
        </li>
        <li>
            <a href="?page=messages" class="<?= $page === 'messages' ? 'active' : '' ?>">
                <i class="fas fa-envelope"></i> Messages
            </a>
        </li>
        <li>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </li>
    </ul>
</div>