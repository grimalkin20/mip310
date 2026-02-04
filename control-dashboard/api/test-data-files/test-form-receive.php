<?php
// Test if form submission is reaching the server

// Very basic logging
file_put_contents(__DIR__ . '/form_received.log', 
    date('Y-m-d H:i:s') . " - REQUEST RECEIVED\n" . 
    "Method: " . $_SERVER['REQUEST_METHOD'] . "\n" .
    "Content-Type: " . $_SERVER['CONTENT_TYPE'] . "\n" .
    "Body: " . file_get_contents('php://input') . "\n" .
    "---\n",
    FILE_APPEND
);

// Always return success
header('Content-Type: application/json');
echo json_encode(['success' => true, 'message' => 'Form received']);
?>
