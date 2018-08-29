-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 29, 2018 at 09:43 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `job_vidya`
--

-- --------------------------------------------------------

--
-- Table structure for table `information`
--

CREATE TABLE `information` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_white` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_dark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_white` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_dark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whatsapp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bbm` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gmap` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gmap_query` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website_status` enum('maintenance','open') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `information`
--

INSERT INTO `information` (`id`, `name`, `logo`, `logo_white`, `logo_dark`, `icon`, `icon_white`, `icon_dark`, `company_name`, `phone`, `phone_2`, `whatsapp`, `bbm`, `address`, `zipcode`, `gmap`, `gmap_query`, `website_status`, `created_at`, `updated_at`) VALUES
(1, 'Aksamedia', 'logo.png', 'logo_white.png', 'logo_dark.png', 'icon.png', 'icon_white.png', 'icon_dark.png', 'CV.AKSAMEDIA', '0822-3330-0330', NULL, NULL, NULL, 'Ruko Icon 21 R-1, Jl. Dr. Ir. H. Soekarno, Semolowaru, Sukolilo, Kota SBY, Jawa Timur 60117', '60117', NULL, NULL, 'open', '2018-04-16 20:26:35', '2018-04-16 20:26:35');

-- --------------------------------------------------------

--
-- Table structure for table `lecturer`
--

