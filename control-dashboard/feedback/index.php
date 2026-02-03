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
    $sql = "SELECT * FROM feedback WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $feedback = $result->fetch_assoc();

        // Move to recycle bin
        $recycle_sql = "INSERT INTO feedback_recycle (feedback_id, user_id, name, email, subject, message, deleted_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $recycle_stmt = $conn->prepare($recycle_sql);
        $recycle_stmt->bind_param("iissss", $id, $feedback['user_id'], $feedback['name'], $feedback['email'], $feedback['subject'], $feedback['message']);

        if ($recycle_stmt->execute()) {
            // Delete from main table
            $delete_sql = "DELETE FROM feedback WHERE id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $id);

            if ($delete_stmt->execute()) {
                logActivity($_SESSION['user_id'], 'Delete Feedback', "Deleted feedback from: {$feedback['name']}");
                $success = "Feedback moved to recycle bin successfully!";
            } else {
                $error = "Failed to delete feedback!";
            }
        } else {
            $error = "Failed to move feedback to recycle bin!";
        }
    } else {
        $error = "Feedback not found!";
    }
}

// Handle status toggle
if (isset($_GET['toggle_status']) && is_numeric($_GET['toggle_status'])) {
    $id = (int)$_GET['toggle_status'];
    $sql = "UPDATE feedback SET status = CASE WHEN status = 'pending' THEN 'reviewed' ELSE 'pending' END WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        logActivity($_SESSION['user_id'], 'Toggle Feedback Status', "Toggled feedback status");
        $success = "Feedback status updated successfully!";
    } else {
        $error = "Failed to update feedback status!";
    }
}

// Search functionality
$search = isset($_GET['search']) ? sanitizeInput($_GET['search']) : '';
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';

// Build WHERE clause
$where_conditions = [];
$params = [];
$param_types = '';

if (!empty($search)) {
    $where_conditions[] = "(f.name LIKE ? OR f.email LIKE ? OR f.subject LIKE ? OR f.message LIKE ?)";
    $search_param = "%$search%";
    $params = array_merge($params, [$search_param, $search_param, $search_param, $search_param]);
    $param_types .= 'ssss';
}

if (!empty($status_filter)) {
    $where_conditions[] = "f.status = ?";
    $params[] = $status_filter;
    $param_types .= 's';
}

$where_clause = !empty($where_conditions) ? 'WHERE ' . implode(' AND ', $where_conditions) : '';

// Get all feedback with pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 20;
$offset = ($page - 1) * $limit;

$sql = "SELECT f.*, u.username FROM feedback f 
        LEFT JOIN users u ON f.user_id = u.id 
        $where_clause ORDER BY f.created_at DESC LIMIT ? OFFSET ?";
$params[] = $limit;
$params[] = $offset;
$param_types .= 'ii';

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($param_types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$feedback_list = $result->fetch_all(MYSQLI_ASSOC);

// Get total count for pagination
$count_sql = "SELECT COUNT(*) as total FROM feedback f $where_clause";
$count_stmt = $conn->prepare($count_sql);
if (!empty($where_conditions)) {
    $count_params = array_slice($params, 0, -2); // Remove limit and offset
    $count_param_types = substr($param_types, 0, -2);
    if (!empty($count_params)) {
        $count_stmt->bind_param($count_param_types, ...$count_params);
    }
}
$count_stmt->execute();
$count_result = $count_stmt->get_result();
$total_feedback = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_feedback / $limit);

