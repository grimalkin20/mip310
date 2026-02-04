<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Simple file-based logging that will definitely work
function logToFile($message) {
    $logFile = __DIR__ . '/api/test-data-files/submit_debug.log';
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $message\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

logToFile('=== New Form Submission ===');

// Include database connection
include "connect.php";

// Set header for JSON response
header('Content-Type: application/json');

logToFile('Request Method: ' . $_SERVER['REQUEST_METHOD']);

// Check database connection
if (!$conn) {
    logToFile('ERROR: Database connection failed');
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

logToFile('Database connected successfully');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    logToFile('ERROR: Not a POST request');
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get JSON data from request body
$json_data = file_get_contents('php://input');
logToFile('Raw JSON data: ' . $json_data);

$data = json_decode($json_data, true);

if ($data === null) {
    logToFile('ERROR: Invalid JSON data');
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid JSON data']);
    exit;
}

logToFile('Decoded data: ' . json_encode($data));

// Validate required fields
if (!isset($data['name']) || empty(trim($data['name']))) {
    logToFile('ERROR: Name is required');
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Name is required']);
    exit;
}

if (!isset($data['email']) || empty(trim($data['email']))) {
    logToFile('ERROR: Email is required');
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Email is required']);
    exit;
}

if (!isset($data['subject']) || empty(trim($data['subject']))) {
    logToFile('ERROR: Subject is required');
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Subject is required']);
    exit;
}

if (!isset($data['message']) || empty(trim($data['message']))) {
    logToFile('ERROR: Message is required');
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Message is required']);
    exit;
}

// Validate email format
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    logToFile('ERROR: Invalid email format - ' . $data['email']);
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid email format']);
    exit;
}

logToFile('All validations passed');

// Sanitize input data
$name = trim($data['name']);
$email = trim($data['email']);
$phone = isset($data['phone']) && !empty(trim($data['phone'])) ? trim($data['phone']) : NULL;
$subject = trim($data['subject']);
$message = trim($data['message']);

logToFile("Sanitized data - Name: $name, Email: $email, Phone: " . ($phone ?? 'NULL') . ", Subject: $subject");

// Prepare SQL statement
$sql = "INSERT INTO contacts (name, email, phone, subject, message, status, created_at, updated_at) 
        VALUES (?, ?, ?, ?, ?, 'new', NOW(), NOW())";

// Prepare and bind
$stmt = $conn->prepare($sql);

if (!$stmt) {
    logToFile('ERROR: Prepare failed - ' . $conn->error);
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    exit;
}

logToFile('Statement prepared successfully');

// Bind parameters - handle NULL phone field
$phoneForBind = $phone; // This will be NULL or a string
if ($phone === NULL) {
    $stmt->bind_param("ssnss", $name, $email, $phoneForBind, $subject, $message);
} else {
    $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);
}

logToFile('Parameters bound successfully');

// Execute statement
if ($stmt->execute()) {
    logToFile('SUCCESS: Data inserted successfully with ID: ' . $stmt->insert_id);
    http_response_code(201);
    echo json_encode([
        'success' => true, 
        'message' => 'Message sent successfully',
        'id' => $stmt->insert_id
    ]);
} else {
    logToFile('ERROR: Execute failed - ' . $stmt->error);
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error submitting contact: ' . $stmt->error]);
}

// Close statement
$stmt->close();
$conn->close();
?>
