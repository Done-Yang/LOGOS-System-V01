-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3000
-- Generation Time: Feb 28, 2024 at 08:55 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_iater01`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` int(15) NOT NULL,
  `group_id` varchar(15) CHARACTER SET utf8 NOT NULL,
  `semester` int(2) NOT NULL,
  `std_id` varchar(15) CHARACTER SET utf8 NOT NULL,
  `sub_id` varchar(15) CHARACTER SET utf8 NOT NULL,
  `note` text DEFAULT NULL,
  `w1_1` float DEFAULT 0,
  `w1_2` float DEFAULT 0,
  `w1_3` float DEFAULT 0,
  `w2_1` float DEFAULT 0,
  `w2_2` float DEFAULT 0,
  `w2_3` float DEFAULT 0,
  `w3_1` float DEFAULT 0,
  `w3_2` float DEFAULT 0,
  `w3_3` float DEFAULT 0,
  `w4_1` float DEFAULT 0,
  `w4_2` float DEFAULT 0,
  `w4_3` float DEFAULT 0,
  `w5_1` float DEFAULT 0,
  `w5_2` float DEFAULT 0,
  `w5_3` float DEFAULT 0,
  `w6_1` float DEFAULT 0,
  `w6_2` float DEFAULT 0,
  `w6_3` float DEFAULT 0,
  `w7_1` float DEFAULT 0,
  `w7_2` float DEFAULT 0,
  `w7_3` float DEFAULT 0,
  `w8_1` float DEFAULT 0,
  `w8_2` float DEFAULT 0,
  `w8_3` float DEFAULT 0,
  `w9_1` float DEFAULT 0,
  `w9_2` float DEFAULT 0,
  `w9_3` float DEFAULT 0,
  `w10_1` float DEFAULT 0,
  `w10_2` float DEFAULT 0,
  `w10_3` float DEFAULT 0,
  `w11_1` float NOT NULL DEFAULT 0,
  `w11_2` float DEFAULT 0,
  `w11_3` float DEFAULT 0,
  `w12_1` float DEFAULT 0,
  `w12_2` float DEFAULT 0,
  `w12_3` float DEFAULT 0,
  `w13_1` float DEFAULT 0,
  `w13_2` float DEFAULT 0,
  `w13_3` float DEFAULT 0,
  `w14_1` float DEFAULT 0,
  `w14_2` float DEFAULT 0,
  `w14_3` float DEFAULT 0,
  `w15_1` float DEFAULT 0,
  `w15_2` float DEFAULT 0,
  `w15_3` float DEFAULT 0,
  `w16_1` float DEFAULT 0,
  `w16_2` float DEFAULT 0,
  `w16_3` float DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `book_id` varchar(250) NOT NULL,
  `book_name` varchar(250) NOT NULL,
  `year` int(10) NOT NULL,
  `program` varchar(50) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `classrooms`
--

