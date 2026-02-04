<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

// Check if user is logged in
// if (!isset($_SESSION['user_id'])) {
//     echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
//     exit;
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course = isset($_POST['course']) ? $_POST['course'] : '';
    $year = isset($_POST['year']) ? $_POST['year'] : '';
    $semester = isset($_POST['semester']) ? $_POST['semester'] : '';
    $result_type = isset($_POST['result_type']) ? $_POST['result_type'] : '';

    // Validation
    if (empty($course) || empty($year) || empty($semester) || empty($result_type)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }

    if (!isset($_FILES['result_file']) || $_FILES['result_file']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'message' => 'Result file (PDF) is required']);
        exit;
    }

    $file = $_FILES['result_file'];
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

    $upload_dir = '../uploads/materials/results/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $new_filename = strtolower(str_replace([' ', '.'], '-', $course)) . '-' . $year . '-' . strtolower(str_replace(' ', '-', $semester)) . '-' . time() . '.' . $file_extension;
    $target_path = $upload_dir . $new_filename;

    // Path for DB (relative to site root if possible, or relative to dashboard)
    $db_file_path = 'control-dashboard/uploads/materials/results/' . $new_filename;

    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        try {
            $stmt = $conn->prepare("INSERT INTO results (course, year, semester, result_type, file_path) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $course, $year, $semester, $result_type, $db_file_path);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Result uploaded successfully']);
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