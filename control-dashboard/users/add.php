<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';
requireLogin();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitizeInput($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $full_name = sanitizeInput($_POST['full_name']);
    $email = sanitizeInput($_POST['email']);
    $mobile_number = sanitizeInput($_POST['mobile_number']);
    $user_type = $_POST['user_type'];

    if (empty($username) || empty($password) || empty($full_name) || empty($email)) {
        $error = "Username, password, full name, and email are required!";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address!";
    } else {
        // Check if username already exists
        $check_sql = "SELECT id FROM users WHERE username = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            $error = "Username already exists!";
        } else {
            // Check if email already exists
            $check_email_sql = "SELECT id FROM users WHERE email = ?";
            $check_email_stmt = $conn->prepare($check_email_sql);
            $check_email_stmt->bind_param("s", $email);
            $check_email_stmt->execute();
            $check_email_result = $check_email_stmt->get_result();

            if ($check_email_result->num_rows > 0) {
                $error = "Email address already exists!";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                $sql = "INSERT INTO users (username, password, full_name, email, mobile_number, user_type, status) VALUES (?, ?, ?, ?, ?, ?, 'active')";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssss", $username, $hashed_password, $full_name, $email, $mobile_number, $user_type);

                if ($stmt->execute()) {
                    logActivity($_SESSION['user_id'], 'Add User', "Added user: $username");
                    $success = "User added successfully!";
                    $username = '';
                    $full_name = '';
                    $email = '';
                    $mobile_number = '';
                    $user_type = 'user';
                } else {
                    $error = "Failed to save user to database!";
                }
            }
        }
    }
}

logActivity($_SESSION['user_id'], 'Add User', 'Accessed add user page');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User - Admin Panel</title>
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
                    <h2><i class="fas fa-user-plus me-2"></i>Add New User</h2>
                    <a href="index.php" class="btn btn-outline-secondary">
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
                        <h5 class="mb-0"><i class="fas fa-plus me-2"></i>Add New User</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="" data-validate>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username *</label>
                                        <input type="text" class="form-control" id="username" name="username" 
                                               value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" 
                                               required>
                                        <div class="form-text">Enter a unique username for this user.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="full_name" class="form-label">Full Name *</label>
                                        <input type="text" class="form-control" id="full_name" name="full_name" 
                                               value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>" 
                                               required>
                                        <div class="form-text">Enter the user's full name.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email *</label>
                                        <input type="email" class="form-control" id="email" name="email" 
                                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" 
                                               required>
                                        <div class="form-text">Enter a valid email address.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="mobile_number" class="form-label">Mobile Number</label>
                                        <input type="text" class="form-control" id="mobile_number" name="mobile_number" 
                                               value="<?php echo isset($_POST['mobile_number']) ? htmlspecialchars($_POST['mobile_number']) : ''; ?>">
                                        <div class="form-text">Optional mobile number.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password *</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password" 
                                                   required minlength="6">
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="form-text">Password must be at least 6 characters long.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="confirm_password" class="form-label">Confirm Password *</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                                   required minlength="6">
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirm_password')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="form-text">Re-enter the password to confirm.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="user_type" class="form-label">User Type *</label>
                                <select class="form-select" id="user_type" name="user_type" required>
                                    <option value="">Select User Type</option>
                                    <option value="user" <?php echo (isset($_POST['user_type']) && $_POST['user_type'] == 'user') ? 'selected' : ''; ?>>Normal User</option>
                                    <option value="admin" <?php echo (isset($_POST['user_type']) && $_POST['user_type'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                    <option value="super_user" <?php echo (isset($_POST['user_type']) && $_POST['user_type'] == 'super_user') ? 'selected' : ''; ?>>Super User</option>
                                </select>
                                <div class="form-text">Select the user's role and permissions.</div>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between">
                                <a href="index.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Add User
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
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const button = field.nextElementSibling;
            const icon = button.querySelector('i');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html> 