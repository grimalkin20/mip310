<?php
// REST API Entry Point
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../config/database.php';
require_once '../includes/functions.php';

// API Response Helper
function apiResponse($data = null, $message = '', $status = 200, $error = false) {
    http_response_code($status);
    echo json_encode([
        'success' => !$error,
        'message' => $message,
        'data' => $data,
        'timestamp' => date('Y-m-d H:i:s')
    ]);
    exit();
}

// Get request method and path
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = str_replace('/api/', '', $path);
$segments = explode('/', $path);

// API Authentication
function authenticateAPI() {
    $headers = getallheaders();
    $apiKey = isset($headers['Authorization']) ? str_replace('Bearer ', '', $headers['Authorization']) : null;
    
    if (!$apiKey) {
        apiResponse(null, 'API key required', 401, true);
    }
    
    // Validate API key (you can implement your own validation logic)
    global $conn;
    $sql = "SELECT * FROM users WHERE api_key = ? AND status = 'active'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $apiKey);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        apiResponse(null, 'Invalid API key', 401, true);
    }
    
    return $result->fetch_assoc();
}

// Route handling
$resource = $segments[0] ?? '';
$id = $segments[1] ?? null;

switch ($resource) {
    case 'auth':
        require_once 'endpoints/auth.php';
        break;
        
    case 'dashboard':
        require_once 'endpoints/dashboard.php';
        break;
        
    case 'users':
        require_once 'endpoints/users.php';
        break;
        
    case 'sliders':
        require_once 'endpoints/sliders.php';
        break;
        
    case 'gallery':
        require_once 'endpoints/gallery.php';
        break;
        
    case 'announcements':
        require_once 'endpoints/announcements.php';
        break;
        
    case 'materials':
        require_once 'endpoints/materials.php';
        break;
        
    case 'inquiries':
        require_once 'endpoints/inquiries.php';
        break;
        
    case 'contacts':
        require_once 'endpoints/contacts.php';
        break;
        
    case 'feedback':
        require_once 'endpoints/feedback.php';
        break;
        
    case 'admissions':
        require_once 'endpoints/admissions.php';
        break;
        
    default:
        apiResponse(null, 'Endpoint not found', 404, true);
}
?> 