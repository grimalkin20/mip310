<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $course = isset($_POST['course']) ? $_POST['course'] : '';
    $year = isset($_POST['year']) ? $_POST['year'] : '';
    $semester = isset($_POST['semester']) ? $_POST['semester'] : '';
    $result_type = isset($_POST['result_type']) ? $_POST['result_type'] : '';

    if ($id <= 0 || empty($course) || empty($year) || empty($semester) || empty($result_type)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }

    try {
        // If a new file is uploaded
        if (isset($_FILES['result_file']) && $_FILES['result_file']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['result_file'];
            $allowed_types = ['application/pdf'];

            if (!in_array($file['type'], $allowed_types)) {
                echo json_encode(['success' => false, 'message' => 'Only PDF files are allowed']);
                exit;
            }

            if ($file['size'] > 10 * 1024 * 1024) {
                echo json_encode(['success' => false, 'message' => 'File size exceeds 10MB limit']);
                exit;
            }

            // Get old file path to delete it
            $stmt = $conn->prepare("SELECT file_path FROM results WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($row = $res->fetch_assoc()) {
                $old_file = str_replace('control-dashboard/', '../', $row['file_path']);
                if (file_exists($old_file)) {
                    unlink($old_file);
                }
            }
            $stmt->close();

            // Upload new file
            $upload_dir = '../uploads/materials/results/';
            $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $new_filename = strtolower(str_replace([' ', '.'], '-', $course)) . '-' . $year . '-' . strtolower(str_replace(' ', '-', $semester)) . '-' . time() . '.' . $file_extension;
            $target_path = $upload_dir . $new_filename;
            $db_file_path = 'control-dashboard/uploads/materials/results/' . $new_filename;

            if (move_uploaded_file($file['tmp_name'], $target_path)) {
                $stmt = $conn->prepare("UPDATE results SET course=?, year=?, semester=?, result_type=?, file_path=? WHERE id=?");
                $stmt->bind_param("sssssi", $course, $year, $semester, $result_type, $db_file_path, $id);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file']);
                exit;
            }
        } else {
            // Update without changing file
            $stmt = $conn->prepare("UPDATE results SET course=?, year=?, semester=?, result_type=? WHERE id=?");
            $stmt->bind_param("ssssi", $course, $year, $semester, $result_type, $id);
        }

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Result updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
        }
        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>