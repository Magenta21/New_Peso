-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2025 at 11:23 AM
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
(1, 'Admin', '$2y$10$O1E2P/Xg2P0p.J8U83uDpOVSH6RwWVoreghhHmssDJpwSkJsoq4Na', '73ijnn12uw@wyoxafp.com', 'Lydia', 'Walker', 'Elaine Murphy', 0, 561, 'Et architecto volupt', '890257', '', '2025-07-11 10:16:09.806518', 1, '../uploads/Admin/474043763_2836446049861869_694324624727446876_n.jpg'),
(2, 'Admin', '$2y$10$3ev96ibfOjkS4u9bGFbR5.Bnaiv9I2SnTFC7d0aJM9VrB3K86sCza', '73ijnn12uw@wyoxafp.com', 'Lydia', 'Walker', 'Elaine Murphy', 0, 561, 'Et architecto volupt', '890257', '', '2025-07-11 10:16:09.806518', 1, '../uploads/Admin/474043763_2836446049861869_694324624727446876_n.jpg');

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
  `grad_course` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `company_photo` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `arrival_date` datetime(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `save_job`
--

CREATE TABLE `save_job` (
  `id` int(255) NOT NULL,
  `job_id` int(255) NOT NULL,
  `applicant_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_applications`
--

CREATE TABLE `service_applications` (
  `id` int(11) NOT NULL,
  `service_type` varchar(50) NOT NULL COMMENT 'TUPAD, Livelihood, or SPES',
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `suffix` varchar(10) DEFAULT NULL,
  `birthdate` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `address` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `id_type` varchar(50) NOT NULL COMMENT 'Type of government ID provided',
  `id_number` varchar(50) NOT NULL COMMENT 'ID number',
  `purpose` text NOT NULL COMMENT 'Applicant''s purpose for applying',
  `agree_terms` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 if terms agreed',
  `application_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Approved','Rejected','Processing') DEFAULT 'Pending',
  `notes` text DEFAULT NULL COMMENT 'Admin notes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_applications`
--

INSERT INTO `service_applications` (`id`, `service_type`, `first_name`, `last_name`, `middle_name`, `suffix`, `birthdate`, `gender`, `address`, `email`, `phone`, `id_type`, `id_number`, `purpose`, `agree_terms`, `application_date`, `status`, `notes`) VALUES
(1, 'SPES', 'Beverly', 'Orn', 'Humberto Stokes', 'Perferendi', '2025-01-04', 'Female', '22439 Paolo Bridge', 'your.email+fakedata19021@gmail.com', '+639915209066', 'Postal ID', '535', 'Quibusdam quidem soluta repellat commodi a.', 1, '2025-07-11 12:56:27', 'Approved', NULL);

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
-- Indexes for table `service_applications`
--
ALTER TABLE `service_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_service_type` (`service_type`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_application_date` (`application_date`);

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
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `applicant_profile`
--
ALTER TABLE `applicant_profile`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `applied_job`
--
ALTER TABLE `applied_job`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cases`
--
ALTER TABLE `cases`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `current_employee`
--
ALTER TABLE `current_employee`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employer`
--
ALTER TABLE `employer`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `interview`
--
ALTER TABLE `interview`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_post`
--
ALTER TABLE `job_post`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language_proficiency`
--
ALTER TABLE `language_proficiency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `license`
--
ALTER TABLE `license`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ofw_profile`
--
ALTER TABLE `ofw_profile`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `save_job`
--
ALTER TABLE `save_job`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_applications`
--
ALTER TABLE `service_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `trainee_status_history`
--
ALTER TABLE `trainee_status_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `trainee_trainings`
--
ALTER TABLE `trainee_trainings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `training`
--
ALTER TABLE `training`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `work_exp`
--
ALTER TABLE `work_exp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
