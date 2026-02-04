<?php
// DDL to create contacts_recycle table

$sql = "CREATE TABLE IF NOT EXISTS `contacts_recycle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) NOT NULL COMMENT 'Original contact ID',
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20),
  `subject` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `status` enum('new','read','replied','closed') DEFAULT 'new',
  `deleted_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `restored_at` datetime,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`),
  KEY `deleted_at` (`deleted_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";

echo "SQL DDL for contacts_recycle table:\n\n";
echo $sql;
?>
