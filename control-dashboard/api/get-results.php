<?php
header('Content-Type: application/json');

// Include database configuration
require_once "../config/database.php";

// Set order by year DESC, semester ASC by default for chronological display
$sql = "SELECT * FROM results WHERE status = 'active' ORDER BY year DESC, semester ASC";
$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(['success' => false, 'data' => [], 'message' => 'Query error: ' . $conn->error]);
    exit;
}

$results = [];
while ($row = $result->fetch_assoc()) {
    $results[] = [
        'id' => (int) $row['id'],
        'course' => $row['course'], // D.Pharma, B.Pharma, M.Pharma
        'year' => $row['year'],
        'semester' => $row['semester'],
        'result_type' => $row['result_type'],
        'file_path' => $row['file_path']
    ];
}

echo json_encode(['success' => true, 'data' => $results, 'count' => count($results)]);
?>