<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

requireLogin();

// Check super user access
if (!isSuperUser()) {
    $_SESSION['error'] = "You do not have permission to access that page.";
    header("Location: ../dashboard.php");
    exit();
}

$success = '';
$error = '';
$report = null;

// Get report ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int) $_GET['id'];

// Handle form submission (Status Update / Admin Notes)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = sanitizeInput($_POST['status']);
    $admin_notes = sanitizeInput($_POST['admin_notes']);

    $stmt = $conn->prepare("UPDATE ragging_reports SET status = ?, admin_notes = ? WHERE id = ?");
    $stmt->bind_param("ssi", $status, $admin_notes, $id);

    if ($stmt->execute()) {
        $success = "Report updated successfully.";
        logActivity($_SESSION['user_id'], 'Update Ragging Report', "Updated status of report #$id to $status");
    } else {
        $error = "Failed to update report.";
    }
}

// Get report data
$sql = "SELECT * FROM ragging_reports WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows != 1) {
    header("Location: index.php");
    exit();
}

$report = $result->fetch_assoc();

// Auto-mark as reviewed if pending (optional, matches the 'mark as read' logic from sample)
if ($report['status'] == 'pending') {
    // keeping it manual for now as per previous logic, but ready if needed
}

logActivity($_SESSION['user_id'], 'View Ragging Report', "Viewed report #{$report['id']}");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Report - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo getAssetUrl('css/style.css'); ?>" rel="stylesheet">
    <style>
        .status-badge {
            font-size: 0.85em;
            padding: 0.35em 0.65em;
            border-radius: 0.25rem;
        }

        .status-pending {
            background-color: #ffc107;
            color: #000;
        }

        .status-reviewed {
            background-color: #17a2b8;
            color: #fff;
        }

        .status-resolved {
            background-color: #28a745;
            color: #fff;
        }

        .status-closed {
            background-color: #6c757d;
            color: #fff;
        }
    </style>
</head>

<body data-theme="light">
    <div class="admin-layout">
        <?php include '../includes/sidebar.php'; ?>
        <div class="main-content">
            <?php include '../includes/header.php'; ?>
            <div class="content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-file-invoice me-2"></i>View Report</h2>
                    <a href="index.php" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Reports
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

                <div class="card mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Incident Details
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Reporter Details -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">ID</label>
                                    <div class="form-control-plaintext">#<?php echo $report['id']; ?></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Date Submitted</label>
                                    <div class="form-control-plaintext"><?php echo formatDate($report['created_at']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Reporter Name</label>
                                    <div class="form-control-plaintext">
                                        <?php if ($report['is_anonymous']): ?>
                                            <span class="badge bg-secondary"><i
                                                    class="fas fa-user-secret me-1"></i>Anonymous</span>
                                        <?php else: ?>
                                            <?php echo htmlspecialchars($report['reporter_name']); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Reporter Contact</label>
                                    <div class="form-control-plaintext">
                                        <?php if ($report['is_anonymous']): ?>
                                            <span class="text-muted">Hidden</span>
                                        <?php else: ?>
                                            <?php if ($report['reporter_email']): ?>
                                                <div><i class="fas fa-envelope me-1 text-muted"></i> <a
                                                        href="mailto:<?php echo htmlspecialchars($report['reporter_email']); ?>"><?php echo htmlspecialchars($report['reporter_email']); ?></a>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ($report['reporter_phone']): ?>
                                                <div><i class="fas fa-phone me-1 text-muted"></i> <a
                                                        href="tel:<?php echo htmlspecialchars($report['reporter_phone']); ?>"><?php echo htmlspecialchars($report['reporter_phone']); ?></a>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Recipient</label>
                                    <div class="form-control-plaintext">
                                        <?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $report['recipient']))); ?>
                                        <?php if ($report['recipient_email']): ?>
                                            <br><small
                                                class="text-muted"><?php echo htmlspecialchars($report['recipient_email']); ?></small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Current Status</label>
                                    <div>
                                        <span class="status-badge status-<?php echo $report['status']; ?>">
                                            <?php echo ucfirst($report['status']); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Technical Details -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted small">IP Address</label>
                                    <div class="form-control-plaintext small text-muted">
                                        <?php echo htmlspecialchars($report['ip_address'] ?? 'N/A'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted small">User Agent</label>
                                    <div class="form-control-plaintext small text-muted">
                                        <?php echo htmlspecialchars($report['user_agent'] ?? 'N/A'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Message</label>
                            <div class="form-control-plaintext p-3 bg-light rounded" style="white-space: pre-wrap;">
                                <?php echo nl2br(htmlspecialchars($report['message'])); ?>
                            </div>
                        </div>

                        <?php if ($report['attachment']): ?>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Attachment</label>
                                <div class="form-control-plaintext">
                                    <a href="../uploads/materials/ragging-image/<?php echo $report['attachment']; ?>"
                                        class="btn btn-sm btn-outline-primary" target="_blank" download>
                                        <i class="fas fa-download me-2"></i>Download
                                        <?php echo htmlspecialchars($report['attachment']); ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Admin Action Card -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Admin Actions</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="status" class="form-label fw-bold">Update Status</label>
                                        <select name="status" id="status" class="form-select">
                                            <option value="pending" <?php echo $report['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="reviewed" <?php echo $report['status'] === 'reviewed' ? 'selected' : ''; ?>>Reviewed</option>
                                            <option value="resolved" <?php echo $report['status'] === 'resolved' ? 'selected' : ''; ?>>Resolved</option>
                                            <option value="closed" <?php echo $report['status'] === 'closed' ? 'selected' : ''; ?>>Closed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="admin_notes" class="form-label fw-bold">Admin Notes</label>
                                        <textarea name="admin_notes" id="admin_notes" rows="3" class="form-control"
                                            placeholder="Internal notes about this case..."><?php echo htmlspecialchars($report['admin_notes'] ?? ''); ?></textarea>
                                        <div class="form-text">These notes are only visible to admins.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo getAssetUrl('js/admin.js'); ?>"></script>
</body>

</html>