CREATE TABLE `classrooms` (
  `id` int(11) NOT NULL,
  `classroom` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `credits`
--

CREATE TABLE `credits` (
  `id` int(11) NOT NULL,
  `credit` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `directors`
--

CREATE TABLE `directors` (
  `dir_id` varchar(15) NOT NULL,
  `u_id` varchar(15) NOT NULL,
  `fname_en` varchar(50) NOT NULL,
  `lname_en` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `fname_la` varchar(50) NOT NULL,
  `lname_la` varchar(50) NOT NULL,
  `fname_ch` varchar(50) DEFAULT NULL,
  `lname_ch` varchar(50) DEFAULT NULL,
  `dob` varchar(50) DEFAULT NULL,
  `nation` varchar(50) DEFAULT NULL,
  `religion` varchar(50) DEFAULT NULL,
  `ethnicity` varchar(50) DEFAULT NULL,
  `tel` varchar(15) NOT NULL,
  `whatsapp` varchar(15) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `emergency_tel` varchar(15) DEFAULT NULL,
  `emergency_name` varchar(50) DEFAULT NULL,
  `village_birth` varchar(50) DEFAULT NULL,
  `district_birth` varchar(50) DEFAULT NULL,
  `province_birth` varchar(50) DEFAULT NULL,
  `village_current` varchar(50) DEFAULT NULL,
  `district_current` varchar(50) DEFAULT NULL,
  `province_current` varchar(50) DEFAULT NULL,
  `house_unit` varchar(10) DEFAULT NULL,
  `house_no` varchar(10) DEFAULT NULL,
  `edu_level1` varchar(100) DEFAULT NULL,
  `edu_branch1` varchar(100) DEFAULT NULL,
  `univ_name1` varchar(100) DEFAULT NULL,
  `edu_district1` varchar(50) DEFAULT NULL,
  `edu_province1` varchar(50) DEFAULT NULL,
  `edu_season1` varchar(15) DEFAULT NULL,
  `edu_level2` varchar(100) DEFAULT NULL,
  `edu_branch2` varchar(100) DEFAULT NULL,
  `univ_name2` varchar(100) DEFAULT NULL,
  `edu_district2` varchar(50) DEFAULT NULL,
  `edu_province2` varchar(50) DEFAULT NULL,
  `edu_season2` varchar(15) DEFAULT NULL,
  `employment_history` varchar(255) DEFAULT NULL,
  `language_proficiency` varchar(255) DEFAULT NULL,
  `talent` varchar(50) DEFAULT NULL,
  `familymatters` varchar(255) DEFAULT NULL,
  `plansforthefuture` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `group_id` varchar(15) NOT NULL,
  `program` varchar(50) DEFAULT NULL,
  `semester` int(10) NOT NULL,
  `part` varchar(50) DEFAULT NULL,
  `season` varchar(15) DEFAULT NULL,
  `year` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `no` int(11) NOT NULL,
  `id` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `hp` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `career` text NOT NULL,
  `name_save` varchar(225) NOT NULL,
  `name_orig` varchar(225) NOT NULL,
  `name1_save` varchar(225) NOT NULL,
  `name1_orig` varchar(225) NOT NULL,
  `level` int(10) NOT NULL,
  `homepage` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `officers`
--

CREATE TABLE `officers` (
  `off_id` varchar(15) NOT NULL,
  `u_id` varchar(15) NOT NULL,
  `fname_en` varchar(50) NOT NULL,
  `lname_en` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `fname_la` varchar(50) NOT NULL,
  `lname_la` varchar(50) NOT NULL,
  `fname_ch` varchar(50) DEFAULT NULL,
  `lname_ch` varchar(50) DEFAULT NULL,
  `dob` varchar(50) DEFAULT NULL,
  `nation` varchar(50) DEFAULT NULL,
  `religion` varchar(50) DEFAULT NULL,
  `ethnicity` varchar(50) DEFAULT NULL,
  `tel` varchar(15) NOT NULL,
  `whatsapp` varchar(15) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `emergency_tel` varchar(15) DEFAULT NULL,
  `emergency_name` varchar(50) DEFAULT NULL,
  `village_birth` varchar(50) DEFAULT NULL,
  `district_birth` varchar(50) DEFAULT NULL,
  `province_birth` varchar(50) DEFAULT NULL,
  `village_current` varchar(50) DEFAULT NULL,
  `district_current` varchar(50) DEFAULT NULL,
  `province_current` varchar(50) DEFAULT NULL,
  `house_unit` varchar(10) DEFAULT NULL,
  `house_no` varchar(10) DEFAULT NULL,
  `edu_level1` varchar(100) DEFAULT NULL,
  `edu_branch1` varchar(100) DEFAULT NULL,
  `univ_name1` varchar(100) DEFAULT NULL,
  `edu_district1` varchar(50) DEFAULT NULL,
  `edu_province1` varchar(50) DEFAULT NULL,
  `edu_season1` varchar(15) DEFAULT NULL,
  `edu_level2` varchar(100) DEFAULT NULL,
  `edu_branch2` varchar(100) DEFAULT NULL,
  `univ_name2` varchar(100) DEFAULT NULL,
  `edu_district2` varchar(50) DEFAULT NULL,
  `edu_province2` varchar(50) DEFAULT NULL,
  `edu_season2` varchar(15) DEFAULT NULL,
  `employment_history` varchar(255) DEFAULT NULL,
  `language_proficiency` varchar(255) DEFAULT NULL,
  `talent` varchar(50) DEFAULT NULL,
  `familymatters` varchar(255) DEFAULT NULL,
  `plansforthefuture` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` int(15) NOT NULL,
  `program` varchar(50) NOT NULL,
  `total_year` int(5) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE `scores` (
  `id` int(15) NOT NULL,
  `group_id` varchar(15) NOT NULL,
  `std_id` varchar(15) NOT NULL,
  `sub_id` varchar(15) NOT NULL,
  `semester` int(2) NOT NULL,
  `season` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `activities` float DEFAULT NULL,
  `behavire` float DEFAULT NULL,
  `attending` float DEFAULT 0,
  `midterm_ex` float DEFAULT NULL,
  `final_ex` float DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `seasons`
--

CREATE TABLE `seasons` (
  `id` int(15) NOT NULL,
  `season` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `semesters`
--

CREATE TABLE `semesters` (
  `id` int(11) NOT NULL,
  `semester` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `star_students`
--

CREATE TABLE `star_students` (
  `id` int(11) NOT NULL,
  `std_id` varchar(15) NOT NULL,
  `total_score` varchar(15) NOT NULL,
  `grade` varchar(5) NOT NULL,
  `group_id` varchar(15) NOT NULL,
  `program` varchar(50) NOT NULL,
  `season` varchar(15) NOT NULL,
  `year` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `studentgroups`
--

CREATE TABLE `studentgroups` (
  `std_group_id` int(15) NOT NULL,
  `group_id` varchar(15) NOT NULL,
  `t_id` varchar(15) DEFAULT NULL,
  `std_id` varchar(15) DEFAULT NULL,
  `program` varchar(50) DEFAULT NULL,
  `season` varchar(15) DEFAULT NULL,
  `year` varchar(10) NOT NULL,
  `part` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `std_id` varchar(15) NOT NULL,
  `u_id` varchar(15) NOT NULL,
  `fname_en` varchar(50) NOT NULL,
  `lname_en` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `fname_la` varchar(50) NOT NULL,
  `lname_la` varchar(50) NOT NULL,
  `program` varchar(50) DEFAULT NULL,
  `season_start` varchar(15) DEFAULT NULL,
  `season_curent` varchar(15) NOT NULL,
  `fname_ch` varchar(50) DEFAULT NULL,
  `lname_ch` varchar(50) DEFAULT NULL,
  `hsk` float DEFAULT NULL,
  `dob` varchar(50) DEFAULT NULL,
  `part` varchar(50) NOT NULL,
  `nation` varchar(50) DEFAULT NULL,
  `religion` varchar(50) DEFAULT NULL,
  `ethnicity` varchar(50) DEFAULT NULL,
  `tel` varchar(15) NOT NULL,
  `whatsapp` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `guardian_tel` varchar(15) DEFAULT NULL,
  `village_birth` varchar(50) DEFAULT NULL,
  `district_birth` varchar(50) DEFAULT NULL,
  `province_birth` varchar(50) DEFAULT NULL,
  `village_current` varchar(50) DEFAULT NULL,
  `district_current` varchar(50) DEFAULT NULL,
  `province_current` varchar(50) DEFAULT NULL,
  `house_unit` varchar(10) DEFAULT NULL,
  `house_no` varchar(10) DEFAULT NULL,
  `highschool` varchar(50) DEFAULT NULL,
  `season_hsc` varchar(15) DEFAULT NULL,
  `district_study` varchar(50) DEFAULT NULL,
  `province_study` varchar(50) DEFAULT NULL,
  `employment_history` varchar(255) DEFAULT NULL,
  `language_proficiency` varchar(255) DEFAULT NULL,
  `talent` varchar(50) DEFAULT NULL,
  `familymatters` varchar(255) DEFAULT NULL,
  `plansforthefuture` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `std_status` varchar(50) NOT NULL DEFAULT 'Studying',
  `group_status` varchar(15) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `students`
--
DELIMITER $$
CREATE TRIGGER `timestamp` BEFORE INSERT ON `students` FOR EACH ROW BEGIN

SET new.updated_at = CONVERT_TZ(CURRENT_TIMESTAMP(), '+00:00', '+07:00' );

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `sub_id` varchar(15) NOT NULL,
  `name` varchar(50) NOT NULL,
  `program` varchar(50) DEFAULT NULL,
  `season` varchar(15) DEFAULT NULL,
  `credit` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `t_id` varchar(15) NOT NULL,
  `u_id` varchar(15) NOT NULL,
  `fname_en` varchar(50) NOT NULL,
  `lname_en` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `fname_la` varchar(50) NOT NULL,
  `lname_la` varchar(50) NOT NULL,
  `t_type` varchar(50) DEFAULT NULL,
  `fname_ch` varchar(50) DEFAULT NULL,
  `lname_ch` varchar(50) DEFAULT NULL,
  `dob` varchar(50) DEFAULT NULL,
  `nation` varchar(50) NOT NULL,
  `religion` varchar(50) DEFAULT NULL,
  `ethnicity` varchar(50) DEFAULT NULL,
  `tel` varchar(15) NOT NULL,
  `whatsapp` varchar(15) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `emergency_tel` varchar(15) DEFAULT NULL,
  `emergency_name` varchar(50) DEFAULT NULL,
  `village_birth` varchar(50) DEFAULT NULL,
  `district_birth` varchar(50) DEFAULT NULL,
  `province_birth` varchar(50) DEFAULT NULL,
  `village_current` varchar(50) DEFAULT NULL,
  `district_current` varchar(50) DEFAULT NULL,
  `province_current` varchar(50) DEFAULT NULL,
  `house_unit` varchar(10) DEFAULT NULL,
  `house_no` varchar(10) DEFAULT NULL,
  `edu_level1` varchar(100) DEFAULT NULL,
  `edu_branch1` varchar(100) DEFAULT NULL,
  `univ_name1` varchar(100) DEFAULT NULL,
  `edu_district1` varchar(50) DEFAULT NULL,
  `edu_province1` varchar(50) DEFAULT NULL,
  `edu_season1` varchar(15) DEFAULT NULL,
  `edu_level2` varchar(100) DEFAULT NULL,
  `edu_branch2` varchar(100) DEFAULT NULL,
  `univ_name2` varchar(100) DEFAULT NULL,
  `edu_district2` varchar(50) DEFAULT NULL,
  `edu_province2` varchar(50) DEFAULT NULL,
  `edu_season2` varchar(15) DEFAULT NULL,
  `employment_history` varchar(255) DEFAULT NULL,
  `language_proficiency` varchar(255) DEFAULT NULL,
  `talent` varchar(50) DEFAULT NULL,
  `familymatters` varchar(255) DEFAULT NULL,
  `plansforthefuture` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `t_status` varchar(50) NOT NULL DEFAULT 'Working',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `timetables`
--

CREATE TABLE `timetables` (
  `t_t_id` int(15) NOT NULL,
  `sub1_id` varchar(15) DEFAULT NULL,
  `sub2_id` varchar(15) DEFAULT NULL,
  `book1` varchar(100) DEFAULT NULL,
  `book2` varchar(100) DEFAULT NULL,
  `teacher1_id` varchar(15) DEFAULT NULL,
  `teacher2_id` varchar(15) DEFAULT NULL,
  `group_id` varchar(15) NOT NULL,
  `class1` varchar(15) DEFAULT NULL,
  `class2` varchar(15) DEFAULT NULL,
  `season` varchar(15) NOT NULL,
  `times1` varchar(50) DEFAULT NULL,
  `times2` varchar(50) DEFAULT NULL,
  `program` varchar(50) NOT NULL,
  `year` int(5) NOT NULL,
  `part` varchar(50) NOT NULL,
  `semester` int(5) NOT NULL,
  `days` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `tel` varchar(15) NOT NULL,
  `u_pass` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `program` (`program`);

--
-- Indexes for table `classrooms`
--
ALTER TABLE `classrooms`
  ADD PRIMARY KEY (`classroom`) USING BTREE,
  ADD KEY `id` (`id`);

--
-- Indexes for table `credits`
--
ALTER TABLE `credits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `directors`
--
ALTER TABLE `directors`
  ADD PRIMARY KEY (`dir_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phonenumber` (`tel`),
  ADD UNIQUE KEY `u_id` (`u_id`) USING BTREE,
  ADD UNIQUE KEY `whatsappnumber` (`whatsapp`),
  ADD UNIQUE KEY `emergency_tel` (`emergency_tel`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`group_id`) USING BTREE,
  ADD KEY `program` (`program`),
  ADD KEY `season` (`season`,`year`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `officers`
--
ALTER TABLE `officers`
  ADD PRIMARY KEY (`off_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phonenumber` (`tel`),
  ADD UNIQUE KEY `u_id` (`u_id`) USING BTREE,
  ADD UNIQUE KEY `whatsappnumber` (`whatsapp`),
  ADD UNIQUE KEY `emergency_tel` (`emergency_tel`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`program`),
  ADD KEY `id` (`id`) USING BTREE;

--
-- Indexes for table `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_group_id` (`group_id`,`sub_id`),
  ADD KEY `sub_id` (`sub_id`),
  ADD KEY `std_id` (`std_id`);

--
-- Indexes for table `seasons`
--
ALTER TABLE `seasons`
  ADD PRIMARY KEY (`season`) USING BTREE,
  ADD KEY `id` (`id`) USING BTREE;

--
-- Indexes for table `semesters`
--
ALTER TABLE `semesters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `star_students`
--
ALTER TABLE `star_students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentgroups`
--
ALTER TABLE `studentgroups`
  ADD PRIMARY KEY (`std_group_id`),
  ADD KEY `t_class_id` (`t_id`),
  ADD KEY `std_id` (`std_id`),
  ADD KEY `season` (`season`),
  ADD KEY `program` (`program`),
  ADD KEY `class_group_id` (`group_id`) USING BTREE;

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`std_id`),
  ADD UNIQUE KEY `phonenumber` (`tel`),
  ADD UNIQUE KEY `u_id` (`u_id`) USING BTREE,
  ADD UNIQUE KEY `whatsappnumber` (`whatsapp`),
  ADD KEY `program` (`program`),
  ADD KEY `season_start` (`season_start`),
  ADD KEY `season_curent` (`season_curent`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`sub_id`),
  ADD KEY `season` (`season`),
  ADD KEY `program` (`program`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`t_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phonenumber` (`tel`),
  ADD UNIQUE KEY `u_id` (`u_id`) USING BTREE,
  ADD UNIQUE KEY `whatsappnumber` (`whatsapp`),
  ADD UNIQUE KEY `emergency_tel` (`emergency_tel`);

--
-- Indexes for table `timetables`
--
ALTER TABLE `timetables`
  ADD PRIMARY KEY (`t_t_id`),
  ADD KEY `sub1_id` (`sub1_id`,`sub2_id`,`teacher1_id`,`teacher2_id`,`group_id`,`class1`,`class2`,`season`),
  ADD KEY `teacher_id1` (`teacher1_id`),
  ADD KEY `sub2_id` (`sub2_id`),
  ADD KEY `teacher2_id` (`teacher2_id`),
  ADD KEY `class1` (`class1`),
  ADD KEY `class2` (`class2`),
  ADD KEY `program` (`program`),
  ADD KEY `season` (`season`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `tel` (`tel`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `classrooms`
--
ALTER TABLE `classrooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `credits`
--
ALTER TABLE `credits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `scores`
--
ALTER TABLE `scores`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4008;

--
-- AUTO_INCREMENT for table `seasons`
--
ALTER TABLE `seasons`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `semesters`
--
ALTER TABLE `semesters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `star_students`
--
ALTER TABLE `star_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `studentgroups`
--
ALTER TABLE `studentgroups`
  MODIFY `std_group_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=687;

--
-- AUTO_INCREMENT for table `timetables`
--
ALTER TABLE `timetables`
  MODIFY `t_t_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=306;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`program`) REFERENCES `programs` (`program`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `directors`
--
ALTER TABLE `directors`
  ADD CONSTRAINT `directors_ibfk_3` FOREIGN KEY (`u_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`program`) REFERENCES `programs` (`program`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `groups_ibfk_2` FOREIGN KEY (`season`) REFERENCES `seasons` (`season`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `officers`
--
ALTER TABLE `officers`
  ADD CONSTRAINT `officers_ibfk_3` FOREIGN KEY (`u_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `scores`
--
ALTER TABLE `scores`
  ADD CONSTRAINT `scores_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `studentgroups`
--
ALTER TABLE `studentgroups`
  ADD CONSTRAINT `studentgroups_ibfk_1` FOREIGN KEY (`t_id`) REFERENCES `teachers` (`t_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `studentgroups_ibfk_2` FOREIGN KEY (`program`) REFERENCES `programs` (`program`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `studentgroups_ibfk_3` FOREIGN KEY (`std_id`) REFERENCES `students` (`std_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `studentgroups_ibfk_4` FOREIGN KEY (`season`) REFERENCES `seasons` (`season`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `studentgroups_ibfk_5` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`program`) REFERENCES `programs` (`program`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `students_ibfk_3` FOREIGN KEY (`season_start`) REFERENCES `seasons` (`season`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_2` FOREIGN KEY (`program`) REFERENCES `programs` (`program`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `subjects_ibfk_3` FOREIGN KEY (`season`) REFERENCES `seasons` (`season`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_3` FOREIGN KEY (`u_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `timetables`
--
ALTER TABLE `timetables`
  ADD CONSTRAINT `timetables_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
