<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

requireLogin();

$success = '';
$error = '';

// Handle delete action
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $sql = "SELECT * FROM media_categories WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $category = $result->fetch_assoc();

        // Check if category has media links
        $check_sql = "SELECT COUNT(*) as count FROM media_links WHERE category_id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("i", $id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        $count = $check_result->fetch_assoc();

        if ($count['count'] > 0) {
            $error = "Cannot delete category. It has {$count['count']} media link(s) associated with it.";
        } else {
            // Move to recycle bin
            $recycle_sql = "INSERT INTO media_categories_recycle (id, name, deleted_at) VALUES (?, ?, NOW())";
            $recycle_stmt = $conn->prepare($recycle_sql);
            $recycle_stmt->bind_param("is", $id, $category['name']);

            if ($recycle_stmt->execute()) {
                // Delete from main table
                $delete_sql = "DELETE FROM media_categories WHERE id = ?";
                $delete_stmt = $conn->prepare($delete_sql);
                $delete_stmt->bind_param("i", $id);

                if ($delete_stmt->execute()) {
                    logActivity($_SESSION['user_id'], 'Delete Media Category', "Deleted category: {$category['name']}");
                    $success = "Category moved to recycle bin successfully!";
                } else {
                    $error = "Failed to delete category!";
                }
            } else {
                $error = "Failed to move category to recycle bin!";
            }
        }
    } else {
        $error = "Category not found!";
    }
}

// Handle status toggle
if (isset($_GET['toggle_status']) && is_numeric($_GET['toggle_status'])) {
    $id = (int)$_GET['toggle_status'];
    $sql = "UPDATE media_categories SET status = CASE WHEN status = 'active' THEN 'inactive' ELSE 'active' END WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        logActivity($_SESSION['user_id'], 'Toggle Media Category Status', "Toggled category status");
        $success = "Category status updated successfully!";
    } else {
        $error = "Failed to update category status!";
    }
}

// Get all media categories
$sql = "SELECT mc.*, COUNT(ml.id) as link_count FROM media_categories mc 
        LEFT JOIN media_links ml ON mc.id = ml.category_id 
        GROUP BY mc.id 
        ORDER BY mc.created_at DESC";
$result = $conn->query($sql);
$categories = $result->fetch_all(MYSQLI_ASSOC);

logActivity($_SESSION['user_id'], 'View Media Categories', 'Viewed media category management page');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Media Categories - Admin Panel</title>
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
                    <h2><i class="fas fa-folder me-2"></i>Manage Media Categories</h2>
                    <a href="add-category.php" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add New Category
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
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Media Categories</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($categories)): ?>
                            <div class="text-center py-5">
                                <i class="fas fa-folder fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No media categories found</h5>
                                <p class="text-muted">Start by adding your first media category.</p>
                                <a href="add-category.php" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Add First Category
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="50">S.No</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th width="120">Links</th>
                                            <th width="120">Status</th>
                                            <th width="150">Created</th>
                                            <th width="200">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($categories as $index => $category): ?>
                                            <tr>
                                                <td><?php echo $index + 1; ?></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($category['name']); ?></strong>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        <?php echo htmlspecialchars($category['description'] ?: 'No description'); ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info"><?php echo $category['link_count']; ?> links</span>
                                                </td>
                                                <td>
                                                    <?php echo getStatusBadge($category['status']); ?>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        <?php echo formatDate($category['created_at']); ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="edit-category.php?id=<?php echo $category['id']; ?>" 
                                                           class="btn btn-sm btn-outline-primary" 
                                                           title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="?toggle_status=<?php echo $category['id']; ?>" 
                                                           class="btn btn-sm btn-outline-warning" 
                                                           title="<?php echo $category['status'] == 'active' ? 'Deactivate' : 'Activate'; ?>"
                                                           onclick="return confirm('Are you sure you want to <?php echo $category['status'] == 'active' ? 'deactivate' : 'activate'; ?> this category?')">
                                                            <i class="fas fa-<?php echo $category['status'] == 'active' ? 'eye-slash' : 'eye'; ?>"></i>
                                                        </a>
                                                        <a href="?delete=<?php echo $category['id']; ?>" 
                                                           class="btn btn-sm btn-outline-danger" 
                                                           title="Delete"
                                                           onclick="return confirm('Are you sure you want to delete this category? It will be moved to recycle bin.')">
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

                <div class="mt-3">
                    <a href="recycle.php" class="btn btn-outline-secondary">
                        <i class="fas fa-trash me-2"></i>View Recycle Bin
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo getAssetUrl('js/admin.js'); ?>"></script>
</body>
</html> 