-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 30, 2024 at 06:45 AM
-- Server version: 8.0.31
-- PHP Version: 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `legislation_process_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `amendments`
--

DROP TABLE IF EXISTS `amendments`;
CREATE TABLE IF NOT EXISTS `amendments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bill_id` int NOT NULL,
  `user_id` int NOT NULL,
  `comment` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

DROP TABLE IF EXISTS `bills`;
CREATE TABLE IF NOT EXISTS `bills` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `author_id` int NOT NULL,
  `status` int NOT NULL DEFAULT '1' COMMENT '1 => Draft\r\n2 => Under Review\r\n3 => Approved\r\n4 => Rejected\r\n5 => Voting\r\n6 => Passed',
  `version_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `message` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `status` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone_verified_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(25) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `is_admin` int NOT NULL DEFAULT '0',
  `role_id` int DEFAULT '2',
  `is_active` int NOT NULL DEFAULT '1',
  `dtoken` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `remember_token` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `phone_verified_at`, `phone`, `password`, `is_admin`, `role_id`, `is_active`, `dtoken`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Member1 of Parliament', 'mp1@gmail.com', NULL, NULL, NULL, '$2y$10$g5TkZHg7MpbR7Z37Be5ZUOgmNMqW5AYlvAEKQ1FR4FMYDcfO5qjn2', 1, 2, 1, NULL, 'rOkI2eAboa4i1zlyQZljQ9CI1IDeAIZzU0QtMf8aRsxOHnt88ZanmNUatvdY', '2024-03-17 20:55:53', '2024-03-17 20:55:53'),
(2, 'Admin', 'admin@gmail.com', NULL, NULL, NULL, '$2y$10$g5TkZHg7MpbR7Z37Be5ZUOgmNMqW5AYlvAEKQ1FR4FMYDcfO5qjn2', 1, 1, 1, NULL, NULL, '2024-04-19 20:06:26', '2024-04-19 20:06:26'),
(6, 'Reviewer', 'reviewer@gmail.com', NULL, NULL, NULL, '$2y$10$g5TkZHg7MpbR7Z37Be5ZUOgmNMqW5AYlvAEKQ1FR4FMYDcfO5qjn2', 1, 3, 1, NULL, NULL, '2024-04-19 20:06:26', '2024-04-19 20:06:26'),
(7, 'Member2 of Parliament', 'mp2@gmail.com', NULL, NULL, NULL, '$2y$10$g5TkZHg7MpbR7Z37Be5ZUOgmNMqW5AYlvAEKQ1FR4FMYDcfO5qjn2', 1, 2, 1, NULL, NULL, '2024-03-17 20:55:53', '2024-03-17 20:55:53');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

DROP TABLE IF EXISTS `votes`;
CREATE TABLE IF NOT EXISTS `votes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bill_id` int NOT NULL,
  `user_id` int NOT NULL,
  `vote` varchar(125) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
