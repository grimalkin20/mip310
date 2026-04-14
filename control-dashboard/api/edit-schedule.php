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
    $id        = isset($_POST['id'])        ? intval($_POST['id'])        : 0;
    $course    = isset($_POST['course'])    ? trim($_POST['course'])      : '';
    $session   = isset($_POST['session'])   ? trim($_POST['session'])     : '';
    $semester  = isset($_POST['semester'])  ? trim($_POST['semester'])    : '';
    $exam_type = isset($_POST['exam_type']) ? trim($_POST['exam_type'])   : '';

    if ($id <= 0 || empty($course) || empty($session) || empty($semester) || empty($exam_type)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }

    try {
        // If a new file is uploaded
        if (isset($_FILES['schedule_file']) && $_FILES['schedule_file']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['schedule_file'];
            $allowed_types = ['application/pdf'];

            if (!in_array($file['type'], $allowed_types)) {
                echo json_encode(['success' => false, 'message' => 'Only PDF files are allowed']);
                exit;
            }

            if ($file['size'] > 10 * 1024 * 1024) {
                echo json_encode(['success' => false, 'message' => 'File size exceeds 10MB limit']);
                exit;
            }

            // Get old file path and delete it
            $stmt = $conn->prepare("SELECT file_path FROM exam_schedules WHERE id = ?");
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
            $upload_dir = '../uploads/materials/schedule/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $new_filename = strtolower(str_replace([' ', '.'], '-', $course))
                . '-' . strtolower(str_replace([' ', '/'], '-', $session))
                . '-' . strtolower(str_replace(' ', '-', $semester))
                . '-' . time() . '.' . $file_extension;
            $target_path   = $upload_dir . $new_filename;
            $db_file_path  = 'control-dashboard/uploads/materials/schedule/' . $new_filename;

            if (move_uploaded_file($file['tmp_name'], $target_path)) {
                $stmt = $conn->prepare(
                    "UPDATE exam_schedules SET course=?, session=?, semester=?, exam_type=?, file_path=? WHERE id=?"
                );
                $stmt->bind_param("sssssi", $course, $session, $semester, $exam_type, $db_file_path, $id);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file']);
                exit;
            }
        } else {
            // Update metadata only, keep existing file
            $stmt = $conn->prepare(
                "UPDATE exam_schedules SET course=?, session=?, semester=?, exam_type=? WHERE id=?"
            );
            $stmt->bind_param("ssssi", $course, $session, $semester, $exam_type, $id);
        }

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Schedule updated successfully']);
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
