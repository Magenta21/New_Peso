-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2025 at 04:11 AM
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
-- Database: `pesoo`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_profile`
--

CREATE TABLE `admin_profile` (
  `ID` int(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Fname` varchar(255) NOT NULL,
  `Lname` varchar(255) NOT NULL,
  `Mname` varchar(255) NOT NULL,
  `Age` int(10) NOT NULL,
  `Cnumber` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `grad_course` varchar(255) NOT NULL,
  `college_graduated` date NOT NULL,
  `college_award` varchar(255) NOT NULL,
  `tertiary_course` varchar(255) NOT NULL,
  `work_location` varchar(255) NOT NULL,
  `preferred_work_location` varchar(255) NOT NULL,
  `preferred_occupation` varchar(255) NOT NULL,
  `disability` varchar(255) NOT NULL,
  `selected_option` varchar(255) NOT NULL,
  `four_ps` varchar(255) NOT NULL,
  `prefix` varchar(255) NOT NULL,
  `religion` varchar(255) NOT NULL,
  `employment_status` varchar(255) NOT NULL,
  `resume` varchar(255) NOT NULL,
  `applicant_type` enum('Training','Employment') NOT NULL,
  `expected_salary` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicant_profile`
--

INSERT INTO `applicant_profile` (`id`, `username`, `password`, `is_verified`, `otp`, `otp_expiry`, `reset_token`, `reset_token_expiry`, `email`, `fname`, `lname`, `mname`, `dob`, `pob`, `age`, `height`, `sex`, `civil_status`, `contact_no`, `landline`, `photo`, `present_address`, `tin`, `sss_no`, `pagibig_no`, `philhealth_no`, `passport_no`, `passport_expiry`, `tertiary_school`, `tertiary_graduated`, `tertiary_award`, `college_school`, `grad_course`, `college_graduated`, `college_award`, `tertiary_course`, `work_location`, `preferred_work_location`, `preferred_occupation`, `disability`, `selected_option`, `four_ps`, `prefix`, `religion`, `employment_status`, `resume`, `applicant_type`, `expected_salary`) VALUES
(2, 'Mark', '$2y$10$cIcE2Z62HDpszBc4szxu1.RPGeLkZ8YYik94p6ny5V0QiUrot.RRq', '1', '475046', '2025-02-18 13:36:56.000000', '', '', 'pesolosbanos4@gmail.com', 'Sedrick', 'Hyatt-Mosciski', 'Ottis Mitchell', '2025-10-10', '', 0, 0, 'male', '', 2147483647, '', '../uploads/Mark/11.jpg', '138 Audra Trafficway', 0, 0, 0, 0, 0, NULL, 'Noemi Streich', '2024-03-07', 'Sed eius suscipit sequi dolores sint accusamus occaecati quae nulla.', 'Nasir Wilderman', '', '2025-12-16', 'Deleniti sapiente similique ipsum dolor ratione.', '', '', '', '', '', '', '', '', '', '', '', 'Training', 0),
(3, 'Mark', '$2y$10$7HG46MrrdnkCrzoPZkYlT.aqSFBGBaBeSXOphDjmY2b0uO0ebPN82', '1', '972741', '2025-02-20 13:06:58.000000', '', '', 'marklawrencemercado8@gmail.com', 'Vilma', 'Gleichner', 'Libby Yost-Reinger', '2024-10-13', '', 0, 0, 'male', '', 2147483647, '', '../uploads/Mark/11.jpg', '29509 Unique Ville', 0, 0, 0, 0, 0, NULL, 'Scottie Leannon', '2024-05-22', 'Praesentium quam occaecati ratione qui dignissimos corporis deleniti corrupti cumque.', 'Rhett Cole', '', '2024-10-07', 'Fugiat assumenda earum nemo fuga iusto.', '', '', '', '', '', '', '', '', '', '', '', 'Employment', 0),
(4, 'Developer123', '$2y$10$uxVV8batjq8wWi6Twf7I/e64na9vKUUv03W8928omQPpaUUYpA6ay', '1', '424477', '2025-03-17 10:24:49.000000', '', '', 'jervinguevarra123@gmail.com', 'Colorado', 'Hoover', 'Ryan Campos', '2000-02-10', '', 25, 0, 'male', 'single', 2147483647, '', 'uploads/Developer123/475335576_1100869198498503_6127088919250197719_n.jpg', 'campvicente lim ', 0, 0, 0, 0, 0, NULL, 'qweqwe', '2000-02-22', 'qweqeq', 'qweqeq', '', '2000-02-22', 'asd', '', '', '', '', '', '', 'yes', '', '', '', '', 'Employment', 0),
(5, 'Lawrence123', '$2y$10$YxE9QiizxlRg5SlSodk/yexNYMDiCfcTnNmh4gBVbbOOJpo1ZM70G', '1', '791946', '2025-03-17 14:44:36.000000', '', '', 'jervin1231@gmail.com', 'Mark Lawrence ', 'qwee', 'Ryan Campos', '2000-02-22', 'ccsDcS', 25, 0, 'male', 'single', 2147483647, '131243', 'uploads/Lawrence123/485202897_632567676296558_479942496838954320_n.jpg', 'wqeqweqwe123', 123124325, 324234, 75676, 34242, 5453453, '2025-03-12 00:00:00.000000', 'qew', '0000-00-00', 'qwe', 'qwe', '', '2000-02-22', 'qwe', 'fgdhhtrhty', 'srgtrdgdrr, &lt;br /&gt;&lt;b&gt;Warning&lt;/b&gt;:  Undefined array key 1 in &lt;b&gt;C:\\xampp\\htdocs\\peso2\\Applicant\\applicant_profile.php&lt;/b&gt; on line &lt;b&gt;349&lt;/b&gt;&lt;br /&gt;, &lt;br /&gt;&lt;b&gt;Warning&lt;/b&gt;:  Undefined array key', 'local', 'tdhdtyhdth, kitchen crew', 'drgtgdrgdr', 'Carpentry Work,Beautician,Auto Mechanic,Stenography,Tailoring', 'yes', 'restsegserser', 'tet4et', 'terteryrt', '', 'Employment', 0),
(6, 'Patrick123', '$2y$10$GDhfOAg2HscIqvuzWs2djeay/xGP1vSzGaplyYg8y96/xf1ZvItrm', '1', '506994', '2025-03-27 10:23:37.000000', '', '', 'vetara3297@boyaga.com', 'Tite ', 'Patrick', 'ni', '2000-02-02', '', 0, 0, 'male', '', 2147483647, '', 'uploads/Patrick123/brave_screenshot_localhost.png', 'asdad', 0, 0, 0, 0, 0, NULL, 'asd', '2000-02-22', 'asd', 'asd', '', '2000-02-20', 'asd', '', '', '', '', '', '', '', '', '', '', '', 'Employment', 0),
(7, 'Law123', '$2y$10$8nVIsn4msxewHMB3EnTqIOMzvQ.p0HXg.5ocWsAio/AGH/73D7csW', '1', '218464', '2025-04-02 10:36:37.000000', '', '', 'metaxab393@infornma.com', 'Mark Lawrence ', 'Hoover', 'Maxine Murray', '2000-02-22', '', 25, 0, 'male', 'single', 2147483647, '', 'uploads/Law123/brave_screenshot_localhost.png', 'campvicente lim ', 0, 0, 0, 0, 0, NULL, 'Eleanora Nader', '3000-02-22', 'qweqeq', 'qwe', '', '1999-04-23', 'qwe', '', '', '', '', '', '', 'yes', '', '', '', '', 'Training', 0),
(8, 'Jervin123', '$2y$10$QQBUuB/xfB2bWHepP/kSfuv1Fm9ul7vAxV4Kqw5UCRcgL.WfilbSO', '1', '140737', '2025-04-02 14:42:18.000000', '', '', 'royalguards081415@gmail.com', 'Colorado', 'Hoover', 'Maxine Murray', '1999-02-22', '', 0, 0, 'male', '', 2147483647, '', '../uploads/Jervin123/brave_screenshot_localhost.png', 'ads', 0, 0, 0, 0, 0, NULL, 'qwe', '0000-00-00', 'weqa', 'asd', '', '2000-02-22', 'asd', '', '', '', '', '', '', '', '', '', '', '', 'Training', 0),
(9, 'admin22', '$2y$10$/.auGUt0767wOCiDdVXSAea8Ig2uKoPDK0brWORhC0zrSdUpcOQGC', '1', '458848', '2025-04-03 14:46:58.000000', '', '', 'huhywypi@logsmarter.net', 'Mark Lawrence ', 'Mercado', 'Ryan Campos', '2000-02-02', '', 25, 0, 'male', 'single', 926515155, '', 'uploads/admin22/brave_screenshot_localhost.png', 'asdijfasjdf', 0, 0, 0, 0, 0, NULL, 'qweqe', '2000-02-22', 'asdad', 'asdasdsadsad', '', '2000-02-20', 'asdfsadfasdf', '', '', '', '', '', '', 'yes', '', '', '', '', 'Employment', 0),
(10, 'Jervin321', '$2y$10$BKBgnxg/ksAUjAfaoQsKvemOBfgc0mJWcVL9Pw4/m2vrIPjKXTeFO', '1', '553063', '2025-04-04 13:47:45.000000', '', '', 'liporadavince1@gmail.com', 'Noah', 'Powell', 'Nigel Stephens', '2009-04-21', '', 0, 0, 'male', '', 837, '', 'uploads/Jervin321/brave_screenshot_localhost.png', 'Dolore aliquam sit ', 0, 0, 0, 0, 0, NULL, 'Wyatt Osborn', '2016-01-17', 'Consequat Quia illu', 'Jacob Glenn', '', '2004-03-03', 'Quis ducimus ut vel', '', '', '', '', '', '', '', '', '', '', '', 'Training', 0),
(11, 'Jervin1234', '$2y$10$Vy4uJgSjtlPXpI3IkImQzOcVLihyWAMQjnerTehZ1hdsShmZ6DJtG', '1', '306472', '2025-04-04 14:15:14.000000', '', '', 'krizzabellebolinavidal@gmail.com', 'qweqe', 'we', 'we', '2000-02-22', '', 0, 0, 'male', '', 2147483647, '', '../uploads/Jervin1234/brave_screenshot_localhost.png', 'asdfsdf', 0, 0, 0, 0, 0, NULL, 'qweqeqe', '2000-02-02', 'asdasdasd', 'asdasdsad', '', '2000-02-22', 'asdfasdfasdf', '', '', '', '', '', '', '', '', '', '', '', 'Employment', 0),
(12, 'lolomo123', '$2y$10$ZOR9YGH2sIh81aJxm4KQs.YfFWo2kuk4ppcA3kd58xZHnZ9BTRThm', '1', '847306', '2025-04-04 14:49:02.000000', '', '', 'banozibu@polkaroad.net', 'Igor', 'Gilliam', 'Ruby Hancock', '1991-10-27', '', 0, 0, 'male', '', 590, '', '../uploads/lolomo123/brave_screenshot_localhost.png', 'Qui ullam voluptatem', 0, 0, 0, 0, 0, NULL, 'Chastity Huff', '1980-05-22', 'Minim sint nostrud ', 'Tanner Marquez', '', '1993-02-18', 'Sed qui sed minus no', '', '', '', '', '', '', '', '', '', '', '', 'Employment', 0),
(13, 'lawrence33', '$2y$10$uk4Q/F5GmQtoVddAXo0EUuQ7ql2djsBILr1Enqztyr2O6UkY0VVeS', '0', '582658', '2025-04-04 14:54:29.000000', '', '', 'waxapomi@dreamclarify.org', 'Ivana', 'Hatfield', 'Keegan Burke', '2005-01-13', '', 0, 0, 'male', '', 796, '', '../uploads/lawrence33/brave_screenshot_localhost.png', 'Ad a consequatur re', 0, 0, 0, 0, 0, NULL, 'Dai Hobbs', '1987-06-12', 'Cillum dolores quod ', 'Brooke Alford', '', '2001-07-12', 'Sed totam irure vero', '', '', '', '', '', '', '', '', '', '', '', 'Training', 0),
(14, 'vonajeti', '$2y$10$I3QM60aOxQ.mmgc8BLtjJOLYZ0xuD2Odcms2PkcrFP.D8ykkLdNRO', '0', '429364', '2025-04-04 14:59:05.000000', '', '', 'cyzohyvizy@mailinator.com', 'Ivana', 'Hatfield', 'Keegan Burke', '2005-01-13', '', 0, 0, 'male', '', 796, '', '../uploads/vonajeti/brave_screenshot_localhost.png', 'Ad a consequatur re', 0, 0, 0, 0, 0, NULL, 'Dai Hobbs', '1987-06-12', 'Cillum dolores quod ', 'Brooke Alford', '', '2001-07-12', 'Sed totam irure vero', '', '', '', '', '', '', '', '', '', '', '', 'Training', 0),
(15, 'digeda', '$2y$10$RdW3IHaErWK7oTwTBUdFre7VeMrtrBL98aN9gOc3oJLjPQlVeFqvW', '0', '792667', '2025-04-11 15:25:27.000000', '', '', 'gezin@mailinator.com', 'Jackson', 'Blevins', 'Jada Whitehead', '2025-03-07', '', 0, 0, 'male', '', 742, '', '../uploads/digeda/peso25.PNG', 'Vel aut velit occae', 0, 0, 0, 0, 0, NULL, 'Cain Charles', '1983-12-13', 'Nemo numquam consequ', 'Willow Cleveland', '', '2022-12-16', 'At molestiae quisqua', '', '', '', '', '', '', '', '', '', '', '', 'Training', 0);

-- --------------------------------------------------------

--
-- Table structure for table `applied_job`
--

CREATE TABLE `applied_job` (
  `id` int(255) DEFAULT NULL,
  `applicant_id` int(255) NOT NULL,
  `job_posting_id` int(255) NOT NULL,
  `application_date` date NOT NULL,
  `status` varchar(255) NOT NULL,
  `job` varchar(255) NOT NULL,
  `interview_date` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applied_job`
