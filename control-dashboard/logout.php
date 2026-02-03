<?php
session_start();

// Log the logout activity
if (isset($_SESSION['user_id'])) {
    require_once 'config/database.php';
    require_once 'includes/functions.php';
    logActivity($_SESSION['user_id'], 'Logout', 'User logged out');
}

// Destroy all session data
session_destroy();

// Redirect to login page
header("Location: index.php");
exit();
?> 