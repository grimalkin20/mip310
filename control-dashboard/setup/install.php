<?php
// Admin Panel Installation Script
session_start();

$step = isset($_GET['step']) ? (int)$_GET['step'] : 1;
$error = '';
$success = '';

// Check if already installed
if (file_exists('../config/installed.txt') && $step == 1) {
    header("Location: ../index.php");
    exit();
}

// Step 1: Welcome
if ($step == 1) {
    $requirements = [
        'PHP Version (>= 7.4)' => version_compare(PHP_VERSION, '7.4.0', '>='),
        'MySQL Extension' => extension_loaded('mysqli'),
        'File Upload Support' => ini_get('file_uploads'),
        'GD Extension (for images)' => extension_loaded('gd'),
        'Writable uploads directory' => is_writable('../uploads') || @mkdir('../uploads', 0755, true)
    ];
    
    $allRequirementsMet = !in_array(false, $requirements);
}

// Step 2: Database Configuration
if ($step == 2 && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $host = $_POST['host'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $database = $_POST['database'];
    
    // Test database connection
    $conn = @new mysqli($host, $username, $password);
    
    if ($conn->connect_error) {
        $error = "Database connection failed: " . $conn->connect_error;
    } else {
        // Create database if it doesn't exist
        $conn->query("CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $conn->select_db($database);
        
        // Import database schema
        $sql = file_get_contents('database.sql');
        $queries = explode(';', $sql);
        
        $success = true;
        foreach ($queries as $query) {
            $query = trim($query);
            if (!empty($query)) {
                if (!$conn->query($query)) {
                    $error = "Error importing database: " . $conn->error;
                    $success = false;
                    break;
                }
            }
        }
        
        if ($success) {
            // Update database config
            $config = "<?php
// Database configuration for WAMP Server
\$host = '$host';
\$username = '$username';
\$password = '$password';
\$database = '$database';

// Create connection
\$conn = new mysqli(\$host, \$username, \$password, \$database);

// Check connection
if (\$conn->connect_error) {
    die(\"Connection failed: \" . \$conn->connect_error);
}

// Set charset to utf8
\$conn->set_charset(\"utf8\");

// Set timezone
date_default_timezone_set('Asia/Kolkata');
?>";
            
            file_put_contents('../config/database.php', $config);
            
            // Create installed marker
            file_put_contents('../config/installed.txt', date('Y-m-d H:i:s'));
            
            $success = "Installation completed successfully!";
        }
        
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel Installation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .install-card { backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.95); }
        .step-indicator { position: relative; }
        .step-indicator::before { content: ''; position: absolute; top: 50%; left: 0; right: 0; height: 2px; background: #e9ecef; z-index: 1; }
        .step-indicator .step { position: relative; z-index: 2; background: white; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-8 col-lg-6">
                <div class="card install-card shadow-lg border-0">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-cogs fa-3x text-primary mb-3"></i>
                            <h3 class="fw-bold">Admin Panel Installation</h3>
                            <p class="text-muted">Step <?php echo $step; ?> of 2</p>
                        </div>
                        
                        <!-- Step Indicator -->
                        <div class="step-indicator d-flex justify-content-between mb-4">
                            <div class="step rounded-circle d-flex align-items-center justify-content-center <?php echo $step >= 1 ? 'bg-primary text-white' : 'bg-secondary text-white'; ?>" style="width: 40px; height: 40px;">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="step rounded-circle d-flex align-items-center justify-content-center <?php echo $step >= 2 ? 'bg-primary text-white' : 'bg-secondary text-white'; ?>" style="width: 40px; height: 40px;">
                                <i class="fas fa-database"></i>
                            </div>
                        </div>
                        
                        <?php if ($error): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($success): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <?php echo $success; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            <div class="text-center">
                                <a href="../index.php" class="btn btn-primary btn-lg">
                                    <i class="fas fa-sign-in-alt me-2"></i>
                                    Go to Admin Panel
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($step == 1): ?>
                            <!-- Step 1: Requirements Check -->
                            <h5 class="mb-3">System Requirements</h5>
                            <div class="mb-4">
                                <?php foreach ($requirements as $requirement => $met): ?>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span><?php echo $requirement; ?></span>
                                        <span class="badge <?php echo $met ? 'bg-success' : 'bg-danger'; ?>">
                                            <i class="fas fa-<?php echo $met ? 'check' : 'times'; ?>"></i>
                                        </span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <?php if ($allRequirementsMet): ?>
                                <div class="d-grid">
                                    <a href="?step=2" class="btn btn-primary btn-lg">
                                        <i class="fas fa-arrow-right me-2"></i>
                                        Continue to Database Setup
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Please fix the requirements above before continuing.
                                </div>
                            <?php endif; ?>
                            
                        <?php elseif ($step == 2 && !$success): ?>
                            <!-- Step 2: Database Configuration -->
                            <h5 class="mb-3">Database Configuration</h5>
                            <form method="POST" action="?step=2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="host" class="form-label">Database Host</label>
                                            <input type="text" class="form-control" id="host" name="host" value="localhost" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Database Username</label>
                                            <input type="text" class="form-control" id="username" name="username" value="root" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Database Password</label>
                                            <input type="password" class="form-control" id="password" name="password" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="database" class="form-label">Database Name</label>
                                            <input type="text" class="form-control" id="database" name="database" value="admin_panel" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-flex gap-2">
                                    <a href="?step=1" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>
                                        Back
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-database me-2"></i>
                                        Install Database
                                    </button>
                                </div>
                            </form>
                        <?php endif; ?>
                        
                        <div class="text-center mt-4">
                            <small class="text-muted">
                                Admin Panel v1.0.0 | 
                                <a href="../README.md" class="text-decoration-none">Documentation</a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 