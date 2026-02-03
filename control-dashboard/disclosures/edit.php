<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

requireLogin();

$success = '';
$error = '';
$disclosure = null;

// Get disclosure ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: manage.php");
    exit();
}

$id = (int)$_GET['id'];

// Get disclosure data
$sql = "SELECT * FROM disclosures WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows != 1) {
    header("Location: manage.php");
    exit();
}

$disclosure = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitizeInput($_POST['name']);
    
    if (empty($name)) {
        $error = "Disclosure name is required!";
    } else {
        $update_file = false;
        $new_file_name = $disclosure['file'];
        
        // Check if new file is uploaded
        if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
            $uploadResult = uploadFile($_FILES['file'], 'disclosures', ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'jpg', 'jpeg', 'png', 'gif']);
            
            if ($uploadResult['success']) {
                // Delete old file
                $old_file_path = "../uploads/disclosures/" . $disclosure['file'];
                if (file_exists($old_file_path)) {
                    unlink($old_file_path);
                }
                
                $new_file_name = $uploadResult['filename'];
                $update_file = true;
            } else {
                $error = $uploadResult['message'];
            }
        }
        
        if (empty($error)) {
            if ($update_file) {
                $sql = "UPDATE disclosures SET name = ?, file = ?, updated_at = NOW() WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssi", $name, $new_file_name, $id);
            } else {
                $sql = "UPDATE disclosures SET name = ?, updated_at = NOW() WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $name, $id);
            }
            
            if ($stmt->execute()) {
                logActivity($_SESSION['user_id'], 'Edit Disclosure', "Updated disclosure: $name");
                $success = "Disclosure updated successfully!";
                
                // Refresh disclosure data
                $sql = "SELECT * FROM disclosures WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $disclosure = $result->fetch_assoc();
            } else {
                $error = "Failed to update disclosure!";
                if ($update_file) {
                    // Delete uploaded file if database update failed
                    deleteFile($uploadResult['path']);
                }
            }
        }
    }
}

logActivity($_SESSION['user_id'], 'Edit Disclosure', "Accessed edit page for disclosure: {$disclosure['name']}");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Disclosure - Admin Panel</title>
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
                    <h2><i class="fas fa-edit me-2"></i>Edit Disclosure</h2>
                    <a href="manage.php" class="btn btn-outline-secondary">
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
                        <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Disclosure: <?php echo htmlspecialchars($disclosure['name']); ?></h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="" enctype="multipart/form-data" data-validate>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Disclosure Name *</label>
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="<?php echo htmlspecialchars($disclosure['name']); ?>" required>
                                        <div class="form-text">Enter a descriptive name for this disclosure.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Current Status</label>
                                        <div>
                                            <?php echo getStatusBadge($disclosure['status']); ?>
                                        </div>
                                        <small class="text-muted">Use the toggle button in manage page to change status.</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="file" class="form-label">New File (Optional)</label>
                                        <input type="file" class="form-control" id="file" name="file" 
                                               accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.gif">
                                        <div class="form-text">Leave empty to keep the current file. Supported formats: PDF, DOC, DOCX, PPT, PPTX, JPG, JPEG, PNG, GIF</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Current File</label>
                                        <div class="current-file-preview">
                                            <?php
                                            $file_ext = strtolower(pathinfo($disclosure['file'], PATHINFO_EXTENSION));
                                            $is_image = in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif']);
                                            ?>
                                            <?php if ($is_image): ?>
                                                <img src="../uploads/disclosures/<?php echo $disclosure['file']; ?>" 
                                                     alt="<?php echo htmlspecialchars($disclosure['name']); ?>" 
                                                     class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                                            <?php else: ?>
                                                <div class="bg-light text-center p-3" style="width: 200px; height: 150px; line-height: 120px;">
                                                    <i class="fas fa-file-<?php echo getFileIcon($file_ext); ?> fa-3x text-primary"></i>
                                                </div>
                                            <?php endif; ?>
                                            <div class="mt-2">
                                                <small class="text-muted">File: <?php echo $disclosure['file']; ?></small>
                                                <br>
                                                <a href="<?php echo getUploadUrl('disclosures/' . $disclosure['file']); ?>" 
                                                   class="btn btn-sm btn-outline-info mt-1" target="_blank">
                                                    <i class="fas fa-download me-1"></i>Download
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Created</label>
                                        <div>
                                            <small class="text-muted">
                                                <?php echo formatDate($disclosure['created_at']); ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Last Updated</label>
                                        <div>
                                            <small class="text-muted">
                                                <?php echo formatDate($disclosure['updated_at']); ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between">
                                <a href="manage.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Disclosure
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
    <script>
        // File upload preview
        document.getElementById('file').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.querySelector('.current-file-preview');
                    const fileExt = file.name.split('.').pop().toLowerCase();
                    const isImage = ['jpg', 'jpeg', 'png', 'gif'].includes(fileExt);
                    
                    if (isImage) {
                        preview.innerHTML = `
                            <img src="${e.target.result}" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 150px; border: 2px solid #28a745;">
                            <div class="mt-2">
                                <small class="text-muted">File: ${file.name}</small>
                            </div>
                        `;
                    } else {
                        preview.innerHTML = `
                            <div class="bg-light text-center p-3" style="width: 200px; height: 150px; line-height: 120px; border: 2px solid #28a745;">
                                <i class="fas fa-file-${getFileIcon(fileExt)} fa-3x text-primary"></i>
                            </div>
                            <div class="mt-2">
                                <small class="text-muted">File: ${file.name}</small>
                            </div>
                        `;
                    }
                };
                reader.readAsDataURL(file);
            }
        });

        function getFileIcon(extension) {
            const icons = {
                'pdf': 'pdf',
                'doc': 'word',
                'docx': 'word',
                'ppt': 'powerpoint',
                'pptx': 'powerpoint',
                'xls': 'excel',
                'xlsx': 'excel',
                'jpg': 'image',
                'jpeg': 'image',
                'png': 'image',
                'gif': 'image',
                'txt': 'text'
            };
            return icons[extension] || 'alt';
        }
    </script>
</body>
</html> 