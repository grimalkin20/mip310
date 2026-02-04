<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

// Ensure user is logged in
requireLogin();

// Check super user access (keeping this for security as per previous requirement)
if (!isSuperUser()) {
    $_SESSION['error'] = "You do not have permission to access that page.";
    header("Location: ../dashboard.php");
    exit();
}

$success = '';
$error = '';

// Handle delete action
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    
    // Get attachment filename first
    $stmt = $conn->prepare("SELECT attachment FROM ragging_reports WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $report = $result->fetch_assoc();
        
        // Delete record
        $delete_stmt = $conn->prepare("DELETE FROM ragging_reports WHERE id = ?");
        $delete_stmt->bind_param("i", $id);
        
        if ($delete_stmt->execute()) {
            // Delete attachment if exists
            if ($report['attachment']) {
                $file_path = "../uploads/materials/ragging-image/" . $report['attachment'];
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            
            $success = "Report deleted successfully.";
            logActivity($_SESSION['user_id'], 'Delete Ragging Report', "Deleted report #$id");
        } else {
            $error = "Failed to delete report.";
        }
    } else {
        $error = "Report not found.";
    }
}

// Get all reports
$sql = "SELECT * FROM ragging_reports ORDER BY created_at DESC";
$result = $conn->query($sql);
$reports = [];
if ($result) {
    $reports = $result->fetch_all(MYSQLI_ASSOC);
}
// Log activity
logActivity($_SESSION['user_id'], 'View Ragging Reports', 'Viewed ragging reports list');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ragging Reports - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo getAssetUrl('css/style.css'); ?>" rel="stylesheet">
    <style>
        .status-badge {
            font-size: 0.85em;
            padding: 0.35em 0.65em;
            border-radius: 0.25rem;
        }
        .status-pending { background-color: #ffc107; color: #000; }
        .status-reviewed { background-color: #17a2b8; color: #fff; }
        .status-resolved { background-color: #28a745; color: #fff; }
        .status-closed { background-color: #6c757d; color: #fff; }
    </style>
</head>
<body data-theme="light">
    <div class="admin-layout">
        <?php include '../includes/sidebar.php'; ?>
        <div class="main-content">
            <?php include '../includes/header.php'; ?>
            <div class="content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-shield-alt me-2"></i>Ragging Reports</h2>
                    <!-- No "Add New" button as reports come from users -->
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
                        <h5 class="mb-0 text-danger"><i class="fas fa-exclamation-circle me-2"></i>Confidential Reports</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($reports)): ?>
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No reports found</h5>
                                <p class="text-muted">New ragging reports submitted by students will appear here.</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="50">ID</th>
                                            <th width="150">Date</th>
                                            <th>Reporter</th>
                                            <th>Recipient</th>
                                            <th>Message Preview</th>
                                            <th width="100">Status</th>
                                            <th width="100">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($reports as $report): ?>
                                            <tr>
                                                <td>#<?php echo $report['id']; ?></td>
                                                <td>
                                                    <small class="text-muted">
                                                        <?php echo formatDate($report['created_at']); ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <?php if ($report['is_anonymous']): ?>
                                                        <span class="badge bg-secondary"><i class="fas fa-user-secret me-1"></i>Anonymous</span>
                                                    <?php else: ?>
                                                        <div class="fw-bold"><?php echo htmlspecialchars($report['reporter_name']); ?></div>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $report['recipient']))); ?>
                                                </td>
                                                <td style="max-width: 250px;">
                                                    <div class="text-truncate" title="<?php echo htmlspecialchars($report['message']); ?>">
                                                        <?php echo htmlspecialchars($report['message']); ?>
                                                    </div>
                                                    <?php if ($report['attachment']): ?>
                                                        <small class="text-primary"><i class="fas fa-paperclip me-1"></i>Attachment</small>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="status-badge status-<?php echo $report['status']; ?>">
                                                        <?php echo ucfirst($report['status']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="view.php?id=<?php echo $report['id']; ?>" 
                                                           class="btn btn-sm btn-outline-primary" 
                                                           title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="?delete=<?php echo $report['id']; ?>" 
                                                           class="btn btn-sm btn-outline-danger" 
                                                           title="Delete"
                                                           onclick="return confirm('Are you sure you want to delete this report? This action cannot be undone and the attachment will be removed.')">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Pagination or Bottom Links -->
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo getAssetUrl('js/admin.js'); ?>"></script>
</body>
</html>