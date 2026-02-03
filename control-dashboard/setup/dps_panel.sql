-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 23, 2025 at 07:46 AM
-- Server version: 10.4.10-MariaDB
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
-- Database: `dps_panel`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_activity_logs_user_id` (`user_id`),
  KEY `idx_activity_logs_created_at` (`created_at`)
) ENGINE=MyISAM AUTO_INCREMENT=943 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `details`, `created_at`) VALUES
(1, 1, 'Dashboard Access', 'Accessed dashboard', '2025-08-04 08:37:18'),
(2, 1, 'View Users', 'Viewed users management page', '2025-08-04 08:37:49'),
(3, 1, 'Add User', 'Accessed add user page', '2025-08-04 08:40:10'),
(4, 1, 'Add User', 'Added user: test', '2025-08-04 08:40:41'),
(5, 1, 'Add User', 'Accessed add user page', '2025-08-04 08:40:41'),
(6, 1, 'Add User', 'Accessed add user page', '2025-08-04 08:40:47'),
(7, 1, 'View Users', 'Viewed users management page', '2025-08-04 08:40:53'),
(8, 1, 'View Users', 'Viewed users management page', '2025-08-04 09:11:06'),
(9, 1, 'View Users', 'Viewed users management page', '2025-08-04 09:11:37'),
(10, 1, 'View Users', 'Viewed users management page', '2025-08-04 09:43:50'),
(11, 1, 'Logout', 'User logged out', '2025-08-04 09:43:53'),
(12, 2, 'Dashboard Access', 'Accessed dashboard', '2025-08-04 10:09:13'),
(13, 2, 'Dashboard Access', 'Accessed dashboard', '2025-08-04 10:12:04'),
(14, 2, 'Dashboard Access', 'Accessed dashboard', '2025-08-04 10:14:26'),
(15, 2, 'Dashboard Access', 'Accessed dashboard', '2025-08-04 10:14:39'),
(16, 2, 'Add Slider', 'Added slider: test', '2025-08-04 10:17:34'),
(17, 2, 'View Sliders', 'Viewed slider management page', '2025-08-04 10:17:53'),
(18, 2, 'Toggle Slider Status', 'Toggled slider status', '2025-08-04 10:18:02'),
(19, 2, 'View Sliders', 'Viewed slider management page', '2025-08-04 10:18:02'),
(20, 2, 'Toggle Slider Status', 'Toggled slider status', '2025-08-04 10:18:10'),
(21, 2, 'View Sliders', 'Viewed slider management page', '2025-08-04 10:18:10'),
(22, 2, 'Toggle Slider Status', 'Toggled slider status', '2025-08-04 10:18:20'),
(23, 2, 'View Sliders', 'Viewed slider management page', '2025-08-04 10:18:20'),
(24, 2, 'Toggle Slider Status', 'Toggled slider status', '2025-08-04 10:18:24'),
(25, 2, 'View Sliders', 'Viewed slider management page', '2025-08-04 10:18:24'),
(26, 2, 'Edit Slider', 'Accessed edit page for slider: test', '2025-08-04 10:18:31'),
(27, 2, 'Toggle Slider Status', 'Toggled slider status', '2025-08-04 10:18:37'),
(28, 2, 'View Sliders', 'Viewed slider management page', '2025-08-04 10:18:37'),
(29, 2, 'Toggle Slider Status', 'Toggled slider status', '2025-08-04 10:18:52'),
(30, 2, 'View Sliders', 'Viewed slider management page', '2025-08-04 10:18:52'),
(31, 1, 'Dashboard Access', 'Accessed dashboard', '2025-08-04 10:20:34'),
(32, 1, 'Dashboard Access', 'Accessed dashboard', '2025-08-04 10:23:05'),
(33, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-08-04 10:23:07'),
(34, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-08-04 10:26:50'),
(35, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-08-04 10:28:16'),
(36, 1, 'Dashboard Access', 'Accessed dashboard', '2025-08-04 10:28:19'),
(37, 1, 'Logout', 'User logged out', '2025-08-04 10:28:22'),
(38, 2, 'Dashboard Access', 'Accessed dashboard', '2025-08-04 10:28:29'),
(39, 2, 'View Inquiries', 'Viewed inquiries management page', '2025-08-04 10:28:34'),
(40, 2, 'View Contacts', 'Viewed contacts management page', '2025-08-04 10:28:41'),
(41, 2, 'View Sliders', 'Viewed slider management page', '2025-08-04 10:28:46'),
(42, 2, 'View Sliders', 'Viewed slider management page', '2025-08-04 10:29:45'),
(43, 2, 'Edit Slider', 'Accessed edit page for slider: test', '2025-08-04 10:29:50'),
(44, 2, 'Edit Slider', 'Accessed edit page for slider: test', '2025-08-04 10:30:48'),
(45, 2, 'View Sliders', 'Viewed slider management page', '2025-08-04 10:31:26'),
(46, 2, 'Edit Slider', 'Accessed edit page for slider: test', '2025-08-04 10:31:28'),
(47, 2, 'Edit Slider', 'Updated slider: test', '2025-08-04 10:31:43'),
(48, 2, 'Edit Slider', 'Accessed edit page for slider: test', '2025-08-04 10:31:43'),
(49, 2, 'Edit Slider', 'Accessed edit page for slider: test', '2025-08-04 10:32:47'),
(50, 2, 'Edit Slider', 'Updated slider: test', '2025-08-04 10:32:53'),
(51, 2, 'Edit Slider', 'Accessed edit page for slider: test', '2025-08-04 10:32:53'),
(52, 1, 'Dashboard Access', 'Accessed dashboard', '2025-08-06 03:47:24'),
(53, 1, 'Dashboard Access', 'Accessed dashboard', '2025-08-06 03:57:07'),
(54, 1, 'Dashboard Access', 'Accessed dashboard', '2025-08-06 04:22:29'),
(55, 1, 'Dashboard Access', 'Accessed dashboard', '2025-08-06 04:22:31'),
(56, 1, 'Dashboard Access', 'Accessed dashboard', '2025-08-06 04:22:32'),
(57, 1, 'Add Disclosure', 'Accessed add disclosure page', '2025-08-06 04:22:49'),
(58, 1, 'Dashboard Access', 'Accessed dashboard', '2025-08-06 04:30:48'),
(59, 1, 'View Sliders', 'Viewed slider management page', '2025-08-06 04:30:59'),
(60, 1, 'View Gallery Images', 'Viewed gallery images management page', '2025-08-06 04:31:14'),
(61, 1, 'View Media Links', 'Viewed media links management page', '2025-08-06 04:31:19'),
(62, 1, 'Add Material Category', 'Accessed add material category page', '2025-08-06 04:31:22'),
(63, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-08-06 04:31:24'),
(64, 1, 'View Sliders', 'Viewed slider management page', '2025-08-06 04:31:27'),
(65, 1, 'View Sliders', 'Viewed slider management page', '2025-08-06 04:35:49'),
(66, 1, 'View Sliders', 'Viewed slider management page', '2025-08-06 04:35:54'),
(67, 1, 'View Recycle Bin', 'Viewed slider recycle bin', '2025-08-06 04:35:57'),
(68, 1, 'Add Disclosure', 'Accessed add disclosure page', '2025-08-06 04:35:59'),
(69, 1, 'View Disclosures', 'Viewed disclosure management page', '2025-08-06 04:36:02'),
(70, 1, 'View Recycle Bin', 'Viewed disclosure recycle bin', '2025-08-06 04:36:03'),
(71, 1, 'Add Gallery Category', 'Accessed add gallery category page', '2025-08-06 04:36:06'),
(72, 1, 'View Gallery Categories', 'Viewed gallery category management page', '2025-08-06 04:36:07'),
(73, 1, 'Dashboard Access', 'Accessed dashboard', '2025-08-06 06:57:09'),
(74, 1, 'Dashboard Access', 'Accessed dashboard', '2025-08-06 06:58:14'),
(75, 1, 'View Users', 'Viewed users management page', '2025-08-06 06:58:24'),
(76, 1, 'Toggle User Status', 'Toggled user status', '2025-08-06 06:58:29'),
(77, 1, 'View Users', 'Viewed users management page', '2025-08-06 06:58:29'),
(78, 1, 'Toggle User Status', 'Toggled user status', '2025-08-06 06:58:33'),
(79, 1, 'View Users', 'Viewed users management page', '2025-08-06 06:58:33'),
(80, 1, 'View Inquiries', 'Viewed inquiries management page', '2025-08-06 06:58:42'),
(81, 1, 'View Contacts', 'Viewed contacts management page', '2025-08-06 06:58:44'),
(82, 1, 'View Feedback', 'Viewed feedback management page', '2025-08-06 06:58:45'),
(83, 1, 'View Sliders', 'Viewed slider management page', '2025-08-06 06:58:49'),
(84, 1, 'View Recycle Bin', 'Viewed slider recycle bin', '2025-08-06 06:58:51'),
(85, 1, 'Add Disclosure', 'Accessed add disclosure page', '2025-08-06 06:58:53'),
(86, 1, 'View Disclosures', 'Viewed disclosure management page', '2025-08-06 06:58:54'),
(87, 1, 'View Recycle Bin', 'Viewed disclosure recycle bin', '2025-08-06 06:58:56'),
(88, 1, 'Add Gallery Category', 'Accessed add gallery category page', '2025-08-06 06:58:58'),
(89, 1, 'View Gallery Categories', 'Viewed gallery category management page', '2025-08-06 06:59:01'),
(90, 1, 'Add Gallery Image', 'Accessed add gallery image page', '2025-08-06 06:59:03'),
(91, 1, 'View Gallery Images', 'Viewed gallery images management page', '2025-08-06 06:59:24'),
(92, 1, 'View Recycle Bin', 'Viewed gallery recycle bin', '2025-08-06 06:59:27'),
(93, 1, 'Add Media Category', 'Accessed add media category page', '2025-08-06 06:59:34'),
(94, 1, 'View Media Categories', 'Viewed media category management page', '2025-08-06 06:59:37'),
(95, 1, 'View Media Links', 'Viewed media links management page', '2025-08-06 06:59:45'),
(96, 1, 'View Media Links', 'Viewed media links management page', '2025-08-06 07:07:41'),
(97, 1, 'View Media Links', 'Viewed media links management page', '2025-08-06 07:08:10'),
(98, 1, 'Add Material Category', 'Accessed add material category page', '2025-08-06 07:08:17'),
(99, 1, 'View Material Categories', 'Viewed material category management page', '2025-08-06 07:08:21'),
(100, 1, 'Add Material File', 'Accessed add material file page', '2025-08-06 07:08:23'),
(101, 1, 'View Material Files', 'Viewed material files management page', '2025-08-06 07:08:50'),
(102, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-08-06 07:08:53'),
(103, 1, 'Add Announcement Category', 'Accessed add announcement category page', '2025-08-06 07:08:56'),
(104, 1, 'View Announcement Categories', 'Viewed announcement category management page', '2025-08-06 07:08:58'),
(105, 1, 'Add Announcement', 'Accessed add announcement page', '2025-08-06 07:09:07'),
(106, 1, 'View Recycle Bin', 'Viewed announcements recycle bin', '2025-08-06 07:09:12'),
(107, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-08-06 07:09:13'),
(108, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-08-06 07:42:57'),
(109, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-08-06 07:42:59'),
(110, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-08-06 08:03:48'),
(111, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-08-06 08:44:16'),
(112, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-08-06 08:46:17'),
(113, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-08-06 08:47:45'),
(114, 1, 'View Sliders', 'Viewed slider management page', '2025-08-06 08:47:50'),
(115, 1, 'View Recycle Bin', 'Viewed slider recycle bin', '2025-08-06 08:47:52'),
(116, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-08-06 08:47:54'),
(117, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-08-06 08:51:45'),
(118, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-08-06 08:52:20'),
(119, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-08-06 08:52:28'),
(120, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-08-06 08:52:30'),
(121, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-08-06 08:52:33'),
(122, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-08-06 08:52:36'),
(123, 1, 'View Admission Form', 'Viewed form from: ', '2025-08-06 08:52:41'),
(124, 1, 'View Admission Form', 'Viewed form from: Rishabh Saxena', '2025-08-06 08:58:54'),
(125, 1, 'Send Email', 'Accessed email page for form: ', '2025-08-06 08:59:16'),
(126, 1, 'View Admission Form', 'Viewed form from: Rishabh Saxena', '2025-08-06 08:59:24'),
(127, 1, 'Send Email', 'Accessed email page for form: ', '2025-08-06 08:59:27'),
(128, 1, 'Send Email', 'Accessed email page for form: Rishabh Saxena', '2025-08-06 09:04:11'),
(129, 1, 'View Admission Form', 'Viewed form from: Rishabh Saxena', '2025-08-06 09:04:28'),
(130, 1, 'View Admission Form', 'Viewed form from: Rishabh Saxena', '2025-08-06 09:07:38'),
(131, 1, 'View Admission Form', 'Viewed form from: Rishabh Saxena', '2025-08-06 09:11:40'),
(132, 1, 'Send Email', 'Accessed email page for form: Rishabh Saxena', '2025-08-06 09:13:10'),
(133, 1, 'Send Email', 'Accessed email page for form: Rishabh Saxena', '2025-08-06 09:18:55'),
(134, 1, 'Send Email', 'Accessed email page for form: Rishabh Saxena', '2025-08-06 09:19:08'),
(135, 1, 'View Admission Form', 'Viewed form from: Rishabh Saxena', '2025-08-06 09:20:41'),
(136, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-08-06 09:20:45'),
(137, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-08-06 09:20:57'),
(138, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-08-06 09:21:06'),
(139, 1, 'Toggle Admission Form Status', 'Toggled form status', '2025-08-06 09:24:25'),
(140, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-08-06 09:24:25'),
(141, 1, 'Toggle Admission Form Status', 'Toggled form status', '2025-08-06 09:24:27'),
(142, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-08-06 09:24:27'),
(143, 1, 'Toggle Admission Form Status', 'Toggled form status', '2025-08-06 09:24:30'),
(144, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-08-06 09:24:30'),
(145, 1, 'Toggle Admission Form Status', 'Toggled form status', '2025-08-06 09:24:39'),
(146, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-08-06 09:24:39'),
(147, 1, 'Toggle Admission Form Status', 'Toggled form status', '2025-08-06 09:24:51'),
(148, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-08-06 09:24:51'),
(149, 1, 'Toggle Admission Form Status', 'Toggled form status', '2025-08-06 09:24:55'),
(150, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-08-06 09:24:55'),
(151, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-08-06 09:25:02'),
(152, 1, 'Toggle Admission Form Status', 'Toggled form status', '2025-08-06 09:25:04'),
(153, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-08-06 09:25:04'),
(154, 1, 'View Recycle Bin', 'Viewed announcements recycle bin', '2025-08-06 09:25:24'),
(155, 1, 'Dashboard Access', 'Accessed dashboard', '2025-09-09 11:33:13'),
(156, 1, 'View Users', 'Viewed users management page', '2025-09-09 11:33:49'),
(157, 1, 'Dashboard Access', 'Accessed dashboard', '2025-09-09 11:33:57'),
(158, 1, 'View Users', 'Viewed users management page', '2025-09-09 11:57:08'),
(159, 1, 'View Inquiries', 'Viewed inquiries management page', '2025-09-09 11:57:54'),
(160, 1, 'View Contacts', 'Viewed contacts management page', '2025-09-09 11:57:58'),
(161, 1, 'Dashboard Access', 'Accessed dashboard', '2025-09-09 11:58:00'),
(162, 1, 'View Users', 'Viewed users management page', '2025-09-09 11:58:27'),
(163, 1, 'View Inquiries', 'Viewed inquiries management page', '2025-09-09 11:58:29'),
(164, 1, 'View Contacts', 'Viewed contacts management page', '2025-09-09 11:58:30'),
(165, 1, 'View Feedback', 'Viewed feedback management page', '2025-09-09 11:58:32'),
(166, 1, 'Dashboard Access', 'Accessed dashboard', '2025-09-09 11:58:41'),
(167, 1, 'View Users', 'Viewed users management page', '2025-09-09 12:00:01'),
(168, 1, 'View Sliders', 'Viewed slider management page', '2025-09-09 12:00:39'),
(169, 1, 'View Recycle Bin', 'Viewed slider recycle bin', '2025-09-09 12:00:43'),
(170, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-09-09 12:37:44'),
(171, 1, 'View Admission Form', 'Viewed form from: Tanvi Desai', '2025-09-09 12:37:54'),
(172, 1, 'View Admission Form', 'Viewed form from: Tanvi Desai', '2025-09-09 12:38:17'),
(173, 1, 'Dashboard Access', 'Accessed dashboard', '2025-09-09 12:39:03'),
(174, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-09-09 12:39:08'),
(175, 1, 'Dashboard Access', 'Accessed dashboard', '2025-09-09 12:39:17'),
(176, 1, 'Dashboard Access', 'Accessed dashboard', '2025-09-18 12:36:45'),
(177, 1, 'Add Media Category', 'Accessed add media category page', '2025-09-18 12:37:01'),
(178, 1, 'Add Media Category', 'Added category: test', '2025-09-18 12:37:23'),
(179, 1, 'Add Media Category', 'Accessed add media category page', '2025-09-18 12:37:23'),
(180, 1, 'View Media Categories', 'Viewed media category management page', '2025-09-18 12:37:34'),
(181, 1, 'Add Media Link', 'Accessed add media link page', '2025-09-18 12:37:50'),
(182, 1, 'Add Media Link', 'Accessed add media link page', '2025-09-18 12:48:44'),
(183, 1, 'Add Media Link', 'Accessed add media link page', '2025-09-18 13:01:19'),
(184, 1, 'Add Media Link', 'Accessed add media link page', '2025-09-18 13:01:21'),
(185, 1, 'Add Media Link', 'Added link: test', '2025-09-18 13:03:19'),
(186, 1, 'Add Media Link', 'Accessed add media link page', '2025-09-18 13:03:19'),
(187, 1, 'Add Media Link', 'Added link: test2', '2025-09-18 13:04:51'),
(188, 1, 'Add Media Link', 'Accessed add media link page', '2025-09-18 13:04:51'),
(189, 1, 'View Media Links', 'Viewed media links management page', '2025-09-18 13:05:16'),
(190, 1, 'View Media Links', 'Viewed media links management page', '2025-09-18 13:12:04'),
(191, 1, 'View Media Links', 'Viewed media links management page', '2025-09-18 13:17:35'),
(192, 1, 'View Media Links', 'Viewed media links management page', '2025-09-18 13:17:52'),
(193, 1, 'Add Media Link', 'Accessed add media link page', '2025-09-18 13:17:58'),
(194, 1, 'View Media Links', 'Viewed media links management page', '2025-09-18 13:20:35'),
(195, 1, 'View Media Links', 'Viewed media links management page', '2025-09-18 13:20:43'),
(196, 1, 'View Media Links', 'Viewed media links management page', '2025-09-18 13:20:53'),
(197, 1, 'View Media Links', 'Viewed media links management page', '2025-09-18 13:22:40'),
(198, 1, 'View Media Links', 'Viewed media links management page', '2025-09-18 13:23:57'),
(199, 1, 'View Media Links', 'Viewed media links management page', '2025-09-18 13:24:11'),
(200, 1, 'Toggle Media Link Status', 'Toggled link status', '2025-09-18 13:24:28'),
(201, 1, 'View Media Links', 'Viewed media links management page', '2025-09-18 13:24:28'),
(202, 1, 'Toggle Media Link Status', 'Toggled link status', '2025-09-18 13:24:33'),
(203, 1, 'View Media Links', 'Viewed media links management page', '2025-09-18 13:24:33'),
(204, 1, 'Toggle Media Link Status', 'Toggled link status', '2025-09-18 13:26:06'),
(205, 1, 'View Media Links', 'Viewed media links management page', '2025-09-18 13:26:06'),
(206, 1, 'Toggle Media Link Status', 'Toggled link status', '2025-09-18 13:26:09'),
(207, 1, 'View Media Links', 'Viewed media links management page', '2025-09-18 13:26:09'),
(208, 1, 'View Media Links', 'Viewed media links management page', '2025-09-18 13:27:10'),
(209, 1, 'Delete Media Link', 'Deleted link: test2', '2025-09-18 13:28:09'),
(210, 1, 'View Media Links', 'Viewed media links management page', '2025-09-18 13:28:09'),
(211, 1, 'View Recycle Bin', 'Viewed media recycle bin', '2025-09-18 13:38:06'),
(212, 1, 'View Recycle Bin', 'Viewed media recycle bin', '2025-09-18 13:41:39'),
(213, 1, 'Add Media Category', 'Accessed add media category page', '2025-09-18 13:41:51'),
(214, 1, 'Add Media Category', 'Added category: admin', '2025-09-18 13:41:58'),
(215, 1, 'Add Media Category', 'Accessed add media category page', '2025-09-18 13:41:58'),
(216, 1, 'View Media Categories', 'Viewed media category management page', '2025-09-18 13:42:05'),
(217, 1, 'View Media Categories', 'Viewed media category management page', '2025-09-18 13:44:43'),
(218, 1, 'Delete Media Category', 'Deleted category: admin', '2025-09-18 13:45:25'),
(219, 1, 'View Media Categories', 'Viewed media category management page', '2025-09-18 13:45:25'),
(220, 1, 'View Recycle Bin', 'Viewed media recycle bin', '2025-09-18 13:45:34'),
(221, 1, 'View Recycle Bin', 'Viewed media recycle bin', '2025-09-18 13:46:27'),
(222, 1, 'Dashboard Access', 'Accessed dashboard', '2025-09-18 13:48:23'),
(223, 1, 'Dashboard Access', 'Accessed dashboard', '2025-09-26 03:27:38'),
(224, 1, 'Dashboard Access', 'Accessed dashboard', '2025-09-26 03:30:30'),
(225, 1, 'Add Slider', 'Added slider: title', '2025-09-26 03:32:05'),
(226, 1, 'View Sliders', 'Viewed slider management page', '2025-09-26 03:32:08'),
(227, 1, 'View Sliders', 'Viewed slider management page', '2025-09-26 03:33:38'),
(228, 1, 'View Sliders', 'Viewed slider management page', '2025-09-26 03:40:52'),
(229, 1, 'View Sliders', 'Viewed slider management page', '2025-09-26 03:40:58'),
(230, 1, 'Delete Slider', 'Deleted slider: test', '2025-09-26 03:41:03'),
(231, 1, 'View Sliders', 'Viewed slider management page', '2025-09-26 03:41:03'),
(232, 1, 'Delete Slider', 'Deleted slider: title', '2025-09-26 03:41:06'),
(233, 1, 'View Sliders', 'Viewed slider management page', '2025-09-26 03:41:06'),
(234, 1, 'View Recycle Bin', 'Viewed slider recycle bin', '2025-09-26 03:41:08'),
(235, 1, 'Permanent Delete Slider', 'Permanently deleted slider: test', '2025-09-26 03:41:21'),
(236, 1, 'View Recycle Bin', 'Viewed slider recycle bin', '2025-09-26 03:41:21'),
(237, 1, 'Permanent Delete Slider', 'Permanently deleted slider: title', '2025-09-26 03:41:25'),
(238, 1, 'View Recycle Bin', 'Viewed slider recycle bin', '2025-09-26 03:41:25'),
(239, 1, 'Add Slider', 'Added slider: rrrrrrrrrrrrrrrrrr', '2025-09-26 03:44:24'),
(240, 1, 'View Sliders', 'Viewed slider management page', '2025-09-26 03:44:29'),
(241, 1, 'Toggle Slider Status', 'Toggled slider status', '2025-09-26 03:44:33'),
(242, 1, 'View Sliders', 'Viewed slider management page', '2025-09-26 03:44:33'),
(243, 1, 'Toggle Slider Status', 'Toggled slider status', '2025-09-26 03:44:35'),
(244, 1, 'View Sliders', 'Viewed slider management page', '2025-09-26 03:44:35'),
(245, 1, 'Toggle Slider Status', 'Toggled slider status', '2025-09-26 03:45:02'),
(246, 1, 'View Sliders', 'Viewed slider management page', '2025-09-26 03:45:02'),
(247, 1, 'Toggle Slider Status', 'Toggled slider status', '2025-09-26 03:45:03'),
(248, 1, 'View Sliders', 'Viewed slider management page', '2025-09-26 03:45:03'),
(249, 1, 'Toggle Slider Status', 'Toggled slider status', '2025-09-26 03:45:03'),
(250, 1, 'View Sliders', 'Viewed slider management page', '2025-09-26 03:45:03'),
(251, 1, 'Toggle Slider Status', 'Toggled slider status', '2025-09-26 03:45:04'),
(252, 1, 'View Sliders', 'Viewed slider management page', '2025-09-26 03:45:04'),
(253, 1, 'Toggle Slider Status', 'Toggled slider status', '2025-09-26 03:45:05'),
(254, 1, 'View Sliders', 'Viewed slider management page', '2025-09-26 03:45:05'),
(255, 1, 'Toggle Slider Status', 'Toggled slider status', '2025-09-26 03:45:05'),
(256, 1, 'View Sliders', 'Viewed slider management page', '2025-09-26 03:45:05'),
(257, 1, 'Toggle Slider Status', 'Toggled slider status', '2025-09-26 03:45:05'),
(258, 1, 'View Sliders', 'Viewed slider management page', '2025-09-26 03:45:05'),
(259, 1, 'Toggle Slider Status', 'Toggled slider status', '2025-09-26 03:45:06'),
(260, 1, 'View Sliders', 'Viewed slider management page', '2025-09-26 03:45:06'),
(261, 1, 'Toggle Slider Status', 'Toggled slider status', '2025-09-26 03:45:07'),
(262, 1, 'View Sliders', 'Viewed slider management page', '2025-09-26 03:45:07'),
(263, 1, 'Toggle Slider Status', 'Toggled slider status', '2025-09-26 03:45:07'),
(264, 1, 'View Sliders', 'Viewed slider management page', '2025-09-26 03:45:07'),
(265, 1, 'View Sliders', 'Viewed slider management page', '2025-09-26 03:45:50'),
(266, 1, 'Delete Slider', 'Deleted slider: rrrrrrrrrrrrrrrrrr', '2025-09-26 03:54:18'),
(267, 1, 'View Sliders', 'Viewed slider management page', '2025-09-26 03:54:18'),
(268, 1, 'View Recycle Bin', 'Viewed slider recycle bin', '2025-09-26 03:54:21'),
(269, 1, 'Permanent Delete Slider', 'Permanently deleted slider: rrrrrrrrrrrrrrrrrr', '2025-09-26 03:54:38'),
(270, 1, 'View Recycle Bin', 'Viewed slider recycle bin', '2025-09-26 03:54:38'),
(271, 1, 'Add Disclosure', 'Accessed add disclosure page', '2025-09-26 03:55:55'),
(272, 1, 'Add Disclosure', 'Accessed add disclosure page', '2025-09-26 03:58:55'),
(273, 1, 'Add Disclosure', 'Added disclosure: test', '2025-09-26 03:59:01'),
(274, 1, 'Add Disclosure', 'Accessed add disclosure page', '2025-09-26 03:59:01'),
(275, 1, 'View Disclosures', 'Viewed disclosure management page', '2025-09-26 03:59:19'),
(276, 1, 'View Disclosures', 'Viewed disclosure management page', '2025-09-26 03:59:50'),
(277, 1, 'View Disclosures', 'Viewed disclosure management page', '2025-09-26 04:00:38'),
(278, 1, 'View Disclosures', 'Viewed disclosure management page', '2025-09-26 04:01:11'),
(279, 1, 'View Disclosures', 'Viewed disclosure management page', '2025-09-26 04:01:43'),
(280, 1, 'View Disclosures', 'Viewed disclosure management page', '2025-09-26 04:02:07'),
(281, 1, 'View Disclosures', 'Viewed disclosure management page', '2025-09-26 04:02:34'),
(282, 1, 'View Disclosures', 'Viewed disclosure management page', '2025-09-26 04:03:15'),
(283, 1, 'View Disclosures', 'Viewed disclosure management page', '2025-09-26 04:04:16'),
(284, 1, 'Delete Disclosure', 'Deleted disclosure: test', '2025-09-26 04:04:19'),
(285, 1, 'View Disclosures', 'Viewed disclosure management page', '2025-09-26 04:04:19'),
(286, 1, 'View Recycle Bin', 'Viewed disclosure recycle bin', '2025-09-26 04:04:23'),
(287, 1, 'View Recycle Bin', 'Viewed disclosure recycle bin', '2025-09-26 04:06:17'),
(288, 1, 'View Recycle Bin', 'Viewed disclosure recycle bin', '2025-09-26 04:06:31'),
(289, 1, 'View Recycle Bin', 'Viewed disclosure recycle bin', '2025-09-26 04:06:33'),
(290, 1, 'View Recycle Bin', 'Viewed disclosure recycle bin', '2025-09-26 04:06:55'),
(291, 1, 'View Recycle Bin', 'Viewed disclosure recycle bin', '2025-09-26 04:06:56'),
(292, 1, 'View Recycle Bin', 'Viewed disclosure recycle bin', '2025-09-26 04:06:59'),
(293, 1, 'View Recycle Bin', 'Viewed disclosure recycle bin', '2025-09-26 04:07:18'),
(294, 1, 'View Recycle Bin', 'Viewed disclosure recycle bin', '2025-09-26 04:07:38'),
(295, 1, 'Permanent Delete Disclosure', 'Permanently deleted disclosure: test', '2025-09-26 04:07:46'),
(296, 1, 'View Recycle Bin', 'Viewed disclosure recycle bin', '2025-09-26 04:07:46'),
(297, 1, 'Add Gallery Category', 'Accessed add gallery category page', '2025-09-26 04:07:59'),
(298, 1, 'Add Gallery Category', 'Added category: dps_db', '2025-09-26 04:08:11'),
(299, 1, 'Add Gallery Category', 'Accessed add gallery category page', '2025-09-26 04:08:11'),
(300, 1, 'View Gallery Categories', 'Viewed gallery category management page', '2025-09-26 04:08:17'),
(301, 1, 'View Gallery Images', 'Viewed gallery images management page', '2025-09-26 04:08:34'),
(302, 1, 'View Gallery Categories', 'Viewed gallery category management page', '2025-09-26 04:08:37'),
(303, 1, 'Add Gallery Category', 'Accessed add gallery category page', '2025-09-26 04:08:38'),
(304, 1, 'View Gallery Categories', 'Viewed gallery category management page', '2025-09-26 04:08:43'),
(305, 1, 'Add Gallery Image', 'Accessed add gallery image page', '2025-09-26 04:09:15'),
(306, 1, 'Add Gallery Image', 'Accessed add gallery image page', '2025-09-26 04:10:34'),
(307, 1, 'Add Gallery Image', 'Added image: mip2', '2025-09-26 04:10:47'),
(308, 1, 'Add Gallery Image', 'Accessed add gallery image page', '2025-09-26 04:10:47'),
(309, 1, 'View Gallery Images', 'Viewed gallery images management page', '2025-09-26 04:10:51'),
(310, 1, 'View Gallery Images', 'Viewed gallery images management page', '2025-09-26 04:12:01'),
(311, 1, 'View Gallery Images', 'Viewed gallery images management page', '2025-09-26 04:12:02'),
(312, 1, 'Delete Gallery Image', 'Deleted image: mip2', '2025-09-26 04:12:17'),
(313, 1, 'View Gallery Images', 'Viewed gallery images management page', '2025-09-26 04:12:17'),
(314, 1, 'View Recycle Bin', 'Viewed gallery recycle bin', '2025-09-26 04:12:27'),
(315, 1, 'Permanent Delete Gallery Image', 'Permanently deleted image: mip2', '2025-09-26 04:12:35'),
(316, 1, 'View Recycle Bin', 'Viewed gallery recycle bin', '2025-09-26 04:12:35'),
(317, 1, 'View Gallery Images', 'Viewed gallery images management page', '2025-09-26 04:13:40'),
(318, 1, 'Add Gallery Image', 'Accessed add gallery image page', '2025-09-26 04:13:43'),
(319, 1, 'Add Gallery Image', 'Added image: mip2', '2025-09-26 04:13:52'),
(320, 1, 'Add Gallery Image', 'Accessed add gallery image page', '2025-09-26 04:13:52'),
(321, 1, 'View Recycle Bin', 'Viewed gallery recycle bin', '2025-09-26 04:13:59'),
(322, 1, 'View Gallery Images', 'Viewed gallery images management page', '2025-09-26 04:14:06'),
(323, 1, 'Delete Gallery Image', 'Deleted image: mip2', '2025-09-26 04:14:12'),
(324, 1, 'View Gallery Images', 'Viewed gallery images management page', '2025-09-26 04:14:12'),
(325, 1, 'View Recycle Bin', 'Viewed gallery recycle bin', '2025-09-26 04:14:23'),
(326, 1, 'Permanent Delete Gallery Image', 'Permanently deleted image: mip2', '2025-09-26 04:24:23'),
(327, 1, 'View Recycle Bin', 'Viewed gallery recycle bin', '2025-09-26 04:24:23'),
(328, 1, 'Add Material Category', 'Accessed add material category page', '2025-09-26 04:24:40'),
(329, 1, 'Add Material Category', 'Accessed add material category page', '2025-09-26 04:24:48'),
(330, 1, 'Add Material Category', 'Accessed add material category page', '2025-09-26 04:31:22'),
(331, 1, 'Add Material Category', 'Accessed add material category page', '2025-09-26 04:31:23'),
(332, 1, 'Add Material Category', 'Accessed add material category page', '2025-09-26 04:32:40'),
(333, 1, 'Add Material Category', 'Accessed add material category page', '2025-09-26 04:32:49'),
(334, 1, 'Add Material Category', 'Accessed add material category page', '2025-09-26 04:59:02'),
(335, 1, 'Add Material Category', 'Accessed add material category page', '2025-09-26 04:59:42'),
(336, 1, 'Add Material Category', 'Accessed add material category page', '2025-09-26 04:59:46'),
(337, 1, 'View Material Categories', 'Viewed material category management page', '2025-09-26 05:07:36'),
(338, 1, 'Add Material File', 'Accessed add material file page', '2025-09-26 05:07:43'),
(339, 1, 'Add Material Category', 'Accessed add material category page', '2025-09-26 05:08:34'),
(340, 1, 'View Material Categories', 'Viewed material category management page', '2025-09-26 05:08:43'),
(341, 1, 'Add Material File', 'Accessed add material file page', '2025-09-26 05:08:50'),
(342, 1, 'Add Material File', 'Accessed add material file page', '2025-09-26 05:17:14'),
(343, 1, 'Add Material File', 'Accessed add material file page', '2025-09-26 05:17:51'),
(344, 1, 'Add Class', 'Accessed add Class page', '2025-09-26 05:17:56'),
(345, 1, 'Add Class', 'Added Class: 1', '2025-09-26 05:18:04'),
(346, 1, 'Add Class', 'Accessed add Class page', '2025-09-26 05:18:04'),
(347, 1, 'Add Section', 'Accessed add Section page', '2025-09-26 05:37:41'),
(348, 1, 'Add Class', 'Accessed add Class page', '2025-09-26 05:37:46'),
(349, 1, 'Add Section', 'Accessed add Section page', '2025-09-26 05:38:00'),
(350, 1, 'Add Section', 'Added Section: A', '2025-09-26 05:38:22'),
(351, 1, 'Add Section', 'Accessed add Section page', '2025-09-26 05:38:22'),
(352, 1, 'Add Section', 'Accessed add Section page', '2025-09-26 05:42:29'),
(353, 1, 'Add Section', 'Accessed add Section page', '2025-09-26 05:44:48'),
(354, 1, 'Add Section', 'Accessed add Section page', '2025-09-26 05:44:51'),
(355, 1, 'Add Section', 'Accessed add Section page', '2025-09-26 05:46:20'),
(356, 1, 'Add Section', 'Accessed add Section page', '2025-09-26 05:49:41'),
(357, 1, 'Add Section', 'Accessed add Section page', '2025-09-26 05:50:45'),
(358, 1, 'Add Section', 'Accessed add Section page', '2025-09-26 05:52:12'),
(359, 1, 'Add Section', 'Accessed add Section page', '2025-09-26 05:52:29'),
(360, 1, 'Add Section', 'Accessed add Section page', '2025-09-26 05:53:35'),
(361, 1, 'Add Section', 'Accessed add Section page', '2025-09-26 05:59:01'),
(362, 1, 'Add Section', 'Added section: A', '2025-09-26 05:59:09'),
(363, 1, 'Add Section', 'Accessed add Section page', '2025-09-26 05:59:09'),
(364, 1, 'Add Class', 'Accessed add Class page', '2025-09-26 06:00:19'),
(365, 1, 'Add Class', 'Accessed add Class page', '2025-09-26 06:04:14'),
(366, 1, 'Add Class', 'Accessed add Class page', '2025-09-26 06:04:40'),
(367, 1, 'Add Class', 'Accessed add Class page', '2025-09-26 06:04:42'),
(368, 1, 'Add Class', 'Accessed add Class page', '2025-09-26 06:04:58'),
(369, 1, 'Add Subject', 'Accessed add Subject page', '2025-09-26 06:07:14'),
(370, 1, 'Add Subject', 'Added Subject: HINDI', '2025-09-26 06:07:20'),
(371, 1, 'Add Subject', 'Accessed add Subject page', '2025-09-26 06:07:20'),
(372, 1, 'Add Subject', 'Accessed add Subject page', '2025-09-26 06:08:30'),
(373, 1, 'Add Subject', 'Accessed add Subject page', '2025-09-26 06:10:38'),
(374, 1, 'Add Subject', 'Accessed add Subject page', '2025-09-26 06:11:07'),
(375, 1, 'Add Section', 'Accessed add Section page', '2025-09-26 06:12:17'),
(376, 1, 'View Feedback', 'Viewed feedback management page', '2025-09-26 06:12:17'),
(377, 1, 'Add Section', 'Accessed add Section page', '2025-09-26 06:12:26'),
(378, 1, 'Add Section', 'Accessed add Section page', '2025-09-26 06:13:19'),
(379, 1, 'Add Section', 'Added section: A', '2025-09-26 06:13:38'),
(380, 1, 'Add Section', 'Accessed add Section page', '2025-09-26 06:13:38'),
(381, 1, 'Add Section', 'Accessed add Section page', '2025-09-26 06:13:42'),
(382, 1, 'Add Material File', 'Accessed add material file page', '2025-09-26 06:14:00'),
(383, 1, 'Add Material File', 'Accessed add material file page', '2025-09-26 06:15:41'),
(384, 1, 'Add Material File', 'Accessed add material file page', '2025-09-26 06:24:20'),
(385, 1, 'Add Material File', 'Accessed add material file page', '2025-09-26 06:41:02'),
(386, 1, 'Add Material File', 'Accessed add material file page', '2025-09-26 06:41:31'),
(387, 1, 'Add Material File', 'Accessed add material file page', '2025-09-26 06:41:48'),
(388, 1, 'Add Material File', 'Accessed add material file page', '2025-09-26 06:42:20'),
(389, 1, 'Add Material File', 'Accessed add material file page', '2025-09-26 06:42:51'),
(390, 1, 'Add Material File', 'Accessed add material file page', '2025-09-26 06:45:40'),
(391, 1, 'Add Material File', 'Accessed add material file page', '2025-09-26 06:51:41'),
(392, 1, 'Add Material File', 'Accessed add material file page', '2025-09-26 06:51:42'),
(393, 1, 'Add Material File', 'Accessed add material file page', '2025-09-26 06:51:57'),
(394, 1, 'Add Material File', 'Accessed add material file page', '2025-09-26 06:52:51'),
(395, 1, 'Add Material File', 'Accessed add material file page', '2025-09-26 06:53:05'),
(396, 1, 'Add Material File', 'Accessed add material file page', '2025-09-26 06:55:21'),
(397, 1, 'Add Material File', 'Accessed add material file page', '2025-09-26 06:55:36'),
(398, 1, 'Dashboard Access', 'Accessed dashboard', '2025-10-06 03:12:17'),
(399, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-10-06 03:13:11'),
(400, 1, 'View Admission Forms', 'Viewed admission forms management page', '2025-10-06 03:13:18'),
(401, 1, 'Add Slider', 'Added slider: slide1', '2025-10-06 03:29:31'),
(402, 1, 'View Sliders', 'Viewed slider management page', '2025-10-06 03:29:35'),
(403, 1, 'View Sliders', 'Viewed slider management page', '2025-10-06 03:35:48'),
(404, 1, 'Edit Slider', 'Accessed edit page for slider: slide1', '2025-10-06 03:35:55'),
(405, 1, 'Add Slider', 'Added slider: slide1', '2025-10-06 03:41:39'),
(406, 1, 'View Sliders', 'Viewed slider management page', '2025-10-06 03:41:43'),
(407, 1, 'Delete Slider', 'Deleted slider: slide1', '2025-10-06 03:41:57'),
(408, 1, 'View Sliders', 'Viewed slider management page', '2025-10-06 03:41:57'),
(409, 1, 'View Recycle Bin', 'Viewed slider recycle bin', '2025-10-06 03:41:59'),
(410, 1, 'Permanent Delete Slider', 'Permanently deleted slider: slide1', '2025-10-06 03:42:02'),
(411, 1, 'View Recycle Bin', 'Viewed slider recycle bin', '2025-10-06 03:42:02'),
(412, 1, 'View Sliders', 'Viewed slider management page', '2025-10-06 03:42:05'),
(413, 1, 'View Sliders', 'Viewed slider management page', '2025-10-06 03:50:14'),
(414, 1, 'Edit Slider', 'Accessed edit page for slider: slide1', '2025-10-06 03:51:37'),
(415, 1, 'View Sliders', 'Viewed slider management page', '2025-10-06 03:51:40'),
(416, 1, 'Edit Slider', 'Accessed edit page for slider: slide1', '2025-10-06 04:35:50'),
(417, 1, 'View Sliders', 'Viewed slider management page', '2025-10-06 04:35:54'),
(418, 1, 'Add Slider', 'Added slider: Excellence in Pharmaceutical Education', '2025-10-07 02:20:01'),
(419, 1, 'View Sliders', 'Viewed slider management page', '2025-10-07 02:20:58'),
(420, 1, 'Delete Slider', 'Deleted slider: slide1', '2025-10-07 02:21:02'),
(421, 1, 'View Sliders', 'Viewed slider management page', '2025-10-07 02:21:02'),
(422, 1, 'Dashboard Access', 'Accessed dashboard', '2025-10-17 09:49:48'),
(423, 1, 'Logout', 'User logged out', '2025-10-17 09:53:01'),
(424, 1, 'Dashboard Access', 'Accessed dashboard', '2025-10-17 11:03:45'),
(425, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-11 06:33:59'),
(426, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-20 15:22:48'),
(427, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-20 15:28:15'),
(428, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-20 15:58:58'),
(429, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-20 16:09:05'),
(430, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-20 16:12:36'),
(431, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-20 16:12:40'),
(432, 1, 'Add Announcement', 'Accessed add announcement page', '2025-11-20 16:12:49'),
(433, 1, 'Add Announcement', 'Accessed add announcement page', '2025-11-20 16:17:16'),
(434, 1, 'Add Announcement', 'Added announcement: Test', '2025-11-20 16:17:28'),
(435, 1, 'Add Announcement', 'Accessed add announcement page', '2025-11-20 16:17:28'),
(436, 1, 'View Announcements', 'Viewed announcements management page', '2025-11-20 16:17:32'),
(437, 1, 'View Announcements', 'Viewed announcements management page', '2025-11-20 16:18:22'),
(438, 1, 'Add Announcement', 'Accessed add announcement page', '2025-11-20 16:39:14'),
(439, 1, 'Add Announcement', 'Added announcement: test 2', '2025-11-20 16:39:29'),
(440, 1, 'Add Announcement', 'Accessed add announcement page', '2025-11-20 16:39:29'),
(441, 1, 'Add Announcement', 'Added announcement: test 3', '2025-11-20 16:39:41'),
(442, 1, 'Add Announcement', 'Accessed add announcement page', '2025-11-20 16:39:41'),
(443, 1, 'View Announcements', 'Viewed announcements management page', '2025-11-20 16:40:04'),
(444, 1, 'Toggle Announcement Status', 'Toggled announcement status', '2025-11-20 16:40:10'),
(445, 1, 'View Announcements', 'Viewed announcements management page', '2025-11-20 16:40:10'),
(446, 1, 'Toggle Announcement Status', 'Toggled announcement status', '2025-11-20 16:40:30'),
(447, 1, 'View Announcements', 'Viewed announcements management page', '2025-11-20 16:40:30'),
(448, 1, 'Toggle Announcement Status', 'Toggled announcement status', '2025-11-20 16:40:37'),
(449, 1, 'View Announcements', 'Viewed announcements management page', '2025-11-20 16:40:37'),
(450, 1, 'View Announcements', 'Viewed announcements management page', '2025-11-20 16:40:47'),
(451, 1, 'Toggle Announcement Status', 'Toggled announcement status', '2025-11-20 16:41:02'),
(452, 1, 'View Announcements', 'Viewed announcements management page', '2025-11-20 16:41:02'),
(453, 1, 'Delete Announcement', 'Deleted announcement: Test', '2025-11-20 16:43:09'),
(454, 1, 'View Announcements', 'Viewed announcements management page', '2025-11-20 16:43:09'),
(455, 1, 'View Recycle Bin', 'Viewed announcements recycle bin', '2025-11-20 16:43:12'),
(456, 1, 'View Recycle Bin', 'Viewed announcements recycle bin', '2025-11-20 16:43:54'),
(457, 1, 'Restore Announcement', 'Restored announcement: Test', '2025-11-20 16:45:58'),
(458, 1, 'View Recycle Bin', 'Viewed announcements recycle bin', '2025-11-20 16:45:58'),
(459, 1, 'View Announcements', 'Viewed announcements management page', '2025-11-20 16:48:36'),
(460, 1, 'Delete Announcement', 'Deleted announcement: Test', '2025-11-20 16:48:47'),
(461, 1, 'View Announcements', 'Viewed announcements management page', '2025-11-20 16:48:47'),
(462, 1, 'View Recycle Bin', 'Viewed announcements recycle bin', '2025-11-20 16:48:50'),
(463, 1, 'View Recycle Bin', 'Viewed announcements recycle bin', '2025-11-20 16:52:10'),
(464, 1, 'View Recycle Bin', 'Viewed announcements recycle bin', '2025-11-20 16:52:55'),
(465, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-21 10:14:04'),
(466, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-21 10:17:14'),
(467, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-21 10:25:46'),
(468, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-21 10:35:19'),
(469, 1, 'Add Gallery Image', 'Accessed add gallery image page', '2025-11-21 10:35:23'),
(470, 1, 'Add Gallery Image', 'Accessed add gallery image page', '2025-11-21 10:35:54'),
(471, 1, 'Add Gallery Image', 'Accessed add gallery image page', '2025-11-21 10:36:13'),
(472, 1, 'Add Gallery Image', 'Accessed add gallery image page', '2025-11-21 10:36:15'),
(473, 1, 'Add Gallery Image', 'Accessed add gallery image page', '2025-11-21 10:36:19'),
(474, 1, 'Add Gallery Image', 'Accessed add gallery image page', '2025-11-21 10:37:40'),
(475, 1, 'Add Gallery Image', 'Accessed add gallery image page', '2025-11-21 10:37:41'),
(476, 1, 'Add Gallery Image', 'Accessed add gallery image page', '2025-11-21 10:38:01'),
(477, 1, 'Add Gallery Image', 'Accessed add gallery image page', '2025-11-21 10:38:42'),
(478, 1, 'Add Gallery Image', 'Accessed add gallery image page', '2025-11-21 10:38:46'),
(479, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-21 10:41:20'),
(480, 1, 'Add Gallery Image', 'Accessed add gallery image page', '2025-11-21 10:41:25'),
(481, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-21 10:46:51'),
(482, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-21 10:47:34'),
(483, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-21 10:48:07'),
(484, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-21 10:48:37'),
(485, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-21 10:50:29'),
(486, 1, 'Add Gallery Image', 'Accessed add gallery image page', '2025-11-21 10:50:32'),
(487, 1, 'Add Gallery Image', 'Added image: test', '2025-11-21 10:57:58'),
(488, 1, 'Add Gallery Image', 'Accessed add gallery image page', '2025-11-21 10:57:58'),
(489, 1, 'View Gallery Images', 'Viewed gallery images management page', '2025-11-21 10:58:00'),
(490, 1, 'View Gallery Images', 'Viewed gallery images management page', '2025-11-21 11:00:19'),
(491, 1, 'Add Gallery Category', 'Accessed add gallery category page', '2025-11-21 11:03:26'),
(492, 1, 'Add Gallery Category', 'Added category: test2', '2025-11-21 11:03:57'),
(493, 1, 'Add Gallery Category', 'Accessed add gallery category page', '2025-11-21 11:03:57'),
(494, 1, 'View Gallery Categories', 'Viewed gallery category management page', '2025-11-21 11:04:00'),
(495, 1, 'View Gallery Categories', 'Viewed gallery category management page', '2025-11-21 11:07:14'),
(496, 1, 'View Gallery Categories', 'Viewed gallery category management page', '2025-11-21 11:07:16'),
(497, 1, 'Delete Gallery Category', 'Deleted category: test2', '2025-11-21 11:07:20'),
(498, 1, 'View Gallery Categories', 'Viewed gallery category management page', '2025-11-21 11:07:20'),
(499, 1, 'View Recycle Bin', 'Viewed gallery recycle bin', '2025-11-21 11:07:23'),
(500, 1, 'View Gallery Images', 'Viewed gallery images management page', '2025-11-21 11:07:51'),
(501, 1, 'View Gallery Images', 'Viewed gallery images management page', '2025-11-21 11:07:53'),
(502, 1, 'View Recycle Bin', 'Viewed gallery recycle bin', '2025-11-21 11:07:57'),
(503, 1, 'View Gallery Images', 'Viewed gallery images management page', '2025-11-21 11:07:59'),
(504, 1, 'Add Gallery Image', 'Accessed add gallery image page', '2025-11-21 11:08:06'),
(505, 1, 'Add Gallery Category', 'Accessed add gallery category page', '2025-11-21 11:08:10'),
(506, 1, 'Add Gallery Category', 'Added category: mmmm', '2025-11-21 11:08:17'),
(507, 1, 'Add Gallery Category', 'Accessed add gallery category page', '2025-11-21 11:08:17'),
(508, 1, 'View Gallery Categories', 'Viewed gallery category management page', '2025-11-21 11:08:18'),
(509, 1, 'Delete Gallery Category', 'Deleted category: mmmm', '2025-11-21 11:08:22'),
(510, 1, 'View Gallery Categories', 'Viewed gallery category management page', '2025-11-21 11:08:22'),
(511, 1, 'View Recycle Bin', 'Viewed gallery recycle bin', '2025-11-21 11:08:25'),
(512, 1, 'View Recycle Bin', 'Viewed gallery recycle bin', '2025-11-21 11:10:19'),
(513, 1, 'View Recycle Bin', 'Viewed gallery recycle bin', '2025-11-21 11:10:45'),
(514, 1, 'View Gallery Images', 'Viewed gallery images management page', '2025-11-21 11:10:47'),
(515, 1, 'Add Gallery Category', 'Accessed add gallery category page', '2025-11-21 11:10:53'),
(516, 1, 'Add Gallery Category', 'Added category: nnn', '2025-11-21 11:10:59'),
(517, 1, 'Add Gallery Category', 'Accessed add gallery category page', '2025-11-21 11:10:59'),
(518, 1, 'View Gallery Categories', 'Viewed gallery category management page', '2025-11-21 11:11:02'),
(519, 1, 'Delete Gallery Category', 'Deleted category: nnn', '2025-11-21 11:11:07'),
(520, 1, 'View Gallery Categories', 'Viewed gallery category management page', '2025-11-21 11:11:07'),
(521, 1, 'View Recycle Bin', 'Viewed gallery recycle bin', '2025-11-21 11:11:10'),
(522, 1, 'View Recycle Bin', 'Viewed gallery recycle bin', '2025-11-21 11:12:20'),
(523, 1, 'View Gallery Categories', 'Viewed gallery category management page', '2025-11-21 11:12:29'),
(524, 1, 'Add Gallery Category', 'Accessed add gallery category page', '2025-11-21 11:12:42'),
(525, 1, 'Add Gallery Category', 'Added category: bbb', '2025-11-21 11:12:47'),
(526, 1, 'Add Gallery Category', 'Accessed add gallery category page', '2025-11-21 11:12:47'),
(527, 1, 'View Gallery Categories', 'Viewed gallery category management page', '2025-11-21 11:12:50'),
(528, 1, 'Delete Gallery Category', 'Deleted category: bbb', '2025-11-21 11:12:54'),
(529, 1, 'View Gallery Categories', 'Viewed gallery category management page', '2025-11-21 11:12:54'),
(530, 1, 'View Recycle Bin', 'Viewed gallery recycle bin', '2025-11-21 11:12:57'),
(531, 1, 'View Gallery Images', 'Viewed gallery images management page', '2025-11-21 11:12:59'),
(532, 1, 'Edit Gallery Image', 'Accessed edit page for image: test', '2025-11-21 11:13:03'),
(533, 1, 'View Gallery Images', 'Viewed gallery images management page', '2025-11-21 11:13:07'),
(534, 1, 'View Gallery Categories', 'Viewed gallery category management page', '2025-11-21 11:13:15'),
(535, 1, 'View Gallery Images', 'Viewed gallery images management page', '2025-11-21 11:13:22'),
(536, 1, 'View Gallery Images', 'Viewed gallery images management page', '2025-11-21 11:14:16'),
(537, 1, 'View Gallery Images', 'Viewed gallery images management page', '2025-11-21 11:14:18'),
(538, 1, 'View Gallery Images', 'Viewed gallery images management page', '2025-11-21 11:21:05'),
(539, 1, 'Edit Gallery Image', 'Accessed edit page for image: test', '2025-11-21 11:21:11'),
(540, 1, 'View Gallery Images', 'Viewed gallery images management page', '2025-11-21 11:21:14'),
(541, 1, 'View Gallery Images', 'Viewed gallery images management page', '2025-11-21 11:21:25'),
(542, 1, 'View Gallery Images', 'Viewed gallery images management page', '2025-11-21 11:21:27'),
(543, 1, 'View Gallery Images', 'Viewed gallery images management page', '2025-11-21 11:21:49'),
(544, 1, 'Edit Gallery Image', 'Accessed edit page for image: test', '2025-11-21 11:21:52'),
(545, 1, 'Edit Gallery Image', 'Accessed edit page for image: test', '2025-11-21 11:22:15'),
(546, 1, 'View Gallery Images', 'Viewed gallery images management page', '2025-11-21 11:22:17'),
(547, 1, 'Edit Gallery Image', 'Accessed edit page for image: test', '2025-11-21 11:22:19'),
(548, 1, 'Edit Gallery Image', 'Accessed edit page for image: test', '2025-11-21 11:23:38'),
(549, 1, 'Edit Gallery Image', 'Updated image: test', '2025-11-21 11:24:08'),
(550, 1, 'Edit Gallery Image', 'Accessed edit page for image: test', '2025-11-21 11:24:08'),
(551, 1, 'View Gallery Images', 'Viewed gallery images management page', '2025-11-21 11:24:11'),
(552, 1, 'Add Material Category', 'Accessed add material category page', '2025-11-21 11:48:33'),
(553, 1, 'Add Class', 'Accessed add Class page', '2025-11-21 11:48:40'),
(554, 1, 'Add Section', 'Accessed add Section page', '2025-11-21 11:48:49'),
(555, 1, 'Add Material File', 'Accessed add material file page', '2025-11-21 11:49:05'),
(556, 1, 'Add Material File', 'Accessed add material file page', '2025-11-21 11:49:38'),
(557, 1, 'Add Material File', 'Accessed add material file page', '2025-11-21 11:50:23'),
(558, 1, 'Add Material File', 'Accessed add material file page', '2025-11-21 11:51:53'),
(559, 1, 'Add Material File', 'Accessed add material file page', '2025-11-21 11:52:17'),
(560, 1, 'Add Material File', 'Accessed add material file page', '2025-11-21 11:53:20'),
(561, 1, 'Add Material File', 'Accessed add material file page', '2025-11-21 11:57:48'),
(562, 1, 'Add Material File', 'Accessed add material file page', '2025-11-21 11:58:05'),
(563, 1, 'View Material Files', 'Viewed material files management page', '2025-11-21 11:58:13'),
(564, 1, 'Add Material File', 'Accessed add material file page', '2025-11-21 11:58:17'),
(565, 1, 'Add Material File', 'Accessed add material file page', '2025-11-21 11:59:36'),
(566, 1, 'Add Material File', 'Accessed add material file page', '2025-11-21 11:59:47'),
(567, 1, 'Add Material File', 'Accessed add material file page', '2025-11-21 12:00:00'),
(568, 1, 'Add Material File', 'Accessed add material file page', '2025-11-21 12:00:22'),
(569, 1, 'Add Material File', 'Accessed add material file page', '2025-11-21 12:09:30'),
(570, 1, 'Add Material File', 'Accessed add material file page', '2025-11-21 12:09:53'),
(571, 1, 'Add Material File', 'Accessed add material file page', '2025-11-21 12:11:50'),
(572, 1, 'Add Material File', 'Accessed add material file page', '2025-11-21 12:12:09'),
(573, 1, 'Add Material File', 'Accessed add material file page', '2025-11-21 12:15:05'),
(574, 1, 'Add Material File', 'Accessed add material file page', '2025-11-21 12:15:25'),
(575, 1, 'Add Material File', 'Accessed add material file page', '2025-11-21 12:15:42'),
(576, 1, 'Add Material File', 'Accessed add material file page', '2025-11-21 12:16:01'),
(577, 1, 'Add Material File', 'Accessed add material file page', '2025-11-21 12:17:01'),
(578, 1, 'Add Material File', 'Accessed add material file page', '2025-11-21 12:18:12'),
(579, 1, 'Add Material File', 'Accessed add material file page', '2025-11-21 12:20:24'),
(580, 1, 'Add Material File', 'Accessed add material file page', '2025-11-21 12:20:55'),
(581, 1, 'Add Material File', 'Accessed add material file page', '2025-11-21 12:24:25'),
(582, 1, 'Add Material File', 'Accessed add material file page', '2025-11-21 12:24:42'),
(583, 1, 'Add Material File', 'Accessed add material file page', '2025-11-21 12:25:10'),
(584, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-22 10:34:46'),
(585, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 10:34:54'),
(586, 1, 'Add Material File', 'Added material: kjnxkjan', '2025-11-22 10:35:08'),
(587, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 10:35:08'),
(588, 1, 'View Material Files', 'Viewed material files management page', '2025-11-22 10:35:11'),
(589, 1, 'View Material Files', 'Viewed material files management page', '2025-11-22 10:38:14'),
(590, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 10:38:16');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `details`, `created_at`) VALUES
(591, 1, 'Add Material File', 'Added material: kjnxkjan', '2025-11-22 10:38:30'),
(592, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 10:38:30'),
(593, 1, 'View Material Files', 'Viewed material files management page', '2025-11-22 10:38:32'),
(594, 1, 'View Material Files', 'Viewed material files management page', '2025-11-22 10:41:01'),
(595, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 10:41:03'),
(596, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 10:41:15'),
(597, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 10:44:59'),
(598, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 10:45:16'),
(599, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 10:47:27'),
(600, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 10:47:50'),
(601, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 10:49:47'),
(602, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 10:50:00'),
(603, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 10:50:43'),
(604, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 10:51:06'),
(605, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 10:57:06'),
(606, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 10:57:19'),
(607, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 10:59:44'),
(608, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 10:59:56'),
(609, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 11:00:54'),
(610, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 11:01:06'),
(611, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 11:01:34'),
(612, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 11:01:46'),
(613, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 11:03:22'),
(614, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 11:03:36'),
(615, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 11:04:10'),
(616, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 11:04:23'),
(617, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 11:05:00'),
(618, 1, 'Add Material File', 'Added material: mip2', '2025-11-22 11:05:13'),
(619, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 11:05:13'),
(620, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 11:09:53'),
(621, 1, 'Add Material File', 'Added material: test', '2025-11-22 11:10:14'),
(622, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 11:10:14'),
(623, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 11:12:38'),
(624, 1, 'Add Material File', 'Added material: test', '2025-11-22 11:12:59'),
(625, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 11:12:59'),
(626, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 11:13:59'),
(627, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 11:14:17'),
(628, 1, 'Add Material File', 'Added material: mip2', '2025-11-22 11:14:26'),
(629, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 11:14:26'),
(630, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 11:16:49'),
(631, 1, 'Add Material File', 'Added material: mip2', '2025-11-22 11:17:03'),
(632, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 11:17:03'),
(633, 1, 'View Material Files', 'Viewed material files management page', '2025-11-22 11:17:33'),
(634, 1, 'View Material Files', 'Viewed material files management page', '2025-11-22 11:17:48'),
(635, 1, 'View Material Files', 'Viewed material files management page', '2025-11-22 11:17:52'),
(636, 1, 'View Material Files', 'Viewed material files management page', '2025-11-22 11:20:30'),
(637, 1, 'Delete Material File', 'Deleted material: mip2', '2025-11-22 11:20:33'),
(638, 1, 'View Material Files', 'Viewed material files management page', '2025-11-22 11:20:33'),
(639, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:20:37'),
(640, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:22:27'),
(641, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:22:46'),
(642, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:23:15'),
(643, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:23:16'),
(644, 1, 'View Material Files', 'Viewed material files management page', '2025-11-22 11:27:19'),
(645, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:28:03'),
(646, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:28:32'),
(647, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:28:34'),
(648, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:28:38'),
(649, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:28:44'),
(650, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:28:58'),
(651, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:29:59'),
(652, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:31:01'),
(653, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:31:31'),
(654, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:31:33'),
(655, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:33:08'),
(656, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:33:26'),
(657, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:34:28'),
(658, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:35:26'),
(659, 1, 'View Material Files', 'Viewed material files management page', '2025-11-22 11:38:26'),
(660, 1, 'Delete Material File', 'Deleted material: mip2', '2025-11-22 11:38:30'),
(661, 1, 'View Material Files', 'Viewed material files management page', '2025-11-22 11:38:30'),
(662, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:38:32'),
(663, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:38:54'),
(664, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:41:08'),
(665, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:43:28'),
(666, 1, 'View Material Files', 'Viewed material files management page', '2025-11-22 11:49:09'),
(667, 1, 'View Material Files', 'Viewed material files management page', '2025-11-22 11:50:16'),
(668, 1, 'Delete Material File', 'Deleted material: test', '2025-11-22 11:50:21'),
(669, 1, 'View Material Files', 'Viewed material files management page', '2025-11-22 11:50:21'),
(670, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:50:24'),
(671, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:51:04'),
(672, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:51:27'),
(673, 1, 'Restore Material File', 'Restored material: test', '2025-11-22 11:51:30'),
(674, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:51:30'),
(675, 1, 'View Material Files', 'Viewed material files management page', '2025-11-22 11:51:32'),
(676, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:54:17'),
(677, 1, 'Permanent Delete Material File', 'Permanently deleted material: mip2', '2025-11-22 11:54:22'),
(678, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:54:22'),
(679, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:54:46'),
(680, 1, 'Permanent Delete Material File', 'Permanently deleted material: mip2', '2025-11-22 11:56:00'),
(681, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:56:00'),
(682, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:56:33'),
(683, 1, 'View Material Files', 'Viewed material files management page', '2025-11-22 11:56:40'),
(684, 1, 'Delete Material File', 'Deleted material: 0', '2025-11-22 11:56:44'),
(685, 1, 'View Material Files', 'Viewed material files management page', '2025-11-22 11:56:44'),
(686, 1, 'Delete Material File', 'Deleted material: 0', '2025-11-22 11:56:47'),
(687, 1, 'View Material Files', 'Viewed material files management page', '2025-11-22 11:56:47'),
(688, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:56:49'),
(689, 1, 'Permanent Delete Material File', 'Permanently deleted material: 0', '2025-11-22 11:56:52'),
(690, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:56:52'),
(691, 1, 'Permanent Delete Material File', 'Permanently deleted material: 0', '2025-11-22 11:56:55'),
(692, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-22 11:56:55'),
(693, 1, 'View Material Files', 'Viewed material files management page', '2025-11-22 11:56:59'),
(694, 1, 'View Material Files', 'Viewed material files management page', '2025-11-22 11:57:31'),
(695, 1, 'Delete Material File', 'Deleted material: test', '2025-11-22 11:57:53'),
(696, 1, 'View Material Files', 'Viewed material files management page', '2025-11-22 11:57:53'),
(697, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 11:58:21'),
(698, 1, 'Add Material File', 'Added material: mip2', '2025-11-22 11:58:34'),
(699, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 11:58:34'),
(700, 1, 'View Material Files', 'Viewed material files management page', '2025-11-22 11:58:36'),
(701, 1, 'View Material Files', 'Viewed material files management page', '2025-11-22 11:59:37'),
(702, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 11:59:39'),
(703, 1, 'Add Material File', 'Added material: mip2', '2025-11-22 11:59:53'),
(704, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 11:59:53'),
(705, 1, 'View Material Files', 'Viewed material files management page', '2025-11-22 11:59:55'),
(706, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 12:11:06'),
(707, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 12:11:19'),
(708, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 12:15:08'),
(709, 1, 'Add Material File', 'Added material: dps_db', '2025-11-22 12:15:22'),
(710, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 12:15:22'),
(711, 1, 'View Material Files', 'Viewed material files management page', '2025-11-22 12:16:05'),
(712, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 12:21:51'),
(713, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 12:27:15'),
(714, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 12:27:36'),
(715, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 12:34:30'),
(716, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 12:34:45'),
(717, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 12:39:11'),
(718, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 12:39:24'),
(719, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 12:46:29'),
(720, 1, 'Add Material File', 'Added material: dps_db', '2025-11-22 12:46:41'),
(721, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 12:46:41'),
(722, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 12:48:04'),
(723, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 12:49:25'),
(724, 1, 'View Material Files', 'Viewed material files management page', '2025-11-22 12:49:26'),
(725, 1, 'View Material Files', 'Viewed material files management page', '2025-11-22 12:50:18'),
(726, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 12:50:56'),
(727, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 13:18:39'),
(728, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 13:20:03'),
(729, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 13:27:12'),
(730, 1, 'Add Material File', 'Accessed add material file page', '2025-11-22 13:27:23'),
(731, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-23 03:02:58'),
(732, 1, 'Add Material File', 'Accessed add material file page', '2025-11-23 03:03:06'),
(733, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-23 03:18:55'),
(734, 1, 'Add Material File', 'Accessed add material file page', '2025-11-23 03:19:00'),
(735, 1, 'Add Material File', 'Accessed add material file page', '2025-11-23 03:19:15'),
(736, 1, 'Add Material File', 'Accessed add material file page', '2025-11-23 03:21:22'),
(737, 1, 'Add Material File', 'Added material: dps_db', '2025-11-23 03:21:42'),
(738, 1, 'Add Material File', 'Accessed add material file page', '2025-11-23 03:21:42'),
(739, 1, 'View Material Files', 'Viewed material files management page', '2025-11-23 03:22:00'),
(740, 1, 'View Material Files', 'Viewed material files management page', '2025-11-23 03:28:40'),
(741, 1, 'Add Material File', 'Accessed add material file page', '2025-11-23 03:28:42'),
(742, 1, 'Add Material File', 'Added material: dps_db', '2025-11-23 03:28:53'),
(743, 1, 'Add Material File', 'Accessed add material file page', '2025-11-23 03:28:53'),
(744, 1, 'View Material Files', 'Viewed material files management page', '2025-11-23 03:31:09'),
(745, 1, 'View Material Files', 'Viewed material files management page', '2025-11-23 03:31:12'),
(746, 1, 'View Material Files', 'Viewed material files management page', '2025-11-23 03:36:38'),
(747, 1, 'View Material Files', 'Viewed material files management page', '2025-11-23 03:36:57'),
(748, 1, 'Add Material File', 'Accessed add material file page', '2025-11-23 03:39:01'),
(749, 1, 'Add Material File', 'Added material: dps_db', '2025-11-23 03:39:14'),
(750, 1, 'Add Material File', 'Accessed add material file page', '2025-11-23 03:39:14'),
(751, 1, 'View Material Files', 'Viewed material files management page', '2025-11-23 03:42:04'),
(752, 1, 'Delete Material File', 'Deleted material: dps_db', '2025-11-23 03:42:10'),
(753, 1, 'View Material Files', 'Viewed material files management page', '2025-11-23 03:42:10'),
(754, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-23 03:42:12'),
(755, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-23 03:43:57'),
(756, 1, 'Restore Material File', 'Restored material: dps_db', '2025-11-23 03:44:04'),
(757, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-23 03:44:04'),
(758, 1, 'View Material Files', 'Viewed material files management page', '2025-11-23 03:44:06'),
(759, 1, 'Delete Material File', 'Deleted material: dps_db', '2025-11-23 03:44:22'),
(760, 1, 'View Material Files', 'Viewed material files management page', '2025-11-23 03:44:22'),
(761, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-23 03:44:26'),
(762, 1, 'Restore Material File', 'Restored material: dps_db', '2025-11-23 03:44:37'),
(763, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-23 03:44:37'),
(764, 1, 'View Material Files', 'Viewed material files management page', '2025-11-23 03:44:38'),
(765, 1, 'Delete Material File', 'Deleted material: dps_db', '2025-11-23 03:44:48'),
(766, 1, 'View Material Files', 'Viewed material files management page', '2025-11-23 03:44:48'),
(767, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-23 03:44:50'),
(768, 1, 'Restore Material File', 'Restored material: dps_db', '2025-11-23 03:44:53'),
(769, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-23 03:44:53'),
(770, 1, 'Permanent Delete Material File', 'Permanently deleted material: test', '2025-11-23 03:44:56'),
(771, 1, 'View Recycle Bin', 'Viewed materials recycle bin', '2025-11-23 03:44:56'),
(772, 1, 'View Material Files', 'Viewed material files management page', '2025-11-23 03:44:59'),
(773, 1, 'Delete Material File', 'Deleted material: mip2', '2025-11-23 03:45:04'),
(774, 1, 'View Material Files', 'Viewed material files management page', '2025-11-23 03:45:04'),
(775, 1, 'Delete Material File', 'Deleted material: dps_db', '2025-11-23 03:45:06'),
(776, 1, 'View Material Files', 'Viewed material files management page', '2025-11-23 03:45:06'),
(777, 1, 'Delete Material File', 'Deleted material: dps_db', '2025-11-23 03:45:08'),
(778, 1, 'View Material Files', 'Viewed material files management page', '2025-11-23 03:45:08'),
(779, 1, 'Delete Material File', 'Deleted material: dps_db', '2025-11-23 03:45:10'),
(780, 1, 'View Material Files', 'Viewed material files management page', '2025-11-23 03:45:10'),
(781, 1, 'Delete Material File', 'Deleted material: dps_db', '2025-11-23 03:45:12'),
(782, 1, 'View Material Files', 'Viewed material files management page', '2025-11-23 03:45:12'),
(783, 1, 'Delete Material File', 'Deleted material: mip2', '2025-11-23 03:45:14'),
(784, 1, 'View Material Files', 'Viewed material files management page', '2025-11-23 03:45:14'),
(785, 1, 'Add Material Category', 'Accessed add material category page', '2025-11-23 03:45:40'),
(786, 1, 'Add Material Category', 'Accessed add material category page', '2025-11-23 03:46:16'),
(787, 1, 'Add Material Category', 'Accessed add material category page', '2025-11-23 03:47:11'),
(788, 1, 'Add Material Category', 'Accessed add material category page', '2025-11-23 03:49:05'),
(789, 1, 'Add Material Category', 'Added category: Winter Homework', '2025-11-23 03:49:15'),
(790, 1, 'Add Material Category', 'Accessed add material category page', '2025-11-23 03:49:15'),
(791, 1, 'View Material Categories', 'Viewed material category management page', '2025-11-23 03:49:28'),
(792, 1, 'Add Class', 'Accessed add Class page', '2025-11-23 03:49:36'),
(793, 1, 'Add Class', 'Accessed add Class page', '2025-11-23 03:49:47'),
(794, 1, 'Add Class', 'Accessed add Class page', '2025-11-23 03:52:08'),
(795, 1, 'Add Class', 'Accessed add Class page', '2025-11-23 03:52:13'),
(796, 1, 'Add Class', 'Accessed add Class page', '2025-11-23 03:54:15'),
(797, 1, 'Add Class', 'Added Class: 2', '2025-11-23 03:54:18'),
(798, 1, 'Add Class', 'Accessed add Class page', '2025-11-23 03:54:18'),
(799, 1, 'Add Class', 'Accessed add Class page', '2025-11-23 03:55:26'),
(800, 1, 'Add Class', 'Accessed add Class page', '2025-11-23 03:55:29'),
(801, 1, 'Add Class', 'Added Class: 3', '2025-11-23 03:55:40'),
(802, 1, 'Add Class', 'Accessed add Class page', '2025-11-23 03:55:40'),
(803, 1, 'Add Section', 'Accessed add Section page', '2025-11-23 03:56:02'),
(804, 1, 'Add Section', 'Added section: B', '2025-11-23 04:01:17'),
(805, 1, 'Add Section', 'Accessed add Section page', '2025-11-23 04:01:17'),
(806, 1, 'Add Material File', 'Accessed add material file page', '2025-11-23 04:01:22'),
(807, 1, 'Add Material File', 'Accessed add material file page', '2025-11-23 04:02:37'),
(808, 1, 'Add Material File', 'Accessed add material file page', '2025-11-23 04:04:04'),
(809, 1, 'Add Section', 'Accessed add Section page', '2025-11-23 04:04:18'),
(810, 1, 'Add Material File', 'Accessed add material file page', '2025-11-23 04:05:16'),
(811, 1, 'Add Material File', 'Accessed add material file page', '2025-11-23 04:08:10'),
(812, 1, 'Add Material File', 'Accessed add material file page', '2025-11-23 04:08:32'),
(813, 1, 'Add Material File', 'Added material: HIMANSHU KUMAR', '2025-11-23 04:08:46'),
(814, 1, 'Add Material File', 'Accessed add material file page', '2025-11-23 04:08:46'),
(815, 1, 'View Material Files', 'Viewed material files management page', '2025-11-23 04:08:47'),
(816, 1, 'View Material Files', 'Viewed material files management page', '2025-11-23 04:09:30'),
(817, 1, 'Add Material File', 'Accessed add material file page', '2025-11-23 04:10:00'),
(818, 1, 'Add Material File', 'Accessed add material file page', '2025-11-23 04:10:14'),
(819, 1, 'Add Subject', 'Accessed add Subject page', '2025-11-23 04:10:25'),
(820, 1, 'Add Subject', 'Added Subject: ENGLISH', '2025-11-23 04:10:41'),
(821, 1, 'Add Subject', 'Accessed add Subject page', '2025-11-23 04:10:41'),
(822, 1, 'Add Subject', 'Accessed add Subject page', '2025-11-23 04:10:59'),
(823, 1, 'Add Subject', 'Accessed add Subject page', '2025-11-23 04:11:02'),
(824, 1, 'Add Material File', 'Accessed add material file page', '2025-11-23 04:11:11'),
(825, 1, 'Add Material File', 'Added material: English Writing', '2025-11-23 04:12:47'),
(826, 1, 'Add Material File', 'Accessed add material file page', '2025-11-23 04:12:47'),
(827, 1, 'View Material Files', 'Viewed material files management page', '2025-11-23 04:12:49'),
(828, 1, 'View Material Files', 'Viewed material files management page', '2025-11-23 04:13:53'),
(829, 1, 'View Material Files', 'Viewed material files management page', '2025-11-23 04:15:47'),
(830, 1, 'Add Announcement Category', 'Accessed add announcement category page', '2025-11-23 04:16:09'),
(831, 1, 'Add Announcement Category', 'Accessed add announcement category page', '2025-11-23 04:16:18'),
(832, 1, 'Add Announcement Category', 'Accessed add announcement category page', '2025-11-23 04:17:14'),
(833, 1, 'Add Announcement Category', 'Added category: Rules & Regulations', '2025-11-23 04:17:23'),
(834, 1, 'Add Announcement Category', 'Accessed add announcement category page', '2025-11-23 04:17:23'),
(835, 1, 'View Announcement Categories', 'Viewed announcement category management page', '2025-11-23 04:17:28'),
(836, 1, 'Add Announcement', 'Accessed add announcement page', '2025-11-23 04:17:35'),
(837, 1, 'Add Announcement', 'Added announcement: Test', '2025-11-23 04:28:33'),
(838, 1, 'Add Announcement', 'Accessed add announcement page', '2025-11-23 04:28:33'),
(839, 1, 'View Announcements', 'Viewed announcements management page', '2025-11-23 04:28:34'),
(840, 1, 'View Material Files', 'Viewed material files management page', '2025-11-23 04:54:33'),
(841, 1, 'Add Material File', 'Accessed add material file page', '2025-11-23 06:04:11'),
(842, 1, 'Add Material File', 'Added material: pdf', '2025-11-23 06:04:43'),
(843, 1, 'Add Material File', 'Accessed add material file page', '2025-11-23 06:04:43'),
(844, 1, 'View Contacts', 'Viewed contacts management page', '2025-11-23 06:08:33'),
(845, 1, 'View Feedback', 'Viewed feedback management page', '2025-11-23 06:08:35'),
(846, 1, 'View Contacts', 'Viewed contacts management page', '2025-11-23 06:08:40'),
(847, 1, 'View Users', 'Viewed users management page', '2025-11-23 06:08:48'),
(848, 1, 'Change User Password', 'Accessed change password page for user: test', '2025-11-23 06:08:56'),
(849, 1, 'Change User Password', 'Changed password for user: test', '2025-11-23 06:09:14'),
(850, 1, 'Change User Password', 'Accessed change password page for user: test', '2025-11-23 06:09:14'),
(851, 1, 'Edit User', 'Accessed edit page for user: test', '2025-11-23 06:09:18'),
(852, 1, 'View Users', 'Viewed users management page', '2025-11-23 06:09:21'),
(853, 1, 'Logout', 'User logged out', '2025-11-23 06:09:33'),
(854, 2, 'Dashboard Access', 'Accessed dashboard', '2025-11-23 06:09:38'),
(855, 2, 'Dashboard Access', 'Accessed dashboard', '2025-11-23 06:10:23'),
(856, 2, 'Dashboard Access', 'Accessed dashboard', '2025-11-23 06:10:28'),
(857, 2, 'Logout', 'User logged out', '2025-11-23 06:10:31'),
(858, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-23 06:10:38'),
(859, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-23 06:11:48'),
(860, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-23 06:14:18'),
(861, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-23 06:14:20'),
(862, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-23 06:14:23'),
(863, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-23 06:14:58'),
(864, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-23 06:15:29'),
(865, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-23 06:16:01'),
(866, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-23 06:16:17'),
(867, 1, 'Logout', 'User logged out', '2025-11-23 06:16:39'),
(868, 2, 'Dashboard Access', 'Accessed dashboard', '2025-11-23 06:16:52'),
(869, 2, 'Logout', 'User logged out', '2025-11-23 06:17:16'),
(870, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-23 06:17:22'),
(871, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-23 06:20:18'),
(872, 1, 'Dashboard Access', 'Accessed dashboard', '2025-11-23 06:35:27'),
(873, 2, 'Dashboard Access', 'Accessed dashboard', '2025-11-23 06:36:30'),
(874, 2, 'View Contacts', 'Viewed contacts management page', '2025-11-23 06:37:15'),
(875, 1, 'View Contacts', 'Viewed contacts management page', '2025-11-23 06:37:22'),
(876, 1, 'View Feedback', 'Viewed feedback management page', '2025-11-23 06:37:24'),
(877, 2, 'Dashboard Access', 'Accessed dashboard', '2025-11-23 06:37:37'),
(878, 2, 'Dashboard Access', 'Accessed dashboard', '2025-11-23 06:58:27'),
(879, 2, 'Dashboard Access', 'Accessed dashboard', '2025-11-23 06:59:56'),
(880, 2, 'Add Slider', 'Added slider: slide 1', '2025-11-23 07:01:32'),
(881, 2, 'View Sliders', 'Viewed slider management page', '2025-11-23 07:01:35'),
(882, 2, 'Delete Slider', 'Deleted slider: Excellence in Pharmaceutical Education', '2025-11-23 07:01:41'),
(883, 2, 'View Sliders', 'Viewed slider management page', '2025-11-23 07:01:41'),
(884, 2, 'View Recycle Bin', 'Viewed slider recycle bin', '2025-11-23 07:01:43'),
(885, 2, 'Permanent Delete Slider', 'Permanently deleted slider: Excellence in Pharmaceutical Education', '2025-11-23 07:01:47'),
(886, 2, 'View Recycle Bin', 'Viewed slider recycle bin', '2025-11-23 07:01:47'),
(887, 2, 'Permanent Delete Slider', 'Permanently deleted slider: slide1', '2025-11-23 07:01:49'),
(888, 2, 'View Recycle Bin', 'Viewed slider recycle bin', '2025-11-23 07:01:49'),
(889, 2, 'View Sliders', 'Viewed slider management page', '2025-11-23 07:01:55'),
(890, 2, 'Add Slider', 'Added slider: slide 2', '2025-11-23 07:03:57'),
(891, 2, 'View Sliders', 'Viewed slider management page', '2025-11-23 07:04:02'),
(892, 1, 'View Sliders', 'Viewed slider management page', '2025-11-23 07:04:31'),
(893, 1, 'Add Slider', 'Added slider: slide2', '2025-11-23 07:08:11'),
(894, 1, 'View Sliders', 'Viewed slider management page', '2025-11-23 07:08:14'),
(895, 1, 'View Sliders', 'Viewed slider management page', '2025-11-23 07:10:22'),
(896, 1, 'View Sliders', 'Viewed slider management page', '2025-11-23 07:10:49'),
(897, 1, 'Edit Slider', 'Accessed edit page for slider: slide 2', '2025-11-23 07:10:54'),
(898, 1, 'Edit Slider', 'Accessed edit page for slider: slide 2', '2025-11-23 07:11:36'),
(899, 1, 'Edit Slider', 'Updated slider: slide 2', '2025-11-23 07:11:44'),
(900, 1, 'Edit Slider', 'Accessed edit page for slider: slide 2', '2025-11-23 07:11:44'),
(901, 1, 'View Sliders', 'Viewed slider management page', '2025-11-23 07:11:47'),
(902, 1, 'Edit Slider', 'Accessed edit page for slider: slide2', '2025-11-23 07:12:01'),
(903, 1, 'Edit Slider', 'Updated slider: slide 3', '2025-11-23 07:12:09'),
(904, 1, 'Edit Slider', 'Accessed edit page for slider: slide 3', '2025-11-23 07:12:09'),
(905, 1, 'View Sliders', 'Viewed slider management page', '2025-11-23 07:12:12'),
(906, 1, 'Add Slider', 'Added slider: slider 4', '2025-11-23 07:12:31'),
(907, 1, 'View Sliders', 'Viewed slider management page', '2025-11-23 07:12:34'),
(908, 1, 'Edit Slider', 'Accessed edit page for slider: slider 4', '2025-11-23 07:12:39'),
(909, 1, 'Edit Slider', 'Updated slider: slide 4', '2025-11-23 07:12:42'),
(910, 1, 'Edit Slider', 'Accessed edit page for slider: slide 4', '2025-11-23 07:12:42'),
(911, 1, 'View Sliders', 'Viewed slider management page', '2025-11-23 07:12:43'),
(912, 1, 'View Announcement Categories', 'Viewed announcement category management page', '2025-11-23 07:40:29'),
(913, 1, 'Add Announcement', 'Accessed add announcement page', '2025-11-23 07:40:32'),
(914, 1, 'Add Announcement', 'Added announcement: RR', '2025-11-23 07:40:53'),
(915, 1, 'Add Announcement', 'Accessed add announcement page', '2025-11-23 07:40:53'),
(916, 1, 'Add Announcement', 'Added announcement: RR', '2025-11-23 07:43:27'),
(917, 1, 'Add Announcement', 'Accessed add announcement page', '2025-11-23 07:43:27'),
(918, 1, 'Add Announcement', 'Added announcement: RR', '2025-11-23 07:43:36'),
(919, 1, 'Add Announcement', 'Accessed add announcement page', '2025-11-23 07:43:36'),
(920, 1, 'Add Announcement', 'Added announcement: RR', '2025-11-23 07:43:45'),
(921, 1, 'Add Announcement', 'Accessed add announcement page', '2025-11-23 07:43:45'),
(922, 1, 'Add Announcement', 'Added announcement: RR', '2025-11-23 07:43:54'),
(923, 1, 'Add Announcement', 'Accessed add announcement page', '2025-11-23 07:43:54'),
(924, 1, 'Add Announcement', 'Added announcement: RR', '2025-11-23 07:44:02'),
(925, 1, 'Add Announcement', 'Accessed add announcement page', '2025-11-23 07:44:02'),
(926, 1, 'Add Announcement', 'Added announcement: RR', '2025-11-23 07:44:10'),
(927, 1, 'Add Announcement', 'Accessed add announcement page', '2025-11-23 07:44:10'),
(928, 1, 'Add Announcement', 'Added announcement: RR', '2025-11-23 07:44:19'),
(929, 1, 'Add Announcement', 'Accessed add announcement page', '2025-11-23 07:44:19'),
(930, 1, 'Add Announcement', 'Added announcement: RR', '2025-11-23 07:44:28'),
(931, 1, 'Add Announcement', 'Accessed add announcement page', '2025-11-23 07:44:28'),
(932, 1, 'Add Announcement', 'Added announcement: RR', '2025-11-23 07:44:37'),
(933, 1, 'Add Announcement', 'Accessed add announcement page', '2025-11-23 07:44:37'),
(934, 1, 'Add Announcement', 'Added announcement: RR', '2025-11-23 07:44:45'),
(935, 1, 'Add Announcement', 'Accessed add announcement page', '2025-11-23 07:44:45'),
(936, 1, 'Add Announcement', 'Added announcement: RR', '2025-11-23 07:44:53'),
(937, 1, 'Add Announcement', 'Accessed add announcement page', '2025-11-23 07:44:53'),
(938, 1, 'Add Announcement', 'Added announcement: RR', '2025-11-23 07:45:00'),
(939, 1, 'Add Announcement', 'Accessed add announcement page', '2025-11-23 07:45:00'),
(940, 1, 'Add Announcement', 'Added announcement: RR', '2025-11-23 07:45:07'),
(941, 1, 'Add Announcement', 'Accessed add announcement page', '2025-11-23 07:45:07'),
(942, 1, 'View Announcements', 'Viewed announcements management page', '2025-11-23 07:45:09');

-- --------------------------------------------------------

--
-- Table structure for table `admission_forms`
--

DROP TABLE IF EXISTS `admission_forms`;
CREATE TABLE IF NOT EXISTS `admission_forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateofbirth` date DEFAULT NULL,
  `gender` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `religion` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aadhar` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobilenumber` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stdemail` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `program` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `degree` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `bloodgroup` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disability` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fathername` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fatheroccupation` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fathernumber` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fatheremail` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fadnumber` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fpannumber` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mothername` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motheroccupation` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mothernumber` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motheremail` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `madnumber` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mpannumber` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `presentaddress` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guardianname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guardainaddress` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guardainmobile` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `relation` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preclass` int(11) DEFAULT NULL,
  `qualification` decimal(5,2) DEFAULT NULL,
  `preclassatt` int(11) DEFAULT NULL,
  `onesiblingname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `onesiblingclass` int(11) DEFAULT NULL,
  `twosiblingname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twosiblingclass` int(11) DEFAULT NULL,
  `threesiblingname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `threesiblingclass` int(11) DEFAULT NULL,
  `stdphoto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stdsign` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stdaadhar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stdtc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stdrtcard` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stdmgcert` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fatphoto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fatsign` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fataadhar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motphoto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motsign` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motaadhar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guardphoto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stdbirth` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transport` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agree` tinyint(1) DEFAULT 0,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_admission_forms_status` (`status`),
  KEY `idx_admission_forms_created_at` (`created_at`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admission_forms`