logActivity($_SESSION['user_id'], 'View Feedback', 'Viewed feedback management page');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Feedback - Admin Panel</title>
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
                    <h2><i class="fas fa-comment me-2"></i>Manage Feedback</h2>
                    <div>
                        <span class="badge bg-primary me-2">Total: <?php echo $total_feedback; ?></span>
                        <a href="recycle.php" class="btn btn-outline-secondary">
                            <i class="fas fa-trash me-2"></i>Recycle Bin
                        </a>
                    </div>
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

                <!-- Search and Filter -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="" class="row g-3">
                            <div class="col-md-4">
                                <label for="search" class="form-label">Search</label>
                                <input type="text" class="form-control" id="search" name="search" 
                                       value="<?php echo htmlspecialchars($search); ?>" 
                                       placeholder="Search by name, email, subject...">
                            </div>
                            <div class="col-md-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">All Status</option>
                                    <option value="pending" <?php echo $status_filter == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="reviewed" <?php echo $status_filter == 'reviewed' ? 'selected' : ''; ?>>Reviewed</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="fas fa-search me-2"></i>Search
                                    </button>
                                    <a href="?" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Clear
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Feedback</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($feedback_list)): ?>
                            <div class="text-center py-5">
                                <i class="fas fa-comment fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No feedback found</h5>
                                <p class="text-muted">Feedback from users will appear here.</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="50">S.No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Subject</th>
                                            <th width="120">User</th>
                                            <th width="120">Status</th>
                                            <th width="150">Submitted</th>
                                            <th width="200">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($feedback_list as $index => $feedback): ?>
                                            <tr class="<?php echo $feedback['status'] == 'pending' ? 'table-warning' : ''; ?>">
                                                <td><?php echo $offset + $index + 1; ?></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($feedback['name']); ?></strong>
                                                </td>
                                                <td>
                                                    <a href="mailto:<?php echo htmlspecialchars($feedback['email']); ?>">
                                                        <?php echo htmlspecialchars($feedback['email']); ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="text-truncate d-inline-block" style="max-width: 200px;" 
                                                          title="<?php echo htmlspecialchars($feedback['subject']); ?>">
                                                        <?php echo htmlspecialchars($feedback['subject']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php if ($feedback['user_id']): ?>
                                                        <span class="badge bg-info"><?php echo htmlspecialchars($feedback['username']); ?></span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary">Guest</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                    $status_badges = [
                                                        'pending' => 'bg-warning',
                                                        'reviewed' => 'bg-success'
                                                    ];
                                                    $badge_class = $status_badges[$feedback['status']] ?? 'bg-secondary';
                                                    ?>
                                                    <span class="badge <?php echo $badge_class; ?>">
                                                        <?php echo ucfirst($feedback['status']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        <?php echo formatDate($feedback['created_at']); ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="view.php?id=<?php echo $feedback['id']; ?>" 
                                                           class="btn btn-sm btn-outline-primary" 
                                                           title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="mailto:<?php echo htmlspecialchars($feedback['email']); ?>" 
                                                           class="btn btn-sm btn-outline-info" 
                                                           title="Reply">
                                                            <i class="fas fa-reply"></i>
                                                        </a>
                                                        <a href="?toggle_status=<?php echo $feedback['id']; ?>" 
                                                           class="btn btn-sm btn-outline-warning" 
                                                           title="<?php echo $feedback['status'] == 'pending' ? 'Mark as Reviewed' : 'Mark as Pending'; ?>"
                                                           onclick="return confirm('Are you sure you want to change the status of this feedback?')">
                                                            <i class="fas fa-<?php echo $feedback['status'] == 'pending' ? 'check' : 'undo'; ?>"></i>
                                                        </a>
                                                        <a href="?delete=<?php echo $feedback['id']; ?>" 
                                                           class="btn btn-sm btn-outline-danger" 
                                                           title="Delete"
                                                           onclick="return confirm('Are you sure you want to delete this feedback? It will be moved to recycle bin.')">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <?php if ($total_pages > 1): ?>
                                <nav aria-label="Page navigation" class="mt-4">
                                    <ul class="pagination justify-content-center">
                                        <?php if ($page > 1): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($status_filter); ?>">
                                                    <i class="fas fa-chevron-left"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                                <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($status_filter); ?>">
                                                    <?php echo $i; ?>
                                                </a>
                                            </li>
                                        <?php endfor; ?>

                                        <?php if ($page < $total_pages): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($status_filter); ?>">
                                                    <i class="fas fa-chevron-right"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            <?php endif; ?>
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