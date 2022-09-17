-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2022 at 05:57 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sched_d_b`
--

-- --------------------------------------------------------

--
-- Table structure for table `class_schedule_info`
--

CREATE TABLE `class_schedule_info` (
  `id` int(30) NOT NULL,
  `schedule_id` int(30) NOT NULL,
  `course_id` int(30) NOT NULL,
  `subject` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(30) NOT NULL,
  `course` varchar(200) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course`, `description`) VALUES
(7, 'BSCpE', 'Bachelor of Science in Computer Engineering');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `id` int(200) NOT NULL,
  `id_no` varchar(200) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `status` varchar(10) NOT NULL,
  `Tload` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`id`, `id_no`, `firstname`, `middlename`, `lastname`, `contact`, `gender`, `address`, `email`, `status`, `Tload`) VALUES
(15, '62992343', 'Leomel', 'M.', 'Abas', '091234567891', 'Male', 'Tanauan City Batangas', 'sample@gmail.com', 'Part-time', 5);

-- --------------------------------------------------------

--
-- Table structure for table `rooms_org`
--

CREATE TABLE `rooms_org` (
  `id` int(30) NOT NULL,
  `room` varchar(200) NOT NULL,
  `descript` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rooms_org`
--

INSERT INTO `rooms_org` (`id`, `room`, `descript`) VALUES
(12, 'Room 402', '');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(255) NOT NULL,
  `faculty_id` int(30) NOT NULL,
  `Csub_id` varchar(300) NOT NULL,
  `yr_sec` varchar(300) NOT NULL,
  `title` varchar(200) NOT NULL,
  `schedule_type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1= class, 2= meeting,3=others',
  `description` text NOT NULL,
  `location` text NOT NULL,
  `is_repeating` tinyint(1) NOT NULL DEFAULT 1,
  `D_counter` varchar(300) NOT NULL,
  `repeating_data` text NOT NULL,
  `schedule_date` date NOT NULL,
  `time_from` time NOT NULL,
  `time_to` time NOT NULL,
  `th` int(255) NOT NULL,
  `sem_id` varchar(300) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `faculty_id`, `Csub_id`, `yr_sec`, `title`, `schedule_type`, `description`, `location`, `is_repeating`, `D_counter`, `repeating_data`, `schedule_date`, `time_from`, `time_to`, `th`, `sem_id`, `date_created`) VALUES
(19, 15, '7', '1A', '1', 1, 'QWE', 'Room 402', 1, '1', '{\"start\":\"2022-01-01\",\"end\":\"2022-05-31\"}', '0000-00-00', '18:00:00', '21:00:00', 3, '1', '2022-02-03 00:29:54'),
(20, 15, '7', '1A', '2', 1, 'ASD', 'Room 402', 1, '1', '{\"start\":\"2022-01-01\",\"end\":\"2022-05-31\"}', '0000-00-00', '16:00:00', '18:00:00', 2, '1', '2022-02-03 00:31:47');

-- --------------------------------------------------------

--
-- Table structure for table `sday`
--

CREATE TABLE `sday` (
  `id` int(200) NOT NULL,
  `days` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sday`
--

INSERT INTO `sday` (`id`, `days`) VALUES
(1, 'Monday'),
(2, 'Tuesday'),
(3, 'Wednesday'),
(4, 'Thursday'),
(5, 'Friday'),
(6, 'Saturday'),
(7, 'Sunday');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(255) NOT NULL,
  `section` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `section`) VALUES
(1, '1A'),
(2, '1B'),
(3, '1C'),
(4, '2A'),
(5, '2B'),
(6, '2C'),
(7, '3A'),
(8, '3B'),
(9, '3C'),
(10, '4A'),
(11, '4B'),
(12, '4C'),
(13, '5A'),
(14, '5B'),
(15, '5C');

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `id` int(255) NOT NULL,
  `semval` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`id`, `semval`) VALUES
(1, '1st Semester'),
(2, '2nd Semester'),
(3, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(30) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subject`, `description`) VALUES
(1, 'DBMS', 'Database Management System'),
(2, 'Mathematics', 'Mathematics'),
(3, 'English', 'English'),
(4, 'Computer Hardware', 'Computer Hardware'),
(5, 'History', 'History');