--

INSERT INTO `admission_forms` (`id`, `firstname`, `lastname`, `category`, `dateofbirth`, `gender`, `religion`, `aadhar`, `mobilenumber`, `stdemail`, `program`, `degree`, `weight`, `height`, `bloodgroup`, `disability`, `fathername`, `fatheroccupation`, `fathernumber`, `fatheremail`, `fadnumber`, `fpannumber`, `mothername`, `motheroccupation`, `mothernumber`, `motheremail`, `madnumber`, `mpannumber`, `address`, `presentaddress`, `guardianname`, `guardainaddress`, `guardainmobile`, `relation`, `school`, `preclass`, `qualification`, `preclassatt`, `onesiblingname`, `onesiblingclass`, `twosiblingname`, `twosiblingclass`, `threesiblingname`, `threesiblingclass`, `stdphoto`, `stdsign`, `stdaadhar`, `stdtc`, `stdrtcard`, `stdmgcert`, `fatphoto`, `fatsign`, `fataadhar`, `motphoto`, `motsign`, `motaadhar`, `guardphoto`, `stdbirth`, `transport`, `agree`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Rahul', 'Kumar', 'General', '2009-03-15', 'Male', 'Hindu', '123456789012', '9876543210', 'rahul.kumar@email.com', '09', 'CBSE', '45.50', '155.20', 'O+', NULL, 'Rajesh Kumar', 'Business Owner', '9876543211', 'rajesh.kumar@email.com', '123456789013', 'ABCDE1234F', 'Priya Kumar', 'Housewife', '9876543212', 'priya.kumar@email.com', '123456789014', 'FGHIJ5678K', '123 Main Street, Delhi', '123 Main Street, Delhi', 'Vikram Singh', '456 Guardian Street, Delhi', '9876543213', 'Uncle', 'Delhi Public School', 8, '85.50', 95, 'Anjali Kumar', 6, NULL, NULL, NULL, NULL, 'uploads/photos/rahul.jpg', 'uploads/signatures/rahul.jpg', 'uploads/aadhar/rahul.jpg', 'uploads/tc/rahul.jpg', 'uploads/rtcard/rahul.jpg', 'uploads/mgcert/rahul.jpg', 'uploads/photos/rajesh.jpg', 'uploads/signatures/rajesh.jpg', 'uploads/aadhar/rajesh.jpg', 'uploads/photos/priya.jpg', 'uploads/signatures/priya.jpg', 'uploads/aadhar/priya.jpg', 'uploads/photos/vikram.jpg', 'uploads/birth/rahul.jpg', 'Bus', 0, 'pending', '2025-08-06 08:43:51', '2025-08-06 08:43:51'),
(31, 'Tanvi', 'Desai', 'OBC', '2006-05-22', 'Female', 'Hindu', '678901234567', '9876543270', 'tanvi.desai@email.com', '12', 'CBSE', '52.10', '165.40', 'AB+', NULL, 'Rajesh Desai', 'Doctor', '9876543271', 'rajesh.desai@email.com', '678901234568', 'NOPQR1234S', 'Kavya Desai', 'Nurse', '9876543272', 'kavya.desai@email.com', '678901234569', 'TUVWX5678Y', '321 Medical Lane, Hyderabad', '321 Medical Lane, Hyderabad', 'Vikram Patel', '654 Guardian Medical, Hyderabad', '9876543273', 'Uncle', 'Hyderabad Medical School', 11, '90.50', 95, 'Tara Desai', 10, 'Dev Desai', 8, 'Mira Desai', 6, 'uploads/photos/tanvi.jpg', 'uploads/signatures/tanvi.jpg', 'uploads/aadhar/tanvi.jpg', 'uploads/tc/tanvi.jpg', 'uploads/rtcard/tanvi.jpg', 'uploads/mgcert/tanvi.jpg', 'uploads/photos/rajesh.jpg', 'uploads/signatures/rajesh.jpg', 'uploads/aadhar/rajesh.jpg', 'uploads/photos/kavya.jpg', 'uploads/signatures/kavya.jpg', 'uploads/aadhar/kavya.jpg', 'uploads/photos/vikram.jpg', 'uploads/birth/tanvi.jpg', 'Bus', 0, 'pending', '2025-08-06 08:52:15', '2025-08-06 08:52:15'),
(30, 'Rishabh', 'Saxena', 'General', '2006-12-15', 'Male', 'Hindu', '567890123456', '9876543266', 'rishabh.saxena@email.com', '12', 'CBSE', '59.20', '172.80', 'A+', NULL, 'Mukesh Saxena', 'Businessman', '9876543267', 'mukesh.saxena@email.com', '567890123457', 'BCDEF5678G', 'Anita Saxena', 'Housewife', '9876543268', 'anita.saxena@email.com', '567890123458', 'HIJKL9012M', '456 Business Street, Bangalore', '456 Business Street, Bangalore', 'Rajesh Kumar', '789 Guardian Business, Bangalore', '9876543269', 'Cousin', 'Bangalore Business School', 11, '86.90', 91, 'Rohan Saxena', 10, 'Tanvi Saxena', 8, 'Aditya Saxena', 6, 'uploads/photos/rishabh.jpg', 'uploads/signatures/rishabh.jpg', 'uploads/aadhar/rishabh.jpg', 'uploads/tc/rishabh.jpg', 'uploads/rtcard/rishabh.jpg', 'uploads/mgcert/rishabh.jpg', 'uploads/photos/mukesh.jpg', 'uploads/signatures/mukesh.jpg', 'uploads/aadhar/mukesh.jpg', 'uploads/photos/anita.jpg', 'uploads/signatures/anita.jpg', 'uploads/aadhar/anita.jpg', 'uploads/photos/rajesh.jpg', 'uploads/birth/rishabh.jpg', 'Car', 0, 'pending', '2025-08-06 08:52:15', '2025-08-06 08:52:15'),
(29, 'Maya', 'Iyer', 'OBC', '2006-07-08', 'Female', 'Hindu', '456789012345', '9876543262', 'maya.iyer@email.com', '12', 'CBSE', '54.80', '167.30', 'B-', NULL, 'Krishna Iyer', 'Engineer', '9876543263', 'krishna.iyer@email.com', '456789012346', 'PQRST9012U', 'Radha Iyer', 'Teacher', '9876543264', 'radha.iyer@email.com', '456789012347', 'VWXYZ3456A', '123 Engineering Park, Mumbai', '123 Engineering Park, Mumbai', 'Srinivas Rao', '789 Guardian Engineering, Mumbai', '9876543265', 'Family Friend', 'Mumbai Engineering School', 11, '88.30', 93, 'Mira Iyer', 10, 'Aarav Iyer', 8, 'Ira Iyer', 6, 'uploads/photos/maya.jpg', 'uploads/signatures/maya.jpg', 'uploads/aadhar/maya.jpg', 'uploads/tc/maya.jpg', 'uploads/rtcard/maya.jpg', 'uploads/mgcert/maya.jpg', 'uploads/photos/krishna.jpg', 'uploads/signatures/krishna.jpg', 'uploads/aadhar/krishna.jpg', 'uploads/photos/radha.jpg', 'uploads/signatures/radha.jpg', 'uploads/aadhar/radha.jpg', 'uploads/photos/srinivas.jpg', 'uploads/birth/maya.jpg', 'Bus', 0, 'pending', '2025-08-06 08:52:15', '2025-08-06 08:52:15'),
(28, 'Dhruv', 'Kapoor', 'General', '2006-02-12', 'Male', 'Hindu', '345678901234', '9876543258', 'dhruv.kapoor@email.com', '12', 'CBSE', '62.40', '175.60', 'O-', NULL, 'Amit Kapoor', 'Doctor', '9876543259', 'amit.kapoor@email.com', '345678901235', 'DEFGH1234I', 'Priya Kapoor', 'Nurse', '9876543260', 'priya.kapoor@email.com', '345678901236', 'JKLMN5678O', '789 Medical Avenue, Delhi', '789 Medical Avenue, Delhi', 'Vikram Singh', '456 Guardian Medical, Delhi', '9876543261', 'Uncle', 'Delhi Medical School', 11, '91.70', 96, 'Dev Kapoor', 10, 'Mira Kapoor', 8, NULL, NULL, 'uploads/photos/dhruv.jpg', 'uploads/signatures/dhruv.jpg', 'uploads/aadhar/dhruv.jpg', 'uploads/tc/dhruv.jpg', 'uploads/rtcard/dhruv.jpg', 'uploads/mgcert/dhruv.jpg', 'uploads/photos/amit.jpg', 'uploads/signatures/amit.jpg', 'uploads/aadhar/amit.jpg', 'uploads/photos/priya.jpg', 'uploads/signatures/priya.jpg', 'uploads/aadhar/priya.jpg', 'uploads/photos/vikram.jpg', 'uploads/birth/dhruv.jpg', 'Car', 0, 'pending', '2025-08-06 08:52:15', '2025-08-06 08:52:15'),
(27, 'Ishita', 'Nair', 'OBC', '2007-08-25', 'Female', 'Hindu', '234567890123', '9876543254', 'ishita.nair@email.com', '11', 'CBSE', '49.20', '161.80', 'AB+', NULL, 'Suresh Nair', 'Engineer', '9876543255', 'suresh.nair@email.com', '234567890124', 'TUVWX5678Y', 'Lakshmi Nair', 'Teacher', '9876543256', 'lakshmi.nair@email.com', '234567890125', 'YZABC9012C', '321 Tech Street, Chennai', '321 Tech Street, Chennai', 'Rajesh Iyer', '654 Guardian Tech, Chennai', '9876543257', 'Cousin', 'Chennai Technical School', 10, '89.10', 94, 'Aarav Nair', 9, 'Kiara Nair', 7, 'Ishaan Nair', 5, 'uploads/photos/ishita.jpg', 'uploads/signatures/ishita.jpg', 'uploads/aadhar/ishita.jpg', 'uploads/tc/ishita.jpg', 'uploads/rtcard/ishita.jpg', 'uploads/mgcert/ishita.jpg', 'uploads/photos/suresh.jpg', 'uploads/signatures/suresh.jpg', 'uploads/aadhar/suresh.jpg', 'uploads/photos/lakshmi.jpg', 'uploads/signatures/lakshmi.jpg', 'uploads/aadhar/lakshmi.jpg', 'uploads/photos/rajesh.jpg', 'uploads/birth/ishita.jpg', 'Bus', 0, 'pending', '2025-08-06 08:52:15', '2025-08-06 08:52:15'),
(26, 'Aditya', 'Joshi', 'General', '2007-04-17', 'Male', 'Hindu', '123456789012', '9876543250', 'aditya.joshi@email.com', '11', 'CBSE', '56.70', '168.90', 'A+', NULL, 'Rajesh Joshi', 'Businessman', '9876543251', 'rajesh.joshi@email.com', '123456789013', 'HIJKL9012M', 'Neha Joshi', 'Housewife', '9876543252', 'neha.joshi@email.com', '123456789014', 'NOPQR3456S', '456 Business Lane, Bangalore', '456 Business Lane, Bangalore', 'Vikram Patel', '789 Guardian Business, Bangalore', '9876543253', 'Family Friend', 'Bangalore Business School', 10, '87.40', 92, 'Ira Joshi', 9, 'Advait Joshi', 7, NULL, NULL, 'uploads/photos/aditya.jpg', 'uploads/signatures/aditya.jpg', 'uploads/aadhar/aditya.jpg', 'uploads/tc/aditya.jpg', 'uploads/rtcard/aditya.jpg', 'uploads/mgcert/aditya.jpg', 'uploads/photos/rajesh.jpg', 'uploads/signatures/rajesh.jpg', 'uploads/aadhar/rajesh.jpg', 'uploads/photos/neha.jpg', 'uploads/signatures/neha.jpg', 'uploads/aadhar/neha.jpg', 'uploads/photos/vikram.jpg', 'uploads/birth/aditya.jpg', 'Car', 0, 'pending', '2025-08-06 08:52:15', '2025-08-06 08:52:15'),
(25, 'Zara', 'Khan', 'OBC', '2007-11-30', 'Female', 'Muslim', '012345678901', '9876543246', 'zara.khan@email.com', '11', 'CBSE', '51.30', '163.50', 'B+', NULL, 'Imran Khan', 'Doctor', '9876543247', 'imran.khan@email.com', '012345678902', 'VWXYZ1234A', 'Sana Khan', 'Nurse', '9876543248', 'sana.khan@email.com', '012345678903', 'BCDEF5678G', '789 Medical Park, Mumbai', '789 Medical Park, Mumbai', 'Ahmed Khan', '321 Guardian Medical, Mumbai', '9876543249', 'Uncle', 'Mumbai Medical School', 10, '85.60', 90, 'Aisha Khan', 9, 'Rizwan Khan', 7, 'Fatima Khan', 5, 'uploads/photos/zara.jpg', 'uploads/signatures/zara.jpg', 'uploads/aadhar/zara.jpg', 'uploads/tc/zara.jpg', 'uploads/rtcard/zara.jpg', 'uploads/mgcert/zara.jpg', 'uploads/photos/imran.jpg', 'uploads/signatures/imran.jpg', 'uploads/aadhar/imran.jpg', 'uploads/photos/sana.jpg', 'uploads/signatures/sana.jpg', 'uploads/aadhar/sana.jpg', 'uploads/photos/ahmed.jpg', 'uploads/birth/zara.jpg', 'Bus', 0, 'pending', '2025-08-06 08:52:15', '2025-08-06 08:52:15'),
(24, 'Arjun', 'Mehta', 'General', '2007-06-14', 'Male', 'Hindu', '901234567890', '9876543242', 'arjun.mehta@email.com', '11', 'CBSE', '58.90', '170.20', 'O+', NULL, 'Vikram Mehta', 'Engineer', '9876543243', 'vikram.mehta@email.com', '901234567891', 'JKLMN5678O', 'Pooja Mehta', 'Teacher', '9876543244', 'pooja.mehta@email.com', '901234567892', 'PQRST9012U', '123 Engineering Street, Delhi', '123 Engineering Street, Delhi', 'Amit Sharma', '456 Guardian Engineering, Delhi', '9876543245', 'Cousin', 'Delhi Technical School', 10, '88.90', 93, 'Advait Mehta', 9, 'Kiara Mehta', 7, NULL, NULL, 'uploads/photos/arjun.jpg', 'uploads/signatures/arjun.jpg', 'uploads/aadhar/arjun.jpg', 'uploads/tc/arjun.jpg', 'uploads/rtcard/arjun.jpg', 'uploads/mgcert/arjun.jpg', 'uploads/photos/vikram.jpg', 'uploads/signatures/vikram.jpg', 'uploads/aadhar/vikram.jpg', 'uploads/photos/pooja.jpg', 'uploads/signatures/pooja.jpg', 'uploads/aadhar/pooja.jpg', 'uploads/photos/amit.jpg', 'uploads/birth/arjun.jpg', 'Car', 0, 'pending', '2025-08-06 08:52:15', '2025-08-06 08:52:15'),
(23, 'Kavya', 'Reddy', 'OBC', '2008-12-08', 'Female', 'Hindu', '890123456789', '9876543238', 'kavya.reddy@email.com', '10', 'CBSE', '47.50', '157.30', 'AB-', NULL, 'Krishna Reddy', 'Business Owner', '9876543239', 'krishna.reddy@email.com', '890123456790', 'YZABC9012C', 'Lakshmi Reddy', 'Housewife', '9876543240', 'lakshmi.reddy@email.com', '890123456791', 'DEFGH3456I', '654 Business Road, Hyderabad', '654 Business Road, Hyderabad', 'Srinivas Rao', '987 Guardian Business, Hyderabad', '9876543241', 'Family Friend', 'Hyderabad Public School', 9, '91.20', 95, 'Vedant Reddy', 8, 'Ananya Reddy', 6, 'Ishaan Reddy', 4, 'uploads/photos/kavya.jpg', 'uploads/signatures/kavya.jpg', 'uploads/aadhar/kavya.jpg', 'uploads/tc/kavya.jpg', 'uploads/rtcard/kavya.jpg', 'uploads/mgcert/kavya.jpg', 'uploads/photos/krishna.jpg', 'uploads/signatures/krishna.jpg', 'uploads/aadhar/krishna.jpg', 'uploads/photos/lakshmi.jpg', 'uploads/signatures/lakshmi.jpg', 'uploads/aadhar/lakshmi.jpg', 'uploads/photos/srinivas.jpg', 'uploads/birth/kavya.jpg', 'Bus', 0, 'pending', '2025-08-06 08:52:15', '2025-08-06 08:52:15'),
(22, 'Rohan', 'Verma', 'General', '2008-03-25', 'Male', 'Hindu', '789012345678', '9876543234', 'rohan.verma@email.com', '10', 'CBSE', '55.20', '165.80', 'A-', NULL, 'Suresh Verma', 'Doctor', '9876543235', 'suresh.verma@email.com', '789012345679', 'NOPQR1234S', 'Anita Verma', 'Nurse', '9876543236', 'anita.verma@email.com', '789012345680', 'STUVW5678X', '321 Medical Lane, Bangalore', '321 Medical Lane, Bangalore', 'Rajesh Kumar', '654 Guardian Medical, Bangalore', '9876543237', 'Uncle', 'Bangalore Central School', 9, '84.70', 88, 'Kiara Verma', 8, 'Aarav Verma', 6, NULL, NULL, 'uploads/photos/rohan.jpg', 'uploads/signatures/rohan.jpg', 'uploads/aadhar/rohan.jpg', 'uploads/tc/rohan.jpg', 'uploads/rtcard/rohan.jpg', 'uploads/mgcert/rohan.jpg', 'uploads/photos/suresh.jpg', 'uploads/signatures/suresh.jpg', 'uploads/aadhar/suresh.jpg', 'uploads/photos/anita.jpg', 'uploads/signatures/anita.jpg', 'uploads/aadhar/anita.jpg', 'uploads/photos/rajesh.jpg', 'uploads/birth/rohan.jpg', 'Car', 0, 'pending', '2025-08-06 08:52:15', '2025-08-06 08:52:15'),
(21, 'Anjali', 'Gupta', 'OBC', '2008-09-12', 'Female', 'Hindu', '678901234567', '9876543230', 'anjali.gupta@email.com', '10', 'CBSE', '49.80', '159.70', 'B-', NULL, 'Prakash Gupta', 'Engineer', '9876543231', 'prakash.gupta@email.com', '678901234568', 'CDEFG3456H', 'Rekha Gupta', 'Teacher', '9876543232', 'rekha.gupta@email.com', '678901234569', 'HIJKL7890M', '987 Tech Street, Mumbai', '987 Tech Street, Mumbai', 'Vikram Joshi', '456 Guardian Tech, Mumbai', '9876543233', 'Cousin', 'Mumbai International School', 9, '89.50', 91, 'Ritvik Gupta', 8, 'Shreya Gupta', 6, 'Advait Gupta', 4, 'uploads/photos/anjali.jpg', 'uploads/signatures/anjali.jpg', 'uploads/aadhar/anjali.jpg', 'uploads/tc/anjali.jpg', 'uploads/rtcard/anjali.jpg', 'uploads/mgcert/anjali.jpg', 'uploads/photos/prakash.jpg', 'uploads/signatures/prakash.jpg', 'uploads/aadhar/prakash.jpg', 'uploads/photos/rekha.jpg', 'uploads/signatures/rekha.jpg', 'uploads/aadhar/rekha.jpg', 'uploads/photos/vikram.jpg', 'uploads/birth/anjali.jpg', 'Bus', 0, 'pending', '2025-08-06 08:52:15', '2025-08-06 08:52:15'),
(20, 'Vikram', 'Malhotra', 'General', '2008-05-18', 'Male', 'Hindu', '567890123456', '9876543226', 'vikram.malhotra@email.com', '10', 'CBSE', '52.70', '162.30', 'O-', NULL, 'Anil Malhotra', 'Businessman', '9876543227', 'anil.malhotra@email.com', '567890123457', 'RSTUV5678W', 'Meera Malhotra', 'Housewife', '9876543228', 'meera.malhotra@email.com', '567890123458', 'WXYZA9012B', '654 Business Park, Delhi', '654 Business Park, Delhi', 'Suresh Gupta', '987 Guardian Park, Delhi', '9876543229', 'Family Friend', 'Delhi Model School', 9, '87.30', 94, 'Anjali Malhotra', 8, 'Rohan Malhotra', 6, NULL, NULL, 'uploads/photos/vikram.jpg', 'uploads/signatures/vikram.jpg', 'uploads/aadhar/vikram.jpg', 'uploads/tc/vikram.jpg', 'uploads/rtcard/vikram.jpg', 'uploads/mgcert/vikram.jpg', 'uploads/photos/anil.jpg', 'uploads/signatures/anil.jpg', 'uploads/aadhar/anil.jpg', 'uploads/photos/meera.jpg', 'uploads/signatures/meera.jpg', 'uploads/aadhar/meera.jpg', 'uploads/photos/suresh.jpg', 'uploads/birth/vikram.jpg', 'Car', 0, 'pending', '2025-08-06 08:52:15', '2025-08-06 08:52:15'),
(18, 'Amit', 'Patel', 'General', '2009-01-10', 'Male', 'Hindu', '345678901234', '9876543218', 'amit.patel@email.com', '09', 'CBSE', '48.30', '158.50', 'A+', NULL, 'Mukesh Patel', 'Doctor', '9876543219', 'mukesh.patel@email.com', '345678901235', 'UVWXY1234Z', 'Sita Patel', 'Nurse', '9876543220', 'sita.patel@email.com', '345678901236', 'ZABCD5678E', '789 Lake Road, Bangalore', '789 Lake Road, Bangalore', 'Rajesh Mehta', '321 Guardian Road, Bangalore', '9876543221', 'Family Friend', 'Bangalore International School', 8, '82.70', 89, 'Kavya Patel', 6, 'Arjun Patel', 4, NULL, NULL, 'uploads/photos/amit.jpg', 'uploads/signatures/amit.jpg', 'uploads/aadhar/amit.jpg', 'uploads/tc/amit.jpg', 'uploads/rtcard/amit.jpg', 'uploads/mgcert/amit.jpg', 'uploads/photos/mukesh.jpg', 'uploads/signatures/mukesh.jpg', 'uploads/aadhar/mukesh.jpg', 'uploads/photos/sita.jpg', 'uploads/signatures/sita.jpg', 'uploads/aadhar/sita.jpg', 'uploads/photos/rajesh.jpg', 'uploads/birth/amit.jpg', 'Bus', 0, 'pending', '2025-08-06 08:52:15', '2025-08-06 08:52:15'),
(19, 'Neha', 'Singh', 'SC', '2009-11-05', 'Female', 'Sikh', '456789012345', '9876543222', 'neha.singh@email.com', '09', 'CBSE', '44.10', '154.00', 'AB+', NULL, 'Ramesh Singh', 'Police Officer', '9876543223', 'ramesh.singh@email.com', '456789012346', 'FGHIJ9012K', 'Kiran Singh', 'Government Employee', '9876543224', 'kiran.singh@email.com', '456789012347', 'LMNOP3456Q', '321 Hill Street, Chandigarh', '321 Hill Street, Chandigarh', 'Gurpreet Singh', '654 Guardian Street, Chandigarh', '9876543225', 'Uncle', 'Chandigarh Public School', 8, '90.10', 96, 'Harpreet Singh', 7, 'Manpreet Singh', 5, 'Jaspreet Singh', 3, 'uploads/photos/neha.jpg', 'uploads/signatures/neha.jpg', 'uploads/aadhar/neha.jpg', 'uploads/tc/neha.jpg', 'uploads/rtcard/neha.jpg', 'uploads/mgcert/neha.jpg', 'uploads/photos/ramesh.jpg', 'uploads/signatures/ramesh.jpg', 'uploads/aadhar/ramesh.jpg', 'uploads/photos/kiran.jpg', 'uploads/signatures/kiran.jpg', 'uploads/aadhar/kiran.jpg', 'uploads/photos/gurpreet.jpg', 'uploads/birth/neha.jpg', 'Bus', 0, 'pending', '2025-08-06 08:52:15', '2025-08-06 08:52:15'),
(17, 'Priya', 'Sharma', 'OBC', '2009-07-22', 'Female', 'Hindu', '234567890123', '9876543214', 'priya.sharma@email.com', '09', 'CBSE', '42.00', '152.80', 'B+', NULL, 'Sunil Sharma', 'Engineer', '9876543215', 'sunil.sharma@email.com', '234567890124', 'KLMNO5678P', 'Reena Sharma', 'Teacher', '9876543216', 'reena.sharma@email.com', '234567890125', 'PQRST9012U', '456 Park Avenue, Mumbai', '456 Park Avenue, Mumbai', 'Amit Patel', '789 Guardian Lane, Mumbai', '9876543217', 'Cousin', 'St. Mary School', 8, '88.20', 92, 'Rohan Sharma', 7, 'Neha Sharma', 5, NULL, NULL, 'uploads/photos/priya.jpg', 'uploads/signatures/priya.jpg', 'uploads/aadhar/priya.jpg', 'uploads/tc/priya.jpg', 'uploads/rtcard/priya.jpg', 'uploads/mgcert/priya.jpg', 'uploads/photos/sunil.jpg', 'uploads/signatures/sunil.jpg', 'uploads/aadhar/sunil.jpg', 'uploads/photos/reena.jpg', 'uploads/signatures/reena.jpg', 'uploads/aadhar/reena.jpg', 'uploads/photos/amit.jpg', 'uploads/birth/priya.jpg', 'Car', 0, 'pending', '2025-08-06 08:52:15', '2025-08-06 08:52:15');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
CREATE TABLE IF NOT EXISTS `announcements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_announcements_category_id` (`category_id`),
  KEY `idx_announcements_status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `category_id`, `title`, `content`, `status`, `created_at`, `updated_at`) VALUES
(5, 4, 'Test', 'This is a test data', 'active', '2025-11-23 04:28:33', '2025-11-23 04:28:33'),
(2, 3, 'test 2', 'notice', 'active', '2025-11-20 16:39:29', '2025-11-20 16:39:29'),
(3, 2, 'test 3', 'news', 'active', '2025-11-20 16:39:41', '2025-11-20 16:39:41'),
(6, 4, 'RR', 'To attend school PTM every month at second Saturday.', 'active', '2025-11-23 07:40:53', '2025-11-23 07:40:53'),
(7, 4, 'RR', 'Parents should check their children’s diary regularly.', 'active', '2025-11-23 07:43:27', '2025-11-23 07:43:27'),
(8, 4, 'RR', 'Change of Name, Date of Birth and Permanent address of the student will not be allowed at any stage.', 'active', '2025-11-23 07:43:36', '2025-11-23 07:43:36'),
(9, 4, 'RR', 'If any student run away without information or if any sudden incident happens then our academy will not be responsible.', 'active', '2025-11-23 07:43:45', '2025-11-23 07:43:45'),
(10, 4, 'RR', 'Admission will be struck off, if any students will be absent consequently five days without written information.', 'active', '2025-11-23 07:43:54', '2025-11-23 07:43:54'),
(11, 4, 'RR', 'In case your ward is absent without any written information a fine at Rs.5/-per day will be charged.', 'active', '2025-11-23 07:44:02', '2025-11-23 07:44:02'),
(12, 4, 'RR', 'Fee card is necessary for submitting school fee.', 'active', '2025-11-23 07:44:10', '2025-11-23 07:44:10'),
(13, 4, 'RR', 'Every month\\\'s school fee must be deposited by the last day of that month. Otherwise, a late fee of Rs. 50 will be charged from the 1st of the next month.', 'active', '2025-11-23 07:44:19', '2025-11-23 07:44:19'),
(14, 4, 'RR', 'If you do not deposit the outstanding school and vehicle fees by 10th of the next month, then the students using the vehicle will be banned from entering the vehicle and the students coming on foot or in their own vehicle will be banned from entering the school campus.', 'active', '2025-11-23 07:44:28', '2025-11-23 07:44:28'),
(15, 4, 'RR', 'Even if the exam is held, your ward will be deprived of the exam. You alone will be responsible for this.', 'active', '2025-11-23 07:44:37', '2025-11-23 07:44:37'),
(16, 4, 'RR', 'Name of the student will be struck off if payment is not made by 10th of next month and student has to take re-admission.', 'active', '2025-11-23 07:44:45', '2025-11-23 07:44:45'),
(17, 4, 'RR', 'Fee of May & June will be paid in month of May, Sept. & Oct. in the month of Sept. and Feb. & March in the month of Feb.', 'active', '2025-11-23 07:44:53', '2025-11-23 07:44:53'),
(18, 4, 'RR', 'Come school in proper dress regarding any type of work.', 'active', '2025-11-23 07:45:00', '2025-11-23 07:45:00'),
(19, 4, 'RR', 'Don’t come school with consume alcohol & chewing narcotics product.', 'active', '2025-11-23 07:45:07', '2025-11-23 07:45:07');

-- --------------------------------------------------------

--
-- Table structure for table `announcements_recycle`
--

DROP TABLE IF EXISTS `announcements_recycle`;
CREATE TABLE IF NOT EXISTS `announcements_recycle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `deleted_by` (`deleted_by`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcements_recycle`
--

INSERT INTO `announcements_recycle` (`id`, `original_id`, `category_id`, `title`, `content`, `deleted_at`, `deleted_by`) VALUES
(2, NULL, 1, 'Test', 'ttttttt', '2025-11-20 16:48:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `announcement_categories`
--

DROP TABLE IF EXISTS `announcement_categories`;
CREATE TABLE IF NOT EXISTS `announcement_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcement_categories`
--

INSERT INTO `announcement_categories` (`id`, `name`, `status`, `created_at`) VALUES
(1, 'Announcement', 'active', '2025-08-04 08:36:00'),
(2, 'News', 'active', '2025-08-04 08:36:00'),
(3, 'Notice', 'active', '2025-08-04 08:36:00'),
(4, 'Rules & Regulations', 'active', '2025-11-23 04:17:23');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
CREATE TABLE IF NOT EXISTS `classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('new','read','replied','closed') COLLATE utf8mb4_unicode_ci DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_contacts_status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `disclosures`
--

DROP TABLE IF EXISTS `disclosures`;
CREATE TABLE IF NOT EXISTS `disclosures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
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
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('new','read','replied','closed') COLLATE utf8mb4_unicode_ci DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
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
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery_categories`
--

INSERT INTO `gallery_categories` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'dps_db', 'test', 'active', '2025-09-26 04:08:11', '2025-09-26 04:08:11');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_categories_recycle`
--

DROP TABLE IF EXISTS `gallery_categories_recycle`;
CREATE TABLE IF NOT EXISTS `gallery_categories_recycle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_gallery_images_category_id` (`category_id`),
  KEY `idx_gallery_images_status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery_images`
--

INSERT INTO `gallery_images` (`id`, `category_id`, `name`, `image`, `description`, `status`, `created_at`, `updated_at`) VALUES
(3, 1, 'test', '69204bd80f4f5_1763724248.png', NULL, 'active', '2025-11-21 10:57:58', '2025-11-21 11:24:08');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images_recycle`
--

DROP TABLE IF EXISTS `gallery_images_recycle`;
CREATE TABLE IF NOT EXISTS `gallery_images_recycle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('new','read','replied','closed') COLLATE utf8mb4_unicode_ci DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_inquiries_status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `section_id` (`section_id`),
  KEY `subject_id` (`subject_id`),
  KEY `idx_materials_type_id` (`type_id`),
  KEY `idx_materials_class_id` (`class_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `type_id`, `class_id`, `section_id`, `subject_id`, `name`, `file`, `file_type`, `file_size`, `description`, `status`, `created_at`, `updated_at`) VALUES
