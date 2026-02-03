<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

error_log('=== add-file.php loaded at ' . date('Y-m-d H:i:s') . ' ===', 3, 'debug.log');
error_log('SESSION USER_ID: ' . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'NOT SET'), 3, 'debug.log');
error_log('REQUEST METHOD: ' . $_SERVER['REQUEST_METHOD'], 3, 'debug.log');

requireLogin();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    error_log('POST request received', 3, 'debug.log');
    $name = sanitizeInput(isset($_POST['name']) ? $_POST['name'] : '');
    $type_id = isset($_POST['type_id']) ? (int)$_POST['type_id'] : 0;
    $class_id = isset($_POST['class_id']) ? (int)$_POST['class_id'] : 0;
    $section_id = (isset($_POST['section_id']) && $_POST['section_id'] !== '') ? (int)$_POST['section_id'] : null;
    $subject_id = isset($_POST['subject_id']) ? (int)$_POST['subject_id'] : 0;
    $description = sanitizeInput(isset($_POST['description']) ? $_POST['description'] : '');

    if (empty($name) || $type_id <= 0 || $class_id <= 0 || $subject_id <= 0) {
        $error = "Please fill in all required fields!";
    } else {
        if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
            // Validate and save uploaded file manually, then insert record in DB
            $file = $_FILES['file'];
            $tmpName = $file['tmp_name'];
            $originalName = $file['name'];
            $fileSize = (int)$file['size'];
            $fileMimeType = $file['type'];
            $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'docx', 'ppt', 'xlsx', 'txt', 'pptx', 'doc', 'xls'];
            $maxSize = 10 * 1024 * 1024; // 10 MB

            if (!in_array($extension, $allowedExtensions)) {
                $error = "Invalid file type. Allowed: " . implode(', ', $allowedExtensions);
            } elseif ($fileSize > $maxSize) {
                $error = "File is too large. Maximum allowed size is 10 MB.";
            } else {
                // Prepare upload directory (using current directory)
                $uploadDir = __DIR__ . DIRECTORY_SEPARATOR . 'materials' . DIRECTORY_SEPARATOR;
                error_log('Upload directory: ' . $uploadDir, 3, 'debug.log');
                
                if (!is_writable($uploadDir)) {
                    $error = "Upload directory is not writable. Please check folder permissions.";
                } elseif (!is_dir($uploadDir)) {
                    if (!mkdir($uploadDir, 0755, true)) {
                        $error = "Unable to create upload directory.";
                    }
                }

                if (empty($error)) {
                    // Generate unique filename
                    $newFileName = uniqid() . '_' . time() . '.' . $extension;
                    $destination = $uploadDir . $newFileName;

                    if (move_uploaded_file($tmpName, $destination)) {
                        // Optional: set permissions
                        @chmod($destination, 0644);

                        // Insert record into database
                        $sql = "INSERT INTO materials (type_id, class_id, section_id, subject_id, name, file, file_type, file_size, description, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($sql);

                        if ($stmt) {
                            $status = 'active';
                            // If section_id is null, keep it null; bind_param accepts null values
                            $section_param = $section_id; // may be null

                            // Types: i(type_id) i(class_id) i(section_id) i(subject_id) s(name) s(file) s(file_type) i(file_size) s(description) s(status)
                            $types = 'iiiisssiss';
                            $stmt->bind_param(
                                $types,
                                $type_id,
                                $class_id,
                                $section_param,
                                $subject_id,
                                $name,
                                $newFileName,
                                $fileMimeType,
                                $fileSize,
                                $description,
                                $status
                            );

                            if ($stmt->execute()) {
                                logActivity($_SESSION['user_id'], 'Add Material File', "Added material: $name");
                                $success = "Material file added successfully!";
                                $_POST = [];
                            } else {
                                // remove file if DB insert failed
                                @unlink($destination);
                                $error = "Database error: " . $stmt->error;
                            }

                            $stmt->close();
                        } else {
                            // remove file if DB prepare failed
                            @unlink($destination);
                            $error = "Database error: " . $conn->error;
                        }
                    } else {
                        $error = "Failed to move uploaded file to destination.";
                    }
                }
            }
        } else {
            $error = "Please select a file to upload!";
        }
    }
}

// Get all types for dropdown
error_log('Fetching material types from database', 3, 'debug.log');
$types_sql = "SELECT * FROM material_types ORDER BY name";
$types_result = $conn->query($types_sql);
$types = $types_result->fetch_all(MYSQLI_ASSOC);
error_log('Material types fetched: ' . count($types) . ' records', 3, 'debug.log');

