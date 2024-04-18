-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2024 at 12:06 AM
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
-- Database: `serdac_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `article_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `published_at` datetime DEFAULT NULL,
  `published_by` varchar(255) NOT NULL,
  `views` int(11) DEFAULT 0,
  `is_draft` tinyint(1) DEFAULT 1,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`article_id`, `title`, `subtitle`, `image_path`, `content`, `published_at`, `published_by`, `views`, `is_draft`, `type`) VALUES
(13, 'Lorem Ipsum', '\"There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is pain...\"', '430848181_1392097421444655_6267022158475031586_n.png', '<h2>What is Lorem Ipsum?</h2>\n\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus <strong>PageMaker including versions of Lorem Ipsum.</strong></p>\n', '2024-04-04 20:46:07', 'username', 0, 0, 'Announcement');

-- --------------------------------------------------------

--
-- Table structure for table `asmt_forms`
--

CREATE TABLE `asmt_forms` (
  `form_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `asmt_forms`
--

INSERT INTO `asmt_forms` (`form_id`, `title`, `description`) VALUES
(8, 'test', 'test 2'),
(9, 'TEST', 'TEST 3'),
(10, 'TEST 5', 'TEST DESC'),
(11, 'TEST 5', 'TEST DESC'),
(12, 'TEST', 'ASD'),
(13, '', ''),
(14, 'TEST', 'TESTT 3'),
(15, 'TEST', 'TESTT 3'),
(16, 'TEST', 'T'),
(17, 'TEST', 'T'),
(18, 'TEST', 'T'),
(19, 'TEST', 'T'),
(20, 'TEST', 'TEST'),
(21, 'TEST', 'test'),
(22, 'TEST', 'test'),
(23, 'TEST', 'TEST'),
(24, 'TEST', 'TEST'),
(25, 'TEST', 'TEST'),
(26, 'TEST', 'TEST'),
(27, 'TEST', 'TEST'),
(28, 'TEST', 'TEST'),
(29, 'TEST', 'TWST'),
(30, 'TEST', 'TWST'),
(31, 'TEST', 'TEST'),
(32, 'TEST', 'TEST'),
(33, 'TEST 3', 'TEST'),
(34, 'TEST 3', 'TEST'),
(35, 'TEST 3', 'TEST'),
(36, 'Q2', 'TEST'),
(37, 'TEST', 'TEST'),
(38, 'TEST', 'TEST'),
(39, 'TEST', 'TEST');

-- --------------------------------------------------------

--
-- Table structure for table `asmt_questions`
--

CREATE TABLE `asmt_questions` (
  `question_id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `question_type` enum('paragraph','multiple_choice_single','multiple_choice_multiple') NOT NULL,
  `options` varchar(255) DEFAULT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `asmt_questions`
--

INSERT INTO `asmt_questions` (`question_id`, `form_id`, `question_text`, `question_type`, `options`, `is_required`) VALUES
(44, 38, 'TEST 1', 'multiple_choice_single', 'W1', 0),
(45, 39, 'TEST', 'paragraph', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `service_participant`
--

CREATE TABLE `service_participant` (
  `sp_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `registration_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_participant`
--

INSERT INTO `service_participant` (`sp_id`, `user_id`, `request_id`, `registration_date`) VALUES
(5, 1, 5, '2024-03-31'),
(6, 1, 5, '2024-03-31');

-- --------------------------------------------------------

--
-- Table structure for table `service_request`
--

CREATE TABLE `service_request` (
  `request_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `service_type` varchar(255) NOT NULL,
  `office_agency` varchar(255) NOT NULL,
  `agency_classification` varchar(255) NOT NULL,
  `client_type` varchar(255) NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `selected_purposes` varchar(255) DEFAULT NULL,
  `additional_purpose_details` varchar(255) DEFAULT NULL,
  `request_date` date DEFAULT NULL,
  `scheduled_date` datetime DEFAULT NULL,
  `ongoing_date` date DEFAULT NULL,
  `cancelled_date` date DEFAULT NULL,
  `completed_date` date DEFAULT NULL,
  `inviteCode` varchar(55) DEFAULT NULL,
  `admin_remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_request`
--

INSERT INTO `service_request` (`request_id`, `user_id`, `service_type`, `office_agency`, `agency_classification`, `client_type`, `status`, `selected_purposes`, `additional_purpose_details`, `request_date`, `scheduled_date`, `ongoing_date`, `cancelled_date`, `completed_date`, `inviteCode`, `admin_remarks`) VALUES
(20, 1, 'data-analysis', 'TEST', 'Private Agency', 'Student', 'Pending', 'Data Analysis', 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sr_dataanalysis`
--

CREATE TABLE `sr_dataanalysis` (
  `da_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `analysis_type` varchar(50) NOT NULL,
  `overview` text NOT NULL,
  `g_objective` text NOT NULL,
  `s_objective` text NOT NULL,
  `manuscript` text DEFAULT NULL,
  `dataset` text DEFAULT NULL,
  `payment_status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sr_dataanalysis`
--

INSERT INTO `sr_dataanalysis` (`da_id`, `request_id`, `analysis_type`, `overview`, `g_objective`, `s_objective`, `manuscript`, `dataset`, `payment_status`) VALUES
(4, 20, 'Run Analysis', 'test Overview', 'test Objective', 'test Specific Objectives:\r\n', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sr_meeting`
--

CREATE TABLE `sr_meeting` (
  `meet_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `service_type` varchar(50) NOT NULL,
  `meeting_type` int(11) NOT NULL,
  `date_time` datetime DEFAULT NULL,
  `mode` varchar(55) DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sr_speaker`
--

CREATE TABLE `sr_speaker` (
  `speaker_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_no` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `agency` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sr_tech_assistance`
--

CREATE TABLE `sr_tech_assistance` (
  `ta_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `consultation_type` varchar(50) DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sr_training`
--

CREATE TABLE `sr_training` (
  `ct_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `s_from` date DEFAULT NULL,
  `s_to` date DEFAULT NULL,
  `title` text DEFAULT NULL,
  `venue` text DEFAULT NULL,
  `no_participants` int(11) DEFAULT NULL,
  `speaker_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `midname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) NOT NULL,
  `contact_no` int(12) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `education_level` varchar(255) DEFAULT NULL,
  `accessType` varchar(255) NOT NULL,
  `gender` int(10) DEFAULT NULL,
  `sex` varchar(10) NOT NULL,
  `zipcode` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(55) DEFAULT NULL,
  `barangay` varchar(55) DEFAULT NULL,
  `userType` varchar(55) DEFAULT NULL,
  `isActive` int(11) NOT NULL,
  `activationCode` varchar(100) NOT NULL,
  `adminAccess` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fname`, `midname`, `lname`, `contact_no`, `email`, `password`, `occupation`, `education_level`, `accessType`, `gender`, `sex`, `zipcode`, `region`, `city`, `province`, `barangay`, `userType`, `isActive`, `activationCode`, `adminAccess`) VALUES
(1, 'Ron', NULL, 'Dale', NULL, 'admin@admin.com', '$2y$10$wWsVJA0Cfjr/FUxCDPUubeJGiVrqryvazLkFLYNvjn2qyq6qNGfLC', NULL, NULL, 'Administrator', NULL, '', NULL, NULL, NULL, NULL, NULL, '0', 1, '', NULL),
(2, 'lyka', 'test', 'xandra', 123456789, 'user@user.com', '$2y$10$6VlT6GkjrF3VY7CaK5FGd.e/xUHSTLz1Yb0NR4raF2Cx2jl.uafD6', NULL, NULL, 'Client', NULL, '', NULL, 'Region IX (Zamboanga Peninzula)', 'Zamboanga City', 'Zamboanga Del Sur', 'Cawit', '0', 1, '', NULL),
(8, 'RONALD DALE', 'Lyka', 'FUENTEBELLA', 2147483647, 'ronaldxdale@gmail.com', '$2y$10$m5b2xNSUu4H840HRgJMUoeRL/4ZmqOe9RNZYoSlQRuxuQogWXdEPa', 'student', 'no_schooling', 'Client', 0, '', '', 'Region IX (Zamboanga Peninzula)', 'Zamboanga City', 'Zamboanga Del Sur', 'Cawit', 'Client', 1, 'c8cfb88f4c', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`article_id`);

--
-- Indexes for table `asmt_forms`
--
ALTER TABLE `asmt_forms`
  ADD PRIMARY KEY (`form_id`);

--
-- Indexes for table `asmt_questions`
--
ALTER TABLE `asmt_questions`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `service_participant`
--
ALTER TABLE `service_participant`
  ADD PRIMARY KEY (`sp_id`);

--
-- Indexes for table `service_request`
--
ALTER TABLE `service_request`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `sr_dataanalysis`
--
ALTER TABLE `sr_dataanalysis`
  ADD PRIMARY KEY (`da_id`);

--
-- Indexes for table `sr_meeting`
--
ALTER TABLE `sr_meeting`
  ADD PRIMARY KEY (`meet_id`);

--
-- Indexes for table `sr_speaker`
--
ALTER TABLE `sr_speaker`
  ADD PRIMARY KEY (`speaker_id`);

--
-- Indexes for table `sr_tech_assistance`
--
ALTER TABLE `sr_tech_assistance`
  ADD PRIMARY KEY (`ta_id`);

--
-- Indexes for table `sr_training`
--
ALTER TABLE `sr_training`
  ADD PRIMARY KEY (`ct_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `asmt_forms`
--
ALTER TABLE `asmt_forms`
  MODIFY `form_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `asmt_questions`
--
ALTER TABLE `asmt_questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `service_participant`
--
ALTER TABLE `service_participant`
  MODIFY `sp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `service_request`
--
ALTER TABLE `service_request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `sr_dataanalysis`
--
ALTER TABLE `sr_dataanalysis`
  MODIFY `da_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sr_meeting`
--
ALTER TABLE `sr_meeting`
  MODIFY `meet_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sr_speaker`
--
ALTER TABLE `sr_speaker`
  MODIFY `speaker_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sr_tech_assistance`
--
ALTER TABLE `sr_tech_assistance`
  MODIFY `ta_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sr_training`
--
ALTER TABLE `sr_training`
  MODIFY `ct_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
