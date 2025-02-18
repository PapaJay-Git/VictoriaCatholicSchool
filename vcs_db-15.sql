-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2024 at 02:22 PM
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
-- Database: `vcs_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `checklists`
--

CREATE TABLE `checklists` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `form_138` tinyint(1) DEFAULT 0,
  `good_moral` tinyint(1) DEFAULT 0,
  `baptisaml_of_birth` tinyint(1) DEFAULT 0,
  `nso_certificate` tinyint(1) DEFAULT 0,
  `previous_year_report_card` tinyint(1) DEFAULT 0,
  `honorary_dismissal` tinyint(1) DEFAULT 0,
  `is_complete` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checklists`
--

INSERT INTO `checklists` (`id`, `student_id`, `form_138`, `good_moral`, `baptisaml_of_birth`, `nso_certificate`, `previous_year_report_card`, `honorary_dismissal`, `is_complete`, `created_at`, `updated_at`) VALUES
(86, 198, 1, 1, 1, 1, 0, 0, 1, '2024-01-17 23:53:06', '2024-01-17 23:53:06'),
(87, 200, 1, 1, 1, 1, 0, 0, 1, '2024-01-18 00:18:09', '2024-01-18 00:18:09'),
(88, 202, 1, 1, 1, 1, 0, 0, 1, '2024-01-18 15:54:34', '2024-01-18 15:54:34');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `is_monday` tinyint(1) DEFAULT 0,
  `is_tuesday` tinyint(1) DEFAULT 0,
  `is_wednesday` tinyint(1) DEFAULT 0,
  `is_thursday` tinyint(1) DEFAULT 0,
  `is_friday` tinyint(1) DEFAULT 0,
  `monday_start_time` varchar(50) DEFAULT NULL,
  `monday_end_time` varchar(50) DEFAULT NULL,
  `tuesday_start_time` varchar(50) DEFAULT NULL,
  `tuesday_end_time` varchar(50) DEFAULT NULL,
  `wednesday_start_time` varchar(50) DEFAULT NULL,
  `wednesday_end_time` varchar(50) DEFAULT NULL,
  `thursday_start_time` varchar(50) DEFAULT NULL,
  `thursday_end_time` varchar(50) DEFAULT NULL,
  `friday_start_time` varchar(50) DEFAULT NULL,
  `friday_end_time` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `teacher_id`, `subject_id`, `section_id`, `is_monday`, `is_tuesday`, `is_wednesday`, `is_thursday`, `is_friday`, `monday_start_time`, `monday_end_time`, `tuesday_start_time`, `tuesday_end_time`, `wednesday_start_time`, `wednesday_end_time`, `thursday_start_time`, `thursday_end_time`, `friday_start_time`, `friday_end_time`, `created_at`, `updated_at`) VALUES
(258, 67, 22, 28, 1, 1, 0, 0, 0, '7:00 AM', '8:00 AM', '7:00 AM', '8:00 AM', '7:00 AM', '7:00 AM', '7:00 AM', '7:00 AM', '7:00 AM', '7:00 AM', '2024-01-18 11:20:04', '2024-01-18 11:20:04'),
(259, 67, 25, 28, 1, 1, 0, 0, 0, '8:00 AM', '9:00 AM', '8:00 AM', '9:00 AM', '7:00 AM', '7:00 AM', '7:00 AM', '7:00 AM', '7:00 AM', '7:00 AM', '2024-01-18 11:20:04', '2024-01-18 11:20:04'),
(260, 67, 33, 28, 1, 0, 0, 0, 0, '9:00 AM', '10:00 AM', '7:00 AM', '7:00 AM', '7:00 AM', '7:00 AM', '7:00 AM', '7:00 AM', '7:00 AM', '7:00 AM', '2024-01-18 11:20:04', '2024-01-18 11:20:04');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `show_until` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `show_until`, `created_at`, `updated_at`) VALUES
(1, 'VALENTINE&#039;S DAY', 'An event filled with love and joy with the students and faculty members this coming February14, 2024. Please be ready for this event as it will showcase a fun and exciting booths and games that will be prepared by each sections!', '2024-02-22', '2023-12-15 12:06:03', '2024-01-15 14:44:13'),
(3, 'Palarong Pinoy Jan 6, 2024', 'Organize a day of traditional Filipino games like patintero, tumbang preso, and sack race. Encourage friendly competition between students and teachers. Consider incorporating a cheering squad competition to boost school spirit.', '2024-02-20', '2023-12-17 00:47:48', '2024-01-15 14:44:32'),
(4, 'Bayanihan Fiesta Dec 20, 2023', 'Celebrate the rich cultural diversity of the Philippines with traditional dances, music performances, and a showcase of regional cuisines. Encourage students to participate in cultural exhibitions, and invite local artists to perform.', '2024-01-31', '2023-12-17 00:48:11', '2024-01-15 14:45:32');

