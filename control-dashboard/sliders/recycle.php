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
    $sql = "SELECT * FROM sliders_recycle WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $slider = $result->fetch_assoc();
        
        // Restore to main table
        $restore_sql = "INSERT INTO sliders (id, name, image, status, created_at, updated_at) VALUES (?, ?, ?, 'active', NOW(), NOW())";
        $restore_stmt = $conn->prepare($restore_sql);
        $restore_stmt->bind_param("iss", $slider['id'], $slider['name'], $slider['image']);
        
        if ($restore_stmt->execute()) {
            // Delete from recycle bin
            $delete_sql = "DELETE FROM sliders_recycle WHERE id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $id);
            
            if ($delete_stmt->execute()) {
                logActivity($_SESSION['user_id'], 'Restore Slider', "Restored slider: {$slider['name']}");
                $success = "Slider restored successfully!";
            } else {
                $error = "Failed to remove from recycle bin!";
            }
        } else {
            $error = "Failed to restore slider!";
        }
    } else {
        $error = "Slider not found in recycle bin!";
    }
}

// Handle permanent delete action
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $sql = "SELECT * FROM sliders_recycle WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $slider = $result->fetch_assoc();
        
        // Delete image file
        $image_path = "uploads/sliders/" . $slider['image'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        // Delete from recycle bin
        $delete_sql = "DELETE FROM sliders_recycle WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $id);
        
        if ($delete_stmt->execute()) {
            logActivity($_SESSION['user_id'], 'Permanent Delete Slider', "Permanently deleted slider: {$slider['name']}");
            $success = "Slider permanently deleted!";
        } else {
            $error = "Failed to delete slider!";
        }
    } else {
        $error = "Slider not found in recycle bin!";
    }
}

// Get all recycled sliders
$sql = "SELECT *, DATEDIFF(NOW(), deleted_at) as days_in_bin FROM sliders_recycle ORDER BY deleted_at DESC";
$result = $conn->query($sql);
$recycled_sliders = $result->fetch_all(MYSQLI_ASSOC);

logActivity($_SESSION['user_id'], 'View Recycle Bin', 'Viewed slider recycle bin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recycle Bin - Sliders - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo getAssetUrl('css/style.css'); ?>" rel="stylesheet">
</head>
<body data-theme="light">
            <div class="admin-layout">
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/control-dashboard/includes/sidebar.php'; ?>
            <div class="main-content">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/control-dashboard/includes/header.php'; ?>
            <div class="content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-trash me-2"></i>Recycle Bin - Sliders</h2>
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
                        <h5 class="mb-0"><i class="fas fa-trash me-2"></i>Deleted Sliders</h5>
                        <small class="text-muted">Items are automatically deleted after 10 days</small>
                    </div>
                    <div class="card-body">
                        <?php if (empty($recycled_sliders)): ?>
                            <div class="text-center py-5">
                                <i class="fas fa-trash fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Recycle bin is empty</h5>
                                <p class="text-muted">No deleted sliders found.</p>
                                <a href="manage.php" class="btn btn-primary">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Manage
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="50">S.No</th>
                                            <th width="100">Image</th>
                                            <th>Name</th>
                                            <th width="120">Days Left</th>
                                            <th width="150">Deleted</th>
                                            <th width="200">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recycled_sliders as $index => $slider): ?>
                                            <tr class="<?php echo $slider['days_in_bin'] >= 7 ? 'table-warning' : ''; ?>">
                                                <td><?php echo $index + 1; ?></td>
                                                <td>
                                                    <?php if (file_exists("../uploads/materials/sliders/" . $slider['image'])): ?>
                                                        <img src="<?php echo getUploadUrl('sliders/' . $slider['image']); ?>" 
                                                             alt="<?php echo htmlspecialchars($slider['name']); ?>" 
                                                             class="img-thumbnail" style="width: 60px; height: 40px; object-fit: cover;">
                                                    <?php else: ?>
                                                        <div class="bg-light text-center" style="width: 60px; height: 40px; line-height: 40px;">
                                                            <i class="fas fa-image text-muted"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($slider['name']); ?></strong>
                                                </td>
                                                <td>
                                                    <?php 
                                                    $days_left = 10 - $slider['days_in_bin'];
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
                                                        <?php echo formatDate($slider['deleted_at']); ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="?restore=<?php echo $slider['id']; ?>" 
                                                           class="btn btn-sm btn-outline-success" 
                                                           title="Restore"
                                                           onclick="return confirm('Are you sure you want to restore this slider?')">
                                                            <i class="fas fa-undo"></i>
                                                        </a>
                                                        <a href="?delete=<?php echo $slider['id']; ?>" 
                                                           class="btn btn-sm btn-outline-danger" 
                                                           title="Permanently Delete"
                                                           onclick="return confirm('Are you sure you want to permanently delete this slider? This action cannot be undone.')">
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