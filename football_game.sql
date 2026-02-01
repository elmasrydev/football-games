-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2026 at 02:10 PM
-- Server version: 9.2.0
-- PHP Version: 8.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `football_game`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-livewire-rate-limiter:a17961fa74e9275d529f489537f179c05d50c2f3', 'i:1;', 1769089478),
('laravel-cache-livewire-rate-limiter:a17961fa74e9275d529f489537f179c05d50c2f3:timer', 'i:1769089478;', 1769089478);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `title`, `slug`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Black & White', 'black-and-white', 'The ultimate grayscale guessing challenge. Watch carefully and answer the question!', 'games/bw.png', '2026-01-21 21:02:10', '2026-01-22 08:45:44'),
(3, 'Stadium Spotter', 'stadium-spotter', 'Test your knowledge by identifying famous football stadiums from around the world.', 'games/stadium-spotter.png', '2026-01-22 11:48:11', '2026-01-22 11:49:26');

-- --------------------------------------------------------

--
-- Table structure for table `hints`
--

CREATE TABLE `hints` (
  `id` bigint UNSIGNED NOT NULL,
  `video_id` bigint UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hints`
--

INSERT INTO `hints` (`id`, `video_id`, `content`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'Premier League', 1, '2026-01-21 21:02:10', '2026-01-21 22:01:49'),
(2, 1, 'Liverpool', 2, '2026-01-21 21:02:10', '2026-01-21 22:01:49'),
(3, 2, 'Manchester United', 1, '2026-01-21 23:11:35', '2026-01-22 06:16:11'),
(4, 2, '2009', 2, '2026-01-22 06:16:11', '2026-01-22 06:16:11'),
(5, 2, 'Puskas Goal', 3, '2026-01-22 06:16:11', '2026-01-22 06:16:11'),
(6, 3, 'Puskas award', 1, '2026-01-22 06:56:47', '2026-01-22 06:56:47'),
(7, 3, '2010', 2, '2026-01-22 06:56:47', '2026-01-22 06:56:47'),
(8, 4, 'Brazilian', 1, '2026-01-22 08:49:11', '2026-01-22 08:49:11'),
(9, 4, 'Puskas Award goal', 2, '2026-01-22 08:49:11', '2026-01-22 08:49:11'),
(10, 4, '2011', 3, '2026-01-22 08:49:11', '2026-01-22 08:49:11');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_21_225049_create_games_table', 1),
(5, '2026_01_21_225050_create_videos_table', 1),
(6, '2026_01_21_225051_create_hints_table', 1),
(7, '2026_01_22_001739_add_timing_columns_to_videos_table', 1),
(8, '2026_01_22_082214_add_slug_to_games_table', 1),
(9, '2026_01_22_105628_change_video_timing_to_string', 2),
(10, '2026_01_22_134316_create_stadium_challenges_table', 3),
(11, '2026_01_22_134316_create_stadium_hints_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('PifdaYSAxVRHF3vABhYPV6aTMPUpHzSLPUif6Myu', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiRHphTFkwS2haek5wcm1iMzRneXQxYjZzdms3Q3doUzBhbXVmeXY5QSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9nYW1lcyI7czo1OiJyb3V0ZSI7czoxMToiZ2FtZXMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjM6InVybCI7YTowOnt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2NDoiYjcyODcwOWUwMDVmZDhhYjg3YmIxYzNmY2QyYjZjZTg3MDAxMGRlOTdmMGIxNmFlNjE3ZmEwNWMxOWI0MTczNiI7czo4OiJmaWxhbWVudCI7YTowOnt9fQ==', 1769091000);

-- --------------------------------------------------------

--
-- Table structure for table `stadium_challenges`
--

CREATE TABLE `stadium_challenges` (
  `id` bigint UNSIGNED NOT NULL,
  `game_id` bigint UNSIGNED NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stadium_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` int DEFAULT NULL,
  `opened_year` int DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `difficulty` enum('easy','medium','hard') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stadium_challenges`
--

INSERT INTO `stadium_challenges` (`id`, `game_id`, `image_path`, `stadium_name`, `capacity`, `opened_year`, `country`, `difficulty`, `created_at`, `updated_at`) VALUES
(1, 3, 'stadiums/test-camp-nou.png', 'Camp Nou', 99354, 1957, 'Spain', 'easy', '2026-01-22 11:56:00', '2026-01-22 12:07:18'),
(2, 3, 'stadiums/test-old-trafford.png', 'Old Trafford', 74310, 1910, 'England', 'easy', '2026-01-22 11:56:00', '2026-01-22 12:07:18'),
(3, 3, 'stadiums/test-parc-des-princes.png', 'Parc des Princes', 47929, 1972, 'France', 'medium', '2026-01-22 11:56:00', '2026-01-22 12:07:18'),
(4, 3, 'stadiums/test-ataturk.png', 'Atatürk Olympic Stadium', 76092, 2002, 'Turkey', 'hard', '2026-01-22 11:56:00', '2026-01-22 12:07:18');

-- --------------------------------------------------------

--
-- Table structure for table `stadium_hints`
--

CREATE TABLE `stadium_hints` (
  `id` bigint UNSIGNED NOT NULL,
  `stadium_challenge_id` bigint UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stadium_hints`
--

INSERT INTO `stadium_hints` (`id`, `stadium_challenge_id`, `content`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'This stadium is home to one of the most successful clubs in Europe.', 1, '2026-01-22 11:56:00', '2026-01-22 11:56:00'),
(2, 1, 'It is located in Barcelona.', 2, '2026-01-22 11:56:00', '2026-01-22 11:56:00'),
(3, 1, 'Messi played here for most of his career.', 3, '2026-01-22 11:56:00', '2026-01-22 11:56:00'),
(4, 2, 'Known as the \"Theatre of Dreams\".', 1, '2026-01-22 11:56:00', '2026-01-22 11:56:00'),
(5, 2, 'Located in Manchester.', 2, '2026-01-22 11:56:00', '2026-01-22 11:56:00'),
(6, 3, 'Home to a club owned by Qatar Sports Investments.', 1, '2026-01-22 11:56:00', '2026-01-22 11:56:00'),
(7, 3, 'Located in Paris.', 2, '2026-01-22 11:56:00', '2026-01-22 11:56:00'),
(8, 4, 'Hosted the 2005 Champions League final (Liverpool vs AC Milan).', 1, '2026-01-22 11:56:00', '2026-01-22 11:56:00'),
(9, 4, 'Located in Istanbul.', 2, '2026-01-22 11:56:00', '2026-01-22 11:56:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@admin.com', '2026-01-22 08:38:20', '$2y$12$RbMQAV6xsgBAT.FZVznrNO03VEs5ra7zZhUJrfRwpHfb2iXcrHK/a', NULL, '2026-01-22 08:38:20', '2026-01-22 08:38:20');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` bigint UNSIGNED NOT NULL,
  `game_id` bigint UNSIGNED NOT NULL,
  `youtube_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uploaded_video` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `start_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `game_id`, `youtube_url`, `uploaded_video`, `question`, `answer`, `created_at`, `updated_at`, `start_time`, `end_time`) VALUES
