<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

// Check if user is logged in
if (!isLoggedIn()) {
    header('Location: ../index.php');
    exit();
}

// Only normal users can add feedback
if (isSuperUser()) {
    header('Location: ../dashboard.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$message = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = trim($_POST['subject']);
    $message_text = trim($_POST['message']);
    
    // Validation
    if (empty($subject) || empty($message_text)) {
        $error = 'Subject and message are required.';
    } elseif (strlen($subject) > 255) {
        $error = 'Subject must be less than 255 characters.';
    } elseif (strlen($message_text) > 1000) {
        $error = 'Message must be less than 1000 characters.';
    } else {
        try {
            $stmt ="INSERT INTO feedback (user_id, name, subject, message, status, created_at) VALUES (?, ?, ?, ?, 'pending', NOW())";
            $stmt->execute([
                $user_id,
                $_SESSION['full_name'],
                $subject,
                $message_text
            ]);
            
            $message = 'Feedback submitted successfully! Thank you for your input.';
            
            // Clear form data
            $subject = '';
            $message_text = '';
        } catch (PDOException $e) {
            $error = 'Error submitting feedback. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Feedback - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo getAssetUrl('css/style.css'); ?>" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <?php include '../includes/sidebar.php'; ?>
        
        <div class="main-content">
            <?php include '../includes/header.php'; ?>
            
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-comment me-2"></i>
                                    Submit Feedback
                                </h5>
                            </div>
                            <div class="card-body">
                                <?php if ($message): ?>
                                    <div class="alert alert-success"><?php echo $message; ?></div>
                                <?php endif; ?>
                                
                                <?php if ($error): ?>
                                    <div class="alert alert-danger"><?php echo $error; ?></div>
                                <?php endif; ?>
                                
                                <div class="row">
                                    <div class="col-md-8">
                                        <form method="POST">
                                            <div class="mb-3">
                                                <label for="subject" class="form-label">Subject *</label>
                                                <input type="text" class="form-control" id="subject" name="subject" value="<?php echo htmlspecialchars($subject ?? ''); ?>" required maxlength="255">
                                                <small class="text-muted">Brief description of your feedback</small>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="message" class="form-label">Message *</label>
                                                <textarea class="form-control" id="message" name="message" rows="6" required maxlength="1000"><?php echo htmlspecialchars($message_text ?? ''); ?></textarea>
                                                <small class="text-muted">Please provide detailed feedback (max 1000 characters)</small>
                                            </div>
                                            
                                            <div class="d-flex justify-content-between">
                                                <a href="<?php echo getAdminUrl('dashboard.php'); ?>" class="btn btn-secondary">
                                                    <i class="fas fa-arrow-left me-2"></i>
                                                    Back to Dashboard
                                                </a>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-paper-plane me-2"></i>
                                                    Submit Feedback
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <h6 class="card-title">
                                                    <i class="fas fa-info-circle me-2"></i>
                                                    Feedback Guidelines
                                                </h6>
                                                <ul class="list-unstyled mb-0">
                                                    <li><i class="fas fa-check text-success me-2"></i>Be constructive and specific</li>
                                                    <li><i class="fas fa-check text-success me-2"></i>Include relevant details</li>
                                                    <li><i class="fas fa-check text-success me-2"></i>Suggest improvements when possible</li>
                                                    <li><i class="fas fa-check text-success me-2"></i>Your feedback will be reviewed by administrators</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo getAssetUrl('js/script.js'); ?>"></script>
</body>
</html> 