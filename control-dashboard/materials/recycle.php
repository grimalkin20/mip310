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
    $sql = "SELECT * FROM materials_recycle WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $material = $result->fetch_assoc();

        // Restore to main table
        $restore_sql = "INSERT INTO materials (id, type_id, class_id, section_id, subject_id, name, file, description, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'active', NOW(), NOW())";
        $restore_stmt = $conn->prepare($restore_sql);
        $restore_stmt->bind_param("iiiiisss", $material['original_id'], $material['type_id'], $material['class_id'], $material['section_id'], $material['subject_id'], $material['name'], $material['file_path'], $material['description']);

        if ($restore_stmt->execute()) {
            // Delete from recycle bin
            $delete_sql = "DELETE FROM materials_recycle WHERE id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $id);

            if ($delete_stmt->execute()) {
                logActivity($_SESSION['user_id'], 'Restore Material File', "Restored material: {$material['name']}");
                $success = "Material restored successfully!";
            } else {
                $error = "Failed to remove from recycle bin!";
            }
        } else {
            $error = "Failed to restore material!";
        }
    } else {
        $error = "Material not found in recycle bin!";
    }
}

// Handle permanent delete action
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $sql = "SELECT * FROM materials_recycle WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $material = $result->fetch_assoc();

        // Delete file from storage
        $file_path = "materials/" . $material['file_path'];
        if (file_exists($file_path) && is_file($file_path)) {
            unlink($file_path);
        }

        // Delete from recycle bin
        $delete_sql = "DELETE FROM materials_recycle WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $id);

        if ($delete_stmt->execute()) {
            logActivity($_SESSION['user_id'], 'Permanent Delete Material File', "Permanently deleted material: {$material['name']}");
            $success = "Material permanently deleted!";
        } else {
            $error = "Failed to delete material!";
        }
    } else {
        $error = "Material not found in recycle bin!";
    }
}

// Get all recycled materials with related data
$sql = "SELECT mr.*, mt.name as type_name, c.name as class_name, s.name as section_name, sub.name as subject_name,  DATEDIFF(NOW(), mr.deleted_at) as days_in_bin 
        FROM materials_recycle mr 
        LEFT JOIN material_types mt ON mr.type_id = mt.id 
        LEFT JOIN classes c ON mr.class_id = c.id 
        LEFT JOIN sections s ON mr.section_id = s.id 
        LEFT JOIN subjects sub ON mr.subject_id = sub.id 
        ORDER BY mr.deleted_at DESC";

$result = $conn->query($sql);

if ($result === false) {
    // Query failed — prevent calling fetch_all() on boolean and surface the DB error
    $error = "Database error: " . $conn->error;
    $recycled_materials = [];
} else {
    $recycled_materials = $result->fetch_all(MYSQLI_ASSOC);
}

logActivity($_SESSION['user_id'], 'View Recycle Bin', 'Viewed materials recycle bin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recycle Bin - Materials - Admin Panel</title>
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
                    <h2><i class="fas fa-trash me-2"></i>Recycle Bin - Materials</h2>
                    <a href="manage-files.php" class="btn btn-outline-secondary">
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
                        <h5 class="mb-0"><i class="fas fa-trash me-2"></i>Deleted Material Files</h5>
                        <small class="text-muted">Items are automatically deleted after 10 days</small>
                    </div>
                    <div class="card-body">
                        <?php if (empty($recycled_materials)): ?>
                            <div class="text-center py-5">
                                <i class="fas fa-trash fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Recycle bin is empty</h5>
                                <p class="text-muted">No deleted material files found.</p>
                                <a href="manage-files.php" class="btn btn-primary">
                                    <i class="fas fa-arrow-left me-2"></i>Add First File
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="50">S.No</th>
                                            <th width="50">O.Id</th>
                                            <th>Name</th>
                                            <th width="120">Type</th>
                                            <th width="100">Class</th>
                                            <th width="100">Section</th>
                                            <th width="120">Subject</th>
                                            <th width="100">File</th>
                                            <th width="120">Days Left</th>
                                            <th width="150">Deleted</th>
                                            <th width="200">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recycled_materials as $index => $material): ?>
                                            <tr class="<?php echo $material['days_in_bin'] >= 7 ? 'table-warning' : ''; ?>">
                                                <td><?php echo $index + 1; ?></td>
                                                <td><?php echo htmlspecialchars($material['original_id']); ?></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($material['name']); ?></strong>
                                                    <br>
                                                    <small class="text-muted"><?php echo htmlspecialchars($material['description']); ?></small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info"><?php echo htmlspecialchars($material['type_name']); ?></span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary"><?php echo htmlspecialchars($material['class_name']); ?></span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary"><?php echo htmlspecialchars($material['section_name']); ?></span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary"><?php echo htmlspecialchars($material['subject_name']); ?></span>
                                                </td>
                                                <td>
                                                    
                                                        <a href="materials/<?php echo htmlspecialchars($material['file_path']); ?>" 
                                                           target="_blank" class="btn btn-sm btn-outline-info">
                                                            <i class="<?php echo getFileIcon($material['file_path']); ?>"></i>
                                                            View
                                                        </a>
                                                    
                                                </td>
                                                <td>
                                                    <?php 
                                                    $days_left = 10 - $material['days_in_bin'];
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
                                                        <?php echo formatDate($material['deleted_at']); ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="?restore=<?php echo $material['id']; ?>" 
                                                           class="btn btn-sm btn-outline-success" 
                                                           title="Restore"
                                                           onclick="return confirm('Are you sure you want to restore this material?')">
                                                            <i class="fas fa-undo"></i>
                                                        </a>
                                                        <a href="?delete=<?php echo $material['id']; ?>" 
                                                           class="btn btn-sm btn-outline-danger" 
                                                           title="Permanently Delete"
                                                           onclick="return confirm('Are you sure you want to permanently delete this material? This action cannot be undone.')">
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