-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2025 at 08:56 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pesoo`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_profile`
--

CREATE TABLE `admin_profile` (
  `ID` int(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `passwords` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Fname` varchar(255) NOT NULL,
  `Lname` varchar(255) NOT NULL,
  `Mname` varchar(255) NOT NULL,
  `Age` int(10) NOT NULL,
  `Cnumber` int(255) NOT NULL,
  `Haddress` varchar(255) DEFAULT NULL,
  `otp` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) NOT NULL,
  `reset_token_expiry` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `is_verified` int(5) DEFAULT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_profile`
--

INSERT INTO `admin_profile` (`ID`, `Username`, `passwords`, `Email`, `Fname`, `Lname`, `Mname`, `Age`, `Cnumber`, `Haddress`, `otp`, `reset_token`, `reset_token_expiry`, `is_verified`, `photo`) VALUES
(15, 'Jac', '$2y$10$/ADkdewqh9hir7FmtYgeyu42q4N5CqkMFHFEtx68bWL4Mdce7VFZu', 'bzmqwgsuix@ibolinva.com', 'Olympia', 'Christian', 'Kylie Vasquez', 0, 581, 'Voluptatem dolore i', '704011', '5d2a7e3029bac67046fb726fe0e3cc2ad99011ceba00aa61da11e18f9a1694742931575076942b6bed2bd34b1f406c0e9b2a', '2025-05-26 07:01:03.000000', 1, '../uploads/Jac/0266554465.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `applicant_profile`
--

CREATE TABLE `applicant_profile` (
  `id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_verified` varchar(255) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `otp_expiry` datetime(6) NOT NULL,
  `reset_token` varchar(255) NOT NULL,
  `reset_token_expiry` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `mname` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `pob` varchar(255) NOT NULL,
  `age` int(255) NOT NULL,
  `height` int(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `civil_status` varchar(255) NOT NULL,
  `contact_no` int(255) NOT NULL,
  `landline` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `present_address` varchar(255) NOT NULL,
  `tin` int(255) NOT NULL,
  `sss_no` int(255) NOT NULL,
  `pagibig_no` int(255) NOT NULL,
  `philhealth_no` int(255) NOT NULL,
  `passport_no` int(255) NOT NULL,
  `passport_expiry` datetime(6) DEFAULT NULL,
  `tertiary_school` varchar(255) NOT NULL,
  `tertiary_graduated` date NOT NULL,
  `tertiary_award` varchar(255) NOT NULL,
  `college_school` varchar(255) NOT NULL,
  `college_graduated` date NOT NULL,
  `college_award` varchar(255) NOT NULL,
  `tertiary_course` varchar(255) NOT NULL,
  `preferred_work_location` varchar(255) NOT NULL,
  `work_location` varchar(255) NOT NULL,
  `preferred_occupation` varchar(255) NOT NULL,
  `disability` varchar(255) NOT NULL,
  `selected_option` varchar(255) NOT NULL,
  `four_ps` varchar(255) NOT NULL,
  `prefix` varchar(255) NOT NULL,
  `religion` varchar(255) NOT NULL,
  `employment_status` varchar(255) NOT NULL,
  `resume` varchar(255) NOT NULL,
  `applicant_type` enum('Training','Employment') NOT NULL,
  `expected_salary` int(255) NOT NULL,
  `grad_course` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicant_profile`
--

INSERT INTO `applicant_profile` (`id`, `username`, `password`, `is_verified`, `otp`, `otp_expiry`, `reset_token`, `reset_token_expiry`, `email`, `fname`, `lname`, `mname`, `dob`, `pob`, `age`, `height`, `sex`, `civil_status`, `contact_no`, `landline`, `photo`, `present_address`, `tin`, `sss_no`, `pagibig_no`, `philhealth_no`, `passport_no`, `passport_expiry`, `tertiary_school`, `tertiary_graduated`, `tertiary_award`, `college_school`, `college_graduated`, `college_award`, `tertiary_course`, `preferred_work_location`, `work_location`, `preferred_occupation`, `disability`, `selected_option`, `four_ps`, `prefix`, `religion`, `employment_status`, `resume`, `applicant_type`, `expected_salary`, `grad_course`) VALUES
(2, 'Mark', '$2y$10$cIcE2Z62HDpszBc4szxu1.RPGeLkZ8YYik94p6ny5V0QiUrot.RRq', '1', '475046', '2025-02-18 13:36:56.000000', '', '', 'pesolosbanos4@gmail.com', 'Sedrick', 'Hyatt-Mosciski', 'Ottis Mitchell', '2025-10-10', '', 0, 0, 'male', '', 2147483647, '', '../uploads/Mark/11.jpg', '138 Audra Trafficway', 0, 0, 0, 0, 0, NULL, 'Noemi Streich', '2024-03-07', 'Sed eius suscipit sequi dolores sint accusamus occaecati quae nulla.', 'Nasir Wilderman', '2025-12-16', 'Deleniti sapiente similique ipsum dolor ratione.', '', '', '', '', '', '', '', '', '', '', '', 'Training', 0, ''),
(3, 'Mark', '$2y$10$7HG46MrrdnkCrzoPZkYlT.aqSFBGBaBeSXOphDjmY2b0uO0ebPN82', '1', '972741', '2025-02-20 13:06:58.000000', '', '', 'marklawrencemercado8@gmail.com', 'Vilma', 'Gleichner', 'Libby Yost-Reinger', '2024-10-13', '', 0, 0, 'male', '', 2147483647, '', '../uploads/Mark/11.jpg', '29509 Unique Ville', 0, 0, 0, 0, 0, NULL, 'Scottie Leannon', '2024-05-22', 'Praesentium quam occaecati ratione qui dignissimos corporis deleniti corrupti cumque.', 'Rhett Cole', '2024-10-07', 'Fugiat assumenda earum nemo fuga iusto.', '', '', '', '', '', '', '', '', '', '', '', 'Employment', 0, ''),
(4, 'Developer123', '$2y$10$6TrIZbWtGlnwaj/qB3DyveKX9dlMkMX3nIPnZ1OUhdnQ4AOxsmSly', '1', '424477', '2025-03-17 10:24:49.000000', '', '', 'jervinguevarra123@gmail.com', 'Colorado', 'Hoover', 'Ryan Campos', '2000-02-10', '', 0, 0, 'male', '', 2147483647, '', 'uploads/Developer123/rizal.PNG', 'campvicente lim ', 0, 0, 0, 0, 0, NULL, 'qweqwe', '2000-02-22', 'qweqeq', 'qweqeq', '2000-02-22', 'asd', '', '', '', '', '', '', '', '', '', '', '', 'Employment', 0, ''),
(5, 'Lawrence123', '$2y$10$wmG6vvUGbNzVs93xEUVo6.8gp.H3gQ0ckYeQSdCgcl44fJJ4FFwlC', '1', '791946', '2025-03-17 14:44:36.000000', '', '', 'jervin1231@gmail.com', 'Mark Lawrence ', 'qwee', 'Ryan Campos', '2000-02-22', 'ccsDcS', 0, 0, 'male', 'single', 2147483647, '131243', 'uploads/Lawrence123/rizal.PNG', 'wqeqweqwe123', 123124325, 324234, 75676, 34242, 5453453, '2025-04-03 00:00:00.000000', 'CDLB', '2019-06-14', 'Academic Award', '2025-06-24', '2025-06-24', 'None', 'ICT', 'local', 'Los banos1, Calamba2, Sta. Cruz3', 'Virtual Assistant, Web Developer, IT specialist, Kargador', 'drgtgdrgdr', 'sergsegesrgser', 'dhrtyrtgdrgdr', 'restsegserser', 'tet4et', 'terteryrt', '', 'Employment', 20000, ''),
(6, 'Patrick123', '$2y$10$GDhfOAg2HscIqvuzWs2djeay/xGP1vSzGaplyYg8y96/xf1ZvItrm', '1', '506994', '2025-03-27 10:23:37.000000', '', '', 'vetara3297@boyaga.com', 'Tite ', 'Patrick', 'ni', '2000-02-02', '', 0, 0, 'male', '', 2147483647, '', 'uploads/Patrick123/brave_screenshot_localhost.png', 'asdad', 0, 0, 0, 0, 0, NULL, 'asd', '2000-02-22', 'asd', 'asd', '2000-02-20', 'asd', '', '', '', '', '', '', '', '', '', '', '', 'Employment', 0, ''),
(7, 'Markrrr', '$2y$10$eovoYRyRckMntWemzIpXFOvUHkMKwnuAMJwRqpRhV29w3xPG8LRUy', '0', '355618', '2025-04-03 14:56:09.000000', '', '', 'huhywypi@logsmarter.net', 'Mark', 'Mercado', 'Lawrence', '2000-12-23', '', 0, 0, 'male', '', 2147483647, '', '../uploads/Markrrr/Planet9_3840x2160.jpg', 'sadfawefw3', 0, 0, 0, 0, 0, NULL, 'afwefaw', '2002-05-21', 'wfafaefawe', 'ewdqedwe', '2024-03-31', 'qwerqweqd', '', '', '', '', '', '', '', '', '', '', '', 'Employment', 0, ''),
(8, 'joker', '$2y$10$vgmaJDqF0BO4scQDxIHHZ.4k0unBO51XIHXljl0clMP26TTQO.nE6', '1', '940675', '2025-04-03 15:00:07.000000', '1bf963501b92a96ee43de8bc32bcac59903e8b507bad660a3a5210c828c0670ddfd4a09e7ca5b6fff3c9f357f86655c88b3c', '2025-05-26 14:03:29', 'db1u6cq8ju@vwhins.com', 'Mark', 'Mercado', 'Lawrence', '2000-12-23', '', 24, 0, 'male', 'single', 2147483647, '', 'uploads/joker/Planet9_3840x2160.jpg', 'sadfawefw3', 0, 0, 0, 0, 0, NULL, 'afwefaw', '2002-05-21', 'wfafaefawe', 'ewdqedwe', '2024-03-31', 'qwerqweqd', '', '', '', '', '', '', 'yes', '', '', '', '', 'Employment', 0, ''),
(9, 'Batbat', '$2y$10$clFfpF56NfPfGi1anegZZ.Ix8zxFGsGz52ifKYRtvCWryWdCkQvJy', '1', '323304', '2025-04-04 14:35:31.000000', '', '', 'batbattmercado@gmail.com', 'Jervin', 'Guevarra', 'Campos', '2002-01-29', '', 0, 0, 'male', '', 2147483647, '', '../uploads/Batbat/Screenshot_20221129_041811.png', 'sdafaf2fffw4fwf', 0, 0, 0, 0, 0, NULL, 'Pulo', '2021-03-03', 'ewfwe', 'ewrw', '2025-04-01', 'ewfwew', '', '', '', '', '', '', '', '', '', '', '', 'Employment', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `applied_job`
--

CREATE TABLE `applied_job` (
  `id` int(255) NOT NULL,
  `applicant_id` int(255) NOT NULL,
  `job_posting_id` int(255) NOT NULL,
  `application_date` date NOT NULL,
  `status` varchar(255) NOT NULL,
  `job` varchar(255) NOT NULL,
  `interview_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applied_job`
--

INSERT INTO `applied_job` (`id`, `applicant_id`, `job_posting_id`, `application_date`, `status`, `job`, `interview_date`) VALUES
(2, 5, 19, '2025-04-02', 'Interview', 'Autem nihil veniam ', NULL),
(4, 9, 20, '2025-04-04', 'Interview Scheduled', 'Service Crew343', '2025-04-08'),
(5, 9, 21, '2025-04-03', 'Rejected', 'lawrence123', '0000-00-00'),
(6, 8, 22, '2025-04-04', 'Interview', 'Security Guard', '0000-00-00'),
(7, 11, 22, '2025-04-04', 'Interview', 'Security Guard', '0000-00-00'),
(8, 9, 21, '2025-04-03', 'Rejected', 'lawrence123', '0000-00-00'),
(9, 8, 22, '2025-04-04', 'Interview', 'Security Guard', '0000-00-00'),
(10, 11, 22, '2025-04-04', 'Interview', 'Security Guard', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

CREATE TABLE `cases` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `status` enum('filed','in progress','result','') NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `messages` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `current_employee`
--

CREATE TABLE `current_employee` (
  `id` int(255) NOT NULL,
  `employer_id` int(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `age` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `contact` int(255) NOT NULL,
  `bday` date NOT NULL,
  `houseaddress` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `current_employee`
--

INSERT INTO `current_employee` (`id`, `employer_id`, `fname`, `mname`, `lname`, `age`, `gender`, `contact`, `bday`, `houseaddress`, `position`) VALUES
(1, 3, 'mark', 'lawrence', 'mercado', '32', 'Male', 91234567, '2017-03-10', '432gdgdvdrvdr', 'back'),
(2, 3, 'jervin', 'baccarat', 'Guevarra', '62', 'Male', 912565475, '2015-03-25', 'gafwefe3431sdfs', 'safwaerew'),
(3, 3, 'mark', 'lawrence', 'mercado', '32', 'Male', 91234567, '2017-03-10', '432gdgdvdrvdr', 'back'),
(4, 3, 'jervin', 'baccarat', 'Guevarra', '62', 'Male', 912565475, '2015-03-25', 'gafwefe3431sdfs', 'safwaerew'),
(5, 3, 'Colorado', 'Ryan Campos', 'Hoover', '4', 'Other', 0, '2020-11-28', 'Libero eos vitae ma', 'Aliqua Obcaecati er');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(255) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `document_type` varchar(255) NOT NULL,
  `document_file` varchar(255) NOT NULL,
  `created_at` datetime(6) NOT NULL,
  `is_verified` varchar(100) DEFAULT NULL,
  `comment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `employer_id`, `document_type`, `document_file`, `created_at`, `is_verified`, `comment`) VALUES
(1, 3, 'hoddies', 'documents/e-Phil-ID.pdf', '2025-03-20 00:00:00.000000', NULL, ''),
(2, 3, 'hoddies1', 'documents/solicit1.pdf', '2025-03-31 00:00:00.000000', 'verified', ''),
(3, 3, 'Jennifer Snyder', 'documents/ITEP414-SAM-Assignment-1-and-Task-1.pdf', '2025-04-17 00:00:00.000000', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `employer`
--

CREATE TABLE `employer` (
  `id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_verified` tinyint(11) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `otp_expiry` datetime(6) NOT NULL,
  `reset_token` varchar(6) NOT NULL,
  `reset_token_expiry` datetime(6) NOT NULL,
  `types_of_employer` enum('local_agencies','direct_hire','Overseas','local_lb') NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_address` varchar(255) NOT NULL,
  `company_contact` varchar(255) NOT NULL,
  `hr` varchar(255) NOT NULL,
  `president` varchar(255) NOT NULL,
  `tel_num` varchar(255) NOT NULL,
  `company_email` varchar(255) NOT NULL,
  `hr_email` varchar(255) NOT NULL,
  `company_photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employer`
--

INSERT INTO `employer` (`id`, `username`, `password`, `email`, `is_verified`, `otp`, `otp_expiry`, `reset_token`, `reset_token_expiry`, `types_of_employer`, `fname`, `lname`, `company_name`, `company_address`, `company_contact`, `hr`, `president`, `tel_num`, `company_email`, `hr_email`, `company_photo`) VALUES
(2, 'Melany.Volkman', '$2y$10$qjOybIq0egPOlWebtb9E9.N/Rfg9YUT53mIrsvhjNEVTU58MK6dGG', 'marklawrencemercado8@gmail.com', 1, '528560', '2025-02-18 14:53:53.000000', '', '0000-00-00 00:00:00.000000', 'local_lb', 'Elsie', 'Crooks', 'David Bosco', 'McLaughlin, Hansen and Beatty', 'Watsica - Yundt', 'Mollitia voluptatibus autem.', 'Explicabo accusantium placeat quibusdam autem.', '09123488990', 'Miller, Labadie and Yundt', '', 'uploads/David_Bosco/444.jpg'),
(3, 'Azure', '$2y$10$vwSz.nuPSNc6Yfx048oCMOu90wIaqoUoeHf3hP9yos81Xft75w4BW', 'ict1mercado.cdlb@gmail.com', 1, '843947', '2025-03-03 09:21:48.000000', '', '0000-00-00 00:00:00.000000', '', 'Mark Lawrence ', 'Mercado1', 'Seth Aguirre', 'Newton Wilder Co', '09915209066', 'Natus maxime velit qsss', 'Nulla cillum enim pa', '09162602288', 'dapiv@mailinator.com', '', 'uploads/Azure/ma.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `interview`
--

CREATE TABLE `interview` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `job_id` int(255) NOT NULL,
  `sched_date` date NOT NULL,
  `sched_time` date NOT NULL,
  `interview` varchar(255) NOT NULL,
  `meeting` varchar(255) NOT NULL,
  `is_read` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_post`
--

CREATE TABLE `job_post` (
  `id` int(255) NOT NULL,
  `employer_id` int(255) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `job_type` varchar(255) NOT NULL,
  `salary` varchar(255) NOT NULL,
  `job_description` varchar(255) NOT NULL,
  `selected_option` varchar(255) NOT NULL,
  `vacant` int(255) NOT NULL,
  `requirement` varchar(255) NOT NULL,
  `work_location` varchar(255) NOT NULL,
  `education` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `date_posted` date NOT NULL,
  `is_active` tinyint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_post`
--

INSERT INTO `job_post` (`id`, `employer_id`, `job_title`, `company_name`, `job_type`, `salary`, `job_description`, `selected_option`, `vacant`, `requirement`, `work_location`, `education`, `remarks`, `date_posted`, `is_active`) VALUES
(1, 0, 'saleslady', 'Ayala Mall', 'Saleslady', '10000', 'asd\nASDASD\nASDASD\nASDA\nSDAS\nDAS\nDAD', '', 3, 'PSA\r\n', 'CAlamba', 'n/A', '', '0000-00-00', 1),
(2, 0, 'saleslady', 'Ayala Mall', 'Mason', '10000', 'asd', '', 3, 'PSA\r\n', 'CAlamba', 'n/A', '', '0000-00-00', 1),
(3, 0, 'welding', 'welding incorporation', 'Welder ', '10000', 'Malakas pangangatawanan', '', 22, 'Malaki muscle ', 'Bay,Laguna', '', 'N/A', '0000-00-00', 1),
(4, 0, 'Mason', 'Mason incorporation', 'masonary', '10000', 'Malakas pangangatawanan', '', 22, 'Malaki muscle ', 'Bay,Laguna', '', 'N/A', '0000-00-00', 1),
(5, 0, 'sisigan ni patrick', 'Patrick\'s sisig', 'hot & sweet \r\n15 yrs old ', '600/day', 'bambang residence\r\n', '', 3, 'Pogi,Malinis,Masarap', 'Bambang', '', '', '0000-00-00', 1),
(6, 0, 'sisigan ni Law', 'Law\'s sisig', 'hot & sweet \r\n15 yrs old ', '600/day', 'bambang residence\r\n', '', 3, 'Pogi,Malinis,Masarap', 'Bambang', '', '', '0000-00-00', 1),
(7, 0, 'Cashier', 'SM Supermarket', 'Full-time', '12000', 'Handles transactions and customer payments', '', 5, 'Honest, Friendly, Basic Math Skills', 'Calamba', 'High School Graduate', '', '2025-02-13', 1),
(8, 0, 'Delivery Rider', 'Lalamove', 'Contract', 'Per delivery', 'Deliver packages efficiently', '', 10, 'Owns motorcycle, Valid License', 'Laguna', 'High School Graduate', '', '2025-02-13', 1),
(9, 0, 'Office Staff', 'ABC Corp.', 'Full-time', '15000', 'General office duties and admin tasks', '', 3, 'Computer literate, Organized', 'Binan', 'College Level', '', '2025-02-13', 1),
(10, 0, 'Bartender', 'The Chill Bar', 'Part-time', '700/day', 'Mixes and serves drinks', '', 2, 'Friendly, Customer Service, Mixology', 'Los Baños', 'N/A', '', '2025-02-13', 1),
(11, 0, 'Call Center Agent', 'Concentrix', 'Full-time', '18000', 'Handles customer inquiries via phone', '', 15, 'Good communication, Typing skills', 'Santa Rosa', 'College Level', '', '2025-02-13', 1),
(12, 0, 'Security Guard', 'Safe Guard Co.', 'Full-time', '14000', 'Ensures safety and security', '', 4, 'Physically fit, Licensed', 'Batangas', 'High School Graduate', '', '2025-02-13', 1),
(13, 0, 'Kitchen Crew', 'Jollibee', 'Full-time', '11000', 'Prepares and cooks food', '', 8, 'Hardworking, Willing to learn', 'San Pablo', 'High School Graduate', '', '2025-02-13', 1),
(14, 0, 'Data Encoder', 'XYZ Solutions', 'Full-time', '16000', 'Encodes and organizes data', '', 6, 'Fast typing, Attention to detail', 'Cabuyao', 'College Level', '', '2025-02-13', 1),
(15, 0, 'Pharmacy Assistant', 'Watsons', 'Full-time', '13000', 'Assists in dispensing medicines', '', 3, 'Customer service, Knowledge in meds', 'San Pedro', 'College Level', '', '2025-02-13', 1),
(16, 0, 'Graphic Designer', 'Creative Minds', 'Freelance', 'Project-based', 'Creates visual designs and marketing materials', '', 2, 'Adobe Photoshop, Creativity', 'Remote', 'College Graduate', '', '2025-02-13', 1),
(17, 2, 'Investor Division Administrator', 'David Bosco', 'contract', '121', 'Human Markets Executive', '', 505, 'Cupiditate pariatur quaerat ad consequuntur soluta tenetur aliquam.', 'consequatur praesentium nam', 'Velit aspernatur ipsa impedit neque repellat adipisci suscipit possimus.', 'Quod expedita sit laudantium nemo veritatis laboriosam quidem.', '2025-02-26', 1),
(18, 2, 'Internal Program Consultant', 'David Bosco', 'contract', '20000', 'National Usability Coordinator', '', 239, 'Aperiam nisi minima placeat.', 'officiis consequuntur eveniet', 'Numquam necessitatibus fugit quo corporis.', 'Reprehenderit facere incidunt dolore blanditiis id.', '2025-02-26', 1),
(19, 3, 'Autem nihil veniam ', 'Seth Aguirre', 'internship', '50', 'Non vero sunt quasi', 'Similique dolor aut ', 931, 'Nihil tempor quia as', 'In laborum quasi sun', 'Id aut ut est iusto ', 'Rerum et non est mol', '2025-03-03', 1),
(20, 3, 'Service Crew343', 'Seth Aguirre', 'part_time', '10000', 'fgsfdgsfgs', 'hard working', 5, 'tujgyjg7', 'khu78', 'khuikk8', 'khk88ku8', '2025-04-03', 1);

-- --------------------------------------------------------

--
-- Table structure for table `language_proficiency`
--

CREATE TABLE `language_proficiency` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `language_p` varchar(255) NOT NULL,
  `read_i` tinyint(11) NOT NULL,
  `write_i` tinyint(11) NOT NULL,
  `speak_i` tinyint(11) NOT NULL,
  `understand_i` tinyint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `language_proficiency`
--

INSERT INTO `language_proficiency` (`id`, `user_id`, `language_p`, `read_i`, `write_i`, `speak_i`, `understand_i`) VALUES
(14, 5, 'Filipino', 1, 1, 1, 1),
(15, 5, 'English', 1, 1, 1, 1),
(33, 5, 'English', 0, 0, 0, 0),
(34, 5, 'filipino', 0, 0, 0, 0),
(35, 5, 'English', 0, 0, 0, 0),
(36, 5, 'filipino', 0, 0, 0, 0),
(37, 5, 'English', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `license`
--

CREATE TABLE `license` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `eligibility` varchar(255) NOT NULL,
  `rating` varchar(255) NOT NULL,
  `doe` date NOT NULL,
  `prc_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `license`
--

INSERT INTO `license` (`id`, `user_id`, `eligibility`, `rating`, `doe`, `prc_path`) VALUES
(10, 5, 'hoddies', '12', '2025-06-12', 'uploads/Lawrence123/1743386181_law_cor-sem2_.pdf'),
(11, 5, 'asdfdfdg', 'Minima excepteur rem', '2222-03-23', 'uploads/Lawrence123/solicit1.pdf'),
(12, 5, 'asd', 're', '1056-05-31', 'uploads/Lawrence123/2nd sem.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(255) NOT NULL,
  `training_id` int(11) NOT NULL,
  `module_name` varchar(255) NOT NULL,
  `module_description` varchar(255) NOT NULL,
  `files` varchar(255) NOT NULL,
  `date_created` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `training_id`, `module_name`, `module_description`, `files`, `date_created`) VALUES
(1, 1, 'Spotting', 'learning the basics', 'uploads/modules/680056f2ac76f_PESO.pdf', '2025-04-17 09:18:42.000000'),
(2, 1, 'joints', 'making joints by welding', 'uploads/modules/68005905dabbe_Application_Form.pdf', '2025-04-17 09:27:33.000000'),
(3, 2, 'Basic vitals checking', 'Checking of pulse, breathing and blood pressure', 'uploads/modules/68005b787a44e_ITEP_413___IMPLEMENTING_INFORMATION_SECURITY.pdf', '2025-04-17 09:38:00.000000'),
(4, 2, 'Basic pattern for massage', 'Guide for basic massage', 'uploads/modules/68005da43f4db_pesodigitalmarketin.pdf', '2025-04-17 09:47:16.000000'),
(6, 3, 'basic cutting', 'proper cutting technies and patterns', 'uploads/modules/68019fb62922e_e_Phil_ID.pdf', '2025-04-18 08:41:26.000000'),
(7, 3, 'Florine Pouros', 'Sequi molestiae aspernatur nesciunt itaque.', 'uploads/modules/68019fc4878ed_LSPU_LB_CCS___Participant_Certificates.pdf', '2025-04-18 08:41:40.000000'),
(8, 3, 'Trinity Wuckert', 'Magni qui exercitationem.', 'uploads/modules/68019fd582210_Performance_Task_2_Part_1_ITEP_413.pdf', '2025-04-18 08:41:57.000000'),
(9, 3, 'Amya Champlin', 'Molestiae voluptas quis quo ullam unde ducimus impedit qui saepe.', 'uploads/modules/68019fe318c3c_Application_Form.pdf', '2025-04-18 08:42:11.000000'),
(10, 3, 'Elwin Goldner', 'Incidunt deserunt accusamus adipisci excepturi dolorem itaque eligendi distinctio voluptas.', 'D:\\xampp\\htdocs\\peso\\admin\\content/uploads/modules/6801a2ff357f5_pesodigitalmarketin.pdf', '2025-04-18 08:55:27.000000'),
(11, 3, 'Kane Weimann', 'Quis dolore accusamus veritatis saepe vitae quisquam odio.', 'uploads/modules/6801a37d7ca0f_ITEP_413___IMPLEMENTING_INFORMATION_SECURITY.pdf', '2025-04-18 08:57:33.000000'),
(12, 3, 'Maude Nikolaus', 'Repudiandae accusamus sed repellat molestiae quam ut maxime est.', 'uploads/modules/6801a43b16c49_e_Phil_ID.pdf', '2025-04-18 09:00:43.000000');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `schedule_date` date DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `image`, `description`, `schedule_date`, `create_at`) VALUES
(1, 'New Tech Innovation Announced', 'news/i1.webp', 'A breakthrough in AI technology has been announced, revolutionizing automation.', '2025-03-01', '2025-02-16 18:45:38'),
(2, 'Local Sports Team Wins Championship', 'news/i2.webp', 'The city celebrates as the home team claims victory in the national championship.', '2025-03-05', '2025-02-16 18:46:05'),
(3, 'Weather Alert: Heavy Rain Expected', 'news/i3.webp', 'Meteorologists warn of incoming heavy rainfall and possible flooding.', '2025-02-25', '2025-02-16 18:46:12'),
(4, 'New Legislation Passed for Green Energy', 'news/i4.webp', 'The government has approved a new bill promoting renewable energy solutions.', '2025-03-10', '2025-02-16 18:46:19'),
(5, 'Upcoming Music Festival Lineup Revealed', 'news/i5.webp', 'Top artists are set to perform at the annual summer music festival.', '2025-03-15', '2025-02-16 18:46:29');

-- --------------------------------------------------------

--
-- Table structure for table `ofw_profile`
--

CREATE TABLE `ofw_profile` (
  `id` int(255) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `otp_expiry` datetime(6) NOT NULL,
  `reset_token` datetime(6) NOT NULL,
  `reset_token_expiry` datetime(6) NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_image` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `prefix` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `sex` varchar(255) NOT NULL,
  `age` int(255) NOT NULL,
  `civil_status` varchar(255) NOT NULL,
  `house_address` varchar(255) NOT NULL,
  `contact_no` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `sss_no` int(255) NOT NULL,
  `pagibig_no` int(255) NOT NULL,
  `philhealth_no` int(255) NOT NULL,
  `passport_no` int(255) NOT NULL,
  `immigration_status` varchar(255) NOT NULL,
  `educational_background` varchar(255) NOT NULL,
  `spouse_name` varchar(255) NOT NULL,
  `spouse_contact` int(255) NOT NULL,
  `fathers_name` varchar(255) NOT NULL,
  `fathers_address` varchar(255) NOT NULL,
  `mothers_name` varchar(255) NOT NULL,
  `mothers_address` varchar(255) NOT NULL,
  `emergency_contact_name` int(255) NOT NULL,
  `emergency_contact_number` int(255) NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `income` int(255) NOT NULL,
  `employment_type` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `employment_form` varchar(255) NOT NULL,
  `employer_abroad` varchar(255) NOT NULL,
  `abroad_contact` int(255) NOT NULL,
  `employer_address` varchar(255) NOT NULL,
  `local_agencies` varchar(255) NOT NULL,
  `local_agency_no` int(255) NOT NULL,
  `name_local_agency` varchar(255) NOT NULL,
  `contact_person_local` varchar(255) NOT NULL,
  `address_local` varchar(255) NOT NULL,
  `email_personal_local` varchar(255) NOT NULL,
  `email_company_local` varchar(255) NOT NULL,
  `agency_abroad` varchar(255) NOT NULL,
  `contact_abroad` varchar(255) NOT NULL,
  `agency_person_abroad` varchar(255) NOT NULL,
  `address_abroad` varchar(255) NOT NULL,
  `email_abroad_personal` varchar(255) NOT NULL,
  `email_abroad_company` varchar(255) NOT NULL,
  `departure_date` datetime(6) NOT NULL,
  `arrival_date` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ofw_profile`
--

INSERT INTO `ofw_profile` (`id`, `otp`, `otp_expiry`, `reset_token`, `reset_token_expiry`, `is_verified`, `username`, `password`, `profile_image`, `last_name`, `first_name`, `middle_name`, `prefix`, `dob`, `sex`, `age`, `civil_status`, `house_address`, `contact_no`, `email`, `sss_no`, `pagibig_no`, `philhealth_no`, `passport_no`, `immigration_status`, `educational_background`, `spouse_name`, `spouse_contact`, `fathers_name`, `fathers_address`, `mothers_name`, `mothers_address`, `emergency_contact_name`, `emergency_contact_number`, `occupation`, `income`, `employment_type`, `country`, `employment_form`, `employer_abroad`, `abroad_contact`, `employer_address`, `local_agencies`, `local_agency_no`, `name_local_agency`, `contact_person_local`, `address_local`, `email_personal_local`, `email_company_local`, `agency_abroad`, `contact_abroad`, `agency_person_abroad`, `address_abroad`, `email_abroad_personal`, `email_abroad_company`, `departure_date`, `arrival_date`) VALUES
(6, '518565', '2025-02-19 14:49:49.000000', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', 1, 'Ruth18', '$2y$10$j4z3TSpS/j9gSCtcuw6xc.yzlxbazX8mwnoxU4lmt8LZ/A8IiPUKK', '../uploads/Ruth18/11.jpg', 'Bode', 'Rowland', 'Jailyn Hirthe', '', '2025-03-18', 'male', 0, '', '6985 Breitenberg Shoals', 912345678, 'marklawrencemercado8@gmail.com', 0, 0, 0, 0, '', '', '', 0, '', '', '', '', 0, 0, '', 0, '', '', '', '', 0, '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000'),
(7, '480058', '2025-02-21 14:34:23.000000', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', 1, 'Melany.Volkman', '$2y$10$cJ1RW.agwZBImdHCp.yWuOgr2e9N6QDgSCmMO/ILyFPDAEooukl16', 'uploads/Melany_Volkman/444.jpg', 'qwe', 'qwe', 'qwe', '', '2000-07-11', 'male', 0, '', 'rh45hgfghrdsh', 2147483647, 'pesolosbanos4@gmail.com', 0, 0, 0, 0, '', '', '', 0, '', '', '', '', 0, 0, '', 0, '', '', '', '', 0, '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000');

-- --------------------------------------------------------

--
-- Table structure for table `save_job`
--

CREATE TABLE `save_job` (
  `id` int(255) NOT NULL,
  `job_id` int(255) NOT NULL,
  `applicant_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `save_job`
--

INSERT INTO `save_job` (`id`, `job_id`, `applicant_id`) VALUES
(3, 20, 8);

-- --------------------------------------------------------

--
-- Table structure for table `skills_training`
--

CREATE TABLE `skills_training` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skills_training`
--

INSERT INTO `skills_training` (`id`, `name`) VALUES
(1, 'Welding'),
(2, 'Hilot Wellness'),
(3, 'Dressmaking'),
(4, 'Computer Literacy');

-- --------------------------------------------------------

--
-- Table structure for table `survey_form`
--

CREATE TABLE `survey_form` (
  `id` int(11) NOT NULL,
  `questions` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `survey_response`
--

CREATE TABLE `survey_response` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `survey_id` int(11) DEFAULT NULL,
  `response` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `techvoc_documents`
--

CREATE TABLE `techvoc_documents` (
  `id` int(255) NOT NULL,
  `school_id` int(255) NOT NULL,
  `school_name` varchar(255) NOT NULL,
  `school_address` varchar(255) NOT NULL,
  `tesda_certificate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trainees_profile`
--

CREATE TABLE `trainees_profile` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` varchar(255) DEFAULT NULL,
  `otp_expiry` datetime(6) DEFAULT NULL,
  `reset_token_expiry` datetime(6) DEFAULT NULL,
  `is_verified` varchar(255) DEFAULT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `mname` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `civil_status` varchar(255) DEFAULT NULL,
  `employment` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `pob` varchar(255) DEFAULT NULL,
  `age` varchar(255) DEFAULT NULL,
  `educ_attain` varchar(255) DEFAULT NULL,
  `parent` varchar(255) DEFAULT NULL,
  `classification` varchar(255) DEFAULT NULL,
  `disability` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainees_profile`
--

INSERT INTO `trainees_profile` (`id`, `username`, `password`, `email`, `otp`, `otp_expiry`, `reset_token_expiry`, `is_verified`, `fname`, `lname`, `mname`, `address`, `contact_no`, `nationality`, `sex`, `civil_status`, `employment`, `dob`, `pob`, `age`, `educ_attain`, `parent`, `classification`, `disability`, `photo`, `reset_token`) VALUES
(6, 'Azure', '$2y$10$ifO9SwO1uuY3lAQGWd0psO/Rw4DUcmHflj0xj.ViV3nJzA40KxGoq', 'heredape@asciibinder.net', '231766', '2025-04-17 22:02:42.000000', NULL, '1', 'Tallulah', 'Lewis', 'Caleb Bryan', 'Eveniet omnis sint', '738', 'Ad qui quia fuga La', 'female', 'male', 'student', '2011-05-25', NULL, NULL, 'cug', 'In omnis vero qui te', 'student', 'Recusandae Neque po', 'uploads/trainees/Azure/680107aa18808_coding.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trainee_status_history`
--

CREATE TABLE `trainee_status_history` (
  `id` int(11) NOT NULL,
  `trainee_training_id` int(11) NOT NULL,
  `old_status` varchar(50) DEFAULT NULL,
  `new_status` varchar(50) NOT NULL,
  `changed_by` int(11) DEFAULT NULL COMMENT 'Admin/user ID who made change',
  `changed_at` datetime NOT NULL DEFAULT current_timestamp(),
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainee_status_history`
--

INSERT INTO `trainee_status_history` (`id`, `trainee_training_id`, `old_status`, `new_status`, `changed_by`, `changed_at`, `notes`) VALUES
(8, 1, 'next_batch', 'next_batch', NULL, '2025-04-18 13:44:37', '');

-- --------------------------------------------------------

--
-- Table structure for table `trainee_trainings`
--

CREATE TABLE `trainee_trainings` (
  `id` int(11) NOT NULL,
  `trainee_id` int(11) NOT NULL,
  `training_id` int(11) NOT NULL,
  `enrollment_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','accepted','graduated','next_batch','rejected') NOT NULL DEFAULT 'pending',
  `completion_date` datetime DEFAULT NULL,
  `status_changed_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainee_trainings`
--

INSERT INTO `trainee_trainings` (`id`, `trainee_id`, `training_id`, `enrollment_date`, `status`, `completion_date`, `status_changed_at`) VALUES
(1, 6, 3, '2025-04-17 21:52:42', 'accepted', NULL, '2025-04-18 14:36:34');

-- --------------------------------------------------------

--
-- Table structure for table `training`
--

CREATE TABLE `training` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `training` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `institution` varchar(255) NOT NULL,
  `certificate_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `training`
--

INSERT INTO `training` (`id`, `user_id`, `training`, `start_date`, `end_date`, `institution`, `certificate_path`) VALUES
(1, 5, 'Brick', '2023-04-23', '2025-07-12', 'afdas', 'uploads/Lawrence123/Final-presentation-aprroval.pdf'),
(2, 5, 'Wordpress', '2002-09-21', '2025-12-05', 'dsafwe', 'uploads/Lawrence123/SOSLIT_PAPER_PRESENTATION-TEMPLATE.pptx');

-- --------------------------------------------------------

--
-- Table structure for table `work_exp`
--

CREATE TABLE `work_exp` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `started_date` date NOT NULL,
  `termination_date` date NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `work_exp`
--

INSERT INTO `work_exp` (`id`, `user_id`, `company_name`, `address`, `position`, `started_date`, `termination_date`, `status`) VALUES
(1, 5, 'Vandervort Group', 'Nihil sapiente magna', 'Eum explicabo omnis adipisci reiciendis aut excepturi sequi saepe eum.', '2015-07-09', '2020-01-10', 'fIL');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_profile`
--
ALTER TABLE `admin_profile`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `applicant_profile`
--
ALTER TABLE `applicant_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applied_job`
--
ALTER TABLE `applied_job`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `current_employee`
--
ALTER TABLE `current_employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employer`
--
ALTER TABLE `employer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `interview`
--
ALTER TABLE `interview`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_post`
--
ALTER TABLE `job_post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language_proficiency`
--
ALTER TABLE `language_proficiency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `license`
--
ALTER TABLE `license`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ofw_profile`
--
ALTER TABLE `ofw_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `save_job`
--
ALTER TABLE `save_job`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skills_training`
--
ALTER TABLE `skills_training`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_form`
--
ALTER TABLE `survey_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_response`
--
ALTER TABLE `survey_response`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `techvoc_documents`
--
ALTER TABLE `techvoc_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trainees_profile`
--
ALTER TABLE `trainees_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trainee_status_history`
--
ALTER TABLE `trainee_status_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trainee_training_id` (`trainee_training_id`);

--
-- Indexes for table `trainee_trainings`
--
ALTER TABLE `trainee_trainings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_trainee_status` (`trainee_id`,`status`),
  ADD KEY `idx_training_status` (`training_id`,`status`);

--
-- Indexes for table `training`
--
ALTER TABLE `training`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_exp`
--
ALTER TABLE `work_exp`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_profile`
--
ALTER TABLE `admin_profile`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `applicant_profile`
--
ALTER TABLE `applicant_profile`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `applied_job`
--
ALTER TABLE `applied_job`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cases`
--
ALTER TABLE `cases`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `current_employee`
--
ALTER TABLE `current_employee`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employer`
--
ALTER TABLE `employer`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `interview`
--
ALTER TABLE `interview`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_post`
--
ALTER TABLE `job_post`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `language_proficiency`
--
ALTER TABLE `language_proficiency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `license`
--
ALTER TABLE `license`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ofw_profile`
--
ALTER TABLE `ofw_profile`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `save_job`
--
ALTER TABLE `save_job`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `skills_training`
--
ALTER TABLE `skills_training`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `survey_form`
--
ALTER TABLE `survey_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `survey_response`
--
ALTER TABLE `survey_response`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `techvoc_documents`
--
ALTER TABLE `techvoc_documents`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trainees_profile`
--
ALTER TABLE `trainees_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `trainee_status_history`
--
ALTER TABLE `trainee_status_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `trainee_trainings`
--
ALTER TABLE `trainee_trainings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `training`
--
ALTER TABLE `training`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `work_exp`
--
ALTER TABLE `work_exp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `trainee_status_history`
--
ALTER TABLE `trainee_status_history`
  ADD CONSTRAINT `trainee_status_history_ibfk_1` FOREIGN KEY (`trainee_training_id`) REFERENCES `trainee_trainings` (`id`);

--
-- Constraints for table `trainee_trainings`
--
ALTER TABLE `trainee_trainings`
  ADD CONSTRAINT `trainee_trainings_ibfk_1` FOREIGN KEY (`trainee_id`) REFERENCES `trainees_profile` (`id`),
  ADD CONSTRAINT `trainee_trainings_ibfk_2` FOREIGN KEY (`training_id`) REFERENCES `skills_training` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
