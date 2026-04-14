<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

requireLogin();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitizeInput($_POST['name']);
    
    if (empty($name)) {
        $error = "Slider name is required!";
    } elseif (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $error = "Please select an image to upload!";
    } else {
        // Upload image
        $uploadResult = uploadFile($_FILES['image'], 'sliders', ['jpg', 'jpeg', 'png', 'gif']);
        
        if ($uploadResult['success']) {
            // Save to database
            $sql = "INSERT INTO sliders (name, image) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $name, $uploadResult['filename']);
            
            if ($stmt->execute()) {
                logActivity($_SESSION['user_id'], 'Add Slider', "Added slider: $name");
                $success = "Slider added successfully!";
                
                // Clear form
                $name = '';
            } else {
                $error = "Failed to save slider to database!";
                // Delete uploaded file if database insert fails
                deleteFile($uploadResult['path']);
            }
        } else {
            $error = $uploadResult['message'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Slider - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo getAssetUrl('css/style.css'); ?>" rel="stylesheet">
</head>
<body data-theme="light">
    <div class="admin-layout">
        <!-- Sidebar -->
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/control-dashboard/includes/sidebar.php'; ?>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/control-dashboard/includes/header.php'; ?>
            
            <!-- Content -->
            <div class="content">
                <div class="page-header">
                    <h1 class="page-title">Add Slider</h1>
                    <p class="page-subtitle">Add new slider images for the website</p>
                </div>
                
                <?php if ($success): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <?php echo $success; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-plus me-2"></i>
                                    Add New Slider
                                </h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="" enctype="multipart/form-data" data-validate>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Slider Name</label>
                                                <input type="text" class="form-control" id="name" name="name" 
                                                       value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" 
                                                       placeholder="Enter slider name" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="image" class="form-label">Slider Image</label>
                                                <input type="file" class="form-control" id="image" name="image" 
                                                       accept="image/*" required>
                                                <div class="form-text">
                                                    Allowed formats: JPG, JPEG, PNG, GIF. Max size: 5MB
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="file-upload-area" id="uploadArea">
                                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                            <h5>Drag & Drop Image Here</h5>
                                            <p class="text-muted">or click to browse</p>
                                            <input type="file" id="dragDropFile" accept="image/*" style="display: none;">
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>
                                            Upload Slider
                                        </button>
                                        <a href="<?php echo getAdminUrl('sliders/manage.php'); ?>" class="btn btn-secondary">
                                            <i class="fas fa-list me-2"></i>
                                            View All Sliders
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Instructions
                                </h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        Use high-quality images (1920x1080 recommended)
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        Keep file size under 5MB for faster loading
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        Supported formats: JPG, JPEG, PNG, GIF
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        Images will be automatically optimized
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo getAssetUrl('js/admin.js'); ?>"></script>
    <script>
        // Drag and drop functionality
        const uploadArea = document.getElementById('uploadArea');
        const dragDropFile = document.getElementById('dragDropFile');
        const imageInput = document.getElementById('image');
        
        uploadArea.addEventListener('click', () => {
            dragDropFile.click();
        });
        
        dragDropFile.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                imageInput.files = e.target.files;
                showFilePreview(file);
            }
        });
        
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });
        
        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('dragover');
        });
        
        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const file = files[0];
                if (file.type.startsWith('image/')) {
                    imageInput.files = files;
                    showFilePreview(file);
                } else {
                    AdminPanel.showNotification('Please select an image file', 'error');
                }
            }
        });
        
        function showFilePreview(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                uploadArea.innerHTML = `
                    <img src="${e.target.result}" class="img-fluid rounded" style="max-height: 200px;">
                    <p class="mt-2 mb-0"><strong>${file.name}</strong></p>
                    <small class="text-muted">${formatFileSize(file.size)}</small>
                `;
            };
            reader.readAsDataURL(file);
        }
    </script>
</body>
</html> 