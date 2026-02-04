<?php
header('Content-Type: application/json');
require_once '../connect.php';

$uploadPath = __DIR__ . '/uploads/materials/sliders';

$result = [
    'upload_path' => $uploadPath,
    'exists' => is_dir($uploadPath),
    'writable' => is_writable($uploadPath),
    'files' => [],
    'db_sliders' => []
];

// Check files in directory
if (is_dir($uploadPath)) {
    $files = @scandir($uploadPath);
    if ($files) {
        $result['files'] = array_diff($files, ['.', '..']);
    }
}

// Check database
$sql = "SELECT id, image FROM sliders LIMIT 10";
$dbResult = mysqli_query($conn, $sql);
if ($dbResult && mysqli_num_rows($dbResult) > 0) {
    while ($row = mysqli_fetch_assoc($dbResult)) {
        $result['db_sliders'][] = [
            'id' => $row['id'],
            'image' => $row['image'],
            'file_exists' => file_exists($uploadPath . '/' . $row['image'])
        ];
    }
}

echo json_encode($result, JSON_PRETTY_PRINT);
?>