-- --------------------------------------------------------

--
-- Table structure for table `guardians`
--

CREATE TABLE `guardians` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `guardian_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guardians`
--

INSERT INTO `guardians` (`id`, `student_id`, `guardian_id`, `created_at`, `updated_at`) VALUES
(72, 198, 199, '2024-01-17 23:52:06', '2024-01-17 23:52:06'),
(73, 200, 201, '2024-01-18 00:15:02', '2024-01-18 00:15:02'),
(74, 202, 203, '2024-01-18 15:46:53', '2024-01-18 15:46:53');

-- --------------------------------------------------------

--
-- Table structure for table `non_account_guardian`
--

CREATE TABLE `non_account_guardian` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `type` enum('father','mother','guardian') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `non_account_guardian`
--

INSERT INTO `non_account_guardian` (`id`, `student_id`, `first_name`, `middle_name`, `last_name`, `occupation`, `email`, `phone`, `type`) VALUES
(7, 198, 'Marry', 'Mao', 'Yusa', 'OFW', 'dilovax932@ikuromi.com', '09111122221', 'guardian'),
(8, 198, 'Shido', 'Mao', 'Yusa', 'Guard', 'munotivy@pelagius.net', '09009099912', 'father'),
(9, 200, 'Julius', 'Oasis', 'Cruz', 'Teacher', 'zepsatemli@gufum.com', '09111222098', 'guardian'),
(10, 200, 'Janna', 'Caleb', 'Cruz', 'OFW', 'cajif21051@rentaen.com', '09111222222', 'mother'),
(11, 202, 'Oscar', 'Francisco', 'Bruno', 'Police Officer', '407working@jcnorris.com', '09345627658', 'father');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `data` varchar(255) DEFAULT NULL,
  `notifiable_id` int(11) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `data`, `notifiable_id`, `is_read`, `created_at`, `updated_at`) VALUES
(352, 'Requirements_filled', 70, 1, '2024-01-18 15:54:34', '2024-01-18 15:55:10'),
(353, 'Student_payment_added', 1, 1, '2024-01-18 15:55:25', '2024-01-18 15:55:53'),
(354, 'Enrollee', 1, 1, '2024-01-18 21:53:05', '2024-01-18 21:53:30'),
(355, 'Enrollee', 70, 1, '2024-01-18 21:53:05', '2024-01-20 11:18:54');

-- --------------------------------------------------------

--
-- Table structure for table `paidmonths`
--

