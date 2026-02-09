<?php
header('Content-Type: application/json');

// Include database configuration
require_once "../config/database.php";

$sql = "SELECT id, category_id, title, content, updated_at FROM announcements WHERE category_id = 3 ORDER BY updated_at DESC LIMIT 10";
$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(['success' => false, 'data' => [], 'message' => 'Query error: ' . $conn->error]);
    exit;
}

$notices = [];
while ($row = $result->fetch_assoc()) {
    $notices[] = [
        'id' => (int)$row['id'],
        'category_id' => (int)$row['category_id'],
        'title' => $row['title'],
        'content' => $row['content'],
        'updated_at' => $row['updated_at'],
        'day' => date('d', strtotime($row['updated_at'])),
        'month' => date('M', strtotime($row['updated_at']))
    ];
}

echo json_encode(['success' => true, 'data' => $notices, 'count' => count($notices)]);
?>