// Get all classes for dropdown
error_log('Fetching classes from database', 3, 'debug.log');
$classes_sql = "SELECT * FROM classes ORDER BY name";
$classes_result = $conn->query($classes_sql);
$classes = $classes_result->fetch_all(MYSQLI_ASSOC);
error_log('Classes fetched: ' . count($classes) . ' records', 3, 'debug.log');

// Get all sections for dropdown (filtered by selected class)
error_log('Fetching sections from database', 3, 'debug.log');
$sections_sql = "SELECT * FROM sections ORDER BY name";
$sections_result = $conn->query($sections_sql);
$sections = $sections_result->fetch_all(MYSQLI_ASSOC);
error_log('Sections fetched: ' . count($sections) . ' records', 3, 'debug.log');

// Get all subjects for dropdown
error_log('Fetching subjects from database', 3, 'debug.log');
$subjects_sql = "SELECT * FROM subjects ORDER BY name";
$subjects_result = $conn->query($subjects_sql);
$subjects = $subjects_result->fetch_all(MYSQLI_ASSOC);
error_log('Subjects fetched: ' . count($subjects) . ' records', 3, 'debug.log');

error_log('Logging page access activity', 3, 'debug.log');
logActivity($_SESSION['user_id'], 'Add Material File', 'Accessed add material file page');
error_log('Page fully loaded and ready for user interaction', 3, 'debug.log');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Material File - Admin Panel</title>
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
                    <h2><i class="fas fa-file-plus me-2"></i>Add Material File</h2>
                    <a href="manage-files.php" class="btn btn-outline-secondary">
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
                        <h5 class="mb-0"><i class="fas fa-plus me-2"></i>Add New Material File</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="" enctype="multipart/form-data" data-validate>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Material Name *</label>
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" 
                                               required>
                                        <div class="form-text">Enter a descriptive name for this material.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="type_id" class="form-label">Type *</label>
                                        <select class="form-select" id="type_id" name="type_id" required>
                                            <option value="">Select Type</option>
                                            <?php foreach ($types as $type): ?>
                                                <option value="<?php echo $type['id']; ?>" 
                                                        <?php echo (isset($_POST['type_id']) && $_POST['type_id'] == $type['id']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($type['name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="form-text">Select the type of material.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="class_id" class="form-label">Class *</label>
                                        <select class="form-select" id="class_id" name="class_id" required>
                                            <option value="">Select Class</option>
                                            <?php foreach ($classes as $class): ?>
                                                <option value="<?php echo $class['id']; ?>" 
                                                        <?php echo (isset($_POST['class_id']) && $_POST['class_id'] == $class['id']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($class['name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="form-text">Select the class.</div>
                                    </div>
                                </div>
                                <!-- <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="section_id" class="form-label">Section </label>
                                        <select class="form-select" id="section_id" name="section_id" >
                                            <option value="">Select Section</option>
                                            <?php foreach ($sections as $section): ?>
                                                <option value="<?php echo $section['id']; ?>" 
                                                        <?php echo (isset($_POST['section_id']) && $_POST['section_id'] == $section['id']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($section['name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="form-text">Select the section.</div>
                                    </div>
                                </div> -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="subject_id" class="form-label">Subject *</label>
                                        <select class="form-select" id="subject_id" name="subject_id" required>
                                            <option value="">Select Subject</option>
                                            <?php foreach ($subjects as $subject): ?>
                                                <option value="<?php echo $subject['id']; ?>" 
                                                        <?php echo (isset($_POST['subject_id']) && $_POST['subject_id'] == $subject['id']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($subject['name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="form-text">Select the subject.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="file" class="form-label">File *</label>
                                        <input type="file" class="form-control" id="file" name="file" 
                                               accept=".jpg,.jpeg,.png,.gif,.pdf,.docx,.ppt,.pptx,.doc,.ppt,.xlsx,.xls,.txt" required>
                                        <div class="form-text">Select a file to upload. Supported formats: JPG, JPEG, PNG, GIF, PDF, DOCX, PPT</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3"><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                                        <div class="form-text">Optional description for this material.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Supported File Types:</strong> Images (JPG, JPEG, PNG, GIF), Documents (PDF, DOCX, PPT)
                                </div>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between">
                                <a href="manage-files.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Add Material File
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