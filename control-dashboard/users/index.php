<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

requireSuperUser();

$success = '';
$error = '';

// Handle delete action
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    
    // Prevent deleting own account
    if ($id == $_SESSION['user_id']) {
        $error = "You cannot delete your own account!";
    } else {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            // Move to recycle bin
            $recycle_sql = "INSERT INTO users_recycle (user_id, username, full_name, email, mobile_number, user_type, deleted_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
            $recycle_stmt = $conn->prepare($recycle_sql);
            $recycle_stmt->bind_param("isssss", $id, $user['username'], $user['full_name'], $user['email'], $user['mobile_number'], $user['user_type']);

            if ($recycle_stmt->execute()) {
                // Delete from main table
                $delete_sql = "DELETE FROM users WHERE id = ?";
                $delete_stmt = $conn->prepare($delete_sql);
                $delete_stmt->bind_param("i", $id);

                if ($delete_stmt->execute()) {
                    logActivity($_SESSION['user_id'], 'Delete User', "Deleted user: {$user['username']}");
                    $success = "User moved to recycle bin successfully!";
                } else {
                    $error = "Failed to delete user!";
                }
            } else {
                $error = "Failed to move user to recycle bin!";
            }
        } else {
            $error = "User not found!";
        }
    }
}

// Handle status toggle
if (isset($_GET['toggle_status']) && is_numeric($_GET['toggle_status'])) {
    $id = (int)$_GET['toggle_status'];
    
    // Prevent deactivating own account
    if ($id == $_SESSION['user_id']) {
        $error = "You cannot deactivate your own account!";
    } else {
        $sql = "UPDATE users SET status = CASE WHEN status = 'active' THEN 'inactive' ELSE 'active' END WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            logActivity($_SESSION['user_id'], 'Toggle User Status', "Toggled user status");
            $success = "User status updated successfully!";
        } else {
            $error = "Failed to update user status!";
        }
    }
}

// Get all users
$sql = "SELECT * FROM users ORDER BY created_at DESC";
$result = $conn->query($sql);
$users = $result->fetch_all(MYSQLI_ASSOC);

logActivity($_SESSION['user_id'], 'View Users', 'Viewed users management page');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin Panel</title>
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
                    <h2><i class="fas fa-users me-2"></i>Manage Users</h2>
                    <a href="add.php" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add New User
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
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Users</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($users)): ?>
                            <div class="text-center py-5">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No users found</h5>
                                <p class="text-muted">Start by adding your first user.</p>
                                <a href="add.php" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Add First User
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="50">S.No</th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th width="120">User Type</th>
                                            <th width="120">Status</th>
                                            <th width="150">Last Login</th>
                                            <th width="200">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $index => $user): ?>
                                            <tr class="<?php echo $user['id'] == $_SESSION['user_id'] ? 'table-primary' : ''; ?>">
                                                <td><?php echo $index + 1; ?></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($user['full_name']); ?></strong>
                                                    <?php if ($user['id'] == $_SESSION['user_id']): ?>
                                                        <span class="badge bg-primary ms-2">You</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <code><?php echo htmlspecialchars($user['username']); ?></code>
                                                </td>
                                                <td>
                                                    <a href="mailto:<?php echo htmlspecialchars($user['email']); ?>">
                                                        <?php echo htmlspecialchars($user['email']); ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php 
                                                    $type_badges = [
                                                        'super_user' => 'bg-danger',
                                                        'admin' => 'bg-warning',
                                                        'user' => 'bg-info'
                                                    ];
                                                    $badge_class = $type_badges[$user['user_type']] ?? 'bg-secondary';
                                                    ?>
                                                    <span class="badge <?php echo $badge_class; ?>">
                                                        <?php echo ucfirst(str_replace('_', ' ', $user['user_type'])); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php echo getStatusBadge($user['status']); ?>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        <?php echo $user['last_login'] ? formatDate($user['last_login']) : 'Never'; ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="edit.php?id=<?php echo $user['id']; ?>" 
                                                           class="btn btn-sm btn-outline-primary" 
                                                           title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="change-password.php?id=<?php echo $user['id']; ?>" 
                                                           class="btn btn-sm btn-outline-warning" 
                                                           title="Change Password">
                                                            <i class="fas fa-key"></i>
                                                        </a>
                                                        <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                                            <a href="?toggle_status=<?php echo $user['id']; ?>" 
                                                               class="btn btn-sm btn-outline-secondary" 
                                                               title="<?php echo $user['status'] == 'active' ? 'Deactivate' : 'Activate'; ?>"
                                                               onclick="return confirm('Are you sure you want to <?php echo $user['status'] == 'active' ? 'deactivate' : 'activate'; ?> this user?')">
                                                                <i class="fas fa-<?php echo $user['status'] == 'active' ? 'user-slash' : 'user-check'; ?>"></i>
                                                            </a>
                                                            <a href="?delete=<?php echo $user['id']; ?>" 
                                                               class="btn btn-sm btn-outline-danger" 
                                                               title="Delete"
                                                               onclick="return confirm('Are you sure you want to delete this user? It will be moved to recycle bin.')">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        <?php endif; ?>
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