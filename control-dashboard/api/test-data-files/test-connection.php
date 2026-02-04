<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Test database connection
include "connect.php";

echo "<!DOCTYPE html><html><head><title>Database Connection Test</title><style>body{font-family:Arial;margin:20px;}</style></head><body>";
echo "<h2>Database Connection Test</h2>";

if (!$conn) {
    echo "<p style='color:red;'><strong>Error:</strong> Database connection failed</p>";
    exit;
}

echo "<p style='color:green;'><strong>Success:</strong> Database connection established</p>";

// Check if contacts table exists and has data
$sql = "SELECT COUNT(*) as total FROM contacts";
$result = $conn->query($sql);

if (!$result) {
    echo "<p style='color:red;'><strong>Error:</strong> " . $conn->error . "</p>";
} else {
    $row = $result->fetch_assoc();
    echo "<p><strong>Total contacts in database:</strong> " . $row['total'] . "</p>";
}

// Show table structure
echo "<h3>Contacts Table Structure:</h3>";
$sql = "DESCRIBE contacts";
$result = $conn->query($sql);

if ($result) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "<td>" . $row['Default'] . "</td>";
        echo "<td>" . $row['Extra'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

echo "</body></html>";
?>
