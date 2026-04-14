<?php
header('Content-Type: application/json');

// this api endpoint is for Update category inside the announcements table 


// Include database configuration
require_once "../config/database.php";

$sql = "SELECT id, category_id, title, content, announce_image, updated_at 
        FROM announcements 
        WHERE category_id = 6 AND status = 'active' 
        ORDER BY updated_at DESC";
$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(['success' => false, 'data' => [], 'message' => 'Query error: ' . $conn->error]);
    exit;
}

$announcements = [];
while ($row = $result->fetch_assoc()) {
    $image = $row['announce_image'] ?? null;

    $announcements[] = [
        'id' => (int) $row['id'],
        'category_id' => (int) $row['category_id'],
        'title' => $row['title'],
        'content' => $row['content'],
        'announce_image' => $image,
        'image_url' => $image ? '/control-dashboard/uploads/materials/announcement/' . $image : null,
        'updated_at' => $row['updated_at'],
        'day' => date('d', strtotime($row['updated_at'])),
        'month' => date('M', strtotime($row['updated_at']))
    ];
}

echo json_encode(['success' => true, 'data' => $announcements, 'count' => count($announcements)]);
?>