-- --------------------------------------------------------

--
-- Table structure for table `subject_global`
--

CREATE TABLE `subject_global` (
  `id` int(30) NOT NULL,
  `course_id` varchar(500) NOT NULL,
  `CPE1_Code` varchar(200) NOT NULL,
  `CPE1_SUBJ_Code` varchar(500) NOT NULL,
  `CPE1_SUBJ_Descript` text NOT NULL,
  `CPE1_Units` varchar(200) NOT NULL,
  `CPE1_Lec` varchar(200) NOT NULL,
  `CPE1_Lab` varchar(200) NOT NULL,
  `CPE1_Sec` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subject_global`
--

INSERT INTO `subject_global` (`id`, `course_id`, `CPE1_Code`, `CPE1_SUBJ_Code`, `CPE1_SUBJ_Descript`, `CPE1_Units`, `CPE1_Lec`, `CPE1_Lab`, `CPE1_Sec`) VALUES
(1, '4', '94', 'CPEN01', 'Computer Engineering as a Discipline', '1', '1', '0', 'A'),
(2, '1', '96', 'CPEN02', 'Programming Logic and Design', '2', '0', '6', 'A'),
(3, '1', '157', 'FILI01', 'Filipino sa Iba\'t Ibang Disiplina', '3', '3', '0', 'E'),
(4, '1', '172', 'GENE01', 'Understanding the Self', '3', '3', '0', 'C'),
(5, '1', '181', 'GENE02', 'Readings in Philippine History', '3', '3', '0', 'C'),
(6, '1', '214', 'MATH01', 'Calculus 1', '3', '3', '0', 'A'),
(7, '1', '224', 'NSCI01', 'Chemistry for Engineers', '4', '3', '3', 'A'),
(8, '1', '226', 'NSTP01', 'LTS/MS 11', '3', '3', '0', 'A'),
(9, '1', '249', 'PHED01', 'Self Testing Activities', '2', '2', '0', 'C'),
(10, '1', '270', 'TCCR01', 'Mabini\'s Life, Works and Writings', '2', '2', '0', 'C'),
(14, '1', '194', 'CLEC03', 'Computer Science', '3', '2', '3', 'B'),
(15, '4', '87', 'CLEC03', 'Computer System', '4', '2', '5', 'A'),
(16, '1', '54', 'PE', 'physical education', '3', '2', '2', 'A'),
(17, '1', '86', 'SEM11', 'TOUR AND TRAVEL', '3', '3', 'b', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_load`
--

CREATE TABLE `teacher_load` (
  `id` int(10) NOT NULL,
  `Load_id` int(10) NOT NULL,
  `Units` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacher_load`
--

INSERT INTO `teacher_load` (`id`, `Load_id`, `Units`) VALUES
(1, 1, 21),
(2, 2, 3),
(3, 3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `trial`
--

CREATE TABLE `trial` (
  `id` int(5) NOT NULL,
  `subj_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `trial`
--

INSERT INTO `trial` (`id`, `subj_id`) VALUES
(1, 6),
(2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 3 COMMENT '1=Admin,2=Staff, 3= subscriber'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `type`) VALUES
(2, 'Administrator', 'admin', '0192023a7bbd73250516f069df18b500', 1),
(3, 'matet prenda', 'BSCPE head', '371db6d80205b0164ed02c60bb3730ea', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class_schedule_info`
--
ALTER TABLE `class_schedule_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms_org`
--
ALTER TABLE `rooms_org`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sday`
--
ALTER TABLE `sday`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject_global`
--
ALTER TABLE `subject_global`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_load`
--
ALTER TABLE `teacher_load`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trial`
--
ALTER TABLE `trial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class_schedule_info`
--
ALTER TABLE `class_schedule_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `rooms_org`
--
ALTER TABLE `rooms_org`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `sday`
--
ALTER TABLE `sday`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subject_global`
--
ALTER TABLE `subject_global`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `teacher_load`
--
ALTER TABLE `teacher_load`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `trial`
--
ALTER TABLE `trial`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