(1, 1, 'https://www.youtube.com/watch?v=8FOya2rUdA0', NULL, 'Who is The Player ?', 'son', '2026-01-21 21:02:10', '2026-01-22 11:44:04', '5', '11'),
(2, 1, 'https://www.youtube.com/watch?v=zl1hwop3pgg', NULL, 'Guess The Player', 'Cristiano Ronaldo', '2026-01-21 23:11:35', '2026-01-22 11:45:43', '19', '22'),
(3, 1, 'https://www.youtube.com/watch?v=zl1hwop3pgg', NULL, 'guess the player', 'Hamit Altintop', '2026-01-22 06:56:47', '2026-01-22 06:56:47', '38', '42'),
(4, 1, 'https://www.youtube.com/watch?v=zl1hwop3pgg', NULL, 'who is this', 'Neymar', '2026-01-22 08:49:11', '2026-01-22 08:50:04', '66', '76');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `games_slug_unique` (`slug`);

--
-- Indexes for table `hints`
--
ALTER TABLE `hints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hints_video_id_foreign` (`video_id`);

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
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stadium_challenges`
--
ALTER TABLE `stadium_challenges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stadium_challenges_game_id_foreign` (`game_id`);

--
-- Indexes for table `stadium_hints`
--
ALTER TABLE `stadium_hints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stadium_hints_stadium_challenge_id_foreign` (`stadium_challenge_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `videos_game_id_foreign` (`game_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hints`
--
ALTER TABLE `hints`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `stadium_challenges`
--
ALTER TABLE `stadium_challenges`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `stadium_hints`
--
ALTER TABLE `stadium_hints`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hints`
--
ALTER TABLE `hints`
  ADD CONSTRAINT `hints_video_id_foreign` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stadium_challenges`
--
ALTER TABLE `stadium_challenges`
  ADD CONSTRAINT `stadium_challenges_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stadium_hints`
--
ALTER TABLE `stadium_hints`
  ADD CONSTRAINT `stadium_hints_stadium_challenge_id_foreign` FOREIGN KEY (`stadium_challenge_id`) REFERENCES `stadium_challenges` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
