<?php
// Authentication functions
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isSuperUser() {
    return isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'super_user';
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: index.php");
        exit();
    }
}

function requireSuperUser() {
    requireLogin();
    if (!isSuperUser()) {
        header("Location: dashboard.php");
        exit();
    }
}

// Helper function to get admin panel root path
function getAdminRootPath() {
    return $_SERVER['DOCUMENT_ROOT'] . '/control-dashboard';
}

// Navigation helper function
function getBaseUrl() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    
    // Get the current script path
    $scriptPath = $_SERVER['SCRIPT_NAME'];
    
    // Find the position of /control-dashboard in the script path
    $adminPanelPos = strpos($scriptPath, '/control-dashboard');
    
    if ($adminPanelPos !== false) {
        // Extract everything up to and including /control-dashboard
        $basePath = substr($scriptPath, 0, $adminPanelPos + strlen('/control-dashboard'));
        // Remove /control-dashboard to get the base URL
        $path = substr($basePath, 0, $adminPanelPos);
    } else {
        // Fallback to document root
        $path = '';
    }
    
    return $protocol . '://' . $host . $path;
}

function getAdminUrl($path = '') {
    $baseUrl = getBaseUrl();
    $adminPath = '/control-dashboard';
    
    // Clean the path
    $path = ltrim($path, '/');
    
    return $baseUrl . $adminPath . '/' . $path;
}

function getAssetUrl($path = '') {
    $baseUrl = getBaseUrl();
    $adminPath = '/control-dashboard';
    
    // Clean the path
    $path = ltrim($path, '/');
    
    return $baseUrl . $adminPath . '/assets/' . $path;
}

function getUploadUrl($path = '') {
    $baseUrl = getBaseUrl();
    $adminPath = '/control-dashboard';
    
    // Clean the path
    $path = ltrim($path, '/');
    
    return $baseUrl . $adminPath . '/uploads/' . $path;
}

// File upload functions
function uploadFile($file, $destination, $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'docx', 'ppt', 'xlsx', 'txt', 'pptx', 'doc', 'xls']) {
    $uploadDir = "../uploads/materials/" . $destination . "/";
    
    // Create directory if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    $fileName = $file['name'];
    $fileSize = $file['size'];
    $fileTmp = $file['tmp_name'];
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    // Check file type
    if (!in_array($fileType, $allowedTypes)) {
        return ['success' => false, 'message' => 'File type not allowed'];
    }
    
    // Check file size (5MB max)
    if ($fileSize > 5 * 1024 * 1024) {
        return ['success' => false, 'message' => 'File size too large (max 5MB)'];
    }
    
    // Generate unique filename
    $newFileName = uniqid() . '_' . time() . '.' . $fileType;
    $uploadPath = $uploadDir . $newFileName;
    
    if (move_uploaded_file($fileTmp, $uploadPath)) {
        return ['success' => true, 'filename' => $newFileName, 'path' => $uploadPath];
    } else {
        return ['success' => false, 'message' => 'Failed to upload file'];
    }
}



function deleteFile($file_path) {
    if (file_exists($file_path)) {
        return unlink($file_path);
    }
    return false;
}

// Database utility functions
function sanitizeInput($data) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($data));
}

function getCurrentDateTime() {
    return date('Y-m-d H:i:s');
}

// Pagination function
function getPagination($totalRecords, $recordsPerPage, $currentPage, $url) {
    $totalPages = ceil($totalRecords / $recordsPerPage);
    $pagination = '';
    
    if ($totalPages > 1) {
        $pagination .= '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';
        
        // Previous button
        if ($currentPage > 1) {
            $pagination .= '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . ($currentPage - 1) . '">Previous</a></li>';
        }
        
        // Page numbers
        for ($i = 1; $i <= $totalPages; $i++) {
            $active = ($i == $currentPage) ? 'active' : '';
            $pagination .= '<li class="page-item ' . $active . '"><a class="page-link" href="' . $url . '?page=' . $i . '">' . $i . '</a></li>';
        }
        
        // Next button
        if ($currentPage < $totalPages) {
            $pagination .= '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . ($currentPage + 1) . '">Next</a></li>';
        }
        
        $pagination .= '</ul></nav>';
    }
    
    return $pagination;
}

// Status functions
function getStatusBadge($status) {
    switch ($status) {
        case 'active':
            return '<span class="badge bg-success">Active</span>';
        case 'inactive':
            return '<span class="badge bg-secondary">Inactive</span>';
        case 'pending':
            return '<span class="badge bg-warning">Pending</span>';
        case 'deleted':
            return '<span class="badge bg-danger">Deleted</span>';
        default:
            return '<span class="badge bg-secondary">Unknown</span>';
    }
}

// User type functions
function getUserTypeBadge($userType) {
    switch ($userType) {
        case 'super_user':
            return '<span class="badge bg-danger">Super User</span>';
        case 'admin':
            return '<span class="badge bg-primary">Admin</span>';
        case 'user':
            return '<span class="badge bg-info">User</span>';
        default:
            return '<span class="badge bg-secondary">Unknown</span>';
    }
}

// Format date
function formatDate($date) {
    return date('d M Y, h:i A', strtotime($date));
}

// Generate random string
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

// Log activity
function logActivity($userId, $action, $details = '') {
    global $conn;
    $sql = "INSERT INTO activity_logs (user_id, action, details, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $userId, $action, $details);
    return $stmt->execute();
}

// Get user info
function getUserInfo($userId) {
    global $conn;
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Check if file exists and is accessible
function fileExists($filePath) {
    return file_exists($filePath) && is_readable($filePath);
}

// Get file size in human readable format
function formatFileSize($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}

// Validate email
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Validate phone number
function isValidPhone($phone) {
    return preg_match('/^[0-9+\-\s()]+$/', $phone);
}

// Send email function (placeholder)
function sendEmail($to, $subject, $message, $attachments = []) {
    // This is a placeholder function
    // In production, you would use PHPMailer or similar library
    $headers = "From: admin@yourwebsite.com\r\n";
    $headers .= "Reply-To: admin@yourwebsite.com\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    
    return mail($to, $subject, $message, $headers);
}

// Get file icon based on extension
function getFileIcon($filename) {
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    switch ($extension) {
        case 'pdf':
            return 'fas fa-file-pdf';
        case 'doc':
        case 'docx':
            return 'fas fa-file-word';
        case 'ppt':
        case 'pptx':
            return 'fas fa-file-powerpoint';
        case 'xls':
        case 'xlsx':
            return 'fas fa-file-excel';
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
            return 'fas fa-file-image';
        case 'txt':
            return 'fas fa-file-alt';
        default:
            return 'fas fa-file';
    }
}
?> 