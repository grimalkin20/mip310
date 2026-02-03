<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

requireLogin();

$success = '';
$error = '';
$form = null;

// Get form ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int)$_GET['id'];

// Get form data
$sql = "SELECT * FROM admission_forms WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows != 1) {
    header("Location: index.php");
    exit();
}

$form = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject = sanitizeInput($_POST['subject']);
    $message = sanitizeInput($_POST['message']);

    if (empty($subject) || empty($message)) {
        $error = "Subject and message are required!";
    } else {
        // Here you would integrate with your email service
        // For now, we'll just log the activity
        logActivity($_SESSION['user_id'], 'Send Email', "Sent email to: {$form['email']} - Subject: $subject");
        $success = "Email sent successfully! (Note: Email functionality needs to be configured)";
    }
}

logActivity($_SESSION['user_id'], 'Send Email', "Accessed email page for form from: {$form['student_name']}");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Email - Admission Form - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo getAssetUrl('css/style.css'); ?>" rel="stylesheet">
</head>
<body data-theme="light">
    <div class="admin-layout">
        <?php include '../includes/sidebar.php'; ?>
        <div class="main-content">
            <?php include '../includes/header.php'; ?>
            <div class="content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-envelope me-2"></i>Send Email</h2>
                    <a href="view.php?id=<?php echo $form['id']; ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Form
                    </a>
                </div>

                <?php if ($success): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i><?php echo $success; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-envelope me-2"></i>Compose Email</h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="">
                                    <div class="mb-3">
                                        <label for="to" class="form-label">To:</label>
                                        <input type="email" class="form-control" id="to" value="<?php echo htmlspecialchars($form['email']); ?>" readonly>
                                        <div class="form-text">Email address of <?php echo htmlspecialchars($form['parent_name']); ?></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="subject" class="form-label">Subject:</label>
                                        <input type="text" class="form-control" id="subject" name="subject" 
                                               value="<?php echo isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : 'Re: Admission Form - ' . htmlspecialchars($form['student_name']); ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="message" class="form-label">Message:</label>
                                        <textarea class="form-control" id="message" name="message" rows="12" required><?php 
                                        if (isset($_POST['message'])) {
                                            echo htmlspecialchars($_POST['message']);
                                        } else {
                                            echo "Dear " . htmlspecialchars($form['parent_name']) . ",\n\n";
                                            echo "Thank you for submitting the admission form for " . htmlspecialchars($form['student_name']) . ".\n\n";
                                            echo "We have received your application with the following details:\n";
                                            echo "- Student Name: " . htmlspecialchars($form['student_name']) . "\n";
                                            echo "- Class: " . htmlspecialchars($form['class']) . "\n";
                                            echo "- Section: " . htmlspecialchars($form['section']) . "\n";
                                            echo "- Subject: " . htmlspecialchars($form['subject']) . "\n\n";
                                            echo "Our team will review your application and contact you within 3-5 business days.\n\n";
                                            echo "If you have any questions, please don't hesitate to contact us.\n\n";
                                            echo "Best regards,\n";
                                            echo "Admissions Team\n";
                                            echo "School Name";
                                        }
                                        ?></textarea>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <a href="view.php?id=<?php echo $form['id']; ?>" class="btn btn-outline-secondary">
                                            <i class="fas fa-arrow-left me-2"></i>Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-paper-plane me-2"></i>Send Email
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Form Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <small class="text-muted">Student Name</small>
                                    <div><strong><?php echo htmlspecialchars($form['student_name']); ?></strong></div>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Parent Name</small>
                                    <div><strong><?php echo htmlspecialchars($form['parent_name']); ?></strong></div>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Email</small>
                                    <div><a href="mailto:<?php echo htmlspecialchars($form['email']); ?>"><?php echo htmlspecialchars($form['email']); ?></a></div>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Phone</small>
                                    <div><?php echo htmlspecialchars($form['phone']); ?></div>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Class Details</small>
                                    <div>
                                        Class: <?php echo htmlspecialchars($form['class']); ?><br>
                                        Section: <?php echo htmlspecialchars($form['section']); ?><br>
                                        Subject: <?php echo htmlspecialchars($form['subject']); ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Status</small>
                                    <div>
                                        <?php if ($form['status'] == 'pending'): ?>
                                            <span class="badge bg-warning">Pending</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Processed</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Submitted</small>
                                    <div><?php echo formatDate($form['created_at']); ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Email Templates</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="loadTemplate('acknowledgment')">
                                        <i class="fas fa-check me-2"></i>Acknowledgment
                                    </button>
                                    <button type="button" class="btn btn-outline-success btn-sm" onclick="loadTemplate('approval')">
                                        <i class="fas fa-thumbs-up me-2"></i>Approval
                                    </button>
                                    <button type="button" class="btn btn-outline-warning btn-sm" onclick="loadTemplate('pending')">
                                        <i class="fas fa-clock me-2"></i>Pending Review
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="loadTemplate('rejection')">
                                        <i class="fas fa-times me-2"></i>Rejection
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo getAssetUrl('js/admin.js'); ?>"></script>
    <script>
        function loadTemplate(type) {
            const templates = {
                acknowledgment: {
                    subject: 'Admission Form Received - <?php echo htmlspecialchars($form['student_name']); ?>',
                    message: `Dear <?php echo htmlspecialchars($form['parent_name']); ?>,

Thank you for submitting the admission form for <?php echo htmlspecialchars($form['student_name']); ?>.

We have received your application and it is currently under review. Our admissions team will process your application within 3-5 business days.

Application Details:
- Student Name: <?php echo htmlspecialchars($form['student_name']); ?>
- Class: <?php echo htmlspecialchars($form['class']); ?>
- Section: <?php echo htmlspecialchars($form['section']); ?>
- Subject: <?php echo htmlspecialchars($form['subject']); ?>

We will contact you soon with further instructions.

Best regards,
Admissions Team
School Name`
                },
                approval: {
                    subject: 'Admission Approved - <?php echo htmlspecialchars($form['student_name']); ?>',
                    message: `Dear <?php echo htmlspecialchars($form['parent_name']); ?>,

We are pleased to inform you that the admission application for <?php echo htmlspecialchars($form['student_name']); ?> has been approved.

Next Steps:
1. Complete the enrollment process
2. Submit required documents
3. Pay the admission fee
4. Attend orientation (details to follow)

Please contact our office to schedule an appointment for completing the enrollment process.

Best regards,
Admissions Team
School Name`
                },
                pending: {
                    subject: 'Admission Form Under Review - <?php echo htmlspecialchars($form['student_name']); ?>',
                    message: `Dear <?php echo htmlspecialchars($form['parent_name']); ?>,

Your admission application for <?php echo htmlspecialchars($form['student_name']); ?> is currently under review.

We may need additional information or documents to complete the review process. You will be contacted if any additional information is required.

We appreciate your patience and will provide an update within 5-7 business days.

Best regards,
Admissions Team
School Name`
                },
                rejection: {
                    subject: 'Admission Application Update - <?php echo htmlspecialchars($form['student_name']); ?>',
                    message: `Dear <?php echo htmlspecialchars($form['parent_name']); ?>,

Thank you for your interest in our school and for submitting an admission application for <?php echo htmlspecialchars($form['student_name']); ?>.

After careful review of your application, we regret to inform you that we are unable to offer admission at this time. This decision was made based on various factors including availability and program requirements.

We encourage you to consider applying again in the future.

Best regards,
Admissions Team
School Name`
                }
            };

            if (templates[type]) {
                document.getElementById('subject').value = templates[type].subject;
                document.getElementById('message').value = templates[type].message;
            }
        }
    </script>
</body>
</html> 