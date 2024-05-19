-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2024 at 12:08 PM
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
-- Database: `publication_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookmark`
--

CREATE TABLE `bookmark` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `document_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookmark`
--

INSERT INTO `bookmark` (`id`, `user_id`, `document_id`) VALUES
(9, 3, 2),
(10, 3, 2),
(11, 3, 4),
(12, 3, 2),
(13, 3, 3),
(14, 3, 4),
(15, 3, 4),
(16, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `documentID` int(11) NOT NULL,
  `documentfile` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `DocumentYear` int(11) DEFAULT NULL,
  `DocumentTitle` varchar(255) DEFAULT NULL,
  `DomainID` int(11) DEFAULT NULL,
  `PublicationID` int(11) DEFAULT NULL,
  `TypeID` int(11) DEFAULT NULL,
  `researchArea` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`documentID`, `documentfile`, `DocumentYear`, `DocumentTitle`, `DomainID`, `PublicationID`, `TypeID`, `researchArea`) VALUES
(2, 'lecture 1 (1).pdf', 2014, 'Tech in medicine', 2, 2, 1, NULL),
(3, 'Cover Letter.pdf', 2021, 'CoverLetter', 2, 2, 1, NULL),
(4, 'AyeshaAsad_CN_Assignment.pdf', 2015, 'assignment', 2, 2, 1, NULL),
(5, 'AyeshaAsad_CN_Assignment.pdf', 2015, 'assignment', 2, 2, 1, NULL),
(6, 'AyeshaAsad_CN_Assignment.pdf', 2015, 'assignment', 2, 1, 1, NULL),
(7, 'AyeshaAsad_CN_Assignment.pdf', 2015, 'assignment', 2, 1, 2, NULL),
(8, 'AyeshaAsad_CN_Assignment.pdf', 2015, 'assignment', 2, 1, 3, NULL),
(9, 'AyeshaAsad_CN_Assignment.pdf', 2015, 'assignment', 1, 1, 3, NULL),
(10, 'AyeshaAsad_CN_Assignment.pdf', 2015, 'assignment', 4, 1, 3, NULL),
(11, 'AyeshaAsad_CN_Assignment.pdf', 2015, 'assignment', 4, 1, 3, NULL),
(12, 'AyeshaAsad_CN_Assignment.pdf', 2015, 'assignment', 4, 1, 3, NULL),
(13, 'AyeshaAsad_CN_Assignment.pdf', 2015, 'assignment', 4, 1, 3, NULL),
(14, 'Design_and_Implementation_of_Library_Management_Sy.pdf', 2016, 'docx file', 4, 1, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `domain`
--

CREATE TABLE `domain` (
  `DomainID` int(11) NOT NULL,
  `DomainName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `domain`
--

INSERT INTO `domain` (`DomainID`, `DomainName`) VALUES
(1, 'ComputerScience'),
(2, 'AI'),
(4, 'pharmacy');

-- --------------------------------------------------------

--
-- Table structure for table `publication`
--

CREATE TABLE `publication` (
  `PublicationID` int(11) NOT NULL,
  `PublicationName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `publication`
--

INSERT INTO `publication` (`PublicationID`, `PublicationName`) VALUES
(1, 'Journals'),
(2, 'Conference');

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `TypeID` int(11) NOT NULL,
  `TypeName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`TypeID`, `TypeName`) VALUES
(1, 'Thesis'),
(2, 'Research paper'),
(3, 'Article');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `institute` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `profile_image` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `city`, `country`, `institute`, `phone_number`, `profile_image`) VALUES
(1, 'AyeshaAsad', 'ayesha@gmail.com', '$2y$10$bYsqZxBxtZ.x4hGs0XPgbuTEqqD6ocg/AWJ1DnIbWjRkwGkh3ZAJa', 'anc', '', '', '', ''),
(3, 'Areeba', 'areeba@gmail.com', '$2y$10$Sdc9qnrHcSAXz3mxKZezOOfIn44T9/ZZcGpqOKov5iXxb1bLgPgl2', 'karachi', 'Pakistan', 'ku', '03212187977', 0x75706c6f6164732f77616c6c392e6a7067),
(4, 'Anas', 'anas@gmail.com', '03d7b0c5a2fb8a113e4926aab5ffcaa68dab5437fc762c2c0cf2f17e3efcf200', NULL, NULL, NULL, NULL, NULL),
(6, 'Anas Mirza', 'anas11@gmail.com', '03d7b0c5a2fb8a113e4926aab5ffcaa68dab5437fc762c2c0cf2f17e3efcf200', NULL, NULL, NULL, NULL, NULL),
(7, 'Amna', 'amna@gmail.com', '280ee077a60f95eec5d6fd88454314383ee33be9a1e1c90c7884605c8af7b5dd', NULL, NULL, NULL, NULL, NULL),
(8, 'Manaim', 'manaim@gmail.com', 'a90c8486b291ee482977b1a7038555be3ca96d67a768a275bc6a2aa908c23074', NULL, NULL, NULL, NULL, NULL),
(10, 'ayeshaasad11', 'ayesha11@gmail.com', 'b36cf3c68d7b300db70a336186cd949b8320ca89ae8ee509f92053fd92e24198', NULL, NULL, NULL, NULL, NULL),
(11, 'mobile', 'mobile@gmail.com', 'd524c1a0811da49592f841085cc0063eb62b3001252a94542795d1ca9824a941', NULL, NULL, NULL, NULL, NULL),
(12, 'a', 'a@gmail.com', 'bef57ec7f53a6d40beb640a780a639c83bc29ac8a9816f1fc6c5c6dcd93c4721', NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `document_id` (`document_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`documentID`),
  ADD KEY `DomainID` (`DomainID`),
  ADD KEY `PublicationID` (`PublicationID`),
  ADD KEY `TypeID` (`TypeID`);

--
-- Indexes for table `domain`
--
ALTER TABLE `domain`
  ADD PRIMARY KEY (`DomainID`);

--
-- Indexes for table `publication`
--
ALTER TABLE `publication`
  ADD PRIMARY KEY (`PublicationID`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`TypeID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookmark`
--
ALTER TABLE `bookmark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `documentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `domain`
--
ALTER TABLE `domain`
  MODIFY `DomainID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `publication`
--
ALTER TABLE `publication`
  MODIFY `PublicationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `TypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD CONSTRAINT `bookmark_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookmark_ibfk_2` FOREIGN KEY (`document_id`) REFERENCES `documents` (`documentID`);

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`DomainID`) REFERENCES `domain` (`DomainID`),
  ADD CONSTRAINT `documents_ibfk_2` FOREIGN KEY (`PublicationID`) REFERENCES `publication` (`PublicationID`),
  ADD CONSTRAINT `documents_ibfk_3` FOREIGN KEY (`TypeID`) REFERENCES `type` (`TypeID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
