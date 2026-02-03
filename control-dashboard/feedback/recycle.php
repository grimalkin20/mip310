<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

requireSuperUser();

$success = '';
$error = '';

// Handle restore action
if (isset($_GET['restore']) && is_numeric($_GET['restore'])) {
    $id = (int)$_GET['restore'];
    $sql = "SELECT * FROM feedback_recycle WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $feedback = $result->fetch_assoc();

        // Restore to main table
        $restore_sql = "INSERT INTO feedback (feedback_id, user_id, name, email, subject, message, status, created_at) VALUES (?, ?, ?, ?, ?, ?, 'reviewed', NOW())";
        $restore_stmt = $conn->prepare($restore_sql);
        $restore_stmt->bind_param("iissss", $feedback['feedback_id'], $feedback['user_id'], $feedback['name'], $feedback['email'], $feedback['subject'], $feedback['message']);

        if ($restore_stmt->execute()) {
            // Delete from recycle bin
            $delete_sql = "DELETE FROM feedback_recycle WHERE id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $id);

            if ($delete_stmt->execute()) {
                logActivity($_SESSION['user_id'], 'Restore Feedback', "Restored feedback from: {$feedback['name']}");
                $success = "Feedback restored successfully!";
            } else {
                $error = "Failed to remove from recycle bin!";
            }
        } else {
            $error = "Failed to restore feedback!";
        }
    } else {
        $error = "Feedback not found in recycle bin!";
    }
}

// Handle permanent delete action
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $sql = "SELECT * FROM feedback_recycle WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $feedback = $result->fetch_assoc();

        // Delete from recycle bin
        $delete_sql = "DELETE FROM feedback_recycle WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $id);

        if ($delete_stmt->execute()) {
            logActivity($_SESSION['user_id'], 'Permanent Delete Feedback', "Permanently deleted feedback from: {$feedback['name']}");
            $success = "Feedback permanently deleted!";
        } else {
            $error = "Failed to delete feedback!";
        }
    } else {
        $error = "Feedback not found in recycle bin!";
    }
}

// Get all recycled feedback
$sql = "SELECT *, DATEDIFF(NOW(), deleted_at) as days_in_bin FROM feedback_recycle ORDER BY deleted_at DESC";
$result = $conn->query($sql);
$recycled_feedback = $result->fetch_all(MYSQLI_ASSOC);

logActivity($_SESSION['user_id'], 'View Recycle Bin', 'Viewed feedback recycle bin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recycle Bin - Feedback - Admin Panel</title>
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
                    <h2><i class="fas fa-trash me-2"></i>Recycle Bin - Feedback</h2>
                    <a href="index.php" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Manage
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

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-trash me-2"></i>Deleted Feedback</h5>
                        <small class="text-muted">Items are automatically deleted after 10 days</small>
                    </div>
                    <div class="card-body">
                        <?php if (empty($recycled_feedback)): ?>
                            <div class="text-center py-5">
                                <i class="fas fa-trash fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Recycle bin is empty</h5>
                                <p class="text-muted">No deleted feedback found.</p>
                                <a href="index.php" class="btn btn-primary">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Manage
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="50">S.No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Subject</th>
                                            <th width="120">Days Left</th>
                                            <th width="150">Deleted</th>
                                            <th width="200">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recycled_feedback as $index => $feedback): ?>
                                            <tr class="<?php echo $feedback['days_in_bin'] >= 7 ? 'table-warning' : ''; ?>">
                                                <td><?php echo $index + 1; ?></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($feedback['name']); ?></strong>
                                                </td>
                                                <td>
                                                    <a href="mailto:<?php echo htmlspecialchars($feedback['email']); ?>">
                                                        <?php echo htmlspecialchars($feedback['email']); ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="text-truncate d-inline-block" style="max-width: 200px;" 
                                                          title="<?php echo htmlspecialchars($feedback['subject']); ?>">
                                                        <?php echo htmlspecialchars($feedback['subject']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php 
                                                    $days_left = 10 - $feedback['days_in_bin'];
                                                    if ($days_left <= 0): ?>
                                                        <span class="badge bg-danger">Expired</span>
                                                    <?php elseif ($days_left <= 3): ?>
                                                        <span class="badge bg-warning"><?php echo $days_left; ?> days</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-success"><?php echo $days_left; ?> days</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        <?php echo formatDate($feedback['deleted_at']); ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="?restore=<?php echo $feedback['id']; ?>" 
                                                           class="btn btn-sm btn-outline-success" 
                                                           title="Restore"
                                                           onclick="return confirm('Are you sure you want to restore this feedback?')">
                                                            <i class="fas fa-undo"></i>
                                                        </a>
                                                        <a href="?delete=<?php echo $feedback['id']; ?>" 
                                                           class="btn btn-sm btn-outline-danger" 
                                                           title="Permanently Delete"
                                                           onclick="return confirm('Are you sure you want to permanently delete this feedback? This action cannot be undone.')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Note:</strong> Items in the recycle bin are automatically deleted after 10 days. 
                                    Items with less than 3 days remaining are highlighted in yellow.
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo getAssetUrl('js/admin.js'); ?>"></script>
</body>
</html> 