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

logActivity($_SESSION['user_id'], 'View Admission Form', "Viewed form from: {$form['firstname']} {$form['lastname']}");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Admission Form - Admin Panel</title>
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
                    <h2><i class="fas fa-file-alt me-2"></i>View Admission Form</h2>
                    <div class="btn-group">
                        <button onclick="window.print()" class="btn btn-outline-primary">
                            <i class="fas fa-print me-2"></i>Print Form
                        </button>
                        <a href="send-email.php?id=<?php echo $form['id']; ?>" class="btn btn-outline-info">
                            <i class="fas fa-envelope me-2"></i>Send Email
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
                                <i class="fas fa-file-alt me-2"></i>Admission Form Details
                            </h5>
                            <div class="no-print">
                                <span class="badge bg-info fs-6">
                                    <?php echo htmlspecialchars($form['category']); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Basic Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3"><i class="fas fa-user me-2"></i>Basic Information</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="150"><strong>Student Name:</strong></td>
                                        <td><?php echo htmlspecialchars($form['firstname'] . ' ' . $form['lastname']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Category:</strong></td>
                                        <td><span class="badge bg-info"><?php echo htmlspecialchars($form['category']); ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Date of Birth:</strong></td>
                                        <td><?php echo !empty($form['dateofbirth']) ? htmlspecialchars($form['dateofbirth']) : 'Not provided'; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Gender:</strong></td>
                                        <td><?php echo htmlspecialchars($form['gender']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Religion:</strong></td>
                                        <td><?php echo htmlspecialchars($form['religion']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Aadhar Number:</strong></td>
                                        <td><?php echo htmlspecialchars($form['aadhar']); ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3"><i class="fas fa-phone me-2"></i>Contact Information</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="150"><strong>Mobile Number:</strong></td>
                                        <td>
                                            <a href="tel:<?php echo htmlspecialchars($form['mobilenumber']); ?>">
                                                <?php echo htmlspecialchars($form['mobilenumber']); ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td>
                                            <a href="mailto:<?php echo htmlspecialchars($form['stdemail']); ?>">
                                                <?php echo htmlspecialchars($form['stdemail']); ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Program:</strong></td>
                                        <td><?php echo htmlspecialchars($form['program']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Degree:</strong></td>
                                        <td><?php echo htmlspecialchars($form['degree']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Submitted:</strong></td>
                                        <td><?php echo formatDate($form['created_at']); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <hr>

                        <!-- Physical Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3"><i class="fas fa-heartbeat me-2"></i>Physical Information</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="150"><strong>Weight (kg):</strong></td>
                                        <td><?php echo !empty($form['weight']) ? htmlspecialchars($form['weight']) : 'Not provided'; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Height (cm):</strong></td>
                                        <td><?php echo !empty($form['height']) ? htmlspecialchars($form['height']) : 'Not provided'; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Blood Group:</strong></td>
                                        <td><?php echo htmlspecialchars($form['bloodgroup']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Disability:</strong></td>
                                        <td><?php echo !empty($form['disability']) ? htmlspecialchars($form['disability']) : 'None'; ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3"><i class="fas fa-graduation-cap me-2"></i>Previous Academic</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="150"><strong>Previous School:</strong></td>
                                        <td><?php echo htmlspecialchars($form['school']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Previous Class:</strong></td>
                                        <td><?php echo htmlspecialchars($form['preclass']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Qualification:</strong></td>
                                        <td><?php echo !empty($form['qualification']) ? htmlspecialchars($form['qualification']) : 'Not provided'; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Previous Attendance:</strong></td>
                                        <td><?php echo !empty($form['preclassatt']) ? htmlspecialchars($form['preclassatt']) . '%' : 'Not provided'; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <hr>

                        <!-- Father's Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3"><i class="fas fa-male me-2"></i>Father's Information</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="150"><strong>Name:</strong></td>
                                        <td><?php echo htmlspecialchars($form['fathername']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Occupation:</strong></td>
                                        <td><?php echo htmlspecialchars($form['fatheroccupation']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Mobile:</strong></td>
                                        <td>
                                            <a href="tel:<?php echo htmlspecialchars($form['fathernumber']); ?>">
                                                <?php echo htmlspecialchars($form['fathernumber']); ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td>
                                            <a href="mailto:<?php echo htmlspecialchars($form['fatheremail']); ?>">
                                                <?php echo htmlspecialchars($form['fatheremail']); ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Aadhar:</strong></td>
                                        <td><?php echo htmlspecialchars($form['fadnumber']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>PAN:</strong></td>
                                        <td><?php echo htmlspecialchars($form['fpannumber']); ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3"><i class="fas fa-female me-2"></i>Mother's Information</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="150"><strong>Name:</strong></td>
                                        <td><?php echo htmlspecialchars($form['mothername']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Occupation:</strong></td>
                                        <td><?php echo htmlspecialchars($form['motheroccupation']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Mobile:</strong></td>
                                        <td>
                                            <a href="tel:<?php echo htmlspecialchars($form['mothernumber']); ?>">
                                                <?php echo htmlspecialchars($form['mothernumber']); ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td>
                                            <a href="mailto:<?php echo htmlspecialchars($form['motheremail']); ?>">
                                                <?php echo htmlspecialchars($form['motheremail']); ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Aadhar:</strong></td>
                                        <td><?php echo htmlspecialchars($form['madnumber']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>PAN:</strong></td>
                                        <td><?php echo htmlspecialchars($form['mpannumber']); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <hr>

                        <!-- Guardian Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3"><i class="fas fa-user-shield me-2"></i>Guardian Information</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="150"><strong>Name:</strong></td>
                                        <td><?php echo htmlspecialchars($form['guardianname']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Address:</strong></td>
                                        <td><?php echo nl2br(htmlspecialchars($form['guardainaddress'])); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Mobile:</strong></td>
                                        <td>
                                            <a href="tel:<?php echo htmlspecialchars($form['guardainmobile']); ?>">
                                                <?php echo htmlspecialchars($form['guardainmobile']); ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Relation:</strong></td>
                                        <td><?php echo htmlspecialchars($form['relation']); ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3"><i class="fas fa-users me-2"></i>Sibling Information</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="150"><strong>Sibling 1:</strong></td>
                                        <td><?php echo !empty($form['onesiblingname']) ? htmlspecialchars($form['onesiblingname']) . ' (Class ' . $form['onesiblingclass'] . ')' : 'Not provided'; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Sibling 2:</strong></td>
                                        <td><?php echo !empty($form['twosiblingname']) ? htmlspecialchars($form['twosiblingname']) . ' (Class ' . $form['twosiblingclass'] . ')' : 'Not provided'; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Sibling 3:</strong></td>
                                        <td><?php echo !empty($form['threesiblingname']) ? htmlspecialchars($form['threesiblingname']) . ' (Class ' . $form['threesiblingclass'] . ')' : 'Not provided'; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Transport:</strong></td>
                                        <td><?php echo htmlspecialchars($form['transport']); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <hr>

                        <!-- Address Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3"><i class="fas fa-map-marker-alt me-2"></i>Address Information</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="mb-0">Permanent Address</h6>
                                            </div>
                                            <div class="card-body">
                                                <?php if (!empty($form['address'])): ?>
                                                    <?php echo nl2br(htmlspecialchars($form['address'])); ?>
                                                <?php else: ?>
                                                    <em class="text-muted">Not provided</em>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="mb-0">Present Address</h6>
                                            </div>
                                            <div class="card-body">
                                                <?php if (!empty($form['presentaddress'])): ?>
                                                    <?php echo nl2br(htmlspecialchars($form['presentaddress'])); ?>
                                                <?php else: ?>
                                                    <em class="text-muted">Not provided</em>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                                                 <!-- Documents Information -->
                         <div class="row mb-4">
                             <div class="col-12">
                                 <h6 class="text-primary mb-3"><i class="fas fa-file-alt me-2"></i>Documents Status</h6>
                                 <div class="row">
                                     <div class="col-md-4">
                                         <div class="card">
                                             <div class="card-header">
                                                 <h6 class="mb-0">Student Documents</h6>
                                             </div>
                                             <div class="card-body">
                                                 <div class="mb-2 d-flex justify-content-between align-items-center">
                                                     <strong>Photo:</strong> 
                                                     <div>
                                                         <?php echo !empty($form['stdphoto']) ? '<span class="badge bg-success">Uploaded</span>' : '<span class="badge bg-warning">Pending</span>'; ?>
                                                         <?php if (!empty($form['stdphoto'])): ?>
                                                             <a href="../uploads/admission-forms/<?php echo htmlspecialchars($form['stdphoto']); ?>" target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                                                                 <i class="fas fa-eye"></i> View
                                                             </a>
                                                         <?php endif; ?>
                                                     </div>
                                                 </div>
                                                 <div class="mb-2 d-flex justify-content-between align-items-center">
                                                     <strong>Signature:</strong> 
                                                     <div>
                                                         <?php echo !empty($form['stdsign']) ? '<span class="badge bg-success">Uploaded</span>' : '<span class="badge bg-warning">Pending</span>'; ?>
                                                         <?php if (!empty($form['stdsign'])): ?>
                                                             <a href="../uploads/admission-forms/<?php echo htmlspecialchars($form['stdsign']); ?>" target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                                                                 <i class="fas fa-eye"></i> View
                                                             </a>
                                                         <?php endif; ?>
                                                     </div>
                                                 </div>
                                                 <div class="mb-2 d-flex justify-content-between align-items-center">
                                                     <strong>Aadhar:</strong> 
                                                     <div>
                                                         <?php echo !empty($form['stdaadhar']) ? '<span class="badge bg-success">Uploaded</span>' : '<span class="badge bg-warning">Pending</span>'; ?>
                                                         <?php if (!empty($form['stdaadhar'])): ?>
                                                             <a href="../uploads/admission-forms/<?php echo htmlspecialchars($form['stdaadhar']); ?>" target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                                                                 <i class="fas fa-eye"></i> View
                                                             </a>
                                                         <?php endif; ?>
                                                     </div>
                                                 </div>
                                                 <div class="mb-2 d-flex justify-content-between align-items-center">
                                                     <strong>Transfer Certificate:</strong> 
                                                     <div>
                                                         <?php echo !empty($form['stdtc']) ? '<span class="badge bg-success">Uploaded</span>' : '<span class="badge bg-warning">Pending</span>'; ?>
                                                         <?php if (!empty($form['stdtc'])): ?>
                                                             <a href="../uploads/admission-forms/<?php echo htmlspecialchars($form['stdtc']); ?>" target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                                                                 <i class="fas fa-eye"></i> View
                                                             </a>
                                                         <?php endif; ?>
                                                     </div>
                                                 </div>
                                                 <div class="mb-2 d-flex justify-content-between align-items-center">
                                                     <strong>Report Card:</strong> 
                                                     <div>
                                                         <?php echo !empty($form['stdrtcard']) ? '<span class="badge bg-success">Uploaded</span>' : '<span class="badge bg-warning">Pending</span>'; ?>
                                                         <?php if (!empty($form['stdrtcard'])): ?>
                                                             <a href="../uploads/admission-forms/<?php echo htmlspecialchars($form['stdrtcard']); ?>" target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                                                                 <i class="fas fa-eye"></i> View
                                                             </a>
                                                         <?php endif; ?>
                                                     </div>
                                                 </div>
                                                 <div class="mb-2 d-flex justify-content-between align-items-center">
                                                     <strong>Migration Certificate:</strong> 
                                                     <div>
                                                         <?php echo !empty($form['stdmgcert']) ? '<span class="badge bg-success">Uploaded</span>' : '<span class="badge bg-warning">Pending</span>'; ?>
                                                         <?php if (!empty($form['stdmgcert'])): ?>
                                                             <a href="../uploads/admission-forms/<?php echo htmlspecialchars($form['stdmgcert']); ?>" target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                                                                 <i class="fas fa-eye"></i> View
                                                             </a>
                                                         <?php endif; ?>
                                                     </div>
                                                 </div>
                                                 <div class="mb-2 d-flex justify-content-between align-items-center">
                                                     <strong>Birth Certificate:</strong> 
                                                     <div>
                                                         <?php echo !empty($form['stdbirth']) ? '<span class="badge bg-success">Uploaded</span>' : '<span class="badge bg-warning">Pending</span>'; ?>
                                                         <?php if (!empty($form['stdbirth'])): ?>
                                                             <a href="../uploads/admission-forms/<?php echo htmlspecialchars($form['stdbirth']); ?>" target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                                                                 <i class="fas fa-eye"></i> View
                                                             </a>
                                                         <?php endif; ?>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="col-md-4">
                                         <div class="card">
                                             <div class="card-header">
                                                 <h6 class="mb-0">Father's Documents</h6>
                                             </div>
                                             <div class="card-body">
                                                 <div class="mb-2 d-flex justify-content-between align-items-center">
                                                     <strong>Photo:</strong> 
                                                     <div>
                                                         <?php echo !empty($form['fatphoto']) ? '<span class="badge bg-success">Uploaded</span>' : '<span class="badge bg-warning">Pending</span>'; ?>
                                                         <?php if (!empty($form['fatphoto'])): ?>
                                                             <a href="../uploads/admission-forms/<?php echo htmlspecialchars($form['fatphoto']); ?>" target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                                                                 <i class="fas fa-eye"></i> View
                                                             </a>
                                                         <?php endif; ?>
                                                     </div>
                                                 </div>
                                                 <div class="mb-2 d-flex justify-content-between align-items-center">
                                                     <strong>Signature:</strong> 
                                                     <div>
                                                         <?php echo !empty($form['fatsign']) ? '<span class="badge bg-success">Uploaded</span>' : '<span class="badge bg-warning">Pending</span>'; ?>
                                                         <?php if (!empty($form['fatsign'])): ?>
                                                             <a href="../uploads/admission-forms/<?php echo htmlspecialchars($form['fatsign']); ?>" target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                                                                 <i class="fas fa-eye"></i> View
                                                             </a>
                                                         <?php endif; ?>
                                                     </div>
                                                 </div>
                                                 <div class="mb-2 d-flex justify-content-between align-items-center">
                                                     <strong>Aadhar:</strong> 
                                                     <div>
                                                         <?php echo !empty($form['fataadhar']) ? '<span class="badge bg-success">Uploaded</span>' : '<span class="badge bg-warning">Pending</span>'; ?>
                                                         <?php if (!empty($form['fataadhar'])): ?>
                                                             <a href="../uploads/admission-forms/<?php echo htmlspecialchars($form['fataadhar']); ?>" target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                                                                 <i class="fas fa-eye"></i> View
                                                             </a>
                                                         <?php endif; ?>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="col-md-4">
                                         <div class="card">
                                             <div class="card-header">
                                                 <h6 class="mb-0">Mother's Documents</h6>
                                             </div>
                                             <div class="card-body">
                                                 <div class="mb-2 d-flex justify-content-between align-items-center">
                                                     <strong>Photo:</strong> 
                                                     <div>
                                                         <?php echo !empty($form['motphoto']) ? '<span class="badge bg-success">Uploaded</span>' : '<span class="badge bg-warning">Pending</span>'; ?>
                                                         <?php if (!empty($form['motphoto'])): ?>
                                                             <a href="../uploads/admission-forms/<?php echo htmlspecialchars($form['motphoto']); ?>" target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                                                                 <i class="fas fa-eye"></i> View
                                                             </a>
                                                         <?php endif; ?>
                                                     </div>
                                                 </div>
                                                 <div class="mb-2 d-flex justify-content-between align-items-center">
                                                     <strong>Signature:</strong> 
                                                     <div>
                                                         <?php echo !empty($form['motsign']) ? '<span class="badge bg-success">Uploaded</span>' : '<span class="badge bg-warning">Pending</span>'; ?>
                                                         <?php if (!empty($form['motsign'])): ?>
                                                             <a href="../uploads/admission-forms/<?php echo htmlspecialchars($form['motsign']); ?>" target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                                                                 <i class="fas fa-eye"></i> View
                                                             </a>
                                                         <?php endif; ?>
                                                     </div>
                                                 </div>
                                                 <div class="mb-2 d-flex justify-content-between align-items-center">
                                                     <strong>Aadhar:</strong> 
                                                     <div>
                                                         <?php echo !empty($form['motaadhar']) ? '<span class="badge bg-success">Uploaded</span>' : '<span class="badge bg-warning">Pending</span>'; ?>
                                                         <?php if (!empty($form['motaadhar'])): ?>
                                                             <a href="../uploads/admission-forms/<?php echo htmlspecialchars($form['motaadhar']); ?>" target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                                                                 <i class="fas fa-eye"></i> View
                                                             </a>
                                                         <?php endif; ?>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
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
                                        <a href="send-email.php?id=<?php echo $form['id']; ?>" class="btn btn-info">
                                            <i class="fas fa-envelope me-2"></i>Send Email
                                        </a>
                                        <button onclick="window.print()" class="btn btn-primary">
                                            <i class="fas fa-print me-2"></i>Print Form
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
                        <h3>Admission Form</h3>
                        <p class="text-muted">Form ID: <?php echo $form['id']; ?></p>
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