
-- Run in phpMyAdmin or MySQL CLI on your mip_panel database
CREATE TABLE IF NOT EXISTS `exam_schedules` (
    `id`         INT AUTO_INCREMENT PRIMARY KEY,
    `course`     ENUM('D.Pharma', 'B.Pharma', 'M.Pharma') NOT NULL,
    `session`    VARCHAR(20) NOT NULL,
    `semester`   VARCHAR(20) NOT NULL,
    `exam_type`  VARCHAR(50) NOT NULL,
    `file_path`  VARCHAR(255) NOT NULL,
    `status`     ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