CREATE TABLE `paidmonths` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paidmonths`
--

INSERT INTO `paidmonths` (`id`, `student_id`, `date`, `created_at`, `updated_at`) VALUES
(312, 198, '2023-7', '2024-01-18 00:06:46', '2024-01-18 00:06:46'),
(313, 198, '2023-8', '2024-01-18 00:06:46', '2024-01-18 00:06:46'),
(314, 198, '2023-9', '2024-01-18 00:06:46', '2024-01-18 00:06:46'),
(315, 198, '2023-10', '2024-01-18 00:06:46', '2024-01-18 00:06:46'),
(316, 198, '2023-11', '2024-01-18 00:06:46', '2024-01-18 00:06:46'),
(317, 200, '2023-7', '2024-01-18 00:18:38', '2024-01-18 00:18:38'),
(318, 200, '2023-8', '2024-01-18 00:18:38', '2024-01-18 00:18:38'),
(319, 200, '2023-9', '2024-01-18 00:18:38', '2024-01-18 00:18:38'),
(320, 200, '2023-10', '2024-01-18 00:18:38', '2024-01-18 00:18:38'),
(321, 200, '2023-11', '2024-01-18 00:18:38', '2024-01-18 00:18:38'),
(322, 200, '2023-12', '2024-01-18 00:18:38', '2024-01-18 00:18:38'),
(323, 200, '2024-1', '2024-01-18 00:18:38', '2024-01-18 00:18:38'),
(324, 200, '2024-2', '2024-01-18 00:18:38', '2024-01-18 00:18:38'),
(325, 200, '2024-3', '2024-01-18 00:18:38', '2024-01-18 00:18:38'),
(326, 202, '2023-7', '2024-01-18 15:55:25', '2024-01-18 15:55:25'),
(327, 202, '2023-8', '2024-01-18 15:55:25', '2024-01-18 15:55:25'),
(328, 202, '2023-9', '2024-01-18 15:55:25', '2024-01-18 15:55:25'),
(329, 202, '2023-10', '2024-01-18 15:55:25', '2024-01-18 15:55:25'),
(330, 202, '2023-11', '2024-01-18 15:55:25', '2024-01-18 15:55:25'),
(331, 202, '2023-12', '2024-01-18 15:55:25', '2024-01-18 15:55:25'),
(332, 202, '2024-1', '2024-01-18 15:55:25', '2024-01-18 15:55:25'),
(333, 202, '2024-2', '2024-01-18 15:55:25', '2024-01-18 15:55:25'),
(334, 202, '2024-3', '2024-01-18 15:55:25', '2024-01-18 15:55:25');

-- --------------------------------------------------------

--
-- Table structure for table `promissory`
--

CREATE TABLE `promissory` (
  `id` int(11) NOT NULL,
  `note` enum('sick','payment') NOT NULL DEFAULT 'sick',
  `student_id` int(11) DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registered_students`
--

CREATE TABLE `registered_students` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `student_type` enum('new','transfer') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registered_students`
--

INSERT INTO `registered_students` (`id`, `student_id`, `student_type`, `created_at`, `updated_at`) VALUES
(113, 198, 'new', '2024-01-17 23:52:50', '2024-01-17 23:52:50'),
(114, 200, 'new', '2024-01-18 00:17:52', '2024-01-18 00:17:52'),
(115, 202, 'new', '2024-01-18 15:54:04', '2024-01-18 15:54:04');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `grade` enum('7','8','9','10','SECTION') DEFAULT NULL,
  `advisory_teacher_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `name`, `grade`, `advisory_teacher_id`, `created_at`, `updated_at`) VALUES
(26, 'INACTIVE', 'SECTION', 0, '2023-12-05 12:15:18', '2023-12-05 12:15:18'),
(28, 'HOLY-ROSARY', '7', 67, '2023-12-06 02:44:00', '2023-12-17 18:20:53'),
(29, 'ST. ALBERT THE GREAT', '8', 67, '2023-12-06 02:44:46', '2023-12-07 07:17:54'),
(30, 'ST. THOMAS AQUINAS', '9', 69, '2023-12-06 02:45:20', '2023-12-07 06:26:38'),
(32, 'ST. DOMINIC', '10', 73, '2023-12-06 04:06:12', '2023-12-07 07:22:53');

-- --------------------------------------------------------

--
-- Table structure for table `student_grades`
--

