<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';
requireLogin();

$user_id = $_SESSION['user_id'];
$message = '';
$error = '';

// Handle form submission for profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $mobile_number = trim($_POST['mobile_number']);
    
    // Validation
    if (empty($full_name) || empty($email)) {
        $error = 'Full name and email are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE users SET full_name = ?, email = ?, mobile_number = ? WHERE id = ?");
            $stmt->execute([$full_name, $email, $mobile_number, $user_id]);
            
            // Update session
            $_SESSION['full_name'] = $full_name;
            $_SESSION['email'] = $email;
            
            $message = 'Profile updated successfully!';
        } catch (PDOException $e) {
            $error = 'Error updating profile. Please try again.';
        }
    }
}

// Get current user data
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = 'Error loading user data.';
    $user = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo getAssetUrl('css/style.css'); ?>" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/control-dashboard/includes/sidebar.php'; ?>
        
        <div class="main-content">
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/control-dashboard/includes/header.php'; ?>
            
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-user me-2"></i>
                                    View Profile
                                </h5>
                            </div>
                            <div class="card-body">
                                <?php if ($message): ?>
                                    <div class="alert alert-success"><?php echo $message; ?></div>
                                <?php endif; ?>
                                
                                <?php if ($error): ?>
                                    <div class="alert alert-danger"><?php echo $error; ?></div>
                                <?php endif; ?>
                                
                                <form method="POST">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Username</label>
                                                <input type="text" class="form-control" id="username" value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" readonly>
                                                <small class="text-muted">Username cannot be changed</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="user_type" class="form-label">User Type</label>
                                                <input type="text" class="form-control" id="user_type" value="<?php echo ucfirst(htmlspecialchars($user['user_type'] ?? '')); ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="full_name" class="form-label">Full Name *</label>
                                                <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email *</label>
                                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="mobile_number" class="form-label">Mobile Number</label>
                                                <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?php echo htmlspecialchars($user['mobile_number'] ?? ''); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="created_at" class="form-label">Member Since</label>
                                                <input type="text" class="form-control" id="created_at" value="<?php echo formatDate($user['created_at'] ?? ''); ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between">
                                        <a href="<?php echo getAdminUrl('dashboard.php'); ?>" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left me-2"></i>
                                            Back to Dashboard
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>
                                            Update Profile
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo getAssetUrl('js/script.js'); ?>"></script>
</body>
</html> 