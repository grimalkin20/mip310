<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

requireLogin();

$success = '';
$error = '';
$slider = null;

// Get slider ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: manage.php");
    exit();
}

$id = (int)$_GET['id'];

// Get slider data
$sql = "SELECT * FROM sliders WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows != 1) {
    header("Location: manage.php");
    exit();
}

$slider = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitizeInput($_POST['name']);
    
    if (empty($name)) {
        $error = "Slider name is required!";
    } else {
        $update_image = false;
        $new_image_name = $slider['image'];
        
        // Check if new image is uploaded
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $uploadResult = uploadFile($_FILES['image'], 'sliders', ['jpg', 'jpeg', 'png', 'gif']);
            
            if ($uploadResult['success']) {
                // Delete old image
                $old_image_path = "../uploads/materials/sliders/" . $slider['image'];
                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
                
                $new_image_name = $uploadResult['filename'];
                $update_image = true;
            } else {
                $error = $uploadResult['message'];
            }
        }
        
        if (empty($error)) {
            if ($update_image) {
                $sql = "UPDATE sliders SET name = ?, image = ?, updated_at = NOW() WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssi", $name, $new_image_name, $id);
            } else {
                $sql = "UPDATE sliders SET name = ?, updated_at = NOW() WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $name, $id);
            }
            
            if ($stmt->execute()) {
                logActivity($_SESSION['user_id'], 'Edit Slider', "Updated slider: $name");
                $success = "Slider updated successfully!";
                
                // Refresh slider data
                $sql = "SELECT * FROM sliders WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $slider = $result->fetch_assoc();
            } else {
                $error = "Failed to update slider!";
                if ($update_image) {
                    // Delete uploaded file if database update failed
                    deleteFile($uploadResult['path']);
                }
            }
        }
    }
}

logActivity($_SESSION['user_id'], 'Edit Slider', "Accessed edit page for slider: {$slider['name']}");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Slider - Admin Panel</title>
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
                    <h2><i class="fas fa-edit me-2"></i>Edit Slider</h2>
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
                        <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Slider: <?php echo htmlspecialchars($slider['name']); ?></h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="" enctype="multipart/form-data" data-validate>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Slider Name *</label>
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="<?php echo htmlspecialchars($slider['name']); ?>" required>
                                        <div class="form-text">Enter a descriptive name for this slider.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Current Status</label>
                                        <div>
                                            <?php echo getStatusBadge($slider['status']); ?>
                                        </div>
                                        <small class="text-muted">Use the toggle button in manage page to change status.</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">New Image (Optional)</label>
                                        <input type="file" class="form-control" id="image" name="image" 
                                               accept="image/*">
                                        <div class="form-text">Leave empty to keep the current image. Only JPG, JPEG, PNG, GIF allowed.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Current Image</label>
                                        <div class="current-image-preview">
                                            <img src="<?php echo getUploadUrl('../uploads/materials/sliders/' . $slider['image']); ?>" 
                                                 alt="<?php echo htmlspecialchars($slider['name']); ?>" 
                                                 class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                                            <div class="mt-2">
                                                <small class="text-muted">File: <?php echo $slider['image']; ?></small>
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
                                                <?php echo formatDate($slider['created_at']); ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Last Updated</label>
                                        <div>
                                            <small class="text-muted">
                                                <?php echo formatDate($slider['updated_at']); ?>
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
                                    <i class="fas fa-save me-2"></i>Update Slider
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
        document.getElementById('image').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.querySelector('.current-image-preview img');
                    preview.src = e.target.result;
                    preview.style.border = '2px solid #28a745';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html> 