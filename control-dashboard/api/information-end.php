<?php
header('Content-Type: application/json');

// this api endpoint is for all the category inside the announcements table except Updates and Circular, there is already two endpoints for them named and updates.php and circular.php

// Include database configuration
require_once "../config/database.php";

$sql = "SELECT id, category_id, title, content, updated_at FROM announcements WHERE category_id NOT IN (5,6) ORDER BY updated_at DESC";
$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(['success' => false, 'data' => [], 'message' => 'Query error: ' . $conn->error]);
    exit;
}

$announcements = [];
while ($row = $result->fetch_assoc()) {
    $announcements[] = [
        'id' => (int) $row['id'],
        'category_id' => (int) $row['category_id'],
        'title' => $row['title'],
        'content' => $row['content'],
        'updated_at' => $row['updated_at'],
        'day' => date('d', strtotime($row['updated_at'])),
        'month' => date('M', strtotime($row['updated_at']))
    ];
}

echo json_encode(['success' => true, 'data' => $announcements, 'count' => count($announcements)]);
?>