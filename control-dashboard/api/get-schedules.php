<?php
header('Content-Type: application/json');

require_once "../config/database.php";

$sql = "SELECT * FROM exam_schedules WHERE status = 'active' ORDER BY created_at DESC";
$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(['success' => false, 'data' => [], 'message' => 'Query error: ' . $conn->error]);
    exit;
}

$schedules = [];
while ($row = $result->fetch_assoc()) {
    $schedules[] = [
        'id'        => (int) $row['id'],
        'course'    => $row['course'],
        'session'   => $row['session'],
        'semester'  => $row['semester'],
        'exam_type' => $row['exam_type'],
        'file_path' => $row['file_path']
    ];
}

echo json_encode(['success' => true, 'data' => $schedules, 'count' => count($schedules)]);
?>
