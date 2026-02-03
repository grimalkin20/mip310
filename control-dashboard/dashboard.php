<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

requireLogin();

// Get dashboard statistics
$stats = [];

// Total users
$sql = "SELECT COUNT(*) as count FROM users WHERE status = 'active'";
$result = $conn->query($sql);
$stats['users'] = $result->fetch_assoc()['count'];

// Total inquiries
$sql = "SELECT COUNT(*) as count FROM inquiries WHERE status = 'unread'";
$result = $conn->query($sql);
$stats['inquiries'] = $result->fetch_assoc()['count'];

// Total contacts
$sql = "SELECT COUNT(*) as count FROM contacts WHERE status = 'unread'";
$result = $conn->query($sql);
$stats['contacts'] = $result->fetch_assoc()['count'];

// Total admission forms
$sql = "SELECT COUNT(*) as count FROM admission_forms WHERE status = 'pending'";
$result = $conn->query($sql);
$stats['admissions'] = $result->fetch_assoc()['count'];

// Recent activities
$sql = "SELECT al.*, u.full_name FROM activity_logs al 
        LEFT JOIN users u ON al.user_id = u.id 
        ORDER BY al.created_at DESC LIMIT 5";
$recent_activities = $conn->query($sql);

// Recent inquiries
$sql = "SELECT * FROM inquiries ORDER BY created_at DESC LIMIT 5";
$recent_inquiries = $conn->query($sql);

// Recent admission forms
$sql = "SELECT * FROM admission_forms ORDER BY created_at DESC LIMIT 5";
$recent_admissions = $conn->query($sql);

// Log activity
logActivity($_SESSION['user_id'], 'Dashboard Access', 'Accessed dashboard');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body data-theme="light">
    <div class="admin-layout">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <?php include 'includes/header.php'; ?>
            
            <!-- Content -->
            <div class="content">
                <div class="page-header">
                    <h1 class="page-title">Dashboard</h1>
                    <p class="page-subtitle">Welcome back, <?php echo $_SESSION['full_name']; ?>!</p>
                </div>
                
                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card stats-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <div class="stats-number"><?php echo $stats['users']; ?></div>
                                        <div class="stats-label">Active Users</div>
                                    </div>
                                    <div class="stats-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card stats-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <div class="stats-number"><?php echo $stats['inquiries']; ?></div>
                                        <div class="stats-label">New Inquiries</div>
                                    </div>
                                    <div class="stats-icon">
                                        <i class="fas fa-question-circle"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card stats-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <div class="stats-number"><?php echo $stats['contacts']; ?></div>
                                        <div class="stats-label">New Contacts</div>
                                    </div>
                                    <div class="stats-icon">
                                        <i class="fas fa-address-book"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stats-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <div class="stats-number"><?php echo $stats['admissions']; ?></div>
                                        <div class="stats-label">Pending Admissions</div>
                                    </div>
                                    <div class="stats-icon">
                                        <i class="fas fa-graduation-cap"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
                
                <!-- Content Row -->
                <div class="row">

                    <?php if (isSuperUser()): ?>
                        <!-- Recent Activities -->
                        <div class="col-lg-8 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-history me-2"></i>
                                        Recent Activities
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>User</th>
                                                    <th>Action</th>
                                                    <th>Details</th>
                                                    <th>Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($activity = $recent_activities->fetch_assoc()): ?>
                                                <tr>
                                                    <td><strong><?php echo $activity['full_name'] ?? 'System'; ?></strong></td>
                                                    <td><?php echo $activity['action']; ?></td>
                                                    <td><?php echo $activity['details']; ?></td>
                                                    <td><?php echo formatDate($activity['created_at']); ?></td>
                                                </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions (Right side) -->
                        <div class="col-lg-4 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-bolt me-2"></i>
                                        Quick Actions
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="sliders/add.php" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Slider</a>
                                        <a href="gallery/add-image.php" class="btn btn-success"><i class="fas fa-image me-2"></i>Add Gallery Image</a>
                                        <a href="disclosures/add.php" class="btn btn-info"><i class="fas fa-file me-2"></i>Add Disclosure</a>
                                        <a href="media/add-link.php" class="btn btn-warning"><i class="fas fa-video me-2"></i>Add Media Link</a>
                                        <a href="users/add.php" class="btn btn-danger"><i class="fas fa-user-plus me-2"></i>Add User</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php else: ?>

                        <!-- Quick Actions (Full width for normal users) -->
                        <div class="col-lg-12 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-bolt me-2"></i>
                                        Quick Actions
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="sliders/add.php" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Slider</a>
                                        <a href="gallery/add-image.php" class="btn btn-success"><i class="fas fa-image me-2"></i>Add Gallery Image</a>
                                        <a href="disclosures/add.php" class="btn btn-info"><i class="fas fa-file me-2"></i>Add Disclosure</a>
                                        <a href="media/add-link.php" class="btn btn-warning"><i class="fas fa-video me-2"></i>Add Media Link</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endif; ?>

                </div>


                
                <!-- Recent Data -->
                <div class="row">
                    <!-- Recent Inquiries -->
                    <!-- <div class="col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-question-circle me-2"></i>
                                    Recent Inquiries
                                </h5>
                            </div>
                            <div class="card-body">
                                <?php if ($recent_inquiries->num_rows > 0): ?>
                                <div class="list-group list-group-flush">
                                    <?php while ($inquiry = $recent_inquiries->fetch_assoc()): ?>
                                    <div class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold"><?php echo htmlspecialchars($inquiry['name']); ?></div>
                                            <small class="text-muted"><?php echo htmlspecialchars($inquiry['subject']); ?></small>
                                        </div>
                                        <span class="badge bg-primary rounded-pill">
                                            <?php echo getStatusBadge($inquiry['status']); ?>
                                        </span>
                                    </div>
                                    <?php endwhile; ?>
                                </div>
                                <?php else: ?>
                                <p class="text-muted text-center">No recent inquiries</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div> -->
                    
                    <!-- Recent Admissions -->
                    <!-- <div class="col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-graduation-cap me-2"></i>
                                    Recent Admission Forms
                                </h5>
                            </div>
                            <div class="card-body">
                                <?php if ($recent_admissions->num_rows > 0): ?>
                                <div class="list-group list-group-flush">
                                    <?php while ($admission = $recent_admissions->fetch_assoc()): ?>
                                    <div class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">
                                                <?php echo htmlspecialchars($admission['student_name']); ?>
                                            </div>
                                            <small class="text-muted">Class: <?php echo htmlspecialchars($admission['class']); ?></small>
                                        </div>
                                        <span class="badge bg-warning rounded-pill">
                                            <?php echo getStatusBadge($admission['status']); ?>
                                        </span>
                                    </div>
                                    <?php endwhile; ?>
                                </div>
                                <?php else: ?>
                                <p class="text-muted text-center">No recent admission forms</p>
                                <?php endif; ?>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/admin.js"></script>
</body>
</html> 