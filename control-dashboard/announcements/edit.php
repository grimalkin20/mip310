<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

requireLogin();

$success = '';
$error = '';
$announcement = null;

// Get announcement ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: manage.php");
    exit();
}

$id = (int)$_GET['id'];

// Get announcement data
$sql = "SELECT * FROM announcements WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows != 1) {
    header("Location: manage.php");
    exit();
}

$announcement = $result->fetch_assoc();

// Get all categories for dropdown
$categories_sql = "SELECT * FROM announcement_categories ORDER BY name";
$categories_result = $conn->query($categories_sql);
$categories = $categories_result->fetch_all(MYSQLI_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = sanitizeInput($_POST['title']);
    $category_id = (int)$_POST['category_id'];
    $content = sanitizeInput($_POST['content']);

    if (empty($title)) {
        $error = "Title is required!";
    } elseif ($category_id <= 0) {
        $error = "Please select a category!";
    } elseif (empty($content)) {
        $error = "Content is required!";
    } else {
        $new_image_name = $announcement['announce_image'];
        $update_image = false;

        // Handle new image upload (optional)
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            // Save announcement images under ../uploads/materials/announcement
            $uploadResult = uploadFile($_FILES['image'], 'announcement', ['jpg', 'jpeg', 'png', 'gif']);

            if ($uploadResult['success']) {
                // Delete old image file if exists
                if (!empty($announcement['announce_image'])) {
                    $old_image_path = "../uploads/materials/announcement/" . $announcement['announce_image'];
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }

                $new_image_name = $uploadResult['filename'];
                $update_image = true;
            } else {
                $error = $uploadResult['message'];
            }
        }

        if (empty($error)) {
            // Update announcement (always write announce_image, keeping old if not changed)
            $sql = "UPDATE announcements 
                    SET category_id = ?, title = ?, content = ?, announce_image = ?, updated_at = NOW() 
                    WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isssi", $category_id, $title, $content, $new_image_name, $id);

            if ($stmt->execute()) {
                logActivity($_SESSION['user_id'], 'Edit Announcement', "Updated announcement: $title");
                $success = "Announcement updated successfully!";

                // Refresh announcement data
                $sql = "SELECT * FROM announcements WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $announcement = $result->fetch_assoc();
            } else {
                $error = "Failed to update announcement!";

                // If DB update failed and we uploaded a new image, delete that new file
                if ($update_image && isset($uploadResult['path'])) {
                    deleteFile($uploadResult['path']);
                }
            }
        }
    }
}

logActivity($_SESSION['user_id'], 'Edit Announcement', "Accessed edit page for announcement: {$announcement['title']}");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Announcement - Admin Panel</title>
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
                    <h2><i class="fas fa-edit me-2"></i>Edit Announcement</h2>
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
                        <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Announcement: <?php echo htmlspecialchars($announcement['title']); ?></h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="" enctype="multipart/form-data" data-validate>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title *</label>
                                        <input type="text" class="form-control" id="title" name="title" 
                                               value="<?php echo htmlspecialchars($announcement['title']); ?>" required>
                                        <div class="form-text">Enter a descriptive title for this announcement.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Category *</label>
                                        <select class="form-select" id="category_id" name="category_id" required>
                                            <option value="">Select Category</option>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?php echo $category['id']; ?>" 
                                                    <?php echo ($announcement['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($category['name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="form-text">Select the category for this announcement.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="content" class="form-label">Content *</label>
                                        <textarea class="form-control" id="content" name="content" rows="8" required><?php echo htmlspecialchars($announcement['content']); ?></textarea>
                                        <div class="form-text">Enter the announcement content.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Current Image</label>
                                        <div class="mb-2">
                                            <?php if (!empty($announcement['announce_image'])): ?>
                                                <img src="<?php echo getUploadUrl('materials/announcement/' . $announcement['announce_image']); ?>" 
                                                     alt="Announcement Image" 
                                                     class="img-thumbnail" style="width: 120px; height: 80px; object-fit: cover;">
                                            <?php else: ?>
                                                <span class="text-muted">No image uploaded</span>
                                            <?php endif; ?>
                                        </div>
                                        <label for="image" class="form-label">Change Image (Optional)</label>
                                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                        <div class="form-text">Upload a new image to replace the current one. JPG, JPEG, PNG, GIF only.</div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between">
                                <a href="manage.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Announcement
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

