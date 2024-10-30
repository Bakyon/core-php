-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Erstellungszeit: 26. Sep 2024 um 12:25
-- Server-Version: 8.3.0
-- PHP-Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `usermanagement`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint UNSIGNED NOT NULL,
  `version` int UNSIGNED NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `status`, `version`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'user management', 0, 1, '2024-09-22 17:10:09', '2024-09-22 17:10:09', NULL),
(2, 'role management', 0, 1, '2024-09-22 17:10:09', '2024-09-22 17:10:09', NULL),
(3, 'permission management', 0, 1, '2024-09-22 17:10:21', '2024-09-22 17:10:21', NULL),
(4, 'role_permission management', 0, 1, '2024-09-22 22:28:32', '2024-09-22 22:28:32', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint UNSIGNED NOT NULL,
  `version` int UNSIGNED NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `roles`
--

INSERT INTO `roles` (`id`, `name`, `status`, `version`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Developer', 1, 1, '2024-09-19 17:29:46', '2024-09-23 00:30:28', NULL),
(2, 'Admin', 2, 1, '2024-09-19 17:29:46', '2024-09-23 00:30:40', NULL),
(3, 'User', 0, 1, '2024-09-19 17:48:44', '2024-09-19 17:48:44', NULL),
(4, 'Tester II', 0, 1, '2024-09-19 17:50:53', '2024-09-22 00:32:50', NULL),
(6, 'Striker', 0, 1, '2024-09-19 18:00:20', '2024-09-19 18:02:24', '2024-09-19 18:02:24');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `role_permission`
--

DROP TABLE IF EXISTS `role_permission`;
CREATE TABLE IF NOT EXISTS `role_permission` (
  `role_id` bigint UNSIGNED NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL,
  `created_ at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`role_id`,`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `role_permission`
--

INSERT INTO `role_permission` (`role_id`, `permission_id`, `created_ at`, `updated_at`) VALUES
(1, 1, '2024-09-22 22:28:58', '2024-09-22 22:28:58'),
(1, 2, '2024-09-22 22:28:58', '2024-09-22 22:28:58'),
(1, 3, '2024-09-22 22:29:05', '2024-09-22 22:29:05'),
(1, 4, '2024-09-26 19:13:46', '2024-09-26 19:13:46'),
(4, 1, '2024-09-26 14:05:31', '2024-09-26 14:05:31'),
(2, 4, '2024-09-26 19:18:26', '2024-09-26 19:18:26'),
(2, 1, '2024-09-26 19:18:26', '2024-09-26 19:18:26'),
(4, 4, '2024-09-26 14:05:31', '2024-09-26 14:05:31'),
(4, 3, '2024-09-26 19:18:26', '2024-09-26 19:18:26'),
(4, 2, '2024-09-26 19:18:26', '2024-09-26 19:18:26');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` tinyint UNSIGNED NOT NULL DEFAULT '3',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` tinyint NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no-avatar.png',
  `status` tinyint UNSIGNED NOT NULL DEFAULT '1' COMMENT '1 - active, 2 - block',
  `version` int UNSIGNED NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `birthday`, `password`, `email`, `gender`, `avatar`, `status`, `version`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Kyon', '1993-11-01', '$2y$10$E/1sIpue.DDXWrA79kLCcuxFJ38XctSic7JfYDAFzIZYkJjexyPUS', 'bakyon@email.com', 1, 'kyon-1725598126.png', 1, 1, '2024-09-11 12:50:44', '2024-09-26 15:03:28', NULL),
(2, 2, 'Aleyy', '2004-10-01', '$2y$10$idofqdi5YzzjlIMxc1LUEONA79Je2gP33qB3nPZ4N7T9Y29BTPNqG', 'aleyy@email.com', 2, 'Aleyy-1726043212.jpg', 1, 1, '2024-09-11 15:26:52', '2024-09-26 14:30:40', NULL),
(3, 3, 'test@email.com', '2000-10-01', '$2y$10$xBhwvdjGtAdiXoSnHTVIKOPgTjrB0W7ut/JZNha8IY5ai5nLOfuH.', 'test@email.com', 3, 'test@email.com-1726329163.jpg', 1, 1, '2024-09-11 15:39:50', '2024-09-26 14:52:23', NULL),
(4, 3, 'sdf', '2000-11-11', 'sdfg', 'sdf', 3, 'no-avatar.png', 1, 1, '2024-09-11 15:46:02', '2024-09-11 16:06:07', '2024-09-11 16:06:07'),
(5, 3, 'Bakakyon', '2000-07-07', '$2y$10$XV0N3.uvD5fsMxGUstBaxeH1JqP3gVWdLv/E7MiGsORKbVQH9Lt0G', 'test_account@email.com', 1, 'Bakakyon-1726655227.jpg', 2, 1, '2024-09-18 17:27:07', '2024-09-26 14:51:38', NULL),
(6, 4, 'X Tester', '2000-01-01', '$2y$10$/8wcuivR1UjVns8phQeD3udGKUovf11aX1Dhu/LiWVSXFLY95tQZy', 'tester@email.com', 3, 'no-avatar.png', 1, 1, '2024-09-24 15:33:24', '2024-09-26 14:30:42', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
