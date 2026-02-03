<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

requireLogin();

$success = '';
$error = '';
$selected_category_id = '';

// Get category ID if provided
if (isset($_GET['category_id']) && is_numeric($_GET['category_id'])) {
    $selected_category_id = (int)$_GET['category_id'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitizeInput($_POST['name']);
    $category_id = (int)$_POST['category_id'];
    
    if (empty($name)) {
        $error = "Image name is required!";
    } elseif ($category_id <= 0) {
        $error = "Please select a category!";
    } elseif (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $error = "Please select an image to upload!";
    } else {
        $uploadResult = uploadFile($_FILES['image'], 'gallery', ['jpg', 'jpeg', 'png', 'gif']);
        
        if ($uploadResult['success']) {
            $sql = "INSERT INTO gallery_images (name, category_id, image) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sis", $name, $category_id, $uploadResult['filename']);
            
            if ($stmt->execute()) {
                logActivity($_SESSION['user_id'], 'Add Gallery Image', "Added image: $name");
                $success = "Image added successfully!";
                $name = ''; // Clear form
            } else {
                $error = "Failed to save image to database!";
                deleteFile($uploadResult['path']);
            }
        } else {
            $error = $uploadResult['message'];
        }
    }
}

// Get all categories
$sql = "SELECT * FROM gallery_categories ORDER BY name ASC";
$result = $conn->query($sql);
$categories = $result->fetch_all(MYSQLI_ASSOC);

logActivity($_SESSION['user_id'], 'Add Gallery Image', 'Accessed add gallery image page');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Gallery Image - Admin Panel</title>
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
                    <h2><i class="fas fa-image me-2"></i>Add Gallery Image</h2>
                    <a href="manage-images.php" class="btn btn-outline-secondary">
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
                        <h5 class="mb-0"><i class="fas fa-plus me-2"></i>Add New Gallery Image</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="" enctype="multipart/form-data" data-validate>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Image Name *</label>
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" 
                                               required>
                                        <div class="form-text">Enter a descriptive name for this image.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Category *</label>
                                        <select class="form-select" id="category_id" name="category_id" required>
                                            <option value="">Select Category</option>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?php echo $category['id']; ?>" 
                                                        <?php echo ($selected_category_id == $category['id'] || (isset($_POST['category_id']) && $_POST['category_id'] == $category['id'])) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($category['name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="form-text">Choose the category for this image.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Upload Image *</label>
                                <input type="file" class="form-control" id="image" name="image" 
                                       accept="image/*" required>
                                <div class="form-text">Supported formats: JPG, JPEG, PNG, GIF (Max 5MB)</div>
                            </div>

                            <div class="mb-3">
                                <div class="file-upload-area" id="uploadArea">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                    <h5>Drag & Drop Image Here</h5>
                                    <p class="text-muted">or click to browse</p>
                                    <input type="file" id="dragDropFile" accept="image/*" style="display: none;">
                                </div>
                            </div>

                            <div class="file-preview" id="filePreview" style="display: none;">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <img id="imagePreview" src="" alt="Preview" class="img-thumbnail me-3" style="width: 100px; height: 100px; object-fit: cover;">
                                            <div>
                                                <h6 class="mb-1" id="fileName">File Name</h6>
                                                <small class="text-muted" id="fileSize">File Size</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between">
                                <a href="manage-images.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-upload me-2"></i>Upload Image
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <?php if (empty($categories)): ?>
                    <div class="mt-4">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>No categories found!</strong> You need to create at least one gallery category before adding images.
                            <a href="add-category.php" class="btn btn-sm btn-warning ms-2">
                                <i class="fas fa-plus me-1"></i>Add Category
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo getAssetUrl('js/admin.js'); ?>"></script>
    <script>
        // Drag and drop functionality
        const uploadArea = document.getElementById('uploadArea');
        const dragDropFile = document.getElementById('dragDropFile');
        const fileInput = document.getElementById('image');
        const filePreview = document.getElementById('filePreview');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const imagePreview = document.getElementById('imagePreview');

        uploadArea.addEventListener('click', () => {
            fileInput.click();
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
                fileInput.files = files;
                showFilePreview(files[0]);
            }
        });

        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                showFilePreview(this.files[0]);
            }
        });

        function showFilePreview(file) {
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
            
            filePreview.style.display = 'block';
            uploadArea.style.display = 'none';
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    </script>
</body>
</html> 