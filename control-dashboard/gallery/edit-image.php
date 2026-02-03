<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

requireLogin();

$success = '';
$error = '';
$image = null;

// Get image ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: manage-images.php");
    exit();
}

$id = (int)$_GET['id'];

// Get image data
$sql = "SELECT gi.*, gc.name as category_name FROM gallery_images gi 
        LEFT JOIN gallery_categories gc ON gi.category_id = gc.id 
        WHERE gi.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows != 1) {
    header("Location: manage-images.php");
    exit();
}

$image = $result->fetch_assoc();

// Get all categories for dropdown
$categories_sql = "SELECT * FROM gallery_categories WHERE status = 'active' ORDER BY name";
$categories_result = $conn->query($categories_sql);
$categories = $categories_result->fetch_all(MYSQLI_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitizeInput($_POST['name']);
    $category_id = (int)$_POST['category_id'];

    if (empty($name)) {
        $error = "Image name is required!";
    } elseif ($category_id <= 0) {
        $error = "Please select a category!";
    } else {
        $update_image = false;
        $new_image_name = $image['image'];

        // Check if new image is uploaded
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $uploadResult = uploadFile($_FILES['image'], 'gallery', ['jpg', 'jpeg', 'png', 'gif']);

            if ($uploadResult['success']) {
                // Delete old image
                $old_image_path = "../uploads/materials/gallery/" . $image['image'];
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
                $sql = "UPDATE gallery_images SET name = ?, category_id = ?, image = ?, updated_at = NOW() WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sisi", $name, $category_id, $new_image_name, $id);
            } else {
                $sql = "UPDATE gallery_images SET name = ?, category_id = ?, updated_at = NOW() WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sii", $name, $category_id, $id);
            }

            if ($stmt->execute()) {
                logActivity($_SESSION['user_id'], 'Edit Gallery Image', "Updated image: $name");
                $success = "Image updated successfully!";

                // Refresh image data
                $sql = "SELECT gi.*, gc.name as category_name FROM gallery_images gi 
                        LEFT JOIN gallery_categories gc ON gi.category_id = gc.id 
                        WHERE gi.id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $image = $result->fetch_assoc();
            } else {
                $error = "Failed to update image!";
                if ($update_image) {
                    // Delete uploaded file if database update failed
                    deleteFile($uploadResult['path']);
                }
            }
        }
    }
}

logActivity($_SESSION['user_id'], 'Edit Gallery Image', "Accessed edit page for image: {$image['name']}");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Gallery Image - Admin Panel</title>
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
                    <h2><i class="fas fa-edit me-2"></i>Edit Gallery Image</h2>
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
                        <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Image: <?php echo htmlspecialchars($image['name']); ?></h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="" enctype="multipart/form-data" data-validate>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Image Name *</label>
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="<?php echo htmlspecialchars($image['name']); ?>" required>
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
                                                        <?php echo $category['id'] == $image['category_id'] ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($category['name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="form-text">Select the category for this image.</div>
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
                                        <label class="form-label">Current Status</label>
                                        <div>
                                            <?php echo getStatusBadge($image['status']); ?>
                                        </div>
                                        <small class="text-muted">Use the toggle button in manage page to change status.</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Current Image</label>
                                        <div class="current-image-preview">
                                            <img src="<?php echo getUploadUrl('materials/gallery/' . $image['image']); ?>" 
                                                 alt="<?php echo htmlspecialchars($image['name']); ?>" 
                                                 class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                                            <div class="mt-2">
                                                <small class="text-muted">File: <?php echo $image['image']; ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Current Category</label>
                                        <div>
                                            <span class="badge bg-info"><?php echo htmlspecialchars($image['category_name']); ?></span>
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
                                                <?php echo formatDate($image['created_at']); ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Last Updated</label>
                                        <div>
                                            <small class="text-muted">
                                                <?php echo formatDate($image['updated_at']); ?>
                                            </small>
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
                                    <i class="fas fa-save me-2"></i>Update Image
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