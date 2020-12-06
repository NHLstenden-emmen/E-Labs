-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2020 at 11:55 PM
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
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(10) NOT NULL,
  `creater` int(10) NOT NULL,
  `viewer` int(10) DEFAULT NULL,
  `title` varchar(50) NOT NULL,
  `message` varchar(2000) NOT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `creater`, `viewer`, `title`, `message`, `date_time`) VALUES
(1, 1, 1, 'title voor kevin', 'verhaaltje voor kevin', '2020-09-10 14:20:13'),
(2, 1, NULL, 'title voor iedereen', 'verhaaltje voor iedereen', '2020-11-10 17:46:13');

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
  `lang` varchar(2) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `user_number`, `password`, `profile_picture`, `lang`, `role`) VALUES
(1, 'Kevin', 'email@mailtje.com', 123456, '$2y$12$x1mzfqUZcEBFkCvhKRt35.SBs5RLRD0D.PZVzyXmBrOXBDXQepF92', '', '', 'Student'),
(2, 'mike', 'mikie@mikel.com', 444318, '$2y$12$cTqvLHlsL/PmgCF/F8o4rOpq33St9IwVNs7bLjB79QBp4Hraodlsa', '', '', 'Docent');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lab_journal`
--
ALTER TABLE `lab_journal`
  ADD PRIMARY KEY (`labjournaal_id`),
  ADD KEY `link creater id to user` (`creater_id`);

--
-- Indexes for table `lab_journal_users`
--
ALTER TABLE `lab_journal_users`
  ADD KEY `link labjournaal tussen  user to user id` (`user_id`),
  ADD KEY `link labjournaal id tussen to labjournaal id` (`lab_journal_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `link creater to user id` (`creater`),
  ADD KEY `link viewer to user id` (`viewer`);

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
  ADD KEY `preperation_link additional user to user` (`user_id`),
  ADD KEY `preperation_link additional id to preperation` (`preperation_id`);

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
-- AUTO_INCREMENT for table `lab_journal`
--
ALTER TABLE `lab_journal`
  MODIFY `labjournaal_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `preparation`
--
ALTER TABLE `preparation`
  MODIFY `preparation_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lab_journal`
--
ALTER TABLE `lab_journal`
  ADD CONSTRAINT `link creater id to user` FOREIGN KEY (`creater_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `lab_journal_users`
--
ALTER TABLE `lab_journal_users`
  ADD CONSTRAINT `link labjournaal id tussen to labjournaal id` FOREIGN KEY (`lab_journal_id`) REFERENCES `lab_journal` (`labjournaal_id`),
  ADD CONSTRAINT `link labjournaal tussen  user to user id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `link creater to user id` FOREIGN KEY (`creater`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `link viewer to user id` FOREIGN KEY (`viewer`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `preparation`
--
ALTER TABLE `preparation`
  ADD CONSTRAINT `link preperations creater to user` FOREIGN KEY (`creater_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `preperation_users`
--
ALTER TABLE `preperation_users`
  ADD CONSTRAINT `preperation_link additional id to preperation` FOREIGN KEY (`preperation_id`) REFERENCES `preparation` (`preparation_id`),
  ADD CONSTRAINT `preperation_link additional user to user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
`e-labs`