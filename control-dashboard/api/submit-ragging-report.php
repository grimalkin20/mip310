<?php
header('Content-Type: application/json');

// Include database configuration
require_once "../config/database.php";
require_once "../includes/functions.php";

// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

try {
    // Get form data
    $report_type = isset($_POST['report_type']) ? sanitizeInput($_POST['report_type']) : 'anti-ragging';
    $recipient = isset($_POST['recipient']) ? sanitizeInput($_POST['recipient']) : '';
    $recipient_phone = isset($_POST['recipient_phone']) ? sanitizeInput($_POST['recipient_phone']) : '';
    $recipient_email = isset($_POST['recipient_email']) ? sanitizeInput($_POST['recipient_email']) : '';
    $message = isset($_POST['message']) ? sanitizeInput($_POST['message']) : '';
    $is_anonymous = isset($_POST['anonymous']) && $_POST['anonymous'] == '1' ? 1 : 0;
    $send_sms = isset($_POST['send_sms']) && $_POST['send_sms'] == 'on' ? 1 : 0;

    // Reporter information (will be NULL if anonymous)
    $reporter_name = $is_anonymous ? null : (isset($_POST['reporter_name']) ? sanitizeInput($_POST['reporter_name']) : null);
    $reporter_phone = $is_anonymous ? null : (isset($_POST['reporter_phone']) ? sanitizeInput($_POST['reporter_phone']) : null);
    $reporter_email = $is_anonymous ? null : (isset($_POST['reporter_email']) ? sanitizeInput($_POST['reporter_email']) : null);

    // Validation
    if (empty($recipient)) {
        throw new Exception('Please select a recipient');
    }

    if (empty($message) || strlen($message) < 10) {
        throw new Exception('Message must be at least 10 characters long');
    }

    // Handle file upload if present
    $attachment_filename = null;
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
        $upload_result = uploadFile($_FILES['attachment'], 'ragging-reports', ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx']);

        if ($upload_result['success']) {
            $attachment_filename = $upload_result['filename'];
        } else {
            throw new Exception('File upload failed: ' . $upload_result['message']);
        }
    }

    // Get client information for security tracking
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? null;
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? null;

    // Insert into database
    $sql = "INSERT INTO ragging_reports 
            (report_type, recipient, recipient_phone, recipient_email, 
             reporter_name, reporter_phone, reporter_email, is_anonymous, 
             message, attachment, send_sms, ip_address, user_agent, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception('Database error: ' . $conn->error);
    }

    $stmt->bind_param(
        "sssssssississs",
        $report_type,
        $recipient,
        $recipient_phone,
        $recipient_email,
        $reporter_name,
        $reporter_phone,
        $reporter_email,
        $is_anonymous,
        $message,
        $attachment_filename,
        $send_sms,
        $ip_address,
        $user_agent
    );

    if ($stmt->execute()) {
        $report_id = $stmt->insert_id;

        // TODO: Send SMS notification if $send_sms is true and SMS gateway is configured
        // TODO: Send email notification to recipient

        echo json_encode([
            'success' => true,
            'message' => 'Your report has been submitted successfully. It will be reviewed by the committee.',
            'report_id' => $report_id
        ]);
    } else {
        throw new Exception('Failed to save report: ' . $stmt->error);
    }

    $stmt->close();

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

$conn->close();
?>