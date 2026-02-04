<?php
header('Content-Type: application/json');

// Include database configuration
require_once "../config/database.php";

$sql = "SELECT id, name, image, status, sort_order FROM sliders WHERE status = 'active' ORDER BY sort_order ASC, id DESC";
$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(['success' => false, 'data' => [], 'message' => 'Query error: ' . $conn->error]);
    exit;
}

$sliders = [];
while ($row = $result->fetch_assoc()) {
    $sliders[] = [
        'id' => (int)$row['id'],
        'name' => $row['name'],
        'image' => $row['image'],
        'status' => $row['status'],
        'sort_order' => (int)$row['sort_order'],
        'image_url' => '/mip310/control-dashboard/uploads/materials/sliders/' . $row['image']
    ];
}

echo json_encode(['success' => true, 'data' => $sliders, 'count' => count($sliders)]);
?>
