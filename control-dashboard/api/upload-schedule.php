<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course    = isset($_POST['course'])    ? trim($_POST['course'])    : '';
    $session   = isset($_POST['session'])   ? trim($_POST['session'])   : '';
    $semester  = isset($_POST['semester'])  ? trim($_POST['semester'])  : '';
    $exam_type = isset($_POST['exam_type']) ? trim($_POST['exam_type']) : '';

    // Validation
    if (empty($course) || empty($session) || empty($semester) || empty($exam_type)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }

    if (!isset($_FILES['schedule_file']) || $_FILES['schedule_file']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'message' => 'Schedule file (PDF) is required']);
        exit;
    }

    $file = $_FILES['schedule_file'];
    $allowed_types = ['application/pdf'];
    if (!in_array($file['type'], $allowed_types)) {
        echo json_encode(['success' => false, 'message' => 'Only PDF files are allowed']);
        exit;
    }

    // Max size 10MB
    if ($file['size'] > 10 * 1024 * 1024) {
        echo json_encode(['success' => false, 'message' => 'File size exceeds 10MB limit']);
        exit;
    }

    $upload_dir = '../uploads/materials/schedule/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $new_filename = strtolower(str_replace([' ', '.'], '-', $course))
        . '-' . strtolower(str_replace([' ', '/'], '-', $session))
        . '-' . strtolower(str_replace(' ', '-', $semester))
        . '-' . time() . '.' . $file_extension;
    $target_path = $upload_dir . $new_filename;

    // Path for DB (relative to site root)
    $db_file_path = 'control-dashboard/uploads/materials/schedule/' . $new_filename;

    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        try {
            $stmt = $conn->prepare(
                "INSERT INTO exam_schedules (course, session, semester, exam_type, file_path) VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->bind_param("sssss", $course, $session, $semester, $exam_type, $db_file_path);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Exam schedule uploaded successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
            }
            $stmt->close();
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