(13, 2, 5, 4, 1, 'HIMANSHU KUMAR', '692288ce3942f_1763870926.png', 'image/png', 236914, 'qaaa', 'active', '2025-11-23 04:08:46', '2025-11-23 04:08:46'),
(14, 3, 7, NULL, 2, 'English Writing', '692289bfb6679_1763871167.png', 'image/png', 137913, 'Complete and submit the homework on 13/01/2025', 'active', '2025-11-23 04:12:47', '2025-11-23 04:12:47'),
(15, 3, 6, NULL, 2, 'pdf', '6922a3fbabc8d_1763877883.pdf', 'application/pdf', 163533, '333', 'active', '2025-11-23 06:04:43', '2025-11-23 06:04:43'),
(12, 1, 1, 1, 1, 'dps_db', '692281e233ebd_1763869154.png', NULL, NULL, 'wwww', 'active', '2025-11-23 03:44:53', '2025-11-23 03:44:53');

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
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` char(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
  `name` char(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media_categories`
--

INSERT INTO `media_categories` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'test', 'this is a test category for check', 'active', '2025-09-18 12:37:23', '2025-09-18 12:37:23');

-- --------------------------------------------------------

--
-- Table structure for table `media_categories_recycle`
--

DROP TABLE IF EXISTS `media_categories_recycle`;
CREATE TABLE IF NOT EXISTS `media_categories_recycle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media_links`
--

