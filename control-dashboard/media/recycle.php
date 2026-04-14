<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

requireLogin();

$success = '';
$error = '';

// Handle restore action for links
if (isset($_GET['restore_link']) && is_numeric($_GET['restore_link'])) {
    $id = (int)$_GET['restore_link'];
    $sql = "SELECT * FROM media_links_recycle WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $link = $result->fetch_assoc();

        // Restore to main table
        $restore_sql = "INSERT INTO media_links (link_id, category_id, name, link, status, created_at, updated_at) VALUES (?, ?, ?, ?, 'active', NOW(), NOW())";
        $restore_stmt = $conn->prepare($restore_sql);
        $restore_stmt->bind_param("iiss", $link['link_id'], $link['category_id'], $link['name'], $link['link']);

        if ($restore_stmt->execute()) {
            // Delete from recycle bin
            $delete_sql = "DELETE FROM media_links_recycle WHERE id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $id);

            if ($delete_stmt->execute()) {
                logActivity($_SESSION['user_id'], 'Restore Media Link', "Restored link: {$link['name']}");
                $success = "Media link restored successfully!";
            } else {
                $error = "Failed to remove from recycle bin!";
            }
        } else {
            $error = "Failed to restore link!";
        }
    } else {
        $error = "Link not found in recycle bin!";
    }
}

// Handle restore action for categories
if (isset($_GET['restore_category']) && is_numeric($_GET['restore_category'])) {
    $id = (int)$_GET['restore_category'];
    $sql = "SELECT * FROM media_categories_recycle WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $category = $result->fetch_assoc();

        // Restore to main table
        $restore_sql = "INSERT INTO media_categories (category_id, name, description, status, created_at) VALUES (?, ?, ?, 'active', NOW())";
        $restore_stmt = $conn->prepare($restore_sql);
        $restore_stmt->bind_param("iss", $category['category_id'], $category['name'], $category['description']);

        if ($restore_stmt->execute()) {
            // Delete from recycle bin
            $delete_sql = "DELETE FROM media_categories_recycle WHERE id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $id);

            if ($delete_stmt->execute()) {
                logActivity($_SESSION['user_id'], 'Restore Media Category', "Restored category: {$category['name']}");
                $success = "Category restored successfully!";
            } else {
                $error = "Failed to remove from recycle bin!";
            }
        } else {
            $error = "Failed to restore category!";
        }
    } else {
        $error = "Category not found in recycle bin!";
    }
}

// Handle permanent delete action for links
if (isset($_GET['delete_link']) && is_numeric($_GET['delete_link'])) {
    $id = (int)$_GET['delete_link'];
    $sql = "SELECT * FROM media_links_recycle WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $link = $result->fetch_assoc();

        // Delete from recycle bin
        $delete_sql = "DELETE FROM media_links_recycle WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $id);

        if ($delete_stmt->execute()) {
            logActivity($_SESSION['user_id'], 'Permanent Delete Media Link', "Permanently deleted link: {$link['name']}");
            $success = "Media link permanently deleted!";
        } else {
            $error = "Failed to delete link!";
        }
    } else {
        $error = "Link not found in recycle bin!";
    }
}

// Handle permanent delete action for categories
if (isset($_GET['delete_category']) && is_numeric($_GET['delete_category'])) {
    $id = (int)$_GET['delete_category'];
    $sql = "SELECT * FROM media_categories_recycle WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $category = $result->fetch_assoc();

        // Delete from recycle bin
        $delete_sql = "DELETE FROM media_categories_recycle WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $id);

        if ($delete_stmt->execute()) {
            logActivity($_SESSION['user_id'], 'Permanent Delete Media Category', "Permanently deleted category: {$category['name']}");
            $success = "Category permanently deleted!";
        } else {
            $error = "Failed to delete category!";
        }
    } else {
        $error = "Category not found in recycle bin!";
    }
}

// Get all recycled links with category names
$links_sql = "SELECT mlr.*, mcr.name as category_name, DATEDIFF(NOW(), mlr.deleted_at) as days_in_bin 
              FROM media_links_recycle mlr 
              LEFT JOIN media_categories_recycle mcr ON mlr.category_id = mcr.id 
              ORDER BY mlr.deleted_at DESC";
$links_result = $conn->query($links_sql);
if ($links_result === false) {
    $error = "Failed to fetch recycled links: " . $conn->error;
    $recycled_links = [];
} else {
    $recycled_links = $links_result->fetch_all(MYSQLI_ASSOC);
}