CREATE TABLE `lecturer` (
  `id` int(11) NOT NULL,
  `identity_number` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `position` varchar(250) NOT NULL,
  `phone` int(11) DEFAULT NULL,
  `address` text,
  `image` varchar(250) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `materi`
--

CREATE TABLE `materi` (
  `id` int(11) NOT NULL,
  `lecturer_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `status` enum('publish','draft') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `materi_attachments`
--

CREATE TABLE `materi_attachments` (
  `id` int(11) NOT NULL,
  `materi_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `file_name` varchar(250) NOT NULL,
  `extension` varchar(250) NOT NULL,
  `size` decimal(10,0) NOT NULL,
  `file_type` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `materi_comments`
--

CREATE TABLE `materi_comments` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `lecturer_id` int(11) DEFAULT NULL,
  `role` enum('student','lecturer') DEFAULT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `email` int(11) NOT NULL,
  `department` varchar(250) NOT NULL,
  `year` int(11) NOT NULL,
  `status` enum('active','register','block') NOT NULL DEFAULT 'block',
  `image` varchar(250) NOT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `address` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `superusers`
--

CREATE TABLE `superusers` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('male','female','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('suspend','active') COLLATE utf8mb4_unicode_ci NOT NULL,
  `suspend_reason` text COLLATE utf8mb4_unicode_ci,
  `ipaddress` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_log` datetime DEFAULT NULL,
  `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_old` text COLLATE utf8mb4_unicode_ci,
  `password_old_date` text COLLATE utf8mb4_unicode_ci,
  `restore_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `restore_expired` datetime DEFAULT NULL,
  `remember_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `superusers`
--

INSERT INTO `superusers` (`id`, `username`, `email`, `name`, `phone`, `address`, `job`, `image`, `gender`, `status`, `suspend_reason`, `ipaddress`, `device`, `last_log`, `password`, `password_old`, `password_old_date`, `restore_token`, `restore_expired`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'aksamedia', 'info@aksamedia.co.id', 'Admin Aksamedia', '085 655 41404', 'Ruko Icon 21 R-1, Jl. Dr. Ir. H. Soekarno, Semolowaru, Sukolilo, Kota SBY, Jawa Timur 60117', 'Administrator', 'default.jpg', 'other', 'active', NULL, '127.0.0.1', NULL, NULL, 'def5020000e6cf9c78c0720eaa99a6c7ccfbb3f76c53589558a67a485e53132d1e22332c1cb29b9910d9936acee306f8cc1cbf50a835915960d169c5592d16866c5627ba8a2dce07a71289bec6d2ec37c523fb2a8cbf9d3f23057b8081f6fe6bba77', 'def502001a6652fa383201c84b876c653399e5444da725854ddb78a1728300df5386d1b053e8b6768c92f3a59ba137f9b2a98d454f04d6834b5f38993b6a062a52ed2252e01c15ec6caea0a8af80751e6282d7671bfd6bfb9a03267a', '2018-04-12', NULL, NULL, NULL, '2018-04-16 20:26:34', '2018-04-16 20:26:34'),
(2, 'copywriter', 'copywriter@aksamedia.co.id', 'Penulis Aksamedia', '085 655 41404', 'Ruko Icon 21 R-1, Jl. Dr. Ir. H. Soekarno, Semolowaru, Sukolilo, Kota SBY, Jawa Timur 60117', 'copywriter', 'default.jpg', 'other', 'active', NULL, '127.0.0.1', NULL, NULL, 'def5020000e6cf9c78c0720eaa99a6c7ccfbb3f76c53589558a67a485e53132d1e22332c1cb29b9910d9936acee306f8cc1cbf50a835915960d169c5592d16866c5627ba8a2dce07a71289bec6d2ec37c523fb2a8cbf9d3f23057b8081f6fe6bba77', 'def502001a6652fa383201c84b876c653399e5444da725854ddb78a1728300df5386d1b053e8b6768c92f3a59ba137f9b2a98d454f04d6834b5f38993b6a062a52ed2252e01c15ec6caea0a8af80751e6282d7671bfd6bfb9a03267a', '2018-04-12', NULL, NULL, NULL, '2018-04-16 20:26:35', '2018-04-16 20:26:35');

-- --------------------------------------------------------

--
-- Table structure for table `superusers_roles`
--

CREATE TABLE `superusers_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `superusers_roles`
--

INSERT INTO `superusers_roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'superusers', '2018-04-16 20:26:33', '2018-04-16 20:26:33'),
(2, 'posts', '2018-04-16 20:26:34', '2018-04-16 20:26:34'),
(3, 'social_media', '2018-04-16 20:26:34', '2018-04-16 20:26:34'),
(4, 'seo', '2018-04-16 20:26:34', '2018-04-16 20:26:34'),
(5, 'faq', '2018-04-16 20:26:34', '2018-04-16 20:26:34'),
(6, 'gallery', '2018-04-16 20:26:34', '2018-04-16 20:26:34'),
(7, 'information', '2018-04-16 20:26:34', '2018-04-16 20:26:34'),
(8, 'page', '2018-04-16 20:26:34', '2018-04-16 20:26:34'),
(9, 'partnerships', '2018-04-16 20:26:34', '2018-04-16 20:26:34'),
(10, 'sliders', '2018-04-16 20:26:34', '2018-04-16 20:26:34'),
(11, 'testimony', '2018-04-16 20:26:34', '2018-04-16 20:26:34');

-- --------------------------------------------------------

--
-- Table structure for table `superusers_roles_give`
--

CREATE TABLE `superusers_roles_give` (
  `id` int(10) UNSIGNED NOT NULL,
  `roles_id` int(10) UNSIGNED NOT NULL,
  `superuser_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `superusers_roles_give`
--

INSERT INTO `superusers_roles_give` (`id`, `roles_id`, `superuser_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2018-04-16 20:26:35', '2018-04-16 20:26:35'),
(2, 2, 2, '2018-04-16 20:26:35', '2018-04-16 20:26:35'),
(3, 3, 2, '2018-04-16 20:26:35', '2018-04-16 20:26:35'),
(4, 4, 2, '2018-04-16 20:26:35', '2018-04-16 20:26:35'),
(5, 5, 2, '2018-04-16 20:26:35', '2018-04-16 20:26:35'),
(6, 6, 2, '2018-04-16 20:26:35', '2018-04-16 20:26:35'),
(7, 8, 2, '2018-04-16 20:26:35', '2018-04-16 20:26:35'),
(8, 9, 2, '2018-04-16 20:26:35', '2018-04-16 20:26:35'),
(9, 10, 2, '2018-04-16 20:26:35', '2018-04-16 20:26:35'),
(10, 11, 2, '2018-04-16 20:26:35', '2018-04-16 20:26:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `information`
--
ALTER TABLE `information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lecturer`
--
ALTER TABLE `lecturer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identity_number` (`identity_number`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_materi__lecturer` (`lecturer_id`);

--
-- Indexes for table `materi_attachments`
--
ALTER TABLE `materi_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_materi__materi_attachments` (`materi_id`);

--
-- Indexes for table `materi_comments`
--
ALTER TABLE `materi_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_materi_comments__student` (`student_id`),
  ADD KEY `fk_materi_comments__lecturer` (`lecturer_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `superusers`
--
ALTER TABLE `superusers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `superusers_username_unique` (`username`),
  ADD UNIQUE KEY `superusers_email_unique` (`email`),
  ADD UNIQUE KEY `superusers_restore_token_unique` (`restore_token`),
  ADD UNIQUE KEY `superusers_remember_token_unique` (`remember_token`);

--
-- Indexes for table `superusers_roles`
--
ALTER TABLE `superusers_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `superusers_roles_name_unique` (`name`);

--
-- Indexes for table `superusers_roles_give`
--
ALTER TABLE `superusers_roles_give`
  ADD PRIMARY KEY (`id`),
  ADD KEY `superusers_roles_give_roles_id_foreign` (`roles_id`),
  ADD KEY `superusers_roles_give_superuser_id_foreign` (`superuser_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `information`
--
ALTER TABLE `information`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lecturer`
--
ALTER TABLE `lecturer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materi_attachments`
--
ALTER TABLE `materi_attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `superusers`
--
ALTER TABLE `superusers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `superusers_roles`
--
ALTER TABLE `superusers_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `superusers_roles_give`
--
ALTER TABLE `superusers_roles_give`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `materi`
--
ALTER TABLE `materi`
  ADD CONSTRAINT `fk_materi__lecturer` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `materi_attachments`
--
ALTER TABLE `materi_attachments`
  ADD CONSTRAINT `fk_materi__materi_attachments` FOREIGN KEY (`materi_id`) REFERENCES `materi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `materi_comments`
--
ALTER TABLE `materi_comments`
  ADD CONSTRAINT `fk_materi_comments__lecturer` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_materi_comments__student` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `superusers_roles_give`
--
ALTER TABLE `superusers_roles_give`
  ADD CONSTRAINT `superusers_roles_give_roles_id_foreign` FOREIGN KEY (`roles_id`) REFERENCES `superusers_roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `superusers_roles_give_superuser_id_foreign` FOREIGN KEY (`superuser_id`) REFERENCES `superusers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