CREATE TABLE `student_grades` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `first_quarter` double DEFAULT 0,
  `second_quarter` double DEFAULT 0,
  `third_quarter` double DEFAULT 0,
  `fourth_quarter` double DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_grades`
--

INSERT INTO `student_grades` (`id`, `student_id`, `subject_id`, `first_quarter`, `second_quarter`, `third_quarter`, `fourth_quarter`, `created_at`, `updated_at`) VALUES
(154, 202, 33, 98, 99, 98, 99, '2024-01-18 16:01:56', '2024-01-18 16:01:56'),
(155, 200, 33, 87, 66, 77, 90, '2024-01-18 16:01:56', '2024-01-18 16:01:56'),
(156, 198, 33, 0, 0, 0, 0, '2024-01-18 16:01:56', '2024-01-18 16:01:56'),
(157, 202, 25, 97, 98, 97, 99, '2024-01-18 16:02:13', '2024-01-18 16:02:13'),
(158, 200, 25, 78, 88, 98, 0, '2024-01-18 16:02:13', '2024-01-18 16:02:13'),
(159, 198, 25, 78, 77, 69, 0, '2024-01-18 16:02:13', '2024-01-18 16:02:13'),
(160, 202, 22, 99, 99, 99, 99, '2024-01-18 16:02:28', '2024-01-18 16:02:28'),
(161, 200, 22, 85, 85, 87, 89, '2024-01-18 16:02:28', '2024-01-18 16:02:28'),
(162, 198, 22, 87, 86, 88, 86, '2024-01-18 16:02:28', '2024-01-18 16:02:28');

-- --------------------------------------------------------

--
-- Table structure for table `student_payment`
--

CREATE TABLE `student_payment` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `payment_type` enum('down','full') DEFAULT NULL,
  `value` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_payment`
--

INSERT INTO `student_payment` (`id`, `student_id`, `payment_type`, `value`, `created_at`, `updated_at`) VALUES
(98, 198, 'down', NULL, '2024-01-18 00:06:46', '2024-01-18 00:06:46'),
(99, 200, 'full', NULL, '2024-01-18 00:18:38', '2024-01-18 00:18:38'),
(100, 202, 'full', NULL, '2024-01-18 15:55:25', '2024-01-18 15:55:25');

-- --------------------------------------------------------

--
-- Table structure for table `student_sections`
--

