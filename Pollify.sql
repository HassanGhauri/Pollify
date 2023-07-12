-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 12, 2023 at 01:07 PM
-- Server version: 8.0.33-0ubuntu0.22.04.2
-- PHP Version: 8.1.2-1ubuntu2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Pollify`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` int NOT NULL,
  `electionid` int NOT NULL,
  `candidatename` varchar(255) NOT NULL,
  `candidatedetails` text NOT NULL,
  `candidatephoto` varchar(255) NOT NULL,
  `insertedby` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `electionid`, `candidatename`, `candidatedetails`, `candidatephoto`, `insertedby`, `timestamp`) VALUES
(8, 8, 'Karachi Kings', 'Owner : Salman Iqbal', '../assets/images/candidates/69716886620_2402722413Screenshot from 2023-07-10 21-52-07.png', 'HamadS.', '2023-07-11 22:15:41'),
(9, 8, 'Peshawar Zalmi', 'Owner : Javaid Afridi', '../assets/images/candidates/69397860389_80917243092Screenshot from 2023-07-10 21-52-07.png', 'HamadS.', '2023-07-11 22:16:16'),
(10, 9, 'Ubit', 'Karachi University', '../assets/images/candidates/69378572507_71055152659Screenshot from 2023-07-10 21-52-07.png', 'HamadS.', '2023-07-11 23:22:58'),
(11, 9, 'Fast', 'Fast University Islamabad', '../assets/images/candidates/92835430809_57215907615Screenshot from 2023-07-10 21-52-07.png', 'HamadS.', '2023-07-11 23:23:32');

-- --------------------------------------------------------

--
-- Table structure for table `elections`
--

CREATE TABLE `elections` (
  `id` int NOT NULL,
  `electiontopic` varchar(255) NOT NULL,
  `noofcandidates` int NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `status` varchar(255) NOT NULL,
  `insertedby` varchar(22) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `elections`
--

INSERT INTO `elections` (`id`, `electiontopic`, `noofcandidates`, `startdate`, `enddate`, `status`, `insertedby`, `timestamp`) VALUES
(8, 'PSL Best Team', 2, '2023-07-12', '2023-07-15', 'Active', 'HamadS.', '2023-07-11 22:15:19'),
(9, 'Best Computer Science Department', 2, '2023-07-12', '2023-07-20', 'Active', 'HamadS.', '2023-07-11 23:20:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `userrole` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `email`, `userrole`, `password`, `timestamp`) VALUES
(1, 'Hamad Saqib', 'HamadS.', 'hamadsaqib2@gmail.com', 'Admin', '21add65abf412609bb5c031f912d387f235bb7e1', '2023-07-10 20:51:48'),
(2, 'Hassan Ghauri', 'HassanG.', 'hassan@gmail.com', 'Admin', '86904aebbc4a75a814fb63c7ff52f4a82329061c', '2023-07-11 03:52:00'),
(3, 'Abdul Mannan', 'A.Mannan', 'abdulmannan@gmail.com', 'Voter', '63ed8c2df60a8c68e800b8e24940682803319d7e', '2023-07-11 21:20:31'),
(4, 'Joe Rogan', 'JoeR.', 'joe@gmail.com', 'Voter', '74c25ab39834f66a726cd927bea4e2059ae9d35e', '2023-07-11 23:07:56'),
(5, 'Brock Lesnar', 'BrockL.', 'beast@gamil.com', 'Voter', '9a26da737f1f708c9eccfa551653d8eaaf3900ce', '2023-07-11 23:44:38');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int NOT NULL,
  `electionid` int NOT NULL,
  `voterid` int NOT NULL,
  `candidateid` int NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `electionid`, `voterid`, `candidateid`, `timestamp`) VALUES
(1, 8, 3, 8, '2023-07-11 22:59:38'),
(2, 8, 4, 8, '2023-07-11 23:16:56'),
(3, 9, 4, 10, '2023-07-11 23:24:17'),
(4, 8, 5, 8, '2023-07-11 23:46:01'),
(5, 9, 5, 10, '2023-07-11 23:46:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `elections`
--
ALTER TABLE `elections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `elections`
--
ALTER TABLE `elections`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
