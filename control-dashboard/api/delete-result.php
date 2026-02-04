<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

// // Check if user is logged in
// if (!isset($_SESSION['user_id'])) {
//     echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
//     exit;
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid result ID']);
        exit;
    }

    try {
        // Get file path first to delete the file
        $stmt = $conn->prepare("SELECT file_path FROM results WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $file_path = $row['file_path'];
            // Adjust path: file_path in DB is 'control-dashboard/uploads/results/...'
            // We need to go from 'control-dashboard/api/' to the file.
            // So relative path from api/ is '../uploads/results/...'
            $relative_file_path = str_replace('control-dashboard/', '../', $file_path);

            // Delete record
            $del_stmt = $conn->prepare("DELETE FROM results WHERE id = ?");
            $del_stmt->bind_param("i", $id);

            if ($del_stmt->execute()) {
                // Delete physical file
                if (!empty($file_path) && file_exists($relative_file_path)) {
                    unlink($relative_file_path);
                }
                echo json_encode(['success' => true, 'message' => 'Result deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete record: ' . $del_stmt->error]);
            }
            $del_stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Result not found']);
        }
        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>