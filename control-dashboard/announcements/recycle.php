<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

requireLogin();

$success = '';
$error = '';

// Handle restore action
if (isset($_GET['restore']) && is_numeric($_GET['restore'])) {
    $id = (int)$_GET['restore'];
    $sql = "SELECT * FROM announcements_recycle WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $announcement = $result->fetch_assoc();

        // Restore to main table
        $restore_sql = "INSERT INTO announcements (id, category_id, title, content, status, created_at, updated_at) VALUES (?, ?, ?, ?, 'active', NOW(), NOW())";
        $restore_stmt = $conn->prepare($restore_sql);
        $restore_stmt->bind_param("iiss", $id['id'], $announcement['category_id'], $announcement['title'], $announcement['content']);

        if ($restore_stmt->execute()) {
            // Delete from recycle bin
            $delete_sql = "DELETE FROM announcements_recycle WHERE id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $id);

            if ($delete_stmt->execute()) {
                logActivity($_SESSION['user_id'], 'Restore Announcement', "Restored announcement: {$announcement['title']}");
                $success = "Announcement restored successfully!";
            } else {
                $error = "Failed to remove from recycle bin!";
            }
        } else {
            $error = "Failed to restore announcement!";
        }
    } else {
        $error = "Announcement not found in recycle bin!";
    }
}

// Handle permanent delete action
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $sql = "SELECT * FROM announcements_recycle WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $announcement = $result->fetch_assoc();

        // Delete image file if exists
        if (!empty($announcement['image'])) {
            $image_path = "../uploads/announcements/" . $announcement['image'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        // Delete from recycle bin
        $delete_sql = "DELETE FROM announcements_recycle WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $id);

        if ($delete_stmt->execute()) {
            logActivity($_SESSION['user_id'], 'Permanent Delete Announcement', "Permanently deleted announcement: {$announcement['title']}");
            $success = "Announcement permanently deleted!";
        } else {
            $error = "Failed to delete announcement!";
        }
    } else {
        $error = "Announcement not found in recycle bin!";
    }
}

// Get all recycled announcements with category names
$sql = "SELECT ar.*, ac.name as category_name, DATEDIFF(NOW(), ar.deleted_at) as days_in_bin
        AND od.original_id as original
        FROM announcements_recycle ar 
        LEFT JOIN announcement_categories ac ON ar.category_id = ac.id 
        AND LEFT JOIN announcement_categories ac ON ar.original_id = od.id
        ORDER BY ar.deleted_at DESC";
$result = $conn->query($sql);
$recycled_announcements = $result->fetch_all(MYSQLI_ASSOC);

logActivity($_SESSION['user_id'], 'View Recycle Bin', 'Viewed announcements recycle bin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recycle Bin - Announcements - Admin Panel</title>
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
                    <h2><i class="fas fa-trash me-2"></i>Recycle Bin - Announcements</h2>
                    <a href="manage.php" class="btn btn-outline-secondary">
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
                        <h5 class="mb-0"><i class="fas fa-trash me-2"></i>Deleted Announcements</h5>
                        <small class="text-muted">Items are automatically deleted after 10 days</small>
                    </div>
                    <div class="card-body">
                        <?php if (empty($recycled_announcements)): ?>
                            <div class="text-center py-5">
                                <i class="fas fa-trash fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Recycle bin is empty</h5>
                                <p class="text-muted">No deleted announcements found.</p>
                                <a href="manage.php" class="btn btn-primary">
                                    <i class="fas fa-arrow-left me-2"></i>Add First Announcement
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="50">S.No</th>
                                            <th>Announcement ID</th>
                                            <th>Title</th>
                                            <th width="80">Category</th>
                                            <!-- <th width="100">Image</th> -->
                                            <th width="120">Days Left</th>
                                            <th width="150">Deleted</th>
                                            <th width="200">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recycled_announcements as $index => $announcement): ?>
                                            <tr class="<?php echo $announcement['days_in_bin'] >= 7 ? 'table-warning' : ''; ?>">
                                                <td><?php echo $index + 1; ?></td>
                                                <td><?php echo $announcement['original']; ?></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($announcement['title']); ?></strong>
                                                    <br><small class="text-muted"><?php echo substr(htmlspecialchars($announcement['content']), 0, 100); ?>...</small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info"><?php echo htmlspecialchars($announcement['category_name']); ?></span>
                                                </td>
                                                <!-- <td>
                                                    <?php if ($announcement['image'] && file_exists("../uploads/announcements/" . $announcement['image'])): ?>
                                                        <img src="<?php echo getUploadUrl('announcements/' . $announcement['image']); ?>" 
                                                             alt="Announcement Image" 
                                                             class="img-thumbnail" style="width: 60px; height: 40px; object-fit: cover;">
                                                    <?php else: ?>
                                                        <span class="text-muted">No image</span>
                                                    <?php endif; ?>
                                                </td> -->
                                                <td>
                                                    <?php 
                                                    $days_left = 10 - $announcement['days_in_bin'];
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
                                                        <?php echo formatDate($announcement['deleted_at']); ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="?restore=<?php echo $announcement['id']; ?>" 
                                                           class="btn btn-sm btn-outline-success" 
                                                           title="Restore"
                                                           onclick="return confirm('Are you sure you want to restore this announcement?')">
                                                            <i class="fas fa-undo"></i>
                                                        </a>
                                                        <a href="?delete=<?php echo $announcement['id']; ?>" 
                                                           class="btn btn-sm btn-outline-danger" 
                                                           title="Permanently Delete"
                                                           onclick="return confirm('Are you sure you want to permanently delete this announcement? This action cannot be undone.')">
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