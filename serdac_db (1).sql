-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2024 at 04:43 PM
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
(4, 'THIS IS A INITIAL POST', 'asdasdas', 'analysis.jpg', 'test', '2024-03-13 11:07:42', 'username', 0, 0, 'Article'),
(5, 'TEST ANN A', 'This is test subtitle ', '430848181_1392097421444655_6267022158475031586_n.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2024-03-14 22:14:27', 'username', 0, 0, 'Announcement');

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
  `purpose` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_request`
--

INSERT INTO `service_request` (`request_id`, `user_id`, `service_type`, `office_agency`, `agency_classification`, `client_type`, `purpose`) VALUES
(4, 8, 'capability-training', 'TEST', 'Goverment Organization', 'Faculty', 'test');

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
  `zipcode` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(55) DEFAULT NULL,
  `barangay` varchar(55) DEFAULT NULL,
  `userType` varchar(55) DEFAULT NULL,
  `isActive` int(11) NOT NULL,
  `activationCode` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fname`, `midname`, `lname`, `contact_no`, `email`, `password`, `occupation`, `education_level`, `accessType`, `gender`, `zipcode`, `region`, `city`, `province`, `barangay`, `userType`, `isActive`, `activationCode`) VALUES
(1, 'Ron', NULL, 'Dale', NULL, 'admin@admin.com', '$2y$10$wWsVJA0Cfjr/FUxCDPUubeJGiVrqryvazLkFLYNvjn2qyq6qNGfLC', NULL, NULL, 'Administrator', NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, ''),
(2, 'lyka', 'test', 'xandra', 123456789, 'user@user.com', 'user', NULL, NULL, 'Client', NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, ''),
(8, 'RONALD DALE', 'Lyka', 'FUENTEBELLA', 2147483647, 'ronaldxdale@gmail.com', '$2y$10$m5b2xNSUu4H840HRgJMUoeRL/4ZmqOe9RNZYoSlQRuxuQogWXdEPa', 'student', 'no_schooling', 'Client', 0, '', 'Region IX (Zamboanga Peninzula)', 'Zamboanga City', 'Zamboanga Del Sur', 'Cawit', 'Client', 1, 'c8cfb88f4c');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`article_id`);

--
-- Indexes for table `service_request`
--
ALTER TABLE `service_request`
  ADD PRIMARY KEY (`request_id`);

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
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `service_request`
--
ALTER TABLE `service_request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
