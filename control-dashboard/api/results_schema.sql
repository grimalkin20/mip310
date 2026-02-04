-- DDL for Results System

CREATE TABLE IF NOT EXISTS `results` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `course` ENUM('D.Pharma', 'B.Pharma', 'M.Pharma') NOT NULL COMMENT 'Course Name',
    `year` VARCHAR(4) NOT NULL COMMENT 'Exam Year (e.g., 2025)',
    `semester` VARCHAR(20) NOT NULL COMMENT 'Semester (e.g., Sem I, Sem II)',
    `result_type` VARCHAR(50) NOT NULL COMMENT 'Type: Regular, Supplementary, etc.',
    `file_path` VARCHAR(255) NOT NULL COMMENT 'Path to the PDF file',
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample Data (Optional)
-- INSERT INTO `results` (`course`, `year`, `semester`, `result_type`, `file_path`) VALUES 
-- ('D.Pharma', '2025', 'Sem I', 'Regular', 'downloads/results/dpharm-2025-sem1.pdf');
