<?php
// Include database connection
include "connect.php";

// Set header for JSON response
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get JSON data from request body
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

// Validate required fields
if (!isset($data['name']) || empty(trim($data['name']))) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Name is required']);
    exit;
}

if (!isset($data['email']) || empty(trim($data['email']))) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Email is required']);
    exit;
}

if (!isset($data['phone']) || empty(trim($data['phone']))) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Phone is required']);
    exit;
}

if (!isset($data['course']) || empty(trim($data['course']))) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Course selection is required']);
    exit;
}

if (!isset($data['message']) || empty(trim($data['message']))) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Message is required']);
    exit;
}

// Validate email format
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid email format']);
    exit;
}

// Sanitize input data
$name = trim($data['name']);
$email = trim($data['email']);
$phone = trim($data['phone']);
$course = trim($data['course']);
$message = trim($data['message']);

// Prepare SQL statement
$sql = "INSERT INTO inquiries (name, email, phone, course, message, status, created_at, updated_at) 
        VALUES (?, ?, ?, ?, ?, 'new', NOW(), NOW())";

// Prepare and bind
$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    exit;
}

// Bind parameters
$stmt->bind_param("sssss", $name, $email, $phone, $course, $message);

// Execute statement
if ($stmt->execute()) {
    http_response_code(201);
    echo json_encode([
        'success' => true, 
        'message' => 'Inquiry submitted successfully',
        'id' => $stmt->insert_id
    ]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error submitting inquiry: ' . $stmt->error]);
}

// Close statement
$stmt->close();
$conn->close();
?>
