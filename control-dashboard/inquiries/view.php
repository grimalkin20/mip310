<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

requireLogin();

$inquiry = null;

// Get inquiry ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int)$_GET['id'];

// Get inquiry data
$sql = "SELECT * FROM inquiries WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows != 1) {
    header("Location: index.php");
    exit();
}

$inquiry = $result->fetch_assoc();

// Mark as read if unread
if ($inquiry['status'] == 'unread') {
    $update_sql = "UPDATE inquiries SET status = 'read' WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("i", $id);
    $update_stmt->execute();
    $inquiry['status'] = 'read';
}

logActivity($_SESSION['user_id'], 'View Inquiry', "Viewed inquiry from: {$inquiry['name']}");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Inquiry - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo getAssetUrl('css/style.css'); ?>" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            .card { border: none !important; box-shadow: none !important; }
            body { background: white !important; }
        }
        .print-only { display: none; }
    </style>
</head>
<body data-theme="light">
    <div class="admin-layout">
        <?php include '../includes/sidebar.php'; ?>
        <div class="main-content">
            <?php include '../includes/header.php'; ?>
            <div class="content">
                <div class="d-flex justify-content-between align-items-center mb-4 no-print">
                    <h2><i class="fas fa-question-circle me-2"></i>View Inquiry</h2>
                    <div class="btn-group">
                        <button onclick="window.print()" class="btn btn-outline-primary">
                            <i class="fas fa-print me-2"></i>Print Inquiry
                        </button>
                        <a href="mailto:<?php echo htmlspecialchars($inquiry['email']); ?>" class="btn btn-outline-info">
                            <i class="fas fa-reply me-2"></i>Reply
                        </a>
                        <a href="index.php" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to List
                        </a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-question-circle me-2"></i>Inquiry Details
                            </h5>
                            <div class="no-print">
                                <?php 
                                $status_badges = [
                                    'unread' => 'bg-warning',
                                    'read' => 'bg-success'
                                ];
                                $badge_class = $status_badges[$inquiry['status']] ?? 'bg-secondary';
                                ?>
                                <span class="badge <?php echo $badge_class; ?> fs-6">
                                    <?php echo ucfirst($inquiry['status']); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">Contact Information</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="150"><strong>Name:</strong></td>
                                        <td><?php echo htmlspecialchars($inquiry['name']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td>
                                            <a href="mailto:<?php echo htmlspecialchars($inquiry['email']); ?>">
                                                <?php echo htmlspecialchars($inquiry['email']); ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Subject:</strong></td>
                                        <td><?php echo htmlspecialchars($inquiry['subject']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Received:</strong></td>
                                        <td><?php echo formatDate($inquiry['created_at']); ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">Quick Actions</h6>
                                <div class="d-grid gap-2">
                                    <a href="mailto:<?php echo htmlspecialchars($inquiry['email']); ?>" 
                                       class="btn btn-info">
                                        <i class="fas fa-reply me-2"></i>Reply via Email
                                    </a>
                                    <button onclick="window.print()" class="btn btn-primary">
                                        <i class="fas fa-print me-2"></i>Print Inquiry
                                    </button>
                                    <a href="index.php" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Back to List
                                    </a>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">Message</h6>
                                <div class="alert alert-light">
                                    <?php echo nl2br(htmlspecialchars($inquiry['message'])); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4 no-print">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <a href="index.php" class="btn btn-outline-secondary">
                                            <i class="fas fa-arrow-left me-2"></i>Back to List
                                        </a>
                                    </div>
                                    <div class="btn-group">
                                        <a href="mailto:<?php echo htmlspecialchars($inquiry['email']); ?>" class="btn btn-info">
                                            <i class="fas fa-reply me-2"></i>Reply
                                        </a>
                                        <button onclick="window.print()" class="btn btn-primary">
                                            <i class="fas fa-print me-2"></i>Print Inquiry
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Print Header -->
                <div class="print-only">
                    <div class="text-center mb-4">
                        <h3>Inquiry Details</h3>
                        <p class="text-muted">Inquiry ID: <?php echo $inquiry['id']; ?></p>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo getAssetUrl('js/admin.js'); ?>"></script>
</body>
</html> 