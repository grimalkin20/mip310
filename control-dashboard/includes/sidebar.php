<?php
// Include functions if not already included
if (!function_exists('getAdminUrl')) {
    require_once __DIR__ . '/../includes/functions.php';
}
?>
<style>
.sidebar {
    color: white !important;
}

.sidebar .nav-link {
    color: white !important;
}

.sidebar .nav-link:hover {
    color: #fff !important;
    background-color: rgba(255, 255, 255, 0.1) !important;
}

.sidebar .nav-link.active {
    color: #fff !important;
    background-color: rgba(255, 255, 255, 0.2) !important;
}

.sidebar .nav-link i {
    color: white !important;
}

.sidebar h6 {
    color: rgba(255, 255, 255, 0.7) !important;
}

.sidebar hr {
    border-color: rgba(255, 255, 255, 0.2) !important;
}
</style>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h3 style="color:#fff;"><i class="fas fa-shield-alt me-2"></i>Admin Panel</h3>
    </div>
    
    <nav class="sidebar-nav">
        <!-- Dashboard -->
        <div class="nav-item">
            <a href="<?php echo getAdminUrl('dashboard.php'); ?>" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </div>
        
        <!-- Super User Only Section -->
        <?php if (isSuperUser()): ?>
        <div class="nav-item">
            <a href="<?php echo getAdminUrl('users/'); ?>" class="nav-link <?php echo strpos($_SERVER['PHP_SELF'], 'users/') !== false ? 'active' : ''; ?>">
                <i class="fas fa-users"></i>
                <span>Users</span>
            </a>
        </div>
        <?php endif; ?>
        
        <!-- Inquiries -->
        <!-- <div class="nav-item">
            <a href="<?php echo getAdminUrl('inquiries/'); ?>" class="nav-link <?php echo strpos($_SERVER['PHP_SELF'], 'inquiries/') !== false ? 'active' : ''; ?>">
                <i class="fas fa-question-circle"></i>
                <span>Inquiries</span>
            </a>
        </div> -->
        
        <!-- Contact -->
        <div class="nav-item">
            <a href="<?php echo getAdminUrl('contact/'); ?>" class="nav-link <?php echo strpos($_SERVER['PHP_SELF'], 'contact/') !== false ? 'active' : ''; ?>">
                <i class="fas fa-address-book"></i>
                <span>Contact</span>
            </a>
        </div>
        
        <!-- Super User Only Section -->
        <?php if (isSuperUser()): ?>
        <div class="nav-item">
            <a href="<?php echo getAdminUrl('feedback/'); ?>" class="nav-link <?php echo strpos($_SERVER['PHP_SELF'], 'feedback/') !== false ? 'active' : ''; ?>">
                <i class="fas fa-comments"></i>
                <span>Feedback (From Users)</span>
            </a>
        </div>
        <?php endif; ?>
        
        <!-- Divider -->
        <hr class="my-3">
        
        <!-- Management Section -->
        <div class="nav-item">
            <h6 class="text-muted px-3 mb-2">MANAGEMENT</h6>
        </div>
        
        <!-- Sliders -->
        <div class="nav-item">
            <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#slidersSubmenu">
                <i class="fas fa-images"></i>
                <span>Sliders</span>
                <i class="fas fa-chevron-down ms-auto"></i>
            </a>
            <div class="collapse" id="slidersSubmenu">
                <div class="nav-item ms-3">
                    <a href="<?php echo getAdminUrl('sliders/add.php'); ?>" class="nav-link">
                        <i class="fas fa-plus"></i>
                        <span>Add Slider Images</span>
                    </a>
                </div>
                <div class="nav-item ms-3">
                    <a href="<?php echo getAdminUrl('sliders/manage.php'); ?>" class="nav-link">
                        <i class="fas fa-cog"></i>
                        <span>Manage Slider Images</span>
                    </a>
                </div>
                <div class="nav-item ms-3">
                    <a href="<?php echo getAdminUrl('sliders/recycle.php'); ?>" class="nav-link">
                        <i class="fas fa-trash"></i>
                        <span>Recycle Bin</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Mandatory Disclosure -->
        <!-- <div class="nav-item">
            <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#disclosuresSubmenu">
                <i class="fas fa-file-contract"></i>
                <span>Mandatory Disclosure</span>
                <i class="fas fa-chevron-down ms-auto"></i>
            </a>
            <div class="collapse" id="disclosuresSubmenu">
                <div class="nav-item ms-3">
                    <a href="<?php echo getAdminUrl('disclosures/add.php'); ?>" class="nav-link">
                        <i class="fas fa-plus"></i>
                        <span>Add Disclosures</span>
                    </a>
                </div>
                <div class="nav-item ms-3">
                    <a href="<?php echo getAdminUrl('disclosures/manage.php'); ?>" class="nav-link">
                        <i class="fas fa-cog"></i>
                        <span>Manage Disclosures</span>
                    </a>
                </div>
                <div class="nav-item ms-3">
                    <a href="<?php echo getAdminUrl('disclosures/recycle.php'); ?>" class="nav-link">
                        <i class="fas fa-trash"></i>
                        <span>Recycle Bin</span>
                    </a>
                </div>
            </div>
        </div> -->
        
        <!-- Gallery -->
        <div class="nav-item">
            <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#gallerySubmenu">
                <i class="fas fa-images"></i>
                <span>Gallery</span>
                <i class="fas fa-chevron-down ms-auto"></i>
            </a>
            <div class="collapse" id="gallerySubmenu">
                <div class="nav-item ms-3">
                    <a href="<?php echo getAdminUrl('gallery/add-category.php'); ?>" class="nav-link">
                        <i class="fas fa-plus"></i>
                        <span>Add Category</span>
                    </a>
                </div>
                <div class="nav-item ms-3">
                    <a href="<?php echo getAdminUrl('gallery/manage-category.php'); ?>" class="nav-link">
                        <i class="fas fa-cog"></i>
                        <span>Manage Category</span>
                    </a>
                </div>
                <div class="nav-item ms-3">
                    <a href="<?php echo getAdminUrl('gallery/add-image.php'); ?>" class="nav-link">
                        <i class="fas fa-plus"></i>
                        <span>Add Images</span>
                    </a>
                </div>
                <div class="nav-item ms-3">
                    <a href="<?php echo getAdminUrl('gallery/manage-images.php'); ?>" class="nav-link">
                        <i class="fas fa-cog"></i>
                        <span>Manage Images</span>
                    </a>
                </div>
                <div class="nav-item ms-3">
                    <a href="<?php echo getAdminUrl('gallery/recycle.php'); ?>" class="nav-link">
                        <i class="fas fa-trash"></i>
                        <span>Recycle Bin</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Media/Video -->
        <div class="nav-item">
            <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#mediaSubmenu">
                <i class="fas fa-video"></i>
                <span>Media / Video</span>
                <i class="fas fa-chevron-down ms-auto"></i>
            </a>
            <div class="collapse" id="mediaSubmenu">
                <div class="nav-item ms-3">
                    <a href="<?php echo getAdminUrl('media/add-category.php'); ?>" class="nav-link">
                        <i class="fas fa-plus"></i>
                        <span>Add Category</span>
                    </a>
                </div>
                <div class="nav-item ms-3">
                    <a href="<?php echo getAdminUrl('media/manage-category.php'); ?>" class="nav-link">
                        <i class="fas fa-cog"></i>
                        <span>Manage Category</span>
                    </a>
                </div>
                <div class="nav-item ms-3">
                    <a href="<?php echo getAdminUrl('media/add-link.php'); ?>" class="nav-link">
                        <i class="fas fa-plus"></i>
                        <span>Add Links</span>
                    </a>
                </div>
                <div class="nav-item ms-3">
                    <a href="<?php echo getAdminUrl('media/manage-links.php'); ?>" class="nav-link">
                        <i class="fas fa-cog"></i>
                        <span>Manage Links</span>
                    </a>
                </div>
                <div class="nav-item ms-3">
                    <a href="<?php echo getAdminUrl('media/recycle.php'); ?>" class="nav-link">
                        <i class="fas fa-trash"></i>
                        <span>Recycle Bin</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Study Materials / Homework -->
        <div class="nav-item">
            <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#materialsSubmenu">
                <i class="fas fa-book"></i>
                <span>Study Materials / Homework</span>
                <i class="fas fa-chevron-down ms-auto"></i>
            </a>
            <div class="collapse" id="materialsSubmenu">
                <div class="nav-item ms-3">
                    <a href="<?php echo getAdminUrl('materials/add-category.php'); ?>" class="nav-link">
                        <i class="fas fa-plus"></i>
                        <span>Add Category</span>
                    </a>
                </div>
                <div class="nav-item ms-3">
                    <a href="<?php echo getAdminUrl('materials/class.php'); ?>" class="nav-link">
                        <i class="fas fa-plus"></i>
                        <span>Add Class</span>
                    </a>
                </div>
                <!-- <div class="nav-item ms-3">
                    <a href="<?php echo getAdminUrl('materials/section.php'); ?>" class="nav-link">
                        <i class="fas fa-plus"></i>
                        <span>Add Section</span>
                    </a>
                </div> -->
                <div class="nav-item ms-3">
                    <a href="<?php echo getAdminUrl('materials/subject.php'); ?>" class="nav-link">
                        <i class="fas fa-plus"></i>
                        <span>Add Subjects</span>
                    </a>
                </div>
                <div class="nav-item ms-3">
                    <a href="<?php echo getAdminUrl('materials/add-file.php'); ?>" class="nav-link">
                        <i class="fas fa-plus"></i>
                        <span>Add Files</span>
                    </a>
                </div>
                <div class="nav-item ms-3">
                    <a href="<?php echo getAdminUrl('materials/manage-category.php'); ?>" class="nav-link">
                        <i class="fas fa-cog"></i>
                        <span>Manage Category</span>
                    </a>
                </div>
                <div class="nav-item ms-3">
                    <a href="<?php echo getAdminUrl('materials/manage-files.php'); ?>" class="nav-link">
                        <i class="fas fa-cog"></i>
                        <span>Manage Files</span>
                    </a>
                </div>
                <div class="nav-item ms-3">
                    <a href="<?php echo getAdminUrl('materials/recycle.php'); ?>" class="nav-link">
                        <i class="fas fa-trash"></i>
                        <span>Recycle Bin</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Announcements / News / Notice -->
        <div class="nav-item">
            <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#announcementsSubmenu">
                <i class="fas fa-bullhorn"></i>
                <span>Announcements / News / Notice</span>
                <i class="fas fa-chevron-down ms-auto"></i>
            </a>
            <div class="collapse" id="announcementsSubmenu">
                <div class="nav-item ms-3">
                    <a href="<?php echo getAdminUrl('announcements/add-category.php'); ?>" class="nav-link">
                        <i class="fas fa-plus"></i>
                        <span>Add Category</span>
                    </a>
                </div>
                <div class="nav-item ms-3">
                    <a href="<?php echo getAdminUrl('announcements/manage-category.php'); ?>" class="nav-link">
                        <i class="fas fa-cog"></i>
                        <span>Manage Category</span>
                    </a>
                </div>
                <div class="nav-item ms-3">
                    <a href="<?php echo getAdminUrl('announcements/add.php'); ?>" class="nav-link">
                        <i class="fas fa-plus"></i>
                        <span>Add Input</span>
                    </a>
                </div>
                <div class="nav-item ms-3">
                    <a href="<?php echo getAdminUrl('announcements/manage.php'); ?>" class="nav-link">
                        <i class="fas fa-cog"></i>
                        <span>Manage Inputs</span>
                    </a>
                </div>
                <div class="nav-item ms-3">
                    <a href="<?php echo getAdminUrl('announcements/recycle.php'); ?>" class="nav-link">
                        <i class="fas fa-trash"></i>
                        <span>Recycle Bin</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Admission Forms -->
        <!-- <div class="nav-item">
            <a href="<?php echo getAdminUrl('admission-forms/'); ?>" class="nav-link <?php echo strpos($_SERVER['PHP_SELF'], 'admission-forms/') !== false ? 'active' : ''; ?>">
                <i class="fas fa-graduation-cap"></i>
                <span>Admission Forms</span>
            </a>
        </div> -->
    </nav>
</div> 