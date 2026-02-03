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
    $sql = "SELECT m.*, mt.name as type_name, c.name as class_name, s.name as section_name, sub.name as subject_name 
            FROM materials m 
            LEFT JOIN material_types mt ON m.type_id = mt.id 
            LEFT JOIN classes c ON m.class_id = c.id 
            LEFT JOIN sections s ON m.section_id = s.id 
            LEFT JOIN subjects sub ON m.subject_id = sub.id 
            WHERE m.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $material = $result->fetch_assoc();

        // Move to recycle bin
        $recycle_sql = "INSERT INTO materials_recycle (original_id, type_id, class_id, section_id, subject_id, name, file_path, description, deleted_at, deleted_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)"; 
        $recycle_stmt = $conn->prepare($recycle_sql);
        $recycle_stmt->bind_param("iiiiisssi", $id, $material['type_id'], $material['class_id'], $material['section_id'], $material['subject_id'], $material['name'], $material['file'], $material['description'], $_SESSION['user_id']);

        if ($recycle_stmt->execute()) {
            // Delete from main table
            $delete_sql = "DELETE FROM materials WHERE id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $id);

            if ($delete_stmt->execute()) {
                logActivity($_SESSION['user_id'], 'Delete Material File', "Deleted material: {$material['name']}");
                $success = "Material moved to recycle bin successfully!";
            } else {
                $error = "Failed to delete material!";
            }
        } else {
            $error = "Failed to move material to recycle bin!";
        }
    } else {
        $error = "Material not found!";
    }
}

// Handle status toggle
if (isset($_GET['toggle_status']) && is_numeric($_GET['toggle_status'])) {
    $id = (int)$_GET['toggle_status'];
    $sql = "UPDATE materials SET status = CASE WHEN status = 'active' THEN 'inactive' ELSE 'active' END WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        logActivity($_SESSION['user_id'], 'Toggle Material Status', "Toggled material status");
        $success = "Material status updated successfully!";
    } else {
        $error = "Failed to update material status!";
    }
}

// Get all materials with related data
$sql = "SELECT m.*, mt.name as type_name, c.name as class_name, s.name as section_name, sub.name as subject_name 
        FROM materials m 
        LEFT JOIN material_types mt ON m.type_id = mt.id 
        LEFT JOIN classes c ON m.class_id = c.id 
        LEFT JOIN sections s ON m.section_id = s.id 
        LEFT JOIN subjects sub ON m.subject_id = sub.id 
        ORDER BY m.created_at DESC";
$result = $conn->query($sql);
$materials = $result->fetch_all(MYSQLI_ASSOC);

logActivity($_SESSION['user_id'], 'View Material Files', 'Viewed material files management page');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Material Files - Admin Panel</title>
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
                    <h2><i class="fas fa-file me-2"></i>Manage Material Files</h2>
                    <a href="add-file.php" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add New File
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
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Material Files</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($materials)): ?>
                            <div class="text-center py-5">
                                <i class="fas fa-file fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No material files found</h5>
                                <p class="text-muted">Start by adding your first material file.</p>
                                <a href="add-file.php" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Add First File
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="50">S.No</th>
                                            <th>Name</th>
                                            <th width="120">Type</th>
                                            <th width="100">Class</th>
                                            <th width="100">Section</th>
                                            <th width="120">Subject</th>
                                            <th width="100">File</th>
                                            <th width="120">Status</th>
                                            <th width="150">Created</th>
                                            <th width="200">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($materials as $index => $material): ?>
                                            <tr>
                                                <td><?php echo $index + 1; ?></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($material['name']); ?></strong>
                                                    <?php if ($material['description']): ?>
                                                        <br><small class="text-muted"><?php echo htmlspecialchars($material['description']); ?></small>
                                                    <?php endif; ?>
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
                                                    <a href="materials/<?php echo htmlspecialchars($material['file']); ?>" 
                                                       target="_blank" class="btn btn-sm btn-outline-info">
                                                        <i class="<?php echo getFileIcon($material['file']); ?>"></i>
                                                        View
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php echo getStatusBadge($material['status']); ?>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        <?php echo formatDate($material['created_at']); ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="edit-file.php?id=<?php echo $material['id']; ?>" 
                                                           class="btn btn-sm btn-outline-primary" 
                                                           title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="?toggle_status=<?php echo $material['id']; ?>" 
                                                           class="btn btn-sm btn-outline-warning" 
                                                           title="<?php echo $material['status'] == 'active' ? 'Deactivate' : 'Activate'; ?>"
                                                           onclick="return confirm('Are you sure you want to <?php echo $material['status'] == 'active' ? 'deactivate' : 'activate'; ?> this material?')">
                                                            <i class="fas fa-<?php echo $material['status'] == 'active' ? 'eye-slash' : 'eye'; ?>"></i>
                                                        </a>
                                                        <a href="?delete=<?php echo $material['id']; ?>" 
                                                           class="btn btn-sm btn-outline-danger" 
                                                           title="Delete"
                                                           onclick="return confirm('Are you sure you want to delete this material? It will be moved to recycle bin.')">
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