CREATE TABLE `student_sections` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_sections`
--

INSERT INTO `student_sections` (`id`, `student_id`, `section_id`, `created_at`, `updated_at`) VALUES
(199, 198, 28, '2024-01-17 23:52:50', '2024-01-17 23:52:50'),
(200, 200, 28, '2024-01-18 00:17:52', '2024-01-18 00:17:52'),
(202, 202, 28, '2024-01-18 21:56:04', '2024-01-18 21:56:04');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `grade` enum('7','8','9','10') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `grade`, `created_at`, `updated_at`) VALUES
(22, 'ENGLISH', '7', '2023-12-07 06:17:42', '2023-12-07 06:17:42'),
(23, 'MATH', '8', '2023-12-07 06:56:34', '2023-12-07 06:56:34'),
(24, 'ENGLISH', '8', '2023-12-07 06:56:53', '2023-12-07 06:56:53'),
(25, 'MATH', '7', '2023-12-07 07:01:01', '2023-12-07 07:01:01'),
(26, 'MATH', '9', '2023-12-07 07:01:14', '2023-12-07 07:01:14'),
(27, 'ENGLISH', '9', '2023-12-07 07:01:25', '2023-12-07 07:01:25'),
(28, 'MATH', '10', '2023-12-07 07:01:43', '2023-12-07 07:01:43'),
(29, 'ENGLISH', '10', '2023-12-07 07:01:53', '2023-12-07 07:01:53'),
(30, 'SCIENCE', '10', '2023-12-07 07:02:10', '2023-12-07 07:02:10'),
(31, 'SCIENCE', '9', '2023-12-07 07:02:38', '2023-12-07 07:02:38'),
(32, 'SCIENCE', '8', '2023-12-07 07:02:53', '2023-12-07 07:02:53'),
(33, 'SCIENCE', '7', '2023-12-07 07:03:09', '2023-12-07 07:03:09'),
(34, 'FILIPINO', '7', '2024-01-18 14:43:19', '2024-01-18 14:43:19');

-- --------------------------------------------------------

--
-- Table structure for table `unregistered_students`
--

CREATE TABLE `unregistered_students` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `requested_grade` varchar(10) NOT NULL,
  `student_type` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `school_number` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `lrn` varchar(20) DEFAULT NULL,
  `is_locked` tinyint(1) DEFAULT 0,
  `login_attempts` int(11) NOT NULL DEFAULT 0,
  `gender` enum('Male','Female') DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `street_no` varchar(100) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `village` varchar(500) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `city_municipality` varchar(500) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `zip_code` varchar(100) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `guardian_type` enum('mother','father','guardian') DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `school_number`, `first_name`, `middle_name`, `last_name`, `email`, `phone`, `lrn`, `is_locked`, `login_attempts`, `gender`, `birthday`, `street_no`, `street`, `village`, `barangay`, `city_municipality`, `province`, `zip_code`, `occupation`, `guardian_type`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', '0', 'Shiela Marie', NULL, 'Angeles', 'shielamarie@gmail.com', '09123456789', NULL, 0, 0, 'Female', '2001-07-27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$SVm4c7p5akS6x4gR/VlP7.T8Osx4KlNU7hcu.ii4XmpHTcdBMQoyO', NULL, '2023-11-14 11:46:49', '2023-12-05 12:23:54'),
(67, 'teacher', '10003', 'Carla', 'Agustin', 'Aquino', 'carlaaquino@gmail.com', '09123456788', NULL, 0, 0, 'Female', '1990-02-02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$U7nKgjibhF8lMnVKYV/SHOd9xKGR4lpmGRE6p1wMipvFierB8jk32', NULL, '2023-12-07 06:06:58', '2024-01-20 11:05:33'),
(68, 'teacher', '10002', 'Anna', 'Roan', 'Lanuzo', 'anna@gmail.com', '09123456787', NULL, 0, 0, 'Female', '1998-03-02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$ESq5RNcDITh7sUfB6To2w.ojEGDPvtpT6Bzl5l1Va4RkMTS.PTB42', NULL, '2023-12-07 06:10:19', '2024-01-12 18:27:08'),
(69, 'teacher', '10001', 'Nicole', 'G', 'Bautista', 'nicole@gmail.com', '09123456781', NULL, 0, 0, 'Female', '2000-02-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$HPlcePoPOAJOQv58fES8RObq6zrFQVdGngpcWJNWyDlcxDN3UBbK6', NULL, '2023-12-07 06:26:10', '2024-01-12 16:09:35'),
(70, 'cashier', '0000101', 'Roan', 'Garcia', 'Lanuzo', 'roanlanuzo090@gmail.com', '09178736980', NULL, 0, 0, 'Male', '2001-03-10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$PFch4qfUyn7/rIclIgNQ8.63OxQbmlri63XIf0JwPI8lujF6XUf2K', NULL, '2023-12-07 06:55:32', '2024-01-20 11:06:06'),
(73, 'teacher', '10004', 'Krizelle', 'Julian', 'Dula', 'krizelleamariedula@gmail.com', '09682159982', NULL, 0, 0, 'Female', '2002-03-19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$AFLUSRyGF1rP7ljN7d6aNe.3D7C7oiy5lleBKjDY/eWlGoEWAoec2', NULL, '2023-12-07 07:22:32', '2024-01-08 12:46:50'),
(198, 'student', NULL, 'Emilia', 'Mao', 'Yusa', 'eimilesufficient@jcnorris.com', '09123444543', '112344555567', 0, 0, 'Male', '2006-03-03', '123', 'Camangaan street', '', 'Palimbo Caarospan', 'Camiling', 'Tarlac', '2306', NULL, NULL, '$2y$10$f37pyC4wnN/GfFxUPfxwdOz/LZfRo2VFYQ31wubUnK/6sybr/mX/C', NULL, '2024-01-17 23:52:06', '2024-01-20 12:58:34'),
(199, 'guardian', NULL, 'Marry', 'Mao', 'Yusa', 'dilovax932@ikuromi.com', '09111122221', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'OFW', 'mother', '$2y$10$NTniJ5Q7k5QG2iVSD2M0.OOv6KS3zFrCTQnghNprBMD/wRjViqQbG', NULL, '2024-01-17 23:52:06', '2024-01-20 13:17:02'),
(200, 'student', NULL, 'John Paul', 'Caleb', 'Cruz', 'chelsygold@jcnorris.com', '09123456665', '124456789032', 0, 0, 'Male', '2006-03-02', '123', 'Camangaan street', '', 'Palimbo Caarosipan', 'Camiling', 'Tarlac', '2306', NULL, NULL, '$2y$10$JiIBhvs3IyuTJ/.fHdhMFOpR64QK1c/smA24/6aeYBESGkAKU5NSq', NULL, '2024-01-18 00:15:02', '2024-01-18 22:49:47'),
(201, 'guardian', NULL, 'Julius', 'Oasis', 'Cruz', 'zepsatemli@gufum.com', '09111222098', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Teacher', 'father', '$2y$10$kxhvivTgjlA2TGuXtjFajuIN7G1ZC9Xh0c6/idkoLLdrwBquSxBLq', NULL, '2024-01-18 00:15:02', '2024-01-18 22:41:32'),
(202, 'student', NULL, 'John Mark', 'Seneres', 'Bruno', '6615artistic@jcnorris.com', '09613662581', '106346080019', 0, 0, 'Male', '2001-04-13', '', '', '', 'Calibungan', 'Victoria', 'Tarlac', '2313', NULL, NULL, '$2y$10$6z7hF2KlmkxQyOQe5Zg7s.RTVrwSGb9iqjAt76fy4y2bsvk5xCLge', NULL, '2024-01-18 15:46:53', '2024-01-20 12:56:27'),
(203, 'guardian', NULL, 'Marilyn', 'Seneres', 'Bruno', '407working@jcnorris.com', '09847689353', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Housewife', 'mother', '$2y$10$6z7hF2KlmkxQyOQe5Zg7s.RTVrwSGb9iqjAt76fy4y2bsvk5xCLge', NULL, '2024-01-18 15:46:53', '2024-01-18 15:46:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `checklists`
--
ALTER TABLE `checklists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guardians`
--
ALTER TABLE `guardians`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `non_account_guardian`
--
ALTER TABLE `non_account_guardian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paidmonths`
--
ALTER TABLE `paidmonths`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promissory`
--
ALTER TABLE `promissory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registered_students`
--
ALTER TABLE `registered_students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_grades`
--
ALTER TABLE `student_grades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_payment`
--
ALTER TABLE `student_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_sections`
--
ALTER TABLE `student_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unregistered_students`
--
ALTER TABLE `unregistered_students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checklists`
--
ALTER TABLE `checklists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=261;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `guardians`
--
ALTER TABLE `guardians`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `non_account_guardian`
--
ALTER TABLE `non_account_guardian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=356;

--
-- AUTO_INCREMENT for table `paidmonths`
--
ALTER TABLE `paidmonths`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=335;

--
-- AUTO_INCREMENT for table `promissory`
--
ALTER TABLE `promissory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `registered_students`
--
ALTER TABLE `registered_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `student_grades`
--
ALTER TABLE `student_grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `student_payment`
--
ALTER TABLE `student_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `student_sections`
--
ALTER TABLE `student_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `unregistered_students`
--
ALTER TABLE `unregistered_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
