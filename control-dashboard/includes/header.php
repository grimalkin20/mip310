<?php
// Include functions if not already included
if (!function_exists('getAdminUrl')) {
    require_once __DIR__ . '/../includes/functions.php';
}
?>
<header class="header">
    <div class="header-left">
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <h4 class="mb-0 ms-3"><?php echo ucfirst(basename($_SERVER['PHP_SELF'], '.php')); ?></h4>
    </div>
    
    <div class="header-right">
        <!-- Theme Toggle -->
        <button class="theme-toggle" id="themeToggle" title="Toggle Theme">
            <i class="fas fa-moon" id="themeIcon"></i>
        </button>
        
        <!-- Maximize Button -->
        <button class="btn btn-outline-secondary btn-sm" id="maximizeBtn" title="Maximize View">
            <i class="fas fa-expand"></i>
        </button>
        
        <!-- User Menu -->
        <div class="user-menu">
            <button class="user-menu-btn" id="userMenuBtn">
                <i class="fas fa-user-circle"></i>
                <span><?php echo $_SESSION['full_name']; ?></span>
                <i class="fas fa-chevron-down"></i>
            </button>
            
            <div class="user-menu-dropdown" id="userMenuDropdown">
                <a href="<?php echo getAdminUrl('profile/view.php'); ?>" class="user-menu-item">
                    <i class="fas fa-user me-2"></i>
                    View Profile
                </a>
                <a href="<?php echo getAdminUrl('profile/settings.php'); ?>" class="user-menu-item">
                    <i class="fas fa-cog me-2"></i>
                    Settings
                </a>
                <?php if (!isSuperUser()): ?>
                <a href="<?php echo getAdminUrl('feedback/add.php'); ?>" class="user-menu-item">
                    <i class="fas fa-comment me-2"></i>
                    Feedback
                </a>
                <?php endif; ?>
                <hr class="my-1">
                <a href="<?php echo getAdminUrl('logout.php'); ?>" class="user-menu-item text-danger">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    Logout
                </a>
            </div>
        </div>
    </div>
</header> 