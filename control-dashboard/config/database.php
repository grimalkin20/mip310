<?php
// Database configuration for WAMP Server
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'mip_panel';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    // Check if JSON response is needed (API context)
    $requestedWith = isset($_SERVER['HTTP_X_REQUESTED_WITH']) ? $_SERVER['HTTP_X_REQUESTED_WITH'] : '';
    if ($requestedWith === 'XMLHttpRequest' || strpos($_SERVER['REQUEST_URI'], '/api/') !== false) {
        header('Content-Type: application/json');
        http_response_code(500);
        die(json_encode(['success' => false, 'data' => [], 'message' => 'Connection failed: ' . $conn->connect_error]));
    } else {
        die("Connection failed: " . $conn->connect_error);
    }
}

// Set charset to utf8
$conn->set_charset("utf8");

// Set timezone
date_default_timezone_set('Asia/Kolkata');
?> 