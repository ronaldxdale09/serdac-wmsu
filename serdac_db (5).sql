-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2024 at 11:29 PM
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
  `author` varchar(255) NOT NULL,
  `views` int(11) DEFAULT 0,
  `is_draft` tinyint(1) DEFAULT 1,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`article_id`, `title`, `subtitle`, `image_path`, `content`, `published_at`, `author`, `views`, `is_draft`, `type`) VALUES
(13, 'Lorem Ipsum2', '\"There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is pain...\"', 'wallpaperflare.com_wallpaper (1).jpg', '<h2>What is Lorem Ipsum?</h2>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus <strong>PageMaker including versions of Lorem Ipsum.</strong></p>\r\n', '2024-04-04 20:46:07', 'test2', 0, 0, 'News'),
(14, 'RONALD NEW SURVEY', 'asdasdas', 'ntcx.png', '<p>test</p>\r\n', '2024-06-05 09:42:39', 'username', 0, 0, 'Event');

-- --------------------------------------------------------

--
-- Table structure for table `asmt_forms`
--

CREATE TABLE `asmt_forms` (
  `form_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `form_type` varchar(50) NOT NULL,
  `request_id` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `quota` int(11) NOT NULL,
  `response_limit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `asmt_forms`
--

INSERT INTO `asmt_forms` (`form_id`, `title`, `description`, `form_type`, `request_id`, `start_date`, `end_date`, `quota`, `response_limit`) VALUES
(99, 'RONALD NEW SURVEY', 'TEST 4', 'post_assessment', 25, '2024-05-26', '2024-05-25', 2, 2),
(102, 'RONALD NEW SURVEY', 'TEST 4', 'post_assessment', 27, '2024-05-24', '2024-05-27', 0, 0),
(103, 'RONALD NEW SURVEY', 'test', 'survey', 37, '2024-06-03', '2024-06-06', 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `asmt_invitations`
--

CREATE TABLE `asmt_invitations` (
  `invitation_id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `form_title` varchar(255) NOT NULL,
  `form_description` text NOT NULL,
  `invite_link` varchar(255) NOT NULL,
  `email_list` text NOT NULL,
  `email_subject` varchar(255) NOT NULL,
  `email_body` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asmt_questions`
--

CREATE TABLE `asmt_questions` (
  `question_id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `question_type` enum('paragraph','multiple_choice_single','multiple_choice_multiple') NOT NULL,
  `options` text DEFAULT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `asmt_questions`
--

INSERT INTO `asmt_questions` (`question_id`, `form_id`, `question_text`, `question_type`, `options`, `is_required`) VALUES
(211, 102, 'TEST E', 'multiple_choice_multiple', 'test 3', 0),
(212, 102, 'test', 'multiple_choice_multiple', '', 0),
(217, 99, 'TEST Q', 'multiple_choice_single', '', 1),
(218, 99, 'test', 'multiple_choice_single', '', 0),
(219, 103, 'TEST Q', 'multiple_choice_single', 'TEST,TEST 2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `asmt_responses`
--

CREATE TABLE `asmt_responses` (
  `response_id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `response_text` text NOT NULL,
  `response_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `asmt_responses`
--

INSERT INTO `asmt_responses` (`response_id`, `form_id`, `question_id`, `user_id`, `response_text`, `response_date`) VALUES
(6, 99, 217, 1, '', '2024-05-16 07:19:48'),
(7, 99, 218, 1, '4', '2024-05-16 07:19:48'),
(8, 99, 217, 1, '', '2024-05-16 07:22:10'),
(9, 99, 218, 1, '3', '2024-05-16 07:22:10'),
(11, 103, 219, 1, 'TEST 2', '2024-06-03 14:38:31');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `mobile`, `subject`, `message`, `submitted_at`) VALUES
(1, 'ronaldxdale@gmail.com', 'ronaldxdale@gmail.com', '09352232051', 'asdasd', 'test asdasd asdas dasd', '2024-05-15 06:34:01'),
(2, 'bg201802148@wmsu.edu.ph', 'bg201802148@wmsu.edu.ph', '09352232051', 'asdasd', 'test', '2024-05-15 14:47:42');

-- --------------------------------------------------------

--
-- Table structure for table `d_meeting_type`
--

CREATE TABLE `d_meeting_type` (
  `mtype_id` int(11) NOT NULL,
  `meeting_type` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `d_meeting_type`
--

INSERT INTO `d_meeting_type` (`mtype_id`, `meeting_type`) VALUES
(1, 'Initial Meeting'),
(2, 'Project Meeting'),
(3, 'Consultative Meeting'),
(4, 'Inception Meeting'),
(5, 'Team Meeting'),
(6, 'Client Meeting');

-- --------------------------------------------------------

--
-- Table structure for table `repo_ebooks`
--

CREATE TABLE `repo_ebooks` (
  `book_id` int(11) NOT NULL,
  `book_title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `year_published` year(4) NOT NULL,
  `cover_page` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `repo_ebooks`
--

INSERT INTO `repo_ebooks` (`book_id`, `book_title`, `author`, `year_published`, `cover_page`) VALUES
(1, 'TEST BOOK', 'Ronald Dale', '2024', 'Screenshot 2023-10-25 162450.png');

-- --------------------------------------------------------

--
-- Table structure for table `repo_projects`
--

CREATE TABLE `repo_projects` (
  `ProjectID` int(11) NOT NULL,
  `ProgramTitle` varchar(255) NOT NULL,
  `ProjectTitle` varchar(255) NOT NULL,
  `ProjectLeader` varchar(255) NOT NULL,
  `ProjectLeaderSex` varchar(50) NOT NULL,
  `ProjectLeaderAgency` varchar(255) NOT NULL,
  `ProjectLeaderContact` varchar(1024) DEFAULT NULL,
  `ImplementingAgency` varchar(255) NOT NULL,
  `ImplementingAgencyAddress` varchar(255) NOT NULL,
  `BaseStation` varchar(255) NOT NULL,
  `ProjectDurationStart` date NOT NULL,
  `ProjectDurationEnd` date NOT NULL,
  `ExtensionDate` date DEFAULT NULL,
  `ProjectCost` decimal(15,2) NOT NULL,
  `SDGAddressed` varchar(255) DEFAULT NULL,
  `ProjectAbstract` text DEFAULT NULL,
  `FundedBy` varchar(255) NOT NULL,
  `FacilitatedBy` varchar(255) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `CooperatingAgencies` varchar(55) DEFAULT NULL,
  `OtherImplementationSites` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `repo_projects`
--

INSERT INTO `repo_projects` (`ProjectID`, `ProgramTitle`, `ProjectTitle`, `ProjectLeader`, `ProjectLeaderSex`, `ProjectLeaderAgency`, `ProjectLeaderContact`, `ImplementingAgency`, `ImplementingAgencyAddress`, `BaseStation`, `ProjectDurationStart`, `ProjectDurationEnd`, `ExtensionDate`, `ProjectCost`, `SDGAddressed`, `ProjectAbstract`, `FundedBy`, `FacilitatedBy`, `Status`, `CooperatingAgencies`, `OtherImplementationSites`) VALUES
(1, 'testr', 'test2', 'test3', 'Male', 'test 5', 'asd', 'das', 'asd', '123', '2024-05-24', '2024-05-26', '2024-05-29', 23232.00, '123', '321', 'DOST-PCAARRD', 'WESMAARRDEC', 'Completed', 'asd', '321');

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
(1, 11, 1, '2024-06-05'),
(2, 11, 2, '2024-06-06'),
(3, 11, 1, '2024-06-06');

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
  `request_date` date NOT NULL,
  `scheduled_date` datetime DEFAULT NULL,
  `ongoing_date` date DEFAULT NULL,
  `cancelled_date` date DEFAULT NULL,
  `completed_date` date DEFAULT NULL,
  `inviteCode` varchar(55) DEFAULT NULL,
  `scheduled_remarks` text DEFAULT NULL,
  `inprogress_remarks` text DEFAULT NULL,
  `completed_remarks` text DEFAULT NULL,
  `cancelled_remarks` text DEFAULT NULL,
  `participants` int(11) DEFAULT 0,
  `participants_quota` int(11) DEFAULT NULL,
  `allowParticipants` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_request`
--

INSERT INTO `service_request` (`request_id`, `user_id`, `service_type`, `office_agency`, `agency_classification`, `client_type`, `status`, `selected_purposes`, `additional_purpose_details`, `request_date`, `scheduled_date`, `ongoing_date`, `cancelled_date`, `completed_date`, `inviteCode`, `scheduled_remarks`, `inprogress_remarks`, `completed_remarks`, `cancelled_remarks`, `participants`, `participants_quota`, `allowParticipants`) VALUES
(1, 11, 'capability-training', 'TEST', 'Private Agency', 'Researcher', 'In Progress', 'Data Analysis', 'test', '2024-06-05', '2024-06-06 09:51:00', '2024-06-06', NULL, NULL, '751c08', '', '', '', NULL, 1, 20, 1),
(2, 11, 'data-analysis', 'WESMARDEC', 'Goverment Organization', 'Goverment Employee', 'Completed', 'Research', 'test', '2024-06-06', '2024-06-06 10:21:00', '2024-06-06', NULL, NULL, '552fc2', 'initial meeting', '', '', NULL, 0, 20, 1);

-- --------------------------------------------------------

--
-- Table structure for table `speaker_profile`
--

CREATE TABLE `speaker_profile` (
  `speaker_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `address` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `speaker_profile`
--

INSERT INTO `speaker_profile` (`speaker_id`, `name`, `address`, `email`, `contact`) VALUES
(1, 'Mark A Tubat', 'Ipil Titay', 'mark@tubat.com', 93523232),
(2, 'Kaxandra Lyka Caimoy', 'San Jose Cawa Cawa', 'lykaxandra09@gmail.com', 2147483647);

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
  `payment_status` varchar(10) DEFAULT NULL,
  `notificationStatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sr_dataanalysis`
--

INSERT INTO `sr_dataanalysis` (`da_id`, `request_id`, `analysis_type`, `overview`, `g_objective`, `s_objective`, `manuscript`, `dataset`, `payment_status`, `notificationStatus`) VALUES
(1, 2, 'Statistical Tool', 'What is Lorem Ipsum?\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,', 'Why do we use it?\r\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\r\n\r\n', 'Where can I get some?\r\nThere are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sr_dataanalysis_files`
--

CREATE TABLE `sr_dataanalysis_files` (
  `da_file_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `size` varchar(50) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `date_uploaded` date DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sr_dataanalysis_files`
--

INSERT INTO `sr_dataanalysis_files` (`da_file_id`, `request_id`, `filename`, `size`, `remarks`, `date_uploaded`, `type`) VALUES
(3, 2, 'REPOSITORY - DB Structure.docx', '15595', 'test remarks', '2024-06-06', 'client'),
(4, 2, 'REPOSITORY - DB Structure (1).docx', '15595', 'test remarks', '2024-06-06', 'Result'),
(6, 2, '20240425T170341651.att.911731590638683.docx', '16939', 'test remarks', '2024-06-06', 'Result'),
(10, 2, 'Doc2.docx', '45608', 'sample file', '2024-06-06', 'Result');

-- --------------------------------------------------------

--
-- Table structure for table `sr_meeting`
--

CREATE TABLE `sr_meeting` (
  `meet_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `meeting_type` varchar(255) NOT NULL,
  `date_time` datetime DEFAULT NULL,
  `mode` varchar(55) DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sr_meeting`
--

INSERT INTO `sr_meeting` (`meet_id`, `request_id`, `meeting_type`, `date_time`, `mode`, `remarks`) VALUES
(11, 1, '5', '2024-06-06 09:51:00', 'face2face', ''),
(12, 1, '1', '2024-06-14 10:02:00', 'face2face', 'test'),
(16, 2, '1', '2024-06-06 10:23:00', 'face2face', ''),
(17, 2, '3', '2024-06-06 10:29:00', 'face2face', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `sr_speaker`
--

CREATE TABLE `sr_speaker` (
  `sr_spk_id` int(11) NOT NULL,
  `speaker_id` varchar(255) NOT NULL,
  `request_id` int(11) NOT NULL,
  `topic` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sr_speaker`
--

INSERT INTO `sr_speaker` (`sr_spk_id`, `speaker_id`, `request_id`, `topic`) VALUES
(1, '1', 1, 'TEST 3');

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
  `s_from` datetime DEFAULT NULL,
  `s_to` datetime DEFAULT NULL,
  `title` text DEFAULT NULL,
  `venue` text DEFAULT NULL,
  `no_participants` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sr_training`
--

INSERT INTO `sr_training` (`ct_id`, `request_id`, `s_from`, `s_to`, `title`, `venue`, `no_participants`) VALUES
(1, 1, '2024-06-14 10:03:00', '2024-06-14 10:03:00', 'SIXTH THREAT vs K-RAM / Reaction Video ', '@ASTORIAL', 0);

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
  `adminAccess` varchar(255) DEFAULT NULL,
  `registration_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fname`, `midname`, `lname`, `contact_no`, `email`, `password`, `occupation`, `education_level`, `accessType`, `gender`, `sex`, `zipcode`, `region`, `city`, `province`, `barangay`, `userType`, `isActive`, `activationCode`, `adminAccess`, `registration_date`) VALUES
(1, 'Ron', 'test', 'Dale', 9268332, 'admin@admin.com', '$2y$10$wWsVJA0Cfjr/FUxCDPUubeJGiVrqryvazLkFLYNvjn2qyq6qNGfLC', NULL, NULL, 'Administrator', NULL, '', NULL, NULL, NULL, NULL, NULL, 'Administrator', 1, '', '[\"superadmin\"]', NULL),
(2, 'lyka', 'test', 'xandra', 123456789, 'devweb09@gmail.com', '$2y$10$6VlT6GkjrF3VY7CaK5FGd.e/xUHSTLz1Yb0NR4raF2Cx2jl.uafD6', NULL, NULL, 'Client', NULL, '', NULL, 'Region IX (Zamboanga Peninzula)', 'Zamboanga City', 'Zamboanga Del Sur', 'Cawit', '0', 1, '', NULL, NULL),
(10, 'RONALD DALE', 'A', 'Fuentebella, Ronald Dale', 0, 'abby@gmail.com', '$2y$10$5E9RK/CauDe8ALDcez.VGuQIaLCFRvjblohLfpJtbZCBW/S.Vm8E2', 'employed_pt', 'elementary', 'Client', 0, 'Female', '', 'Region IX (Zamboanga Peninzula)', 'Zamboanga City', 'Zamboanga Del Sur', 'Baliwasan', 'Client', 0, '2777d17d62', NULL, NULL),
(11, 'RONALD DALE', 'test', 'Fuentebella', 0, 'ronaldxdale@gmail.com', '$2y$10$efW1JAuMCuccoLYNL.maZu1CQC/xcxYT6HK6WyLrN9H3YtuMlcLzO', 'employed_pt', 'elementary', 'Client', 0, 'Male', '', 'Region IX (Zamboanga Peninzula)', 'Dimataling', 'Zamboanga Del Sur', 'Baha', 'Client', 1, 'b40905de43', NULL, '0000-00-00'),
(12, 'Mark', 'A', 'Mark A Tubat', 0, 'ronzero0926@gmail.com', '$2y$10$j882pD38RNk9eLHDgKgr1ukDkESI8iSAoP/7lgank8R2SJdsuJ3Oq', 'employed_ft', 'elementary', 'Client', 0, 'Female', '', 'Region IV-A (CALABARZON)', 'Cabuyao City', 'Laguna', 'Butong', 'Client', 0, 'e1332f6a09', NULL, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `user_activity_log`
--

CREATE TABLE `user_activity_log` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `activity_type` varchar(100) NOT NULL,
  `activity_description` text NOT NULL,
  `activity_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `isView` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_activity_log`
--

INSERT INTO `user_activity_log` (`log_id`, `user_id`, `activity_type`, `activity_description`, `activity_timestamp`, `isView`) VALUES
(1, 2, 'reject_request', 'User rejected request with ID 33', '2024-05-15 05:03:25', 1),
(2, 0, 'contact_form_submission', 'Contact form submitted by ronaldxdale@gmail.com', '2024-05-15 06:34:01', 1),
(3, 0, 'contact_form_submission', 'Contact form submitted by bg201802148@wmsu.edu.ph', '2024-05-15 14:47:42', 1),
(4, 1, 'service_request', 'User submitted a new service request with ID 37 and service type data-analysis', '2024-05-23 17:17:04', 1),
(5, 11, 'service_request', 'User submitted a new service request with ID 1 and service type capability-training', '2024-06-05 16:18:25', 1),
(6, 11, 'service_request', 'User submitted a new service request with ID 2 and service type data-analysis', '2024-06-06 02:20:33', 0),
(7, 11, 'file_upload', 'User uploaded file: REPOSITORY - DB Structure.docx for request ID 2', '2024-06-06 13:16:56', 0),
(8, 11, 'file_upload', 'User uploaded file: REPOSITORY - DB Structure.docx for request ID 2', '2024-06-06 13:34:34', 0),
(9, 11, 'file_upload', 'User uploaded file: REPOSITORY - DB Structure.docx for request ID 2', '2024-06-06 13:35:44', 0);

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
-- Indexes for table `asmt_invitations`
--
ALTER TABLE `asmt_invitations`
  ADD PRIMARY KEY (`invitation_id`);

--
-- Indexes for table `asmt_questions`
--
ALTER TABLE `asmt_questions`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `asmt_responses`
--
ALTER TABLE `asmt_responses`
  ADD PRIMARY KEY (`response_id`),
  ADD KEY `form_id` (`form_id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `d_meeting_type`
--
ALTER TABLE `d_meeting_type`
  ADD PRIMARY KEY (`mtype_id`);

--
-- Indexes for table `repo_ebooks`
--
ALTER TABLE `repo_ebooks`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `repo_projects`
--
ALTER TABLE `repo_projects`
  ADD PRIMARY KEY (`ProjectID`);

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
-- Indexes for table `speaker_profile`
--
ALTER TABLE `speaker_profile`
  ADD PRIMARY KEY (`speaker_id`);

--
-- Indexes for table `sr_dataanalysis`
--
ALTER TABLE `sr_dataanalysis`
  ADD PRIMARY KEY (`da_id`);

--
-- Indexes for table `sr_dataanalysis_files`
--
ALTER TABLE `sr_dataanalysis_files`
  ADD PRIMARY KEY (`da_file_id`);

--
-- Indexes for table `sr_meeting`
--
ALTER TABLE `sr_meeting`
  ADD PRIMARY KEY (`meet_id`);

--
-- Indexes for table `sr_speaker`
--
ALTER TABLE `sr_speaker`
  ADD PRIMARY KEY (`sr_spk_id`);

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
-- Indexes for table `user_activity_log`
--
ALTER TABLE `user_activity_log`
  ADD PRIMARY KEY (`log_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `asmt_forms`
--
ALTER TABLE `asmt_forms`
  MODIFY `form_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `asmt_invitations`
--
ALTER TABLE `asmt_invitations`
  MODIFY `invitation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asmt_questions`
--
ALTER TABLE `asmt_questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=220;

--
-- AUTO_INCREMENT for table `asmt_responses`
--
ALTER TABLE `asmt_responses`
  MODIFY `response_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `d_meeting_type`
--
ALTER TABLE `d_meeting_type`
  MODIFY `mtype_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `repo_ebooks`
--
ALTER TABLE `repo_ebooks`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `repo_projects`
--
ALTER TABLE `repo_projects`
  MODIFY `ProjectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `service_participant`
--
ALTER TABLE `service_participant`
  MODIFY `sp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `service_request`
--
ALTER TABLE `service_request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `speaker_profile`
--
ALTER TABLE `speaker_profile`
  MODIFY `speaker_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sr_dataanalysis`
--
ALTER TABLE `sr_dataanalysis`
  MODIFY `da_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sr_dataanalysis_files`
--
ALTER TABLE `sr_dataanalysis_files`
  MODIFY `da_file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sr_meeting`
--
ALTER TABLE `sr_meeting`
  MODIFY `meet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `sr_speaker`
--
ALTER TABLE `sr_speaker`
  MODIFY `sr_spk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sr_tech_assistance`
--
ALTER TABLE `sr_tech_assistance`
  MODIFY `ta_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sr_training`
--
ALTER TABLE `sr_training`
  MODIFY `ct_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_activity_log`
--
ALTER TABLE `user_activity_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `asmt_responses`
--
ALTER TABLE `asmt_responses`
  ADD CONSTRAINT `asmt_responses_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `asmt_forms` (`form_id`),
  ADD CONSTRAINT `asmt_responses_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `asmt_questions` (`question_id`),
  ADD CONSTRAINT `asmt_responses_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
