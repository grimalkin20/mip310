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
    
    // Check if category has images
    $check_sql = "SELECT COUNT(*) as count FROM gallery_images WHERE category_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $image_count = $check_result->fetch_assoc()['count'];
    
    if ($image_count > 0) {
        $error = "Cannot delete category. It contains $image_count image(s). Please move or delete the images first.";
    } else {
        $sql = "SELECT * FROM gallery_categories WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $category = $result->fetch_assoc();
            
            // Move to recycle bin
            $recycle_sql = "INSERT INTO gallery_categories_recycle (id,original_id, name, deleted_at) VALUES (?, ?, ?, NOW())";
            $recycle_stmt = $conn->prepare($recycle_sql);
            $recycle_stmt->bind_param("iis", $id, $original_id, $category['name']);
            
            if ($recycle_stmt->execute()) {
                // Delete from main table
                $delete_sql = "DELETE FROM gallery_categories WHERE id = ?";
                $delete_stmt = $conn->prepare($delete_sql);
                $delete_stmt->bind_param("i", $id);
                
                if ($delete_stmt->execute()) {
                    logActivity($_SESSION['user_id'], 'Delete Gallery Category', "Deleted category: {$category['name']}");
                    $success = "Category moved to recycle bin successfully!";
                } else {
                    $error = "Failed to delete category!";
                }
            } else {
                $error = "Failed to move category to recycle bin!";
            }
        } else {
            $error = "Category not found!";
        }
    }
}

// Get all categories with image count
$sql = "SELECT gc.*, COUNT(gi.id) as image_count 
        FROM gallery_categories gc 
        LEFT JOIN gallery_images gi ON gc.id = gi.category_id 
        GROUP BY gc.id 
        ORDER BY gc.created_at DESC";
$result = $conn->query($sql);
$categories = $result->fetch_all(MYSQLI_ASSOC);

logActivity($_SESSION['user_id'], 'View Gallery Categories', 'Viewed gallery category management page');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Gallery Categories - Admin Panel</title>
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
                    <h2><i class="fas fa-folder me-2"></i>Manage Gallery Categories</h2>
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
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Gallery Categories</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($categories)): ?>
                            <div class="text-center py-5">
                                <i class="fas fa-folder fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No categories found</h5>
                                <p class="text-muted">Start by adding your first gallery category.</p>
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
                                            <th>Category Name</th>
                                            <th>Description</th>
                                            <th width="120">Images</th>
                                            <th width="150">Created</th>
                                            <th width="150">Actions</th>
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
                                                    <?php if (!empty($category['description'])): ?>
                                                        <?php echo htmlspecialchars($category['description']); ?>
                                                    <?php else: ?>
                                                        <span class="text-muted">No description</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info"><?php echo $category['image_count']; ?> images</span>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        <?php echo formatDate($category['created_at']); ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="add-image.php?category_id=<?php echo $category['id']; ?>" 
                                                           class="btn btn-sm btn-outline-success" 
                                                           title="Add Images">
                                                            <i class="fas fa-plus"></i>
                                                        </a>
                                                        <a href="manage-images.php?category_id=<?php echo $category['id']; ?>" 
                                                           class="btn btn-sm btn-outline-info" 
                                                           title="View Images">
                                                            <i class="fas fa-images"></i>
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