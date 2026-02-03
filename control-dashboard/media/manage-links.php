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
    $sql = "SELECT ml.*, mc.name as category_name FROM media_links ml 
            LEFT JOIN media_categories mc ON ml.category_id = mc.id 
            WHERE ml.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $link = $result->fetch_assoc();

        // Move to recycle bin
        $recycle_sql = "INSERT INTO media_links_recycle (id, category_id, name, link_url, deleted_at) VALUES (?, ?, ?, ?, NOW())";
        $recycle_stmt = $conn->prepare($recycle_sql);
        $recycle_stmt->bind_param("iiss", $id, $link['category_id'], $link['name'], $link['link_url']);

        if ($recycle_stmt->execute()) {
            // Delete from main table
            $delete_sql = "DELETE FROM media_links WHERE id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $id);

            if ($delete_stmt->execute()) {
                logActivity($_SESSION['user_id'], 'Delete Media Link', "Deleted link: {$link['name']}");
                $success = "Media link moved to recycle bin successfully!";
            } else {
                $error = "Failed to delete link!";
            }
        } else {
            $error = "Failed to move link to recycle bin!";
        }
    } else {
        $error = "Link not found!";
    }
}

// Handle status toggle
if (isset($_GET['toggle_status']) && is_numeric($_GET['toggle_status'])) {
    $id = (int)$_GET['toggle_status'];
    $sql = "UPDATE media_links SET status = CASE WHEN status = 'active' THEN 'inactive' ELSE 'active' END WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        logActivity($_SESSION['user_id'], 'Toggle Media Link Status', "Toggled link status");
        $success = "Link status updated successfully!";
    } else {
        $error = "Failed to update link status!";
    }
}

// Get all media links with category names
$sql = "SELECT ml.*, mc.name as category_name FROM media_links ml 
        LEFT JOIN media_categories mc ON ml.category_id = mc.id 
        ORDER BY ml.created_at DESC";
$result = $conn->query($sql);
$links = $result->fetch_all(MYSQLI_ASSOC);

logActivity($_SESSION['user_id'], 'View Media Links', 'Viewed media links management page');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Media Links - Admin Panel</title>
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
                    <h2><i class="fas fa-link me-2"></i>Manage Media Links</h2>
                    <a href="add-link.php" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add New Link
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
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Media Links</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($links)): ?>
                            <div class="text-center py-5">
                                <i class="fas fa-link fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No media links found</h5>
                                <p class="text-muted">Start by adding your first media link.</p>
                                <a href="add-link.php" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Add First Link
                                </a>
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
                                            <th width="120">Status</th>
                                            <th width="150">Created</th>
                                            <th width="200">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($links as $index => $link): ?>
                                            <tr>
                                                <td><?php echo $index + 1; ?></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($link['name']); ?></strong>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info"><?php echo htmlspecialchars($link['category_name']); ?></span>
                                                </td>
                                                <td>
                                                    <a href="<?php echo htmlspecialchars($link['link_url']); ?>" 
                                                       target="_blank" class="text-truncate d-inline-block" 
                                                       style="max-width: 200px;" title="<?php echo htmlspecialchars($link['link_url']); ?>">
                                                        <?php echo htmlspecialchars($link['link_url']); ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php echo getStatusBadge($link['status']); ?>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        <?php echo formatDate($link['created_at']); ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="edit-link.php?id=<?php echo $link['id']; ?>" 
                                                           class="btn btn-sm btn-outline-primary" 
                                                           title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="<?php echo htmlspecialchars($link['link_url']); ?>" 
                                                           class="btn btn-sm btn-outline-info" 
                                                           title="View"
                                                           target="_blank">
                                                            <i class="fas fa-external-link-alt"></i>
                                                        </a>
                                                        <a href="?toggle_status=<?php echo $link['id']; ?>" 
                                                           class="btn btn-sm btn-outline-warning" 
                                                           title="<?php echo $link['status'] == 'active' ? 'Deactivate' : 'Activate'; ?>"
                                                           onclick="return confirm('Are you sure you want to <?php echo $link['status'] == 'active' ? 'deactivate' : 'activate'; ?> this link?')">
                                                            <i class="fas fa-<?php echo $link['status'] == 'active' ? 'eye-slash' : 'eye'; ?>"></i>
                                                        </a>
                                                        <a href="?delete=<?php echo $link['id']; ?>" 
                                                           class="btn btn-sm btn-outline-danger" 
                                                           title="Delete"
                                                           onclick="return confirm('Are you sure you want to delete this link? It will be moved to recycle bin.')">
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