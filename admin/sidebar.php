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
                    <i class="fas fa-building"></i> Employer Management
                </a>
            </li>
            <li>
                <a href="?page=training" class="<?= $page === 'training' ? 'active' : '' ?>">
                    <i class="fas fa-users"></i> Training Management
                </a>
            </li>
            <li>
                <a href="?page=ofw_cases" class="<?= $page === 'ofw_cases' ? 'active' : '' ?>">
                    <i class="fas fa-plane"></i> OFW File Case
                </a>
            </li>
            <li>
                <a href="?page=survey" class="<?= $page === 'survey' ? 'active' : '' ?>">
                    <i class="fas fa-poll"></i> Survey Management
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