--

INSERT INTO `applied_job` (`id`, `applicant_id`, `job_posting_id`, `application_date`, `status`, `job`, `interview_date`) VALUES
(NULL, 9, 21, '2025-04-03', 'Rejected', 'lawrence123', '0000-00-00 00:00:00.000000'),
(NULL, 8, 22, '2025-04-04', 'Interview', 'Security Guard', '0000-00-00 00:00:00.000000'),
(NULL, 11, 22, '2025-04-04', 'Interview', 'Security Guard', '0000-00-00 00:00:00.000000');

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
(5, 3, 'Colorado', 'Ryan Campos', 'Hoover', '4', 'Other', 0, '2020-11-28', 'Libero eos vitae ma', 'Aliqua Obcaecati er'),
(6, 3, 'Cailin', 'Drake Leach', 'Logan', '10', 'Female', 0, '2014-06-12', 'Temporibus aut aut m', 'Aspernatur est solut'),
(7, 3, 'Felicia', 'Denton Dorsey', 'Mercado', '15', 'Female', 0, '2010-01-27', 'Tempor voluptas sit', 'Incidunt doloremque'),
(8, 3, 'Drake', 'Azalia Watts', 'Chambers', '47', 'Female', 0, '1977-09-11', 'Saepe doloremque del', 'Quis et dignissimos');

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
  `is_verified` tinyint(1) NOT NULL,
  `comment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `employer_id`, `document_type`, `document_file`, `created_at`, `is_verified`, `comment`) VALUES
(1, 3, 'hoddies', 'documents/Final-presentation-aprroval.pdf', '2025-03-20 00:00:00.000000', 0, ''),
(2, 3, 'hoddies1', 'documents/solicit1.pdf', '2025-03-31 00:00:00.000000', 0, '');

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
(3, 'Azure', '$2y$10$vwSz.nuPSNc6Yfx048oCMOu90wIaqoUoeHf3hP9yos81Xft75w4BW', 'ict1mercado.cdlb@gmail.com', 1, '843947', '2025-03-03 09:21:48.000000', '', '0000-00-00 00:00:00.000000', '', 'Mark Lawrence ', 'Mercado1', 'Seth Aguirre', 'Newton Wilder Co', '09915209066', 'Natus maxime velit qsss', 'Nulla cillum enim pa', '09162602288', 'dapiv@mailinator.com', '', 'uploads/Azure/ma.jpg'),
(4, 'rirohu', '$2y$10$4QfAz7dgrDG.gdJ9FmSBhus3mjZbCZwr7oUPfA1sbLnTXbLXIckgG', 'zipexabuh@mailinator.com', 0, '841060', '2025-04-04 15:00:36.000000', '', '0000-00-00 00:00:00.000000', 'local_lb', 'Tatum', 'Alvarez', 'Ezekiel Richardson', 'Wilkins Howell LLC', '87', 'Ea non delectus nos', 'Lorem aspernatur ven', '905', 'cicevitox@mailinator.com', '', 'uploads/Ezekiel_Richardson/Capture.PNG'),
(5, 'xiteba', '$2y$10$NV.NKYp0QBiAIVm0btz7kO0rAfMaGtuKz.Fg93JrHx0EVaBAbKIwG', 'fepuloriw@mailinator.com', 0, '107404', '2025-04-11 15:20:02.000000', '', '0000-00-00 00:00:00.000000', 'Overseas', 'Lamar', 'Fry', 'Emerald Hawkins', 'Shaffer and Richardson Trading', '84', 'Quia id ullamco aut', 'Qui dolores cupidita', '475', 'boziror@mailinator.com', '', 'uploads/Emerald_Hawkins/peso24.PNG');

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
(17, 2, 'Investor Division Administrator', 'David Bosco', 'contract', '121', 'Human Markets Executive', '', 505, 'Cupiditate pariatur quaerat ad consequuntur soluta tenetur aliquam.', 'consequatur praesentium nam', 'Velit aspernatur ipsa impedit neque repellat adipisci suscipit possimus.', 'Quod expedita sit laudantium nemo veritatis laboriosam quidem.', '2025-02-26', 1),
(18, 2, 'Internal Program Consultant', 'David Bosco', 'contract', '20000', 'National Usability Coordinator', '', 239, 'Aperiam nisi minima placeat.', 'officiis consequuntur eveniet', 'Numquam necessitatibus fugit quo corporis.', 'Reprehenderit facere incidunt dolore blanditiis id.', '2025-02-26', 1),
(19, 3, 'Autem nihil veniam ', 'Seth Aguirre', 'internship', '50', 'Non vero sunt quasi', 'Similique dolor aut ', 931, 'Nihil tempor quia as', 'In laborum quasi sun', 'Id aut ut est iusto ', 'Rerum et non est mol', '2025-03-03', 1),
(20, 3, 'Building maintenance', 'Seth Aguirre', 'part_time', '78978', 'sadfadgshfgh', 'carpentry,Mechanic', 23, 'afdsafagres', 'rtgrgbrtb', 'sresvesrv', 'sdfgsergesrgs', '2025-03-31', 1),
(21, 3, 'lawrence123', 'Seth Aguirre', 'full_time', '23000', 'asdasdasdasd', 'bomba', 2, 'weqeqe', 'asdf', 'asdfaf', 'asdf', '2025-04-03', 1),
(22, 3, 'Security Guard', 'Seth Aguirre', 'full_time', '2000', 'afdsfdsaf', 'asdfsaf', 2, 'asdfsafsaf', 'sgfdsgs', 'sdfg', 'sdfg', '2025-04-04', 1);

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
(15, 5, 'English', 1, 1, 1, 1);

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
  `module_name` varchar(255) NOT NULL,
  `files` varchar(255) NOT NULL,
  `date_created` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `philheath_no` int(255) NOT NULL,
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

INSERT INTO `ofw_profile` (`id`, `otp`, `otp_expiry`, `reset_token`, `reset_token_expiry`, `is_verified`, `username`, `password`, `profile_image`, `last_name`, `first_name`, `middle_name`, `prefix`, `dob`, `sex`, `age`, `civil_status`, `house_address`, `contact_no`, `email`, `sss_no`, `pagibig_no`, `philheath_no`, `passport_no`, `immigration_status`, `educational_background`, `spouse_name`, `spouse_contact`, `fathers_name`, `fathers_address`, `mothers_name`, `mothers_address`, `emergency_contact_name`, `emergency_contact_number`, `occupation`, `income`, `employment_type`, `country`, `employment_form`, `employer_abroad`, `abroad_contact`, `employer_address`, `local_agencies`, `local_agency_no`, `name_local_agency`, `contact_person_local`, `address_local`, `email_personal_local`, `email_company_local`, `agency_abroad`, `contact_abroad`, `agency_person_abroad`, `address_abroad`, `email_abroad_personal`, `email_abroad_company`, `departure_date`, `arrival_date`) VALUES
(6, '518565', '2025-02-19 14:49:49.000000', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', 1, 'Ruth18', '$2y$10$j4z3TSpS/j9gSCtcuw6xc.yzlxbazX8mwnoxU4lmt8LZ/A8IiPUKK', '../uploads/Ruth18/11.jpg', 'Bode', 'Rowland', 'Jailyn Hirthe', '', '2025-03-18', 'male', 0, '', '6985 Breitenberg Shoals', 912345678, 'marklawrencemercado8@gmail.com', 0, 0, 0, 0, '', '', '', 0, '', '', '', '', 0, 0, '', 0, '', '', '', '', 0, '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000'),
(7, '480058', '2025-02-21 14:34:23.000000', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', 1, 'Melany.Volkman', '$2y$10$cJ1RW.agwZBImdHCp.yWuOgr2e9N6QDgSCmMO/ILyFPDAEooukl16', 'uploads/Melany_Volkman/444.jpg', 'qwe', 'qwe', 'qwe', '', '2000-07-11', 'male', 0, '', 'rh45hgfghrdsh', 2147483647, 'pesolosbanos4@gmail.com', 0, 0, 0, 0, '', '', '', 0, '', '', '', '', 0, 0, '', 0, '', '', '', '', 0, '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000'),
(8, '457276', '2025-04-04 15:00:58.000000', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', 0, 'qubamiwuxu', '$2y$10$8KITP8a8MiDepHKAmtFwweFrKDyxD2.TJtAyg5JsE/1ZUvqli3MqO', 'uploads/qubamiwuxu/Capture.PNG', 'Hubbard', 'Rhonda', 'Olga Key', '', '2015-03-11', 'female', 0, '', 'Ipsam occaecat accus', 54, 'butu@mailinator.com', 0, 0, 0, 0, '', '', '', 0, '', '', '', '', 0, 0, '', 0, '', '', '', '', 0, '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000');

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

-- --------------------------------------------------------

--
-- Table structure for table `welding`
--

CREATE TABLE `welding` (
  `id` int(255) NOT NULL,
  `modules_id` varchar(255) NOT NULL,
  `trainees_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for table `cases`
--
ALTER TABLE `cases`
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
-- Indexes for table `trainees_profile`
--
ALTER TABLE `trainees_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `welding`
--
ALTER TABLE `welding`
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
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `applicant_profile`
--
ALTER TABLE `applicant_profile`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `cases`
--
ALTER TABLE `cases`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `current_employee`
--
ALTER TABLE `current_employee`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employer`
--
ALTER TABLE `employer`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `job_post`
--
ALTER TABLE `job_post`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `language_proficiency`
--
ALTER TABLE `language_proficiency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `license`
--
ALTER TABLE `license`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ofw_profile`
--
ALTER TABLE `ofw_profile`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
-- AUTO_INCREMENT for table `trainees_profile`
--
ALTER TABLE `trainees_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `welding`
--
ALTER TABLE `welding`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `work_exp`
--
ALTER TABLE `work_exp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
