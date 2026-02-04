<?php
header('Content-Type: application/json');

echo json_encode([
    'success' => true,
    'test' => 'API is working',
    'timestamp' => date('Y-m-d H:i:s')
]);
?>
