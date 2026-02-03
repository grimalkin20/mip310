<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

requireLogin();

$form = null;

// Get form ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int)$_GET['id'];

// Get form data
$sql = "SELECT * FROM admission_forms WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows != 1) {
    header("Location: index.php");
    exit();
}

$form = $result->fetch_assoc();

logActivity($_SESSION['user_id'], 'Print Admission Form', "Printed form from: {$form['student_name']}");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Admission Form - <?php echo htmlspecialchars($form['student_name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; padding: 20px; }
            .print-header { text-align: center; margin-bottom: 30px; }
            .form-section { margin-bottom: 20px; }
            .form-row { margin-bottom: 15px; }
            .form-label { font-weight: bold; }
            .form-value { border-bottom: 1px solid #ccc; padding: 5px 0; }
        }
        .print-header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
        .form-section { margin-bottom: 25px; }
        .form-row { margin-bottom: 15px; }
        .form-label { font-weight: bold; color: #333; }
        .form-value { border-bottom: 1px solid #ccc; padding: 8px 0; min-height: 20px; }
        .status-badge { font-size: 14px; padding: 5px 10px; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Print Header -->
        <div class="print-header">
            <h1><i class="fas fa-graduation-cap me-3"></i>Admission Form</h1>
            <p class="text-muted">School Name - Academic Year 2024-2025</p>
        </div>

        <!-- Form Details -->
        <div class="row">
            <div class="col-12">
                <div class="form-section">
                    <h4><i class="fas fa-user me-2"></i>Student Information</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="form-label">Student Name:</div>
                                <div class="form-value"><?php echo htmlspecialchars($form['student_name']); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="form-label">Parent/Guardian Name:</div>
                                <div class="form-value"><?php echo htmlspecialchars($form['parent_name']); ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h4><i class="fas fa-address-book me-2"></i>Contact Information</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="form-label">Email Address:</div>
                                <div class="form-value"><?php echo htmlspecialchars($form['email']); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="form-label">Phone Number:</div>
                                <div class="form-value"><?php echo htmlspecialchars($form['phone']); ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h4><i class="fas fa-school me-2"></i>Academic Information</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-row">
                                <div class="form-label">Class:</div>
                                <div class="form-value"><?php echo htmlspecialchars($form['class']); ?></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-row">
                                <div class="form-label">Section:</div>
                                <div class="form-value"><?php echo htmlspecialchars($form['section']); ?></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-row">
                                <div class="form-label">Subject:</div>
                                <div class="form-value"><?php echo htmlspecialchars($form['subject']); ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h4><i class="fas fa-comment me-2"></i>Additional Information</h4>
                    <div class="form-row">
                        <div class="form-label">Message:</div>
                        <div class="form-value" style="min-height: 100px; white-space: pre-wrap;">
                            <?php echo nl2br(htmlspecialchars($form['message'] ?: 'No additional message provided.')); ?>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h4><i class="fas fa-info-circle me-2"></i>Form Details</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="form-label">Status:</div>
                                <div class="form-value">
                                    <?php if ($form['status'] == 'pending'): ?>
                                        <span class="badge bg-warning status-badge">Pending</span>
                                    <?php else: ?>
                                        <span class="badge bg-success status-badge">Processed</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="form-label">Submitted:</div>
                                <div class="form-value"><?php echo formatDate($form['created_at']); ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Signature Section -->
                <div class="form-section mt-5">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="form-label">Parent/Guardian Signature:</div>
                                <div class="form-value" style="min-height: 50px; border: 1px dashed #ccc;">
                                    <br><br>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="form-label">Date:</div>
                                <div class="form-value"><?php echo date('d/m/Y'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin Section -->
                <div class="form-section mt-5">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="form-label">Admin Signature:</div>
                                <div class="form-value" style="min-height: 50px; border: 1px dashed #ccc;">
                                    <br><br>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="form-label">Processed Date:</div>
                                <div class="form-value">_________________</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Print Button -->
        <div class="no-print mt-4 text-center">
            <button onclick="window.print()" class="btn btn-primary me-2">
                <i class="fas fa-print me-2"></i>Print Form
            </button>
            <a href="view.php?id=<?php echo $form['id']; ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Form
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 