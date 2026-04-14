-- DDL for Exam Schedule System
-- Mirrors the results table structure

CREATE TABLE IF NOT EXISTS `exam_schedules` (
    `id`         INT AUTO_INCREMENT PRIMARY KEY,
    `course`     ENUM('D.Pharma', 'B.Pharma', 'M.Pharma') NOT NULL COMMENT 'Course Name',
    `session`    VARCHAR(20) NOT NULL COMMENT 'Academic Session (e.g., 2023-27, 2024-25)',
    `semester`   VARCHAR(20) NOT NULL COMMENT 'Semester or Part (e.g., Sem I, Part I)',
    `exam_type`  VARCHAR(50) NOT NULL COMMENT 'Type: Mid-Term, End-Term, 1st Sessional, etc.',
    `file_path`  VARCHAR(255) NOT NULL COMMENT 'Path to the uploaded PDF file',
    `status`     ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample Data (Optional)
-- INSERT INTO `exam_schedules` (`course`, `session`, `semester`, `exam_type`, `file_path`) VALUES
-- ('B.Pharma', '2023-27', 'Sem III', '2nd Sessional', 'control-dashboard/uploads/materials/schedule/bpharma-2023-27-sem-iii-example.pdf');
