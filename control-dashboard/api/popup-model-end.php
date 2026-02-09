<?php
header('Content-Type: application/json');

// Include database configuration
require_once "../config/database.php";

$sql = "SELECT id, category_id, name, image, status, created_at 
        FROM gallery_images 
        WHERE category_id = 2 AND status = 'active' 
        ORDER BY created_at DESC";
$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(['success' => false, 'data' => [], 'message' => 'Query error: ' . $conn->error]);
    exit;
}

$gallery_images = [];
while ($row = $result->fetch_assoc()) {
    $gallery_images[] = [
        'id' => (int) $row['id'],
        'category_id' => (int) $row['category_id'],
        'name' => $row['name'],
        'image' => $row['image'],
        'status' => $row['status'],
        'created_at' => $row['created_at'],
        'image_url' => '/mip310/control-dashboard/uploads/materials/gallery/' . $row['image']
    ];
}

echo json_encode(['success' => true, 'data' => $gallery_images, 'count' => count($gallery_images)]);
?>