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
    $include_form = isset($_POST['include_form']);

    if (empty($subject)) {
        $error = "Email subject is required!";
    } elseif (empty($message)) {
        $error = "Email message is required!";
    } else {
        // Generate form PDF content
        $form_content = generateFormPDF($form);
        
        // Send email (placeholder function)
        $email_result = sendEmail($form['email'], $subject, $message, $include_form ? $form_content : null);
        
        if ($email_result['success']) {
            // Update form status to processed
            $update_sql = "UPDATE admission_forms SET status = 'processed' WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("i", $id);
            $update_stmt->execute();
            
            logActivity($_SESSION['user_id'], 'Send Email', "Sent email to: {$form['email']} for form: {$form['student_name']}");
            $success = "Email sent successfully! Form status updated to processed.";
        } else {
            $error = "Failed to send email: " . $email_result['message'];
        }
    }
}

logActivity($_SESSION['user_id'], 'Send Email', "Accessed email page for form: {$form['firstname']} {$form['lastname']}");

// Function to generate form PDF content
function generateFormPDF($form) {
    $content = "
    <html>
    <head>
        <title>Admission Form - {$form['firstname']} {$form['lastname']}</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .header { text-align: center; margin-bottom: 30px; }
            .section { margin-bottom: 20px; }
            .label { font-weight: bold; }
            table { width: 100%; border-collapse: collapse; }
            td { padding: 8px; border-bottom: 1px solid #ddd; }
        </style>
    </head>
    <body>
        <div class='header'>
            <h2>Admission Form</h2>
            <p>Form ID: {$form['id']}</p>
        </div>
        
        <div class='section'>
            <h3>Student Information</h3>
            <table>
                <tr><td class='label'>Student Name:</td><td>{$form['firstname']} {$form['lastname']}</td></tr>
                <tr><td class='label'>Parent Name:</td><td>{$form['fathername']}</td></tr>
                <tr><td class='label'>Email:</td><td>{$form['stdemail']}</td></tr>
                <tr><td class='label'>Mobile:</td><td>{$form['mobilenumber']}</td></tr>
            </table>
        </div>
        
        <div class='section'>
            <h3>Academic Information</h3>
            <table>
                <tr><td class='label'>Program:</td><td>{$form['program']}</td></tr>
                <tr><td class='label'>Category:</td><td>{$form['category']}</td></tr>
                <tr><td class='label'>Degree:</td><td>{$form['degree']}</td></tr>
                <tr><td class='label'>Submitted:</td><td>" . formatDate($form['created_at']) . "</td></tr>
            </table>
        </div>
        
        <div class='section'>
            <h3>Additional Message</h3>
            <p>" . nl2br(htmlspecialchars($form['address'] ?: 'No address information provided.')) . "</p>
        </div>
    </body>
    </html>";
    
    return $content;
}
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
                                <h5 class="mb-0"><i class="fas fa-envelope me-2"></i>Send Email to Applicant</h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="" data-validate>
                                    <div class="mb-3">
                                        <label for="to" class="form-label">To</label>
                                        <input type="email" class="form-control" id="to" value="<?php echo htmlspecialchars($form['stdemail']); ?>" readonly>
                                        <div class="form-text">Email address of the applicant.</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="subject" class="form-label">Subject *</label>
                                        <input type="text" class="form-control" id="subject" name="subject" 
                                               value="<?php echo isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : 'Admission Form Response'; ?>" required>
                                        <div class="form-text">Enter the email subject line.</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="message" class="form-label">Message *</label>
                                        <textarea class="form-control" id="message" name="message" rows="10" required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : "Dear {$form['fathername']},

Thank you for submitting the admission form for {$form['firstname']} {$form['lastname']}.

We have received your application for admission to {$form['program']} with {$form['degree']} as the preferred course.

Our team will review your application and contact you within 3-5 business days with further instructions.

If you have any questions, please don't hesitate to contact us.

Best regards,
School Administration"; ?></textarea>
                                        <div class="form-text">Enter your email message. You can use the pre-filled template or customize it.</div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="include_form" name="include_form" checked>
                                            <label class="form-check-label" for="include_form">
                                                Include admission form as PDF attachment
                                            </label>
                                        </div>
                                        <div class="form-text">The admission form will be attached as a PDF file to the email.</div>
                                    </div>

                                    <hr>

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
                                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Form Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <strong>Student Name:</strong><br>
                                    <?php echo htmlspecialchars($form['firstname'] . ' ' . $form['lastname']); ?>
                                </div>
                                <div class="mb-3">
                                    <strong>Parent Name:</strong><br>
                                    <?php echo htmlspecialchars($form['fathername']); ?>
                                </div>
                                <div class="mb-3">
                                    <strong>Program:</strong><br>
                                    <?php echo htmlspecialchars($form['program']); ?>
                                </div>
                                <div class="mb-3">
                                    <strong>Category:</strong><br>
                                    <?php echo htmlspecialchars($form['category']); ?>
                                </div>
                                <div class="mb-3">
                                    <strong>Category:</strong><br>
                                    <span class="badge bg-info">
                                        <?php echo htmlspecialchars($form['category']); ?>
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <strong>Submitted:</strong><br>
                                    <small class="text-muted">
                                        <?php echo formatDate($form['created_at']); ?>
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Email Tips</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        Use a professional tone
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        Include next steps clearly
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        Provide contact information
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        Attach the form for reference
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo getAssetUrl('js/admin.js'); ?>"></script>
</body>
</html> 