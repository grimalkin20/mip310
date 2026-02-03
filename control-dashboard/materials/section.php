<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

requireLogin();

$success = '';
$error = '';
$selected_category_id = '';

// Get class ID if provided (for pre-selecting in dropdown)
if (isset($_GET['class_id']) && is_numeric($_GET['class_id'])) {
    $selected_category_id = (int)$_GET['class_id'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitizeInput($_POST['name']);
    $class_id = isset($_POST['class_id']) ? (int)$_POST['class_id'] : 0;
    $description = isset($_POST['description']) ? sanitizeInput($_POST['description']) : '';

    if (empty($name)) {
        $error = "Section name is required!";
    } elseif ($class_id <= 0) {
        $error = "Please select a class!";
    } else {
        $sql = "INSERT INTO sections (name, class_id, description) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sis", $name, $class_id, $description);

        if ($stmt->execute()) {
            logActivity($_SESSION['user_id'], 'Add Section', "Added section: $name");
            $success = "Section added successfully!";
            // Optionally clear form fields
            $_POST['name'] = '';
            $_POST['description'] = '';
            $_POST['class_id'] = '';
        } else {
            $error = "Failed to save section to database!";
        }
    }
}
// Get all Classes for the dropdown
$sql = "SELECT * FROM classes ORDER BY name ASC";
$result = $conn->query($sql);
$categories = $result->fetch_all(MYSQLI_ASSOC);

logActivity($_SESSION['user_id'], 'Add Section', 'Accessed add Section page');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Section - Admin Panel</title>
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
                    <h2><i class="fas fa-folder-plus me-2"></i>Add Section</h2>
                    <a href="manage-category.php" class="btn btn-outline-secondary">
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
                        <h5 class="mb-0"><i class="fas fa-plus me-2"></i>Add New Section Section</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="" data-validate>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Section Name *</label>
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" 
                                               required>
                                        <div class="form-text">Enter a unique name for this category.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="class_id" class="form-label">Class *</label>
                                        <select class="form-select" id="class_id" name="class_id" required>
                                            <option value="">Select Class</option>
                                            <?php foreach ($categories as $class): ?>
                                                <option value="<?php echo $class['id']; ?>"
                                                    <?php
                                                        $selected = '';
                                                        if (isset($_POST['class_id']) && $_POST['class_id'] == $class['id']) {
                                                            $selected = 'selected';
                                                        } elseif ($selected_category_id == $class['id']) {
                                                            $selected = 'selected';
                                                        }
                                                        echo $selected;
                                                    ?>>
                                                    <?php echo htmlspecialchars($class['name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="form-text">Choose the Class.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3"><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                                        <div class="form-text">Optional description for this category.</div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between">
                                <a href="manage-category.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Add Section
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Show existing classes with their sections -->
                    <div class="mt-4" style="padding:10px;">
                        <h5><i class="fas fa-list me-2"></i>Existing Classes & Sections</h5>
                        <?php
                        // Fetch all classes with their sections
                        $sql = "SELECT c.id AS class_id, c.name AS class_name, s.id AS section_id, s.name AS section_name, s.description
                                FROM classes c
                                LEFT JOIN sections s ON c.id = s.class_id
                                ORDER BY c.name ASC, s.name ASC";
                        $result = $conn->query($sql);

                        $classes = [];
                        while ($row = $result->fetch_assoc()) {
                            $cid = $row['class_id'];
                            if (!isset($classes[$cid])) {
                                $classes[$cid] = [
                                    'name' => $row['class_name'],
                                    'sections' => []
                                ];
                            }
                            if ($row['section_id']) {
                                $classes[$cid]['sections'][] = [
                                    'id' => $row['section_id'],
                                    'name' => $row['section_name'],
                                    'description' => $row['description']
                                ];
                            }
                        }
                        ?>

                        <?php if (count($classes) > 0): ?>
                            <div class="accordion" id="classesAccordion">
                                <?php $i = 0; foreach ($classes as $cid => $class): ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading<?php echo $cid; ?>">
                                            <button class="accordion-button <?php echo $i > 0 ? 'collapsed' : ''; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $cid; ?>" aria-expanded="<?php echo $i === 0 ? 'true' : 'false'; ?>" aria-controls="collapse<?php echo $cid; ?>">
                                                <i class="fas fa-chalkboard me-2"></i><?php echo htmlspecialchars($class['name']); ?>
                                            </button>
                                        </h2>
                                        <div id="collapse<?php echo $cid; ?>" class="accordion-collapse collapse <?php echo $i === 0 ? 'show' : ''; ?>" aria-labelledby="heading<?php echo $cid; ?>" data-bs-parent="#classesAccordion">
                                            <div class="accordion-body">
                                                <?php if (count($class['sections']) > 0): ?>
                                                    <ul class="list-group">
                                                        <?php foreach ($class['sections'] as $section): ?>
                                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                <span>
                                                                    <i class="fas fa-folder me-2"></i>
                                                                    <?php echo htmlspecialchars($section['name']); ?>
                                                                    <?php if ($section['description']): ?>
                                                                        <small class="text-muted ms-2">(<?php echo htmlspecialchars($section['description']); ?>)</small>
                                                                    <?php endif; ?>
                                                                </span>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                <?php else: ?>
                                                    <span class="text-muted">No sections found for this class.</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php $i++; endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info mt-3">
                                <i class="fas fa-info-circle me-2"></i>No classes or sections found.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo getAssetUrl('js/admin.js'); ?>"></script>
</body>
</html> 