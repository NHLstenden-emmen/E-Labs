-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2021 at 08:57 PM
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
  `labjournal_id` int(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `theory` varchar(2000) NOT NULL,
  `safety` varchar(2000) NOT NULL,
  `creator_id` int(10) NOT NULL,
  `log` varchar(2000) NOT NULL,
  `method_materials` varchar(2000) NOT NULL,
  `submitted` tinyint(1) NOT NULL,
  `grade` int(2) NOT NULL,
  `year` int(11) NOT NULL,
  `Attachment` varchar(255) NOT NULL,
  `Goal` varchar(2000) NOT NULL,
  `Hypothesis` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lab_journal_users`
--

CREATE TABLE `lab_journal_users` (
  `user_id` int(10) NOT NULL,
  `lab_journal_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(10) NOT NULL,
  `creator` int(10) NOT NULL,
  `viewer` int(10) DEFAULT NULL,
  `title` varchar(50) NOT NULL,
  `message` varchar(2000) NOT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `preparation`
--

CREATE TABLE `preparation` (
  `preparation_id` int(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `theory` varchar(1000) NOT NULL,
  `safety` varchar(1000) NOT NULL,
  `creator_id` int(10) NOT NULL,
  `log` varchar(1000) NOT NULL,
  `method_materials` varchar(1000) NOT NULL,
  `submitted` tinyint(1) NOT NULL,
  `grade` int(2) NOT NULL,
  `year` int(11) NOT NULL,
  `Attachment` varchar(255) NOT NULL,
  `Goal` varchar(1000) NOT NULL,
  `Hypothesis` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `preperation_users`
--

CREATE TABLE `preperation_users` (
  `user_id` int(10) NOT NULL,
  `preparation_id` int(50) NOT NULL
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
(1, 'Kevin', 'kevin@docent.com', 123456, '$2y$12$x1mzfqUZcEBFkCvhKRt35.SBs5RLRD0D.PZVzyXmBrOXBDXQepF92', 'gebruikersBestanden/profilePictures/blank-profile-picture.png', 'nl', 'Docent'),
(2, 'Marjolein', 'Marjolein@docent.com', 444318, '$2y$12$x1mzfqUZcEBFkCvhKRt35.SBs5RLRD0D.PZVzyXmBrOXBDXQepF92', 'gebruikersBestanden/profilePictures/blank-profile-picture.png', 'nl', 'Docent'),
(3, 'Faya', 'Faya@docent.com', 444318, '$2y$12$cTqvLHlsL/PmgCF/F8o4rOpq33St9IwVNs7bLjB79QBp4Hraodlsa', 'gebruikersBestanden/profilePictures/blank-profile-picture.png', 'nl', 'Docent'),
(4, 'mike', 'mike@student.com', 123498231, '$2y$12$dUzcBjA99R6dYQj3toVnSeiUzpTWeWpzoS.w5DY.qQVuemH6LYfYu', 'gebruikersBestanden/profilePictures/blank-profile-picture.png', 'nl', 'Student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lab_journal`
--
ALTER TABLE `lab_journal`
  ADD PRIMARY KEY (`labjournal_id`),
  ADD KEY `link creator_id to user` (`creator_id`);

--
-- Indexes for table `lab_journal_users`
--
ALTER TABLE `lab_journal_users`
  ADD KEY `link labjournal tussen user to user id` (`user_id`),
  ADD KEY `link labjournal id to labjournal id` (`lab_journal_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `link creator to user id` (`creator`),
  ADD KEY `link viewer to user id` (`viewer`);

--
-- Indexes for table `preparation`
--
ALTER TABLE `preparation`
  ADD PRIMARY KEY (`preparation_id`),
  ADD UNIQUE KEY `creator_id` (`creator_id`);

--
-- Indexes for table `preperation_users`
--
ALTER TABLE `preperation_users`
  ADD KEY `preperation_link additional user to user` (`user_id`),
  ADD KEY `preperation_link additional id to preperation` (`preparation_id`);

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
  MODIFY `labjournal_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `preparation`
--
ALTER TABLE `preparation`
  MODIFY `preparation_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lab_journal`
--
ALTER TABLE `lab_journal`
  ADD CONSTRAINT `labjournal link creator_id to user` FOREIGN KEY (`creator_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `lab_journal_users`
--
ALTER TABLE `lab_journal_users`
  ADD CONSTRAINT `link labjournal tussen user to user id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `link labjournal_id tussen to labjournaal id` FOREIGN KEY (`lab_journal_id`) REFERENCES `lab_journal` (`labjournal_id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `link creator to user id` FOREIGN KEY (`creator`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `link viewer to user id` FOREIGN KEY (`viewer`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `preparation`
--
ALTER TABLE `preparation`
  ADD CONSTRAINT `preparation link creator_id to user` FOREIGN KEY (`creator_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `preperation_users`
--
ALTER TABLE `preperation_users`
  ADD CONSTRAINT `preperation_link additional user to user	` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `preperation_link additional id to preperation` FOREIGN KEY (`preparation_id`) REFERENCES `preparation` (`preparation_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
