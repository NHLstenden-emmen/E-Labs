-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2020 at 11:15 AM
-- Server version: 10.4.16-MariaDB-log
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-labs`
--

-- --------------------------------------------------------

--
-- Table structure for table `lab_journal`
--

CREATE TABLE `lab_journal` (
  `labjournaal_id` int(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `theory` varchar(2000) NOT NULL,
  `safety` varchar(2000) NOT NULL,
  `creater_id` int(10) NOT NULL,
  `logboek` varchar(2000) NOT NULL,
  `method_materials` varchar(2000) NOT NULL,
  `submitted` tinyint(1) NOT NULL,
  `grade` int(2) NOT NULL,
  `year` int(11) NOT NULL,
  `Attachment` varchar(100) NOT NULL,
  `Goal` varchar(2000) NOT NULL,
  `Hypothesis` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lab_journal_users`
--

CREATE TABLE `lab_journal_users` (
  `user_id` int(10) NOT NULL,
  `lab_journal_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `meldingen`
--

CREATE TABLE `meldingen` (
  `creater` int(10) NOT NULL,
  `viewer` int(10) NOT NULL,
  `title` varchar(50) NOT NULL,
  `message` varchar(2000) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `preparation`
--

CREATE TABLE `preparation` (
  `preparation_id` int(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `materials` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `creater_id` int(10) NOT NULL,
  `hypothesis` varchar(255) NOT NULL,
  `device settings` varchar(255) NOT NULL,
  `grade` int(2) NOT NULL,
  `year` int(1) NOT NULL,
  `safety` varchar(255) NOT NULL,
  `preparation_questions` varchar(255) NOT NULL,
  `goal` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `preperation_users`
--

CREATE TABLE `preperation_users` (
  `user_id` int(10) NOT NULL,
  `preperation_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(73) NOT NULL,
  `user_number` int(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) NOT NULL,
  `lang` varchar(10) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `user_number`, `password`, `profile_picture`, `lang`, `role`) VALUES
(1, 'Kevin', 'email@mailtje.com', 123456, 'test', '', '', 'Student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lab_journal`
--
ALTER TABLE `lab_journal`
  ADD PRIMARY KEY (`labjournaal_id`),
  ADD KEY `Creater` (`creater_id`);

--
-- Indexes for table `lab_journal_users`
--
ALTER TABLE `lab_journal_users`
  ADD KEY `lab_journal_id` (`lab_journal_id`),
  ADD KEY `lab_journal_users_ibfk_2` (`user_id`);

--
-- Indexes for table `meldingen`
--
ALTER TABLE `meldingen`
  ADD KEY `crea` (`creater`),
  ADD KEY `viewer` (`viewer`);

--
-- Indexes for table `preparation`
--
ALTER TABLE `preparation`
  ADD PRIMARY KEY (`preparation_id`),
  ADD UNIQUE KEY `creater_id` (`creater_id`);

--
-- Indexes for table `preperation_users`
--
ALTER TABLE `preperation_users`
  ADD KEY `preperation_id` (`preperation_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`,`user_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lab_journal`
--
ALTER TABLE `lab_journal`
  ADD CONSTRAINT `Creater` FOREIGN KEY (`creater_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `lab_journal_users`
--
ALTER TABLE `lab_journal_users`
  ADD CONSTRAINT `lab_journal_users_ibfk_1` FOREIGN KEY (`lab_journal_id`) REFERENCES `lab_journal` (`labjournaal_id`),
  ADD CONSTRAINT `lab_journal_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `meldingen`
--
ALTER TABLE `meldingen`
  ADD CONSTRAINT `crea` FOREIGN KEY (`creater`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `meldingen_ibfk_1` FOREIGN KEY (`viewer`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `preparation`
--
ALTER TABLE `preparation`
  ADD CONSTRAINT `preparation_ibfk_1` FOREIGN KEY (`creater_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `preperation_users`
--
ALTER TABLE `preperation_users`
  ADD CONSTRAINT `preperation_users_ibfk_1` FOREIGN KEY (`preperation_id`) REFERENCES `preparation` (`preparation_id`),
  ADD CONSTRAINT `preperation_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
