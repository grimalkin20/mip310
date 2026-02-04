<?php
include 'config/database.php';

echo "<!DOCTYPE html><html><head><title>Table Check</title></head><body>";
echo "<h2>Contacts Table Check</h2>";

// Check if table exists
$result = $conn->query("SHOW TABLES LIKE 'contacts'");
if ($result->num_rows > 0) {
    echo "<p style='color:green;'>Contacts table EXISTS</p>";
    
    // Get table structure
    $result = $conn->query("DESCRIBE contacts");
    echo "<h3>Table Structure:</h3>";
    echo "<table border='1' cellpadding='5'><tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
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
    
    // Count records
    $countResult = $conn->query("SELECT COUNT(*) as total FROM contacts");
    $countRow = $countResult->fetch_assoc();
    echo "<p><strong>Total records:</strong> " . $countRow['total'] . "</p>";
    
} else {
    echo "<p style='color:red;'>Contacts table DOES NOT EXIST</p>";
    echo "<p>Please create the table first.</p>";
}

echo "</body></html>";
?>
