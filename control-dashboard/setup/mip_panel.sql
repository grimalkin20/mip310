-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 04, 2026 at 11:30 AM
-- Server version: 8.0.18
-- PHP Version: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mip_panel`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_activity_logs_user_id` (`user_id`),
  KEY `idx_activity_logs_created_at` (`created_at`)
) ENGINE=MyISAM AUTO_INCREMENT=1143 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `details`, `created_at`) VALUES
(943, 1, 'Dashboard Access', 'Accessed dashboard', '2026-02-03 15:49:09'),
(944, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-03 15:49:12'),
(945, 1, 'Dashboard Access', 'Accessed dashboard', '2026-02-03 15:49:14'),
(946, 1, 'View Gallery Categories', 'Viewed gallery category management page', '2026-02-03 16:00:49'),
(947, 1, 'View Gallery Images', 'Viewed gallery images management page', '2026-02-03 16:01:07'),
(948, 1, 'Dashboard Access', 'Accessed dashboard', '2026-02-03 16:04:01'),
(949, 1, 'Dashboard Access', 'Accessed dashboard', '2026-02-03 16:06:15'),
(950, 1, 'Dashboard Access', 'Accessed dashboard', '2026-02-03 16:06:43'),
(951, 1, 'Dashboard Access', 'Accessed dashboard', '2026-02-03 16:07:26'),
(952, 1, 'Dashboard Access', 'Accessed dashboard', '2026-02-03 16:11:34'),
(953, 1, 'View Gallery Images', 'Viewed gallery images management page', '2026-02-03 16:38:25'),
(954, 1, 'Add Gallery Image', 'Accessed add gallery image page', '2026-02-03 16:38:31'),
(955, 1, 'Add Gallery Image', 'Accessed add gallery image page', '2026-02-03 16:38:54'),
(956, 1, 'Add Gallery Image', 'Accessed add gallery image page', '2026-02-03 16:39:10'),
(957, 1, 'Add Gallery Image', 'Accessed add gallery image page', '2026-02-03 16:40:18'),
(958, 1, 'Add Gallery Image', 'Added image: mip test 2', '2026-02-03 16:40:29'),
(959, 1, 'Add Gallery Image', 'Accessed add gallery image page', '2026-02-03 16:40:29'),
(960, 1, 'View Feedback', 'Viewed feedback management page', '2026-02-03 16:41:03'),
(961, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-03 16:41:05'),
(962, 1, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 03:52:32'),
(963, 1, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 03:52:43'),
(964, 1, 'Logout', 'User logged out', '2026-02-04 03:52:47'),
(965, 1, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 03:52:53'),
(966, 1, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 04:02:30'),
(967, 1, 'View Sliders', 'Viewed slider management page', '2026-02-04 04:02:32'),
(968, 1, 'Add Slider', 'Added slider: slide3', '2026-02-04 04:05:48'),
(969, 1, 'Add Slider', 'Added slider: slide2', '2026-02-04 04:06:03'),
(970, 1, 'Add Slider', 'Added slider: slide3', '2026-02-04 04:06:14'),
(971, 1, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 04:07:11'),
(972, 1, 'View Sliders', 'Viewed slider management page', '2026-02-04 04:07:18'),
(973, 1, 'Toggle Slider Status', 'Toggled slider status', '2026-02-04 04:07:41'),
(974, 1, 'View Sliders', 'Viewed slider management page', '2026-02-04 04:07:41'),
(975, 1, 'Toggle Slider Status', 'Toggled slider status', '2026-02-04 04:09:08'),
(976, 1, 'View Sliders', 'Viewed slider management page', '2026-02-04 04:09:08'),
(977, 1, 'Add Announcement Category', 'Accessed add announcement category page', '2026-02-04 04:09:41'),
(978, 1, 'View Announcements', 'Viewed announcements management page', '2026-02-04 04:09:48'),
(979, 1, 'View Announcement Categories', 'Viewed announcement category management page', '2026-02-04 04:09:55'),
(980, 1, 'Add Announcement', 'Accessed add announcement page', '2026-02-04 04:10:24'),
(981, 1, 'Add Announcement', 'Added announcement: M.Pharm Admissions 2025 - Applications Open', '2026-02-04 04:18:36'),
(982, 1, 'Add Announcement', 'Accessed add announcement page', '2026-02-04 04:18:36'),
(983, 1, 'View Announcements', 'Viewed announcements management page', '2026-02-04 04:18:39'),
(984, 1, 'Add Announcement', 'Accessed add announcement page', '2026-02-04 04:33:18'),
(985, 1, 'Add Announcement', 'Added announcement: B. Pharma (2022-26) 7th Semester', '2026-02-04 04:58:17'),
(986, 1, 'Add Announcement', 'Accessed add announcement page', '2026-02-04 04:58:17'),
(987, 1, 'View Announcements', 'Viewed announcements management page', '2026-02-04 04:58:24'),
(988, 1, 'View Announcements', 'Viewed announcements management page', '2026-02-04 05:19:23'),
(989, 1, 'View Inquiries', 'Viewed inquiries management page', '2026-02-04 05:19:24'),
(990, 1, 'View Inquiry', 'Viewed inquiry from: Jay', '2026-02-04 05:19:30'),
(991, 1, 'View Inquiries', 'Viewed inquiries management page', '2026-02-04 05:19:34'),
(992, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-04 05:19:45'),
(993, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-04 05:25:39'),
(994, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-04 05:25:41'),
(995, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-04 05:25:43'),
(996, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-04 05:25:46'),
(997, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-04 05:25:53'),
(998, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-04 05:32:30'),
(999, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-04 05:33:25'),
(1000, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-04 05:34:06'),
(1001, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-04 05:34:07'),
(1002, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-04 05:35:56'),
(1003, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-04 05:35:58'),
(1004, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-04 05:41:09'),
(1005, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-04 05:41:11'),
(1006, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-04 05:45:15'),
(1007, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-04 05:47:55'),
(1008, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-04 05:51:01'),
(1009, 1, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 05:54:04'),
(1010, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-04 05:54:06'),
(1011, 1, 'View Contact', 'Viewed contact from: Jay Thakur', '2026-02-04 05:57:17'),
(1012, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-04 05:57:24'),
(1013, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-04 05:58:55'),
(1014, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-04 05:59:36'),
(1015, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-04 05:59:39'),
(1016, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-04 06:02:04'),
(1017, 1, 'Delete Contact', 'Deleted contact from: John Doe', '2026-02-04 06:02:08'),
(1018, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-04 06:02:08'),
(1019, 1, 'View Inquiries', 'Viewed inquiries management page', '2026-02-04 06:06:12'),
(1020, 1, 'Setup', 'Created inquiries_recycle table', '2026-02-04 06:08:12'),
(1021, 1, 'View Inquiries', 'Viewed inquiries management page', '2026-02-04 06:08:41'),
(1022, 1, 'View Inquiries', 'Viewed inquiries management page', '2026-02-04 06:08:44'),
(1023, 1, 'View Inquiries', 'Viewed inquiries management page', '2026-02-04 06:09:23'),
(1024, 1, 'Delete Inquiry', 'Deleted inquiry from: Jay', '2026-02-04 06:09:26'),
(1025, 1, 'View Inquiries', 'Viewed inquiries management page', '2026-02-04 06:09:26'),
(1026, 1, 'View Recycle Bin', 'Viewed inquiries recycle bin', '2026-02-04 06:09:29'),
(1027, 1, 'View Recycle Bin', 'Viewed inquiries recycle bin', '2026-02-04 06:16:10'),
(1028, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-04 06:16:15'),
(1029, 1, 'View Recycle Bin', 'Viewed contact recycle bin', '2026-02-04 06:16:17'),
(1030, 1, 'View Inquiries', 'Viewed inquiries management page', '2026-02-04 06:16:24'),
(1031, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-04 06:16:26'),
(1032, 1, 'View Inquiries', 'Viewed inquiries management page', '2026-02-04 06:16:27'),
(1033, 1, 'View Recycle Bin', 'Viewed inquiries recycle bin', '2026-02-04 06:16:29'),
(1034, 1, 'Restore Inquiry', 'Restored inquiry from: Jay', '2026-02-04 06:16:31'),
(1035, 1, 'View Recycle Bin', 'Viewed inquiries recycle bin', '2026-02-04 06:16:31'),
(1036, 1, 'View Inquiries', 'Viewed inquiries management page', '2026-02-04 06:16:32'),
(1037, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-04 06:16:35'),
(1038, 1, 'View Contacts', 'Viewed contacts management page', '2026-02-04 06:36:23'),
(1039, 1, 'View Sliders', 'Viewed slider management page', '2026-02-04 06:36:26'),
(1040, 1, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 07:25:58'),
(1041, 1, 'Add Announcement', 'Accessed add announcement page', '2026-02-04 07:26:09'),
(1042, 1, 'Add Announcement', 'Added announcement: Test 2', '2026-02-04 07:26:34'),
(1043, 1, 'Add Announcement', 'Accessed add announcement page', '2026-02-04 07:26:34'),
(1044, 1, 'Add Announcement', 'Added announcement: Test 3', '2026-02-04 07:26:45'),
(1045, 1, 'Add Announcement', 'Accessed add announcement page', '2026-02-04 07:26:45'),
(1046, 1, 'View Gallery Categories', 'Viewed gallery category management page', '2026-02-04 07:28:44'),
(1047, 1, 'Add Gallery Image', 'Accessed add gallery image page', '2026-02-04 07:30:24'),
(1048, 1, 'Add Gallery Image', 'Added image: Main Campus', '2026-02-04 07:37:06'),
(1049, 1, 'Add Gallery Image', 'Accessed add gallery image page', '2026-02-04 07:37:06'),
(1050, 1, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 07:46:47'),
(1051, 1, 'View Gallery Images', 'Viewed gallery images management page', '2026-02-04 07:46:53'),
(1052, 1, 'View Media Links', 'Viewed media links management page', '2026-02-04 07:54:05'),
(1053, 1, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 08:07:06'),
(1054, 1, 'View Media Links', 'Viewed media links management page', '2026-02-04 08:07:10'),
(1055, 1, 'Delete Media Link', 'Deleted link: B.Pharm Program Overview', '2026-02-04 08:08:06'),
(1056, 1, 'View Media Links', 'Viewed media links management page', '2026-02-04 08:08:06'),
(1057, 1, 'Delete Media Link', 'Deleted link: Student Life at MIP', '2026-02-04 08:08:09'),
(1058, 1, 'View Media Links', 'Viewed media links management page', '2026-02-04 08:08:09'),
(1059, 1, 'Delete Media Link', 'Deleted link: Faculty & Research Excellence', '2026-02-04 08:08:11'),
(1060, 1, 'View Media Links', 'Viewed media links management page', '2026-02-04 08:08:11'),
(1061, 1, 'Delete Media Link', 'Deleted link: Placement & Career Success', '2026-02-04 08:08:14'),
(1062, 1, 'View Media Links', 'Viewed media links management page', '2026-02-04 08:08:14'),
(1063, 1, 'Toggle Media Link Status', 'Toggled link status', '2026-02-04 08:08:17'),
(1064, 1, 'View Media Links', 'Viewed media links management page', '2026-02-04 08:08:17'),
(1065, 1, 'Delete Media Link', 'Deleted link: Admission & Application Process', '2026-02-04 08:08:19'),
(1066, 1, 'View Media Links', 'Viewed media links management page', '2026-02-04 08:08:19'),
(1067, 1, 'Delete Media Link', 'Deleted link: Campus Tour - Magadh Institute of Pharmacy', '2026-02-04 08:08:22'),
(1068, 1, 'View Media Links', 'Viewed media links management page', '2026-02-04 08:08:22'),
(1069, 1, 'Toggle Media Link Status', 'Toggled link status', '2026-02-04 08:08:32'),
(1070, 1, 'View Media Links', 'Viewed media links management page', '2026-02-04 08:08:32'),
(1071, 1, 'View Feedback', 'Viewed feedback management page', '2026-02-04 08:08:53'),
(1072, 1, 'View Feedback', 'Viewed feedback management page', '2026-02-04 08:46:40'),
(1073, 1, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 08:47:07'),
(1074, 1, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 08:47:09'),
(1075, 1, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 08:47:10'),
(1076, 1, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 08:47:11'),
(1077, 1, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 08:48:01'),
(1078, 1, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 08:50:22'),
(1079, 1, 'View Ragging Reports', 'Viewed ragging reports list', '2026-02-04 08:52:59'),
(1080, 1, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 09:16:46'),
(1081, 1, 'View Ragging Reports', 'Viewed ragging reports list', '2026-02-04 09:16:47'),
(1082, 1, 'View Ragging Report', 'Viewed report #1', '2026-02-04 09:16:49'),
(1083, 1, 'Update Ragging Report', 'Updated status of report #1 to reviewed', '2026-02-04 09:17:28'),
(1084, 1, 'View Ragging Report', 'Viewed report #1', '2026-02-04 09:17:28'),
(1085, 1, 'View Ragging Reports', 'Viewed ragging reports list', '2026-02-04 09:17:32'),
(1086, 1, 'View Ragging Reports', 'Viewed ragging reports list', '2026-02-04 09:23:09'),
(1087, 1, 'View Ragging Reports', 'Viewed ragging reports list', '2026-02-04 09:25:21'),
(1088, 1, 'Delete Ragging Report', 'Deleted report #1', '2026-02-04 09:25:24'),
(1089, 1, 'View Ragging Reports', 'Viewed ragging reports list', '2026-02-04 09:25:24'),
(1090, 1, 'View Ragging Reports', 'Viewed ragging reports list', '2026-02-04 09:27:57'),
(1091, 1, 'View Ragging Report', 'Viewed report #3', '2026-02-04 09:28:04'),
(1092, 1, 'Delete Ragging Report', 'Deleted report #3', '2026-02-04 09:28:17'),
(1093, 1, 'View Ragging Reports', 'Viewed ragging reports list', '2026-02-04 09:28:17'),
(1094, 1, 'Delete Ragging Report', 'Deleted report #2', '2026-02-04 09:28:20'),
(1095, 1, 'View Ragging Reports', 'Viewed ragging reports list', '2026-02-04 09:28:20'),
(1096, 1, 'View Users', 'Viewed users management page', '2026-02-04 09:28:28'),
(1097, 1, 'Change User Password', 'Accessed change password page for user: test', '2026-02-04 09:28:37'),
(1098, 1, 'Change User Password', 'Changed password for user: test', '2026-02-04 09:28:52'),
(1099, 1, 'Change User Password', 'Accessed change password page for user: test', '2026-02-04 09:28:52'),
(1100, 1, 'View Users', 'Viewed users management page', '2026-02-04 09:28:56'),
(1101, 1, 'Logout', 'User logged out', '2026-02-04 09:29:02'),
(1102, 2, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 09:29:13'),
(1103, 2, 'View Inquiries', 'Viewed inquiries management page', '2026-02-04 09:29:16'),
(1104, 2, 'View Contacts', 'Viewed contacts management page', '2026-02-04 09:29:17'),
(1105, 2, 'Add Announcement Category', 'Accessed add announcement category page', '2026-02-04 09:32:11'),
(1106, 2, 'View Announcement Categories', 'Viewed announcement category management page', '2026-02-04 09:32:15'),
(1107, 2, 'Add Announcement Category', 'Accessed add announcement category page', '2026-02-04 09:33:01'),
(1108, 2, 'Add Announcement Category', 'Added category: Circular', '2026-02-04 09:33:07'),
(1109, 2, 'Add Announcement Category', 'Accessed add announcement category page', '2026-02-04 09:33:07'),
(1110, 2, 'Add Announcement Category', 'Added category: Updates', '2026-02-04 09:33:13'),
(1111, 2, 'Add Announcement Category', 'Accessed add announcement category page', '2026-02-04 09:33:13'),
(1112, 2, 'Add Announcement', 'Accessed add announcement page', '2026-02-04 09:33:19'),
(1113, 2, 'Add Material Category', 'Accessed add material category page', '2026-02-04 09:35:35'),
(1114, 2, 'Add Material File', 'Accessed add material file page', '2026-02-04 09:35:43'),
(1115, 2, 'Add Announcement Category', 'Accessed add announcement category page', '2026-02-04 09:42:08'),
(1116, 2, 'Add Announcement Category', 'Added category: Exam Notice', '2026-02-04 09:42:16'),
(1117, 2, 'Add Announcement Category', 'Accessed add announcement category page', '2026-02-04 09:42:16'),
(1118, 2, 'View Announcement Categories', 'Viewed announcement category management page', '2026-02-04 09:42:32'),
(1119, 2, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 09:43:32'),
(1120, 2, 'View Inquiries', 'Viewed inquiries management page', '2026-02-04 09:43:37'),
(1121, 2, 'View Contacts', 'Viewed contacts management page', '2026-02-04 09:43:38'),
(1122, 2, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 09:43:39'),
(1123, 2, 'Add Disclosure', 'Accessed add disclosure page', '2026-02-04 09:43:55'),
(1124, 2, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 09:44:00'),
(1125, 2, 'Add Announcement', 'Accessed add announcement page', '2026-02-04 10:10:43'),
(1126, 2, 'Add Announcement', 'Added announcement: this is a test', '2026-02-04 10:11:01'),
(1127, 2, 'Add Announcement', 'Accessed add announcement page', '2026-02-04 10:11:01'),
(1128, 2, 'Add Announcement', 'Added announcement: this is a test', '2026-02-04 10:11:16'),
(1129, 2, 'Add Announcement', 'Accessed add announcement page', '2026-02-04 10:11:16'),
(1130, 2, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 10:57:09'),
(1131, 2, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 10:57:14'),
(1132, 2, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 10:57:18'),
(1133, 2, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 10:57:21'),
(1134, 2, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 10:58:34'),
(1135, 2, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 10:58:41'),
(1136, 2, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 10:58:46'),
(1137, 2, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 11:01:40'),
(1138, 2, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 11:06:54'),
(1139, 2, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 11:23:42'),
(1140, 2, 'Logout', 'User logged out', '2026-02-04 11:25:40'),
(1141, 1, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 11:25:46'),
(1142, 1, 'Dashboard Access', 'Accessed dashboard', '2026-02-04 11:27:15');

-- --------------------------------------------------------

--
-- Table structure for table `admission_forms`
--

DROP TABLE IF EXISTS `admission_forms`;
CREATE TABLE IF NOT EXISTS `admission_forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateofbirth` date DEFAULT NULL,
  `gender` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `religion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aadhar` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobilenumber` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stdemail` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `program` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `degree` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `bloodgroup` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disability` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fathername` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fatheroccupation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fathernumber` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fatheremail` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fadnumber` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fpannumber` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mothername` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motheroccupation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mothernumber` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motheremail` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `madnumber` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mpannumber` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `presentaddress` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `guardianname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guardainaddress` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `guardainmobile` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `relation` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preclass` int(11) DEFAULT NULL,
  `qualification` decimal(5,2) DEFAULT NULL,
  `preclassatt` int(11) DEFAULT NULL,
  `onesiblingname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `onesiblingclass` int(11) DEFAULT NULL,
  `twosiblingname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twosiblingclass` int(11) DEFAULT NULL,
  `threesiblingname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `threesiblingclass` int(11) DEFAULT NULL,
  `stdphoto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stdsign` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stdaadhar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stdtc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stdrtcard` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stdmgcert` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fatphoto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fatsign` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fataadhar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motphoto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motsign` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motaadhar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guardphoto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stdbirth` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transport` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agree` tinyint(1) DEFAULT '0',
  `status` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_admission_forms_status` (`status`),
  KEY `idx_admission_forms_created_at` (`created_at`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
CREATE TABLE IF NOT EXISTS `announcements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_announcements_category_id` (`category_id`),
  KEY `idx_announcements_status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `category_id`, `title`, `content`, `status`, `created_at`) VALUES
(20, 1, 'M.Pharm Admissions 2025 - Applications Open', 'Applications are now open for M.Pharm programs. Apply online to secure your seat for the 2025 intake. Early applications will be given priority for scholarships.', 'active', '2026-02-04 04:18:36'),
(21, 3, 'B. Pharma (2022-26) 7th Semester', 'B. Pharma (2022-26) 7th Semester Classes will start on its regular timing from 1st of February. Time Table will be uploaded later on the website.', 'active', '2026-02-04 04:58:17'),
(22, 1, 'Test 2', 'This is a test for api call for announcements', 'active', '2026-02-04 07:26:34'),
(23, 3, 'Test 3', 'This is a test for api call for announcements test 3', 'active', '2026-02-04 07:26:45'),
(24, 5, 'this is a test', 'this is a test for circular inpput', 'active', '2026-02-04 10:11:01'),
(25, 6, 'this is a test', 'this is a test for update announcements inpput', 'active', '2026-02-04 10:11:16');

-- --------------------------------------------------------

--
-- Table structure for table `announcements_recycle`
--

DROP TABLE IF EXISTS `announcements_recycle`;
CREATE TABLE IF NOT EXISTS `announcements_recycle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `deleted_by` (`deleted_by`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcement_categories`
--

DROP TABLE IF EXISTS `announcement_categories`;
CREATE TABLE IF NOT EXISTS `announcement_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcement_categories`
--

INSERT INTO `announcement_categories` (`id`, `name`, `status`, `created_at`) VALUES
(1, 'Announcement', 'active', '2025-08-04 08:36:00'),
(2, 'News', 'active', '2025-08-04 08:36:00'),
(3, 'Notice', 'active', '2025-08-04 08:36:00'),
(4, 'Rules & Regulations', 'active', '2025-11-23 04:17:23'),
(5, 'Circular', 'active', '2026-02-04 09:33:07'),
(6, 'Updates', 'active', '2026-02-04 09:33:13'),
(7, 'Exam Notice', 'active', '2026-02-04 09:42:16');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
CREATE TABLE IF NOT EXISTS `classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `name`, `status`, `created_at`, `description`) VALUES
(1, '09', 'active', '2025-08-04 08:36:00', ''),
(2, '10', 'active', '2025-08-04 08:36:00', ''),
(3, '11', 'active', '2025-08-04 08:36:00', ''),
(4, '12', 'active', '2025-08-04 08:36:00', ''),
(5, '1', 'active', '2025-09-26 05:18:04', ''),
(6, '2', 'active', '2025-11-23 03:54:18', ''),
(7, '3', 'active', '2025-11-23 03:55:40', '');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('new','read','replied','closed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_contacts_status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `subject`, `message`, `status`, `created_at`) VALUES
(1, 'Test User', 'test@example.com', '+91-1234567890', 'Test Subject', 'This is a test message', 'new', '2026-02-04 05:30:44'),
(2, 'Test User', 'test@example.com', '+91-1234567890', 'Test Subject', 'This is a test message', 'new', '2026-02-04 05:33:15'),
(3, 'John Doe', 'john@example.com', '+91-9876543210', 'Test Inquiry', 'This is a test message', 'new', '2026-02-04 05:43:18'),
(4, 'John Doe', 'john@example.com', '+91-9876543210', 'Test Inquiry', 'This is a test message', 'new', '2026-02-04 05:43:21'),
(5, 'John Doe', 'john@example.com', '+91-9876543210', 'Test Inquiry', 'This is a test message', 'new', '2026-02-04 05:43:24'),
(7, 'Jay Thakur', 'kr.himanshu@outlook.in', '07461007540', 'Test Inquiry', 'test for api calls', 'read', '2026-02-04 05:53:48');

-- --------------------------------------------------------

--
-- Table structure for table `contacts_recycle`
--

DROP TABLE IF EXISTS `contacts_recycle`;
CREATE TABLE IF NOT EXISTS `contacts_recycle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) NOT NULL COMMENT 'Original contact ID',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('new','read','replied','closed') COLLATE utf8mb4_unicode_ci DEFAULT 'new',
  `deleted_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `restored_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`),
  KEY `deleted_at` (`deleted_at`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts_recycle`
--

INSERT INTO `contacts_recycle` (`id`, `contact_id`, `name`, `email`, `phone`, `subject`, `message`, `status`, `deleted_at`, `restored_at`) VALUES
(1, 6, 'John Doe', 'john@example.com', '+91-9876543210', 'Test Inquiry', 'This is a test message', 'new', '2026-02-04 11:32:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `disclosures`
--

DROP TABLE IF EXISTS `disclosures`;
CREATE TABLE IF NOT EXISTS `disclosures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `disclosures_recycle`
--

DROP TABLE IF EXISTS `disclosures_recycle`;
CREATE TABLE IF NOT EXISTS `disclosures_recycle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original_id` int(11) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `deleted_by` (`deleted_by`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('new','read','replied','closed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `idx_feedback_status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_categories`
--

DROP TABLE IF EXISTS `gallery_categories`;
CREATE TABLE IF NOT EXISTS `gallery_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery_categories`
--

INSERT INTO `gallery_categories` (`id`, `name`, `description`, `status`, `created_at`) VALUES
(1, 'mip_college', 'test', 'active', '2025-09-26 04:08:11');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_categories_recycle`
--

DROP TABLE IF EXISTS `gallery_categories_recycle`;
CREATE TABLE IF NOT EXISTS `gallery_categories_recycle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original_id` int(11) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `deleted_by` (`deleted_by`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery_categories_recycle`
--

INSERT INTO `gallery_categories_recycle` (`id`, `original_id`, `name`, `deleted_at`, `deleted_by`) VALUES
(1, 2, 'test2', '2025-11-21 11:07:20', NULL),
(2, 3, 'mmmm', '2025-11-21 11:08:22', NULL),
(3, NULL, 'nnn', '2025-11-21 11:11:07', NULL),
(5, NULL, 'bbb', '2025-11-21 11:12:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images`
--

DROP TABLE IF EXISTS `gallery_images`;
CREATE TABLE IF NOT EXISTS `gallery_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_gallery_images_category_id` (`category_id`),
  KEY `idx_gallery_images_status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery_images`
--

INSERT INTO `gallery_images` (`id`, `category_id`, `name`, `image`, `description`, `status`, `created_at`) VALUES
(3, 1, 'test', '69204bd80f4f5_1763724248.png', NULL, 'active', '2025-11-21 10:57:58'),
(4, 1, 'mip test 2', '698224fd9afb3_1770136829.jpeg', NULL, 'active', '2026-02-03 16:40:29'),
(5, 1, 'Main Campus', '6982f722c2295_1770190626.jpg', NULL, 'active', '2026-02-04 07:37:06');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images_recycle`
--

DROP TABLE IF EXISTS `gallery_images_recycle`;
CREATE TABLE IF NOT EXISTS `gallery_images_recycle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `deleted_by` (`deleted_by`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

DROP TABLE IF EXISTS `inquiries`;
CREATE TABLE IF NOT EXISTS `inquiries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('new','read','replied','closed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_inquiries_status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`id`, `name`, `email`, `phone`, `course`, `message`, `status`, `created_at`) VALUES
(2, 'Jay', 'jay@gmail.com', '9999999999', 'bpharm', 'this is a test message for testing the api', 'read', '2026-02-04 06:16:31');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries_recycle`
--

DROP TABLE IF EXISTS `inquiries_recycle`;
CREATE TABLE IF NOT EXISTS `inquiries_recycle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inquiry_id` int(11) NOT NULL COMMENT 'Original inquiry ID',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('new','read','replied','closed') COLLATE utf8mb4_unicode_ci DEFAULT 'new',
  `deleted_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `restored_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inquiry_id` (`inquiry_id`),
  KEY `deleted_at` (`deleted_at`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

DROP TABLE IF EXISTS `materials`;
CREATE TABLE IF NOT EXISTS `materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `section_id` (`section_id`),
  KEY `subject_id` (`subject_id`),
  KEY `idx_materials_type_id` (`type_id`),
  KEY `idx_materials_class_id` (`class_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `type_id`, `class_id`, `section_id`, `subject_id`, `name`, `file`, `file_type`, `file_size`, `description`, `status`, `created_at`) VALUES
(13, 2, 5, 4, 1, 'HIMANSHU KUMAR', '692288ce3942f_1763870926.png', 'image/png', 236914, 'qaaa', 'active', '2025-11-23 04:08:46'),
(14, 3, 7, NULL, 2, 'English Writing', '692289bfb6679_1763871167.png', 'image/png', 137913, 'Complete and submit the homework on 13/01/2025', 'active', '2025-11-23 04:12:47'),
(15, 3, 6, NULL, 2, 'pdf', '6922a3fbabc8d_1763877883.pdf', 'application/pdf', 163533, '333', 'active', '2025-11-23 06:04:43'),
(12, 1, 1, 1, 1, 'dps_db', '692281e233ebd_1763869154.png', NULL, NULL, 'wwww', 'active', '2025-11-23 03:44:53');

-- --------------------------------------------------------

--
-- Table structure for table `materials_recycle`
--

DROP TABLE IF EXISTS `materials_recycle`;
CREATE TABLE IF NOT EXISTS `materials_recycle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `deleted_by` (`deleted_by`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `materials_recycle`
--

INSERT INTO `materials_recycle` (`id`, `original_id`, `type_id`, `class_id`, `section_id`, `subject_id`, `name`, `file_path`, `description`, `deleted_at`, `deleted_by`) VALUES
(10, 6, 1, 5, 1, 1, 'mip2', '', 'ewdcs', '2025-11-23 03:45:04', 1),
(11, 11, 1, 1, 1, 1, 'dps_db', '69227f75cf55e_1763868533.png', 'aAAA', '2025-11-23 03:45:06', 1),
(12, 10, 1, 5, 1, 1, 'dps_db', '69227dc60f9fb_1763868102.png', 'aaa', '2025-11-23 03:45:08', 1),
(13, 9, 1, 5, 1, 1, 'dps_db', 'http://localhost/control-dashboard/uploads/materials/materials/', '', '2025-11-23 03:45:10', 1),
(14, 8, 1, 5, 2, 1, 'dps_db', 'Screenshot (1).png', 'uihi', '2025-11-23 03:45:12', 1),
(15, 7, 1, 5, 1, 1, 'mip2', '', 'llll', '2025-11-23 03:45:14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `material_types`
--

DROP TABLE IF EXISTS `material_types`;
CREATE TABLE IF NOT EXISTS `material_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material_types`
--

INSERT INTO `material_types` (`id`, `name`, `status`, `created_at`) VALUES
(1, 'Study Material', 'active', '2025-08-04 08:36:00'),
(2, 'Homework and Assignments', 'active', '2025-08-04 08:36:00'),
(3, 'Winter Homework', 'active', '2025-11-23 03:49:15');

-- --------------------------------------------------------

--
-- Table structure for table `media_categories`
--

DROP TABLE IF EXISTS `media_categories`;
CREATE TABLE IF NOT EXISTS `media_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media_categories`
--

INSERT INTO `media_categories` (`id`, `name`, `description`, `status`, `created_at`) VALUES
(1, 'test', 'this is a test category for check', 'active', '2025-09-18 12:37:23');

-- --------------------------------------------------------

--
-- Table structure for table `media_categories_recycle`
--

DROP TABLE IF EXISTS `media_categories_recycle`;
CREATE TABLE IF NOT EXISTS `media_categories_recycle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original_id` int(11) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `deleted_by` (`deleted_by`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media_categories_recycle`
--

INSERT INTO `media_categories_recycle` (`id`, `original_id`, `name`, `deleted_at`, `deleted_by`) VALUES
(2, NULL, 'admin', '2025-09-18 13:45:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `media_links`
--

DROP TABLE IF EXISTS `media_links`;
CREATE TABLE IF NOT EXISTS `media_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media_links`
--

INSERT INTO `media_links` (`id`, `category_id`, `name`, `link_url`, `description`, `status`, `created_at`) VALUES
(1, 1, 'test', 'https://www.youtube.com/watch?v=4QbW0jJyrFo', NULL, 'inactive', '2025-09-18 13:03:19');

-- --------------------------------------------------------

--
-- Table structure for table `media_links_recycle`
--

DROP TABLE IF EXISTS `media_links_recycle`;
CREATE TABLE IF NOT EXISTS `media_links_recycle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `deleted_by` (`deleted_by`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media_links_recycle`
--

INSERT INTO `media_links_recycle` (`id`, `original_id`, `category_id`, `name`, `link_url`, `deleted_at`, `deleted_by`) VALUES
(2, NULL, 1, 'test2', 'https://www.youtube.com/watch?v=4QbW0jJyrFo', '2025-09-18 13:28:09', NULL),
(4, NULL, 1, 'B.Pharm Program Overview', 'https://youtu.be/pFrE14wpGWY', '2026-02-04 08:08:06', NULL),
(5, NULL, 1, 'Student Life at MIP', 'https://www.youtube.com/watch?v=Z9G-VLHrMiE', '2026-02-04 08:08:09', NULL),
(6, NULL, 1, 'Faculty & Research Excellence', 'https://youtu.be/U7sQi5xwkWs', '2026-02-04 08:08:11', NULL),
(7, NULL, 1, 'Placement & Career Success', 'https://www.youtube.com/watch?v=8YDGQU4f6OQ', '2026-02-04 08:08:14', NULL),
(8, NULL, 1, 'Admission & Application Process', 'https://youtu.be/qGY0FKwqfK8', '2026-02-04 08:08:19', NULL),
(3, NULL, 1, 'Campus Tour - Magadh Institute of Pharmacy', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', '2026-02-04 08:08:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ragging_reports`
--

DROP TABLE IF EXISTS `ragging_reports`;
CREATE TABLE IF NOT EXISTS `ragging_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'anti-ragging',
  `recipient` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipient_phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recipient_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reporter_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reporter_phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reporter_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_anonymous` tinyint(1) DEFAULT '0',
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `send_sms` tinyint(1) DEFAULT '0',
  `status` enum('pending','reviewed','resolved','closed') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

DROP TABLE IF EXISTS `results`;
CREATE TABLE IF NOT EXISTS `results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course` enum('D.Pharma','B.Pharma','M.Pharma') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Course Name',
  `year` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Semester (e.g., Sem I, Sem II)',
  `result_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Type: Regular, Supplementary, etc.',
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Path to the PDF file',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `course`, `year`, `semester`, `result_type`, `file_path`, `status`, `created_at`) VALUES
(1, 'D.Pharma', '2025-27', 'Sem I', 'Regular', 'downloads/results/dpharm-2025-sem1.pdf', 'active', '2026-02-04 10:37:00'),
(2, 'B.Pharma', '2022-26', 'Sem VII', 'Regular', 'control-dashboard/uploads/materials/results/b-pharma-2022-26-sem-vii-1770203142.pdf', 'active', '2026-02-04 11:05:42');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

DROP TABLE IF EXISTS `sections`;
CREATE TABLE IF NOT EXISTS `sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) DEFAULT NULL,
  `name` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `class_id` (`class_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `class_id`, `name`, `status`, `description`, `created_at`) VALUES
(1, NULL, 'A', 'active', '', '2025-09-26 05:38:22'),
(2, 5, 'A', 'active', '1', '2025-09-26 05:59:09'),
(3, 1, 'A', 'active', 'jnjn', '2025-09-26 06:13:38'),
(4, 5, 'B', 'active', '', '2025-11-23 04:01:17');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

DROP TABLE IF EXISTS `sliders`;
CREATE TABLE IF NOT EXISTS `sliders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `sort_order` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_sliders_status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `name`, `image`, `status`, `sort_order`, `created_at`) VALUES
(11, 'slide3', '6982c59c5ecc7_1770177948.jpg', 'active', 0, '2026-02-04 04:05:48'),
(12, 'slide2', '6982c5abe6916_1770177963.jpg', 'active', 0, '2026-02-04 04:06:03'),
(13, 'slide3', '6982c5b69bab7_1770177974.jpg', 'active', 0, '2026-02-04 04:06:14');

-- --------------------------------------------------------

--
-- Table structure for table `sliders_recycle`
--

DROP TABLE IF EXISTS `sliders_recycle`;
CREATE TABLE IF NOT EXISTS `sliders_recycle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original_id` int(11) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `deleted_by` (`deleted_by`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `description`, `status`, `created_at`) VALUES
(1, 'HINDI', 'jidnio', 'active', '2025-09-26 06:07:20'),
(2, 'ENGLISH', 'ENGLISH', 'active', '2025-11-23 04:10:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` enum('super_user','admin','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `profile_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_users_username` (`username`),
  KEY `idx_users_email` (`email`),
  KEY `idx_users_status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `email`, `mobile_number`, `user_type`, `status`, `profile_image`, `last_login`, `created_at`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Super Administrator', 'admin@adminpanel.com', NULL, 'super_user', 'active', NULL, '2026-02-04 16:55:46', '2025-08-04 08:36:00'),
(2, 'test', '$2y$10$HIMS.eOvDkxb9LUJVfBbtOEusYfj8MlOpWwGS/XN9zpsDC1M7xVPO', 'jay', 'kr.himanshu@outlook.in', '07461007540', 'admin', 'active', NULL, '2026-02-04 16:53:42', '2025-08-04 08:40:41');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