// Get all recycled categories
$categories_sql = "SELECT *, DATEDIFF(NOW(), deleted_at) as days_in_bin FROM media_categories_recycle ORDER BY deleted_at DESC";
$categories_result = $conn->query($categories_sql);
$recycled_categories = $categories_result->fetch_all(MYSQLI_ASSOC);

logActivity($_SESSION['user_id'], 'View Recycle Bin', 'Viewed media recycle bin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recycle Bin - Media - Admin Panel</title>
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
                    <h2><i class="fas fa-trash me-2"></i>Recycle Bin - Media</h2>
                    <a href="manage-links.php" class="btn btn-outline-secondary">
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

                <!-- Recycled Links -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-link me-2"></i>Deleted Media Links</h5>
                        <small class="text-muted">Items are automatically deleted after 10 days</small>
                    </div>
                    <div class="card-body">
                        <?php if (empty($recycled_links)): ?>
                            <div class="text-center py-3">
                                <i class="fas fa-link fa-2x text-muted mb-2"></i>
                                <p class="text-muted mb-0">No deleted media links found.</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="50">S.No</th>
                                            <th>Name</th>
                                            <th width="120">Category</th>
                                            <th>Link</th>
                                            <th width="120">Days Left</th>
                                            <th width="150">Deleted</th>
                                            <th width="200">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recycled_links as $index => $link): ?>
                                            <tr class="<?php echo $link['days_in_bin'] >= 7 ? 'table-warning' : ''; ?>">
                                                <td><?php echo $index + 1; ?></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($link['name']); ?></strong>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info"><?php echo htmlspecialchars($link['category_name'] ?: 'Unknown'); ?></span>
                                                </td>
                                                <td>
                                                    <a href="<?php echo htmlspecialchars($link['link_url']); ?>" 
                                                       target="_blank" class="text-truncate d-inline-block" 
                                                       style="max-width: 200px;" title="<?php echo htmlspecialchars($link['link_url']); ?>">
                                                        <?php echo htmlspecialchars($link['link_url']); ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php 
                                                    $days_left = 10 - $link['days_in_bin'];
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
                                                        <?php echo formatDate($link['deleted_at']); ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="?restore_link=<?php echo $link['id']; ?>" 
                                                           class="btn btn-sm btn-outline-success" 
                                                           title="Restore"
                                                           onclick="return confirm('Are you sure you want to restore this link?')">
                                                            <i class="fas fa-undo"></i>
                                                        </a>
                                                        <a href="?delete_link=<?php echo $link['id']; ?>" 
                                                           class="btn btn-sm btn-outline-danger" 
                                                           title="Permanently Delete"
                                                           onclick="return confirm('Are you sure you want to permanently delete this link? This action cannot be undone.')">
                                                            <i class="fas fa-trash-alt"></i>
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

                <!-- Recycled Categories -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-folder me-2"></i>Deleted Media Categories</h5>
                        <small class="text-muted">Items are automatically deleted after 10 days</small>
                    </div>
                    <div class="card-body">
                        <?php if (empty($recycled_categories)): ?>
                            <div class="text-center py-3">
                                <i class="fas fa-folder fa-2x text-muted mb-2"></i>
                                <p class="text-muted mb-0">No deleted media categories found.</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="50">S.No</th>
                                            <th>Name</th>
                                            <th width="120">Days Left</th>
                                            <th width="150">Deleted</th>
                                            <th width="200">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recycled_categories as $index => $category): ?>
                                            <tr class="<?php echo $category['days_in_bin'] >= 7 ? 'table-warning' : ''; ?>">
                                                <td><?php echo $index + 1; ?></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($category['name']); ?></strong>
                                                </td>
                                                <td>
                                                    <?php 
                                                    $days_left = 10 - $category['days_in_bin'];
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
                                                        <?php echo formatDate($category['deleted_at']); ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="?restore_category=<?php echo $category['id']; ?>" 
                                                           class="btn btn-sm btn-outline-success" 
                                                           title="Restore"
                                                           onclick="return confirm('Are you sure you want to restore this category?')">
                                                            <i class="fas fa-undo"></i>
                                                        </a>
                                                        <a href="?delete_category=<?php echo $category['id']; ?>" 
                                                           class="btn btn-sm btn-outline-danger" 
                                                           title="Permanently Delete"
                                                           onclick="return confirm('Are you sure you want to permanently delete this category? This action cannot be undone.')">
                                                            <i class="fas fa-trash-alt"></i>
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
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Note:</strong> Items in the recycle bin are automatically deleted after 10 days. 
                        Items with less than 3 days remaining are highlighted in yellow.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo getAssetUrl('js/admin.js'); ?>"></script>
</body>
</html> 