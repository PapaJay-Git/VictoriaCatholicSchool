-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2023 at 03:20 PM
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
(50, 68, 22, 28, 1, 0, 1, 0, 0, '7:30 AM', '8:30 AM', '7:00 AM', '7:00 AM', '7:30 AM', '8:30 AM', '7:00 AM', '7:00 AM', '7:00 AM', '7:00 AM', '2023-12-07 06:20:40', '2023-12-07 06:20:40'),
(51, 69, 26, 30, 1, 1, 1, 1, 1, '8:30 AM', '9:30 AM', '9:00 AM', '10:00 AM', '10:00 AM', '11:00 AM', '11:00 AM', '12:00 PM', '11:30 AM', '12:30 PM', '2023-12-07 07:26:21', '2023-12-07 07:26:21'),
(52, 67, 27, 30, 0, 1, 0, 1, 0, '7:00 AM', '7:00 AM', '9:30 AM', '10:30 AM', '7:00 AM', '7:00 AM', '1:00 PM', '2:00 PM', '7:00 AM', '7:00 AM', '2023-12-07 07:26:21', '2023-12-07 07:26:21'),
(53, 68, 31, 30, 0, 1, 0, 0, 0, '7:00 AM', '7:00 AM', '7:00 AM', '8:00 AM', '7:00 AM', '7:00 AM', '7:00 AM', '7:00 AM', '7:00 AM', '7:00 AM', '2023-12-07 07:26:21', '2023-12-07 07:26:21'),
(54, 73, 23, 29, 1, 0, 1, 0, 0, '7:00 AM', '8:00 AM', '7:00 AM', '7:00 AM', '7:00 AM', '8:00 AM', '7:00 AM', '7:00 AM', '7:00 AM', '7:00 AM', '2023-12-07 08:15:44', '2023-12-07 08:15:44'),
(55, 68, 24, 29, 0, 1, 0, 0, 1, '7:00 AM', '7:00 AM', '7:00 AM', '8:00 AM', '7:00 AM', '7:00 AM', '7:00 AM', '7:00 AM', '7:00 AM', '8:00 AM', '2023-12-07 08:15:44', '2023-12-07 08:15:44'),
(56, 67, 32, 29, 0, 1, 1, 0, 0, '7:00 AM', '7:00 AM', '7:00 AM', '8:00 AM', '7:00 AM', '8:00 AM', '7:00 AM', '7:00 AM', '7:00 AM', '7:00 AM', '2023-12-07 08:15:44', '2023-12-07 08:15:44');

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

-- --------------------------------------------------------

--
-- Table structure for table `promissory`
--

