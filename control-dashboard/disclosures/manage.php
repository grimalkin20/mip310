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
    $sql = "SELECT * FROM disclosures WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $disclosure = $result->fetch_assoc();
        
        // Move to recycle bin
        $recycle_sql = "INSERT INTO disclosures_recycle (id, name, file_path, deleted_at) VALUES (?, ?, ?, NOW())";
        $recycle_stmt = $conn->prepare($recycle_sql);
        $recycle_stmt->bind_param("iss", $id, $disclosure['name'], $disclosure['file_path']);
        
        if ($recycle_stmt->execute()) {
            // Delete from main table
            $delete_sql = "DELETE FROM disclosures WHERE id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $id);
            
            if ($delete_stmt->execute()) {
                logActivity($_SESSION['user_id'], 'Delete Disclosure', "Deleted disclosure: {$disclosure['name']}");
                $success = "Disclosure moved to recycle bin successfully!";
            } else {
                $error = "Failed to delete disclosure!";
            }
        } else {
            $error = "Failed to move disclosure to recycle bin!";
        }
    } else {
        $error = "Disclosure not found!";
    }
}

// Handle status toggle
if (isset($_GET['toggle_status']) && is_numeric($_GET['toggle_status'])) {
    $id = (int)$_GET['toggle_status'];
    $sql = "UPDATE disclosures SET status = CASE WHEN status = 'active' THEN 'inactive' ELSE 'active' END WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        logActivity($_SESSION['user_id'], 'Toggle Disclosure Status', "Toggled disclosure status");
        $success = "Disclosure status updated successfully!";
    } else {
        $error = "Failed to update disclosure status!";
    }
}

// Get all disclosures
$sql = "SELECT * FROM disclosures ORDER BY created_at DESC";
$result = $conn->query($sql);
$disclosures = $result->fetch_all(MYSQLI_ASSOC);

logActivity($_SESSION['user_id'], 'View Disclosures', 'Viewed disclosure management page');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Disclosures - Admin Panel</title>
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
                    <h2><i class="fas fa-file-alt me-2"></i>Manage Disclosures</h2>
                    <a href="add.php" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add New Disclosure
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
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Disclosures</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($disclosures)): ?>
                            <div class="text-center py-5">
                                <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No disclosures found</h5>
                                <p class="text-muted">Start by adding your first disclosure file.</p>
                                <a href="add.php" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Add First Disclosure
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="50">S.No</th>
                                            <th width="100">File</th>
                                            <th>Name</th>
                                            <th width="120">Status</th>
                                            <th width="150">Created</th>
                                            <th width="200">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($disclosures as $index => $disclosure): ?>
                                            <tr>
                                                <td><?php echo $index + 1; ?></td>
                                                <td>
                                                    <?php
                                                    $file_ext = strtolower(pathinfo($disclosure['file_path'], PATHINFO_EXTENSION));
                                                    $is_image = in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif']);
                                                    ?>
                                                    <?php if ($is_image): ?>
                                                        <img src="uploads/disclosures/<?php echo $disclosure['file_path']; ?>" 
                                                             alt="<?php echo htmlspecialchars($disclosure['name']); ?>" 
                                                             class="img-thumbnail" style="width: 60px; height: 40px; object-fit: cover;">
                                                    <?php else: ?>
                                                        <div class="bg-light text-center" style="width: 60px; height: 40px; line-height: 40px;">
                                                            <i class="fas fa-file-<?php echo getFileIcon($file_ext); ?> text-primary"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($disclosure['name']); ?></strong>
                                                    <br>
                                                    <small class="text-muted"><?php echo $disclosure['file_path']; ?></small>
                                                </td>
                                                <td>
                                                    <?php echo getStatusBadge($disclosure['status']); ?>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        <?php echo formatDate($disclosure['created_at']); ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="edit.php?id=<?php echo $disclosure['id']; ?>" 
                                                           class="btn btn-sm btn-outline-primary" 
                                                           title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="<?php echo getUploadUrl('disclosures/' . $disclosure['file_path']); ?>" 
                                                           class="btn btn-sm btn-outline-info" 
                                                           title="Download"
                                                           target="_blank">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                        <a href="?toggle_status=<?php echo $disclosure['id']; ?>" 
                                                           class="btn btn-sm btn-outline-warning" 
                                                           title="<?php echo $disclosure['status'] == 'active' ? 'Deactivate' : 'Activate'; ?>"
                                                           onclick="return confirm('Are you sure you want to <?php echo $disclosure['status'] == 'active' ? 'deactivate' : 'activate'; ?> this disclosure?')">
                                                            <i class="fas fa-<?php echo $disclosure['status'] == 'active' ? 'eye-slash' : 'eye'; ?>"></i>
                                                        </a>
                                                        <a href="?delete=<?php echo $disclosure['id']; ?>" 
                                                           class="btn btn-sm btn-outline-danger" 
                                                           title="Delete"
                                                           onclick="return confirm('Are you sure you want to delete this disclosure? It will be moved to recycle bin.')">
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