INSERT INTO `media_links` (`id`, `category_id`, `name`, `link_url`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'test', 'https://www.youtube.com/watch?v=4QbW0jJyrFo', NULL, 'inactive', '2025-09-18 13:03:19', '2025-09-18 13:24:33');

-- --------------------------------------------------------

--
-- Table structure for table `media_links_recycle`
--

DROP TABLE IF EXISTS `media_links_recycle`;
CREATE TABLE IF NOT EXISTS `media_links_recycle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `deleted_by` (`deleted_by`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media_links_recycle`
--

INSERT INTO `media_links_recycle` (`id`, `original_id`, `category_id`, `name`, `link_url`, `deleted_at`, `deleted_by`) VALUES
(2, NULL, 1, 'test2', 'https://www.youtube.com/watch?v=4QbW0jJyrFo', '2025-09-18 13:28:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

DROP TABLE IF EXISTS `sections`;
CREATE TABLE IF NOT EXISTS `sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) DEFAULT NULL,
  `name` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_sliders_status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `name`, `image`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(8, 'slide 2', '6922b3b070b1d_1763881904.jpg', 'active', 0, '2025-11-23 07:03:57', '2025-11-23 07:11:44'),
(7, 'slide 1', '6922b14c13e80_1763881292.jpg', 'active', 0, '2025-11-23 07:01:32', '2025-11-23 07:01:32'),
(9, 'slide 3', '6922b3c98738f_1763881929.jpg', 'active', 0, '2025-11-23 07:08:11', '2025-11-23 07:12:09'),
(10, 'slide 4', '6922b3df8ebdf_1763881951.jpg', 'active', 0, '2025-11-23 07:12:31', '2025-11-23 07:12:42');

-- --------------------------------------------------------

--
-- Table structure for table `sliders_recycle`
--

DROP TABLE IF EXISTS `sliders_recycle`;
CREATE TABLE IF NOT EXISTS `sliders_recycle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` enum('super_user','admin','user') COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `status` enum('active','inactive','pending') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
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

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `email`, `mobile_number`, `user_type`, `status`, `profile_image`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Super Administrator', 'admin@adminpanel.com', NULL, 'super_user', 'active', NULL, '2025-11-23 11:47:22', '2025-08-04 08:36:00', '2025-11-23 06:17:22'),
(2, 'test', '$2y$10$QrPR1Q49emAwdxyzW.GlMOo9GoFWXdVdsloBFdxR9h.bjzlIJhrMC', 'jay', 'kr.himanshu@outlook.in', '07461007540', 'admin', 'active', NULL, '2025-11-23 12:06:30', '2025-08-04 08:40:41', '2025-11-23 06:36:30');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
