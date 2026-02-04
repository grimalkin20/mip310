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
    $sql = "SELECT * FROM contacts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $contact = $result->fetch_assoc();

        // Move to recycle bin
        $recycle_sql = "INSERT INTO contacts_recycle (contact_id, name, email, phone, subject, message, status, deleted_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
        $recycle_stmt = $conn->prepare($recycle_sql);
        
        if (!$recycle_stmt) {
            $error = "Prepare failed: " . $conn->error;
        } else {
            // Always bind all parameters - phone can be NULL
            $recycle_stmt->bind_param("issssss", $id, $contact['name'], $contact['email'], $contact['phone'], $contact['subject'], $contact['message'], $contact['status']);

            if ($recycle_stmt->execute()) {
                // Delete from main table
                $delete_sql = "DELETE FROM contacts WHERE id = ?";
                $delete_stmt = $conn->prepare($delete_sql);
                $delete_stmt->bind_param("i", $id);

                if ($delete_stmt->execute()) {
                    logActivity($_SESSION['user_id'], 'Delete Contact', "Deleted contact from: {$contact['name']}");
                    $success = "Contact moved to recycle bin successfully!";
                } else {
                    $error = "Failed to delete contact!";
                }
            } else {
                $error = "Failed to move contact to recycle bin: " . $recycle_stmt->error;
            }
        }
    } else {
        $error = "Contact not found!";
    }
}

// Handle status toggle
if (isset($_GET['toggle_status']) && is_numeric($_GET['toggle_status'])) {
    $id = (int)$_GET['toggle_status'];
    $sql = "UPDATE contacts SET status = CASE WHEN status = 'new' THEN 'read' WHEN status = 'read' THEN 'new' ELSE status END WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        logActivity($_SESSION['user_id'], 'Toggle Contact Status', "Toggled contact status");
        $success = "Contact status updated successfully!";
    } else {
        $error = "Failed to update contact status!";
    }
}

// Get all contacts with pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 20;
$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM contacts ORDER BY created_at DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();
$contacts = $result->fetch_all(MYSQLI_ASSOC);

// Get total count for pagination
$count_sql = "SELECT COUNT(*) as total FROM contacts";
$count_result = $conn->query($count_sql);
$total_contacts = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_contacts / $limit);

// Get status counts
$status_sql = "SELECT status, COUNT(*) as count FROM contacts GROUP BY status";
$status_result = $conn->query($status_sql);
$status_counts = [];
while ($row = $status_result->fetch_assoc()) {
    $status_counts[$row['status']] = $row['count'];
}

logActivity($_SESSION['user_id'], 'View Contacts', 'Viewed contacts management page');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Contacts - Admin Panel</title>
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
                    <h2><i class="fas fa-envelope me-2"></i>Manage Contacts</h2>
                    <div>
                        <span class="badge bg-primary me-2">Total: <?php echo $total_contacts; ?></span>
                        <span class="badge bg-warning me-2">New: <?php echo isset($status_counts['new']) ? $status_counts['new'] : 0; ?></span>
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

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Contact Inquiries</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($contacts)): ?>
                            <div class="text-center py-5">
                                <i class="fas fa-envelope fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No contact inquiries found</h5>
                                <p class="text-muted">Contact inquiries from your website will appear here.</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="50">S.No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Subject</th>
                                            <th width="120">Status</th>
                                            <th width="150">Received</th>
                                            <th width="200">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($contacts as $index => $contact): ?>
                                            <tr class="<?php echo $contact['status'] == 'new' ? 'table-warning' : ''; ?>">
                                                <td><?php echo $offset + $index + 1; ?></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($contact['name']); ?></strong>
                                                </td>
                                                <td>
                                                    <a href="mailto:<?php echo htmlspecialchars($contact['email']); ?>">
                                                        <?php echo htmlspecialchars($contact['email']); ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="tel:<?php echo htmlspecialchars($contact['phone']); ?>">
                                                        <?php echo htmlspecialchars($contact['phone']); ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="text-truncate d-inline-block" style="max-width: 200px;" 
                                                          title="<?php echo htmlspecialchars($contact['subject']); ?>">
                                                        <?php echo htmlspecialchars($contact['subject']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php 
                                                    $status_badges = [
                                                        'new' => 'bg-warning',
                                                        'read' => 'bg-info',
                                                        'replied' => 'bg-success',
                                                        'closed' => 'bg-secondary'
                                                    ];
                                                    $badge_class = $status_badges[$contact['status']] ?? 'bg-secondary';
                                                    ?>
                                                    <span class="badge <?php echo $badge_class; ?>">
                                                        <?php echo ucfirst($contact['status']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        <?php echo formatDate($contact['created_at']); ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="view.php?id=<?php echo $contact['id']; ?>" 
                                                           class="btn btn-sm btn-outline-info" 
                                                           title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <div class="btn-group" role="group">
                                                            <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fas fa-tasks"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li><a class="dropdown-item" href="?toggle_status=<?php echo $contact['id']; ?>">Toggle Status</a></li>
                                                            </ul>
                                                        </div>
                                                        <a href="?delete=<?php echo $contact['id']; ?>" 
                                                           class="btn btn-sm btn-outline-danger" 
                                                           title="Delete"
                                                           onclick="return confirm('Are you sure you want to delete this contact? It will be moved to recycle bin.')">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <?php if ($total_pages > 1): ?>
                                <nav aria-label="Contact pagination">
                                    <ul class="pagination justify-content-center">
                                        <?php if ($page > 1): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                                            </li>
                                        <?php endif; ?>
                                        
                                        <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        
                                        <?php if ($page < $total_pages): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
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