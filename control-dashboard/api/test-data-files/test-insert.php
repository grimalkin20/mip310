<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head><title>Contact Form Test</title><style>body{font-family:Arial;margin:20px;}table{border-collapse:collapse;}td,th{border:1px solid #ddd;padding:8px;}th{background:#f2f2f2;}</style></head><body>";

echo "<h2>Contact Form Submission Test</h2>";

// Include database connection
include "connect.php";

if (!$conn) {
    echo "<p style='color:red;'><strong>Error:</strong> Database connection failed</p>";
    echo "</body></html>";
    exit;
}

echo "<p style='color:green;'><strong>Database Connected</strong></p>";

// Simulate form data
$testData = [
    'name' => 'Test User',
    'email' => 'test@example.com',
    'phone' => '+91-1234567890',
    'subject' => 'Test Subject',
    'message' => 'This is a test message'
];

echo "<h3>Test Data Being Submitted:</h3>";
echo "<table>";
foreach ($testData as $key => $value) {
    echo "<tr><th>" . $key . "</th><td>" . htmlspecialchars($value) . "</td></tr>";
}
echo "</table>";

// Prepare SQL statement
$sql = "INSERT INTO contacts (name, email, phone, subject, message, status, created_at, updated_at) 
        VALUES (?, ?, ?, ?, ?, 'new', NOW(), NOW())";

// Prepare and bind
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "<p style='color:red;'><strong>Error:</strong> Prepare failed - " . $conn->error . "</p>";
    echo "</body></html>";
    exit;
}

echo "<p style='color:green;'><strong>Statement prepared successfully</strong></p>";

// Extract values
$name = $testData['name'];
$email = $testData['email'];
$phone = $testData['phone'];
$subject = $testData['subject'];
$message = $testData['message'];

// Bind parameters
if (!$stmt->bind_param("sssss", $name, $email, $phone, $subject, $message)) {
    echo "<p style='color:red;'><strong>Error:</strong> Bind failed - " . $stmt->error . "</p>";
    echo "</body></html>";
    exit;
}

echo "<p style='color:green;'><strong>Parameters bound successfully</strong></p>";

// Execute statement
if ($stmt->execute()) {
    echo "<p style='color:green;'><strong>Success:</strong> Data inserted successfully</p>";
    echo "<p>Insert ID: " . $stmt->insert_id . "</p>";
    
    // Verify the data was inserted
    $verify_sql = "SELECT * FROM contacts WHERE id = " . $stmt->insert_id;
    $verify_result = $conn->query($verify_sql);
    if ($verify_result && $verify_result->num_rows > 0) {
        $row = $verify_result->fetch_assoc();
        echo "<h3>Inserted Data Verification:</h3>";
        echo "<table>";
        foreach ($row as $key => $value) {
            echo "<tr><th>" . $key . "</th><td>" . htmlspecialchars($value) . "</td></tr>";
        }
        echo "</table>";
    }
} else {
    echo "<p style='color:red;'><strong>Error:</strong> Execute failed - " . $stmt->error . "</p>";
}

// Close statement and connection
$stmt->close();
$conn->close();

echo "</body></html>";
?>
