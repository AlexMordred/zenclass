-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 14, 2018 at 01:40 PM
-- Server version: 5.7.23-0ubuntu0.18.04.1
-- PHP Version: 7.2.7-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dev_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `News`
--

CREATE TABLE `News` (
  `ID` int(11) NOT NULL,
  `ParticipantId` int(11) NOT NULL,
  `NewsTitle` varchar(255) NOT NULL,
  `NewsMessage` text NOT NULL,
  `LikesCounter` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `News`
--

INSERT INTO `News` (`ID`, `ParticipantId`, `NewsTitle`, `NewsMessage`, `LikesCounter`) VALUES
(1, 1, 'New agenda!', 'Please visit our site!', 0);

-- --------------------------------------------------------

--
-- Table structure for table `Participant`
--

CREATE TABLE `Participant` (
  `ID` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Participant`
--

INSERT INTO `Participant` (`ID`, `Email`, `Name`) VALUES
(1, 'airmail@code-pilots.com', 'The first user');

-- --------------------------------------------------------

--
-- Table structure for table `Session`
--

CREATE TABLE `Session` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `TimeOfEvent` datetime NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Session`
--

INSERT INTO `Session` (`ID`, `Name`, `TimeOfEvent`, `Description`) VALUES
(1, 'Laravel 5.7 from scratch', '2018-09-27 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `SessionParticipant`
--

CREATE TABLE `SessionParticipant` (
  `SessionId` int(11) NOT NULL,
  `ParticipantId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Speaker`
--

CREATE TABLE `Speaker` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Speaker`
--

INSERT INTO `Speaker` (`ID`, `Name`) VALUES
(1, 'Watson'),
(2, 'Arnold');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `News`
--
ALTER TABLE `News`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Participant`
--
ALTER TABLE `Participant`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Session`
--
ALTER TABLE `Session`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `SessionParticipant`
--
ALTER TABLE `SessionParticipant`
  ADD KEY `SessionId` (`SessionId`),
  ADD KEY `ParticipantId` (`ParticipantId`);

--
-- Indexes for table `Speaker`
--
ALTER TABLE `Speaker`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `News`
--
ALTER TABLE `News`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Participant`
--
ALTER TABLE `Participant`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Session`
--
ALTER TABLE `Session`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Speaker`
--
ALTER TABLE `Speaker`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
