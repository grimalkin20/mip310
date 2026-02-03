<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

requireLogin();

$success = '';
$error = '';
$contact = null;

// Get contact ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int)$_GET['id'];

// Get contact data
$sql = "SELECT * FROM contacts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows != 1) {
    header("Location: index.php");
    exit();
}

$contact = $result->fetch_assoc();

// Mark as read if unread
if ($contact['status'] == 'unread') {
    $update_sql = "UPDATE contacts SET status = 'read' WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("i", $id);
    $update_stmt->execute();
    $contact['status'] = 'read';
}

logActivity($_SESSION['user_id'], 'View Contact', "Viewed contact from: {$contact['name']}");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Contact - Admin Panel</title>
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
                    <h2><i class="fas fa-envelope me-2"></i>View Contact</h2>
                    <a href="index.php" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Contacts
                    </a>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-eye me-2"></i>Contact Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Name</label>
                                    <div class="form-control-plaintext">
                                        <?php echo htmlspecialchars($contact['name']); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Email</label>
                                    <div class="form-control-plaintext">
                                        <a href="mailto:<?php echo htmlspecialchars($contact['email']); ?>">
                                            <?php echo htmlspecialchars($contact['email']); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Subject</label>
                                    <div class="form-control-plaintext">
                                        <?php echo htmlspecialchars($contact['subject']); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Status</label>
                                    <div>
                                        <?php if ($contact['status'] == 'unread'): ?>
                                            <span class="badge bg-warning">Unread</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Read</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Received</label>
                                    <div class="form-control-plaintext">
                                        <?php echo formatDate($contact['created_at']); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">IP Address</label>
                                    <div class="form-control-plaintext">
                                        <code><?php echo htmlspecialchars($contact['ip_address']); ?></code>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Message</label>
                            <div class="form-control-plaintext" style="min-height: 200px; white-space: pre-wrap;">
                                <?php echo nl2br(htmlspecialchars($contact['message'])); ?>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="mailto:<?php echo htmlspecialchars($contact['email']); ?>" 
                                   class="btn btn-primary">
                                    <i class="fas fa-reply me-2"></i>Reply
                                </a>
                                <a href="?id=<?php echo $contact['id']; ?>&toggle_status=1" 
                                   class="btn btn-outline-warning"
                                   onclick="return confirm('Are you sure you want to mark this contact as <?php echo $contact['status'] == 'unread' ? 'read' : 'unread'; ?>?')">
                                    <i class="fas fa-<?php echo $contact['status'] == 'unread' ? 'check' : 'times'; ?> me-2"></i>
                                    Mark as <?php echo $contact['status'] == 'unread' ? 'Read' : 'Unread'; ?>
                                </a>
                            </div>
                            <div>
                                <a href="index.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Back
                                </a>
                                <a href="?id=<?php echo $contact['id']; ?>&delete=1" 
                                   class="btn btn-outline-danger"
                                   onclick="return confirm('Are you sure you want to delete this contact? It will be moved to recycle bin.')">
                                    <i class="fas fa-trash me-2"></i>Delete
                                </a>
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