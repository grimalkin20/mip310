<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

requireLogin();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitizeInput($_POST['name']);
    $category_id = (int)$_POST['category_id'];
    $link = sanitizeInput($_POST['link']);

    if (empty($name)) {
        $error = "Link name is required!";
    } elseif ($category_id <= 0) {
        $error = "Please select a category!";
    } elseif (empty($link)) {
        $error = "Video link is required!";
    } elseif (!filter_var($link, FILTER_VALIDATE_URL)) {
        $error = "Please enter a valid URL!";
    } else {
        $sql = "INSERT INTO media_links (name, category_id, link_url) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            // Ensure the bind_param types match your database schema: 's' for string, 'i' for integer
            $stmt->bind_param("sis", $name, $category_id, $link);

            if ($stmt->execute()) {
                logActivity($_SESSION['user_id'], 'Add Media Link', "Added link: $name");
                $success = "Media link added successfully!";
                $name = '';
                $category_id = '';
                $link = '';
            } else {
                $error = "Failed to save link to database!";
            }
            $stmt->close();
        } else {
            $error = "Database error: " . $conn->error;
        }
    }
}

// Get all active categories for dropdown
$categories_sql = "SELECT * FROM media_categories WHERE status = 'active' ORDER BY name";
$categories_result = $conn->query($categories_sql);
$categories = $categories_result->fetch_all(MYSQLI_ASSOC);

logActivity($_SESSION['user_id'], 'Add Media Link', 'Accessed add media link page');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Media Link - Admin Panel</title>
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
                    <h2><i class="fas fa-link me-2"></i>Add Media Link</h2>
                    <a href="manage-links.php" class="btn btn-outline-secondary">
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
                        <h5 class="mb-0"><i class="fas fa-plus me-2"></i>Add New Media Link</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="" data-validate>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Link Name *</label>
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" 
                                               required>
                                        <div class="form-text">Enter a descriptive name for this video link.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Category *</label>
                                        <select class="form-select" id="category_id" name="category_id" required>
                                            <option value="">Select Category</option>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?php echo $category['id']; ?>" 
                                                        <?php echo (isset($_POST['category_id']) && $_POST['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($category['name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="form-text">Select the category for this video link.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="link" class="form-label">Video Link *</label>
                                <input type="url" class="form-control" id="link" name="link" 
                                       value="<?php echo isset($_POST['link']) ? htmlspecialchars($_POST['link']) : ''; ?>" 
                                       placeholder="https://www.youtube.com/watch?v=..." required>
                                <div class="form-text">Enter the full URL of the video (YouTube, Vimeo, etc.).</div>
                            </div>

                            <div class="mb-3">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Supported Platforms:</strong> YouTube, Vimeo, Dailymotion, and other video hosting platforms.
                                </div>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between">
                                <a href="manage-links.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Add Media Link
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