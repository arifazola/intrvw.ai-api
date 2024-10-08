-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2024 at 04:58 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `intrvw`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `interview_results`
--

CREATE TABLE `interview_results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `score` int(11) NOT NULL,
  `feedback` text NOT NULL,
  `summary` text NOT NULL,
  `interview_title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `interview_results`
--

INSERT INTO `interview_results` (`id`, `user_id`, `score`, `feedback`, `summary`, `interview_title`) VALUES
(127, 11, 0, '{\"results\": [{\"title\": \"Communication\", \"score\": 1, \"shortDesc\": \"Candidate refused to answer the introductory question, showing a lack of communication and engagement.\", \"desc\": \"The candidate\'s immediate refusal to answer the introductory question demonstrates a lack of communication and engagement. This suggests potential issues with interpersonal skills and a reluctance to participate in the interview process.\"}, {\"title\": \"Professionalism\", \"score\": 1, \"shortDesc\": \"Candidate\'s abrupt response lacks professionalism and respect for the interviewer.\", \"desc\": \"The candidate\'s abrupt and dismissive response is unprofessional and disrespectful. It indicates a lack of understanding of proper interview etiquette and a disregard for the interviewer\'s time and effort.\"}]}\n', 'Keep it up', 'Fullstack Developer'),
(128, 11, 0, '{\n    \"results\": [\n        {\n            \"title\": \"Communication\",\n            \"score\": 1,\n            \"shortDesc\": \"The candidate declined to participate in the interview.\",\n            \"desc\": \"The candidate expressed a clear disinterest in partaking in the interview process. This resulted in an abrupt end to the conversation and left little room for assessment of communication skills or engagement.\"\n        }\n    ]\n}', 'Keep it up', 'Fullstack dev'),
(129, 11, 0, '{\n    \"results\": [\n        {\n            \"title\": \"Engagement and Enthusiasm\",\n            \"score\": 2,\n            \"shortDesc\": \"The candidate showed a lack of interest in engaging with the interview process.\",\n            \"desc\": \"The candidate directly expressed disinterest in participating in the interview and declined to share any personal background or motivations. This suggests a lack of enthusiasm for the opportunity and could reflect on their overall engagement levels in a professional setting.\"\n        }\n    ]\n}', 'Keep it up', 'Security');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_09_13_221908_create_personal_access_tokens_table', 1),
(5, '2024_09_15_185117_create_interview_result_table', 2),
(6, '2024_09_19_161553_add_interview_title_on_interview_results_table', 3),
(7, '2024_09_20_231400_add_new_remaining_token_column_user_table', 4),
(8, '2024_09_20_231756_add_new_remaining_token_column_user_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(14, 'App\\Models\\User', 10, 'auth_token', '310b004b5804deaac8f59f5ad84951cb3d952b69ef12cee44e1590fe3934c051', '[\"*\"]', NULL, NULL, '2024-09-14 14:29:42', '2024-09-14 14:29:42'),
(23, 'App\\Models\\User', 13, 'auth_token', '823d3a4220daaab7efb77c782416e92198f3e80e8cb2bb663335f56a78c7a7bb', '[\"*\"]', NULL, NULL, '2024-09-16 08:36:53', '2024-09-16 08:36:53'),
(40, 'App\\Models\\User', 9, 'auth_token', 'e3e8d0b198ae74902fd15ada4c021595980ad3fc63d8a8409dc72664a9fae428', '[\"*\"]', '2024-09-18 11:07:32', NULL, '2024-09-18 10:53:14', '2024-09-18 11:07:32'),
(80, 'App\\Models\\User', 11, 'auth_token', '62a2f70b365d0b6e5712366bc1525a42c46e22dece31862e7de5ed141ee09d8b', '[\"*\"]', '2024-10-02 22:08:23', NULL, '2024-09-29 02:00:35', '2024-10-02 22:08:23');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('W6VtrTVup6NFMLq8ZlqBSd13cJJ88IBwUVprQkFZ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36 Edg/128.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWEx0Q1BEU0p5VWdaTUdrM3gzUk9qR0dMUm1Idm9MVjlKT3lidWpzWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTcxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZW1haWwvdmVyaWZ5LzkvYWMzZmFkZTdlNmM2NzM4NDdiYWFhNmE1NTY0M2UzZmYxZGZiNjNkNT9leHBpcmVzPTE3MjYzMDM1Njcmc2lnbmF0dXJlPTdjOTU3MjBjYmE4ZDA4OWY4ZDhhNDA2MzAwZjI3ZmI2YWU3ZjYwNmY3YjU5ZmM4ZWNkMmM2NjNiYWYwZWRkYzciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1726299983);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remaining_token` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `remaining_token`) VALUES
(9, 'Ari Fazola', 'afazola@gmail.com', NULL, '$2y$12$zqX50ksTQSyVYVmejI4fY.qMXm7zzMY.TFDjJn04qfploXLiqNGCS', NULL, '2024-09-14 00:46:07', '2024-09-14 00:46:07', 3),
(11, 'Eko Syaifulloh', 'juktano@gmail.com', '2024-09-15 08:47:28', '$2y$12$EIq0pUiBqYLjmcuIo/SihOKTMycAD41UvBDsv.C3PfUo3Wc7SoFDm', NULL, '2024-09-15 08:47:29', '2024-09-15 08:47:29', 3),
(12, 'Ari Fazola', 'afazolaaa@gmail.com', '2024-09-16 07:33:33', '$2y$12$9/xEot8DkvdC.CXIVsh6t.hEwL/3V6SCgjou46htxjDmMizCvhgHa', NULL, '2024-09-16 07:33:33', '2024-09-16 07:33:33', 3),
(13, 'Ari Fazolaaa', 'afazolaaa@gmail.coma', '2024-09-16 08:36:53', '$2y$12$sUjBtkStUHagi4KzlTK4cehRNaHmRKwxh1mT7yC2c7vw7JTIcXOV6', NULL, '2024-09-16 08:36:53', '2024-09-16 08:36:53', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `interview_results`
--
ALTER TABLE `interview_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `interview_results_user_id_foreign` (`user_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `interview_results`
--
ALTER TABLE `interview_results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `interview_results`
--
ALTER TABLE `interview_results`
  ADD CONSTRAINT `interview_results_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