CREATE TABLE `promissory` (
  `id` int(11) NOT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
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
(28, 'HOLY-ROSARY', '7', 68, '2023-12-06 02:44:00', '2023-12-07 07:17:24'),
(29, 'ST. ALBERT THE GREAT', '8', 67, '2023-12-06 02:44:46', '2023-12-07 07:17:54'),
(30, 'ST. THOMAS AQUINAS', '9', 69, '2023-12-06 02:45:20', '2023-12-07 06:26:38'),
(32, 'ST. DOMINIC', '10', 73, '2023-12-06 04:06:12', '2023-12-07 07:22:53');

-- --------------------------------------------------------

--
-- Table structure for table `student_balance`
--

CREATE TABLE `student_balance` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `descriptive_balance` double DEFAULT 0,
  `info` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(33, 'SCIENCE', '7', '2023-12-07 07:03:09', '2023-12-07 07:03:09');

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

--
-- Dumping data for table `unregistered_students`
--

INSERT INTO `unregistered_students` (`id`, `student_id`, `requested_grade`, `student_type`, `created_at`, `updated_at`) VALUES
(34, 98, '7', 'new', '2023-12-10 14:19:58', '2023-12-10 14:19:58');

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
  `gender` enum('Male','Female') DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `school_number`, `first_name`, `middle_name`, `last_name`, `email`, `phone`, `gender`, `birthday`, `address`, `occupation`, `username`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', '0', 'Shiela Marie', NULL, 'Angeles', 'shielamarie@gmail.com', '09123456789', 'Female', '2001-07-27', 'Victoria Tarlac', NULL, 'admin', '$2y$10$SVm4c7p5akS6x4gR/VlP7.T8Osx4KlNU7hcu.ii4XmpHTcdBMQoyO', NULL, '2023-11-14 11:46:49', '2023-12-05 12:23:54'),
(67, 'teacher', '10003', 'Carla', 'Agustin', 'Aquino', 'carlaaquino@gmail.com', '09123456788', 'Female', '1990-02-02', 'Camiling, Tarlac', NULL, 'carla0001', '$2y$10$Ue2KTR37FvCbDgeKQlLRZ.rL4iSoE9/Q8NPbR/IpeUQe.wgu2T3wC', NULL, '2023-12-07 06:06:58', '2023-12-07 07:18:57'),
(68, 'teacher', '10002', 'Anna', 'Roan', 'Lanuzo', 'anna@gmail.com', '09123456787', 'Female', '1998-03-02', 'Victoria, Tarlac', NULL, 'annalanuzo001', '$2y$10$pR6jOfKzbgSLG8QQ0vspIufeQ9apQJ1TcLxrarH7gHGpkRpJ8wtTe', NULL, '2023-12-07 06:10:19', '2023-12-07 07:18:39'),
(69, 'teacher', '10001', 'Nicole', 'G', 'Bautista', 'nicole@gmail.com', '09123456781', 'Female', '2000-02-04', 'Camiling, Tarlac', NULL, 'nicolebautista001', '$2y$10$TnujQGE8fBEtCqS1mFkXCux/T0eLZJNQRc1Uif8L/D4T0UVRyavR.', NULL, '2023-12-07 06:26:10', '2023-12-07 07:18:22'),
(70, 'cashier', '0000101', 'Roan', 'Garcia', 'Lanuzo', 'roanlanuzo090@gmail.com', '09178736980', 'Male', '2001-03-10', 'Matatalaib , Tarlac', NULL, 'roankarl', '$2y$10$hcG2wGoYaIXOY/qOcDBvYezjFmqH7NOe7y.xDnyyGAfvqZ7jQkm3a', NULL, '2023-12-07 06:55:32', '2023-12-07 06:55:32'),
(73, 'teacher', '10004', 'Krizelle', 'Julian', 'Dula', 'krizelleamariedula@gmail.com', '09682159982', 'Female', '2002-03-19', 'Concepcion, Tarlac.', NULL, 'krizelledl', '$2y$10$AFLUSRyGF1rP7ljN7d6aNe.3D7C7oiy5lleBKjDY/eWlGoEWAoec2', NULL, '2023-12-07 07:22:32', '2023-12-07 07:22:32'),
(74, 'teacher', '00005', 'Joe', 'Panlilio', 'Canasa', 'johnlorenzpanlilio51@gmail.com', '09914384304', 'Male', '1999-05-27', 'Cope Alfonso 1440', NULL, 'joepanlilio0', '$2y$10$Onlcg1OaLFgOVr4czuxwM.arEbFUFJQ55nImXwRweeKq/ttLBtmle', NULL, '2023-12-07 07:55:19', '2023-12-07 07:55:19'),
(76, 'parent', NULL, 'Angel Anne', 'Sabado', 'Garia', 'karllanuzo10@gmail.com', '09832456787', 'Female', '2015-07-12', 'Fiesta Communities Matatalaib Tarlac City', NULL, 'Angelanne', '$2y$10$23VsfD2lrDvREKSHMjo81e0LhfCMM3RMfNjaKkr4yMWbKAyRTA6.S', NULL, '2023-12-08 00:33:39', '2023-12-09 08:11:09'),
(78, 'parent', '000000123123', 'Kairi', 'Miz', 'Irving', 'nthjolmpuvfpxxy@wireconnected.com', '09111123334', 'Female', NULL, 'Camiling, Tarlac', NULL, 'kairi001', 'P@ssword123', NULL, '2023-12-09 07:04:25', '2023-12-09 07:04:25'),
(98, 'student', NULL, 'John Mark', 'Seneres', 'Bruno', 'njeverbxkhccq@wireconnected.com', '09657835671', 'Male', '2001-03-13', 'Camiling, Tarlac.', NULL, 'jmbruno', '$2y$10$c.bhgLLVyd1muPrFcTu1NeHOKbQDMijYrfcEDTgidDrdxDlalqe1K', NULL, '2023-12-10 14:19:58', '2023-12-10 14:19:58');

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
-- Indexes for table `guardians`
--
ALTER TABLE `guardians`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
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
-- Indexes for table `student_balance`
--
ALTER TABLE `student_balance`
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
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checklists`
--
ALTER TABLE `checklists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `guardians`
--
ALTER TABLE `guardians`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `promissory`
--
ALTER TABLE `promissory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `registered_students`
--
ALTER TABLE `registered_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `student_balance`
--
ALTER TABLE `student_balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `student_payment`
--
ALTER TABLE `student_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `student_sections`
--
ALTER TABLE `student_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `unregistered_students`
--
ALTER TABLE `unregistered_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
