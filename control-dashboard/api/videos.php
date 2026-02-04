<?php
header('Content-Type: application/json');

// Include database configuration
require_once "../config/database.php";

$sql = "SELECT id, category_id, name, link_url, description, status, created_at 
        FROM media_links 
        WHERE status = 'active' 
        ORDER BY created_at DESC";
$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(['success' => false, 'data' => [], 'message' => 'Query error: ' . $conn->error]);
    exit;
}

$videos = [];
while ($row = $result->fetch_assoc()) {
    // Extract YouTube video ID from URL
    $video_id = '';
    $url = $row['link_url'];

    // Handle different YouTube URL formats
    if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $matches)) {
        $video_id = $matches[1];
    } elseif (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $matches)) {
        $video_id = $matches[1];
    } elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $matches)) {
        $video_id = $matches[1];
    }

    $videos[] = [
        'id' => (int) $row['id'],
        'category_id' => (int) $row['category_id'],
        'name' => $row['name'],
        'link_url' => $row['link_url'],
        'description' => $row['description'],
        'status' => $row['status'],
        'created_at' => $row['created_at'],
        'video_id' => $video_id,
        'embed_url' => $video_id ? 'https://www.youtube.com/embed/' . $video_id : '',
        'thumbnail_url' => $video_id ? 'https://img.youtube.com/vi/' . $video_id . '/hqdefault.jpg' : ''
    ];
}

echo json_encode(['success' => true, 'data' => $videos, 'count' => count($videos)]);
?>