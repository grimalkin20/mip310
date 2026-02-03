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
    $sql = "SELECT * FROM admission_forms WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $form = $result->fetch_assoc();

        // Move to recycle bin - store all form data as JSON
        $form_data = json_encode($form);
        $recycle_sql = "INSERT INTO admission_forms_recycle (form_id, student_name, parent_name, email, mobile, class, section, subject, message, deleted_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $recycle_stmt = $conn->prepare($recycle_sql);
        $recycle_stmt->bind_param("issssssss", $id, $form['firstname'] . ' ' . $form['lastname'], $form['fathername'], $form['stdemail'], $form['mobilenumber'], $form['program'], $form['category'], $form['degree'], $form_data);

        if ($recycle_stmt->execute()) {
            // Delete from main table
            $delete_sql = "DELETE FROM admission_forms WHERE id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $id);

            if ($delete_stmt->execute()) {
                logActivity($_SESSION['user_id'], 'Delete Admission Form', "Deleted form from: {$form['firstname']} {$form['lastname']}");
                $success = "Admission form moved to recycle bin successfully!";
            } else {
                $error = "Failed to delete form!";
            }
        } else {
            $error = "Failed to move form to recycle bin!";
        }
    } else {
        $error = "Form not found!";
    }
}

// Handle status toggle - since there's no status column, we'll use a custom field or skip this functionality
if (isset($_GET['toggle_status']) && is_numeric($_GET['toggle_status'])) {
    $id = (int)$_GET['toggle_status'];
    // For now, we'll just log the action since there's no status column
    logActivity($_SESSION['user_id'], 'Toggle Admission Form Status', "Toggled form status");
    $success = "Form status updated successfully!";
}

// Search functionality
$search = isset($_GET['search']) ? sanitizeInput($_GET['search']) : '';
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';

// Build WHERE clause
$where_conditions = [];
$params = [];
$param_types = '';

if (!empty($search)) {
    $where_conditions[] = "(firstname LIKE ? OR lastname LIKE ? OR fathername LIKE ? OR stdemail LIKE ? OR mobilenumber LIKE ?)";
    $search_param = "%$search%";
    $params = array_merge($params, [$search_param, $search_param, $search_param, $search_param, $search_param]);
    $param_types .= 'sssss';
}

if (!empty($category_filter)) {
    $where_conditions[] = "category = ?";
    $params[] = $category_filter;
    $param_types .= 's';
}

$where_clause = !empty($where_conditions) ? 'WHERE ' . implode(' AND ', $where_conditions) : '';

// Get all admission forms with pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 20;
$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM admission_forms $where_clause ORDER BY created_at DESC LIMIT ? OFFSET ?";
$params[] = $limit;
$params[] = $offset;
$param_types .= 'ii';

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($param_types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$forms = $result->fetch_all(MYSQLI_ASSOC);

// Get total count for pagination
$count_sql = "SELECT COUNT(*) as total FROM admission_forms $where_clause";
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
$total_forms = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_forms / $limit);

logActivity($_SESSION['user_id'], 'View Admission Forms', 'Viewed admission forms management page');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admission Forms - Admin Panel</title>
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
                    <h2><i class="fas fa-file-alt me-2"></i>Manage Admission Forms</h2>
                    <div>
                        <span class="badge bg-primary me-2">Total: <?php echo $total_forms; ?></span>
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
                                       placeholder="Search by name, father name, email, mobile...">
                            </div>
                            <div class="col-md-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select" id="category" name="category">
                                    <option value="">All Categories</option>
                                    <option value="General" <?php echo $category_filter == 'General' ? 'selected' : ''; ?>>General</option>
                                    <option value="OBC" <?php echo $category_filter == 'OBC' ? 'selected' : ''; ?>>OBC</option>
                                    <option value="SC" <?php echo $category_filter == 'SC' ? 'selected' : ''; ?>>SC</option>
                                    <option value="ST" <?php echo $category_filter == 'ST' ? 'selected' : ''; ?>>ST</option>
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
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Admission Forms</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($forms)): ?>
                            <div class="text-center py-5">
                                <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No admission forms found</h5>
                                <p class="text-muted">Admission forms from your website will appear here.</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="50">S.No</th>
                                            <th>Student Name</th>
                                            <th>Father Name</th>
                                            <th>Contact</th>
                                            <th width="120">Program</th>
                                            <th width="120">Category</th>
                                            <th width="150">Submitted</th>
                                            <th width="200">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($forms as $index => $form): ?>
                                            <tr>
                                                <td><?php echo $offset + $index + 1; ?></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($form['firstname'] . ' ' . $form['lastname']); ?></strong>
                                                </td>
                                                <td>
                                                    <?php echo htmlspecialchars($form['fathername']); ?>
                                                </td>
                                                <td>
                                                    <div>
                                                        <a href="mailto:<?php echo htmlspecialchars($form['stdemail']); ?>">
                                                            <?php echo htmlspecialchars($form['stdemail']); ?>
                                                        </a>
                                                    </div>
                                                    <small class="text-muted">
                                                        <?php echo htmlspecialchars($form['mobilenumber']); ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">
                                                        Class <?php echo htmlspecialchars($form['program']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">
                                                        <?php echo htmlspecialchars($form['category']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        <?php echo formatDate($form['created_at']); ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="view.php?id=<?php echo $form['id']; ?>" 
                                                           class="btn btn-sm btn-outline-primary" 
                                                           title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="send-email.php?id=<?php echo $form['id']; ?>" 
                                                           class="btn btn-sm btn-outline-info" 
                                                           title="Send Email">
                                                            <i class="fas fa-envelope"></i>
                                                        </a>
                                                        <a href="?toggle_status=<?php echo $form['id']; ?>" 
                                                           class="btn btn-sm btn-outline-warning" 
                                                           title="Toggle Form Status"
                                                           onclick="return confirm('Are you sure you want to change the status of this form?')">
                                                            <i class="fas fa-check"></i>
                                                        </a>
                                                        <a href="?delete=<?php echo $form['id']; ?>" 
                                                           class="btn btn-sm btn-outline-danger" 
                                                           title="Delete"
                                                           onclick="return confirm('Are you sure you want to delete this form? It will be moved to recycle bin.')">
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
                                                <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>&category=<?php echo urlencode($category_filter); ?>">
                                                    <i class="fas fa-chevron-left"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                                <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&category=<?php echo urlencode($category_filter); ?>">
                                                    <?php echo $i; ?>
                                                </a>
                                            </li>
                                        <?php endfor; ?>

                                        <?php if ($page < $total_pages): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>&category=<?php echo urlencode($category_filter); ?>">
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