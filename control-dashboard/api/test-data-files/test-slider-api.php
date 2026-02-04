<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Direct database connection - no dependencies
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'mip_panel';

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'data' => [],
        'message' => 'Connection failed: ' . mysqli_connect_error()
    ]);
    exit;
}

mysqli_set_charset($conn, "utf8");

// Check table structure first
$sql_check = "DESCRIBE sliders";
$result_check = mysqli_query($conn, $sql_check);

$fields = [];
if ($result_check) {
    while ($row = mysqli_fetch_assoc($result_check)) {
        $fields[] = $row;
    }
}

// Query sliders - only active sliders, ordered by sort_order
$sql = "SELECT id, name, image, status, sort_order FROM sliders WHERE status = 'active' ORDER BY sort_order ASC, id DESC";
$result = mysqli_query($conn, $sql);

if (!$result) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'data' => [],
        'fields' => $fields,
        'message' => 'Query error: ' . mysqli_error($conn)
    ]);
    mysqli_close($conn);
    exit;
}

$sliders = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $sliders[] = [
            'id' => (int)$row['id'],
            'name' => $row['name'],
            'image' => $row['image'],
            'status' => $row['status'],
            'sort_order' => (int)$row['sort_order'],
            'image_url' => 'control-dashboard/uploads/materials/sliders/' . $row['image']
        ];
    }
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'data' => $sliders,
        'count' => count($sliders)
    ]);
} else {
    http_response_code(200);
    echo json_encode([
        'success' => false,
        'data' => [],
        'message' => 'No sliders found'
    ]);
}

mysqli_close($conn);
?>
