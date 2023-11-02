-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2023 at 02:27 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ros`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `ID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`ID`, `username`, `password`) VALUES
(1, 'admin', 'adminros123');

-- --------------------------------------------------------

--
-- Table structure for table `req_appoint`
--

CREATE TABLE `req_appoint` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Number` varchar(24) NOT NULL,
  `Message` varchar(255) NOT NULL,
  `req_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `req_appoint`
--

INSERT INTO `req_appoint` (`ID`, `Name`, `Email`, `Number`, `Message`, `req_date`) VALUES
(8, 'One', 'none@gmail.com', '09552514', '092322', '2023-10-18'),
(9, 'wew', 'ewew@gmail.com', '12222', 'dawda', '2023-10-20'),
(10, 'tra', 'tra@gmail.com', '158797', 'dadada', '2023-10-20'),
(11, 'ewew', 'evl@gmai.com', '182515', 'wewew', '2023-10-20'),
(12, 'ere', 'evel@gmail.com', '25454', 'adadasd', '2023-10-20'),
(13, 'adada', 'adad@gmail.com', '78799', 'adadasdasd', '2023-10-20'),
(14, 'daada', 'dada@gmail.com', '4545454', 'adawdad', '2023-10-21'),
(15, 'adada', 'adada@gmail.com', '787487878', 'dadada', '2023-10-21'),
(16, 'dadada', 'ewaeawewa@gmail.com', '079806546', 'adasdasda', '2023-10-21'),
(17, 'ewrwe', 'ewewe@gmail.com', '3131352131', 'azdadadas', '2023-10-21'),
(18, 'eqwewqeqw', 'aead@gmail.com', '4653132', 'adasdsad', '2023-10-21'),
(19, 'Juan', 'Juan@gmail.com', '864646', 'adadada', '2023-10-21'),
(20, 'adadas32', 'adasd@gmail.com', '44121', 'dadasdsadsa', '2023-10-21'),
(21, 'adasda', 'sfae@gmail.com', '989854', 'adsadas\\r\\n', '2023-10-21'),
(22, 'jk', 'jk@gmail.com', '09464546', 'adadasd', '2023-10-21'),
(23, 'Kuminga', 'Jks@gmail.com', '09654589', 'This is test', '2023-10-21');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Number` varchar(255) NOT NULL,
  `Sched_Date` date NOT NULL DEFAULT current_timestamp(),
  `Sched_Time` time NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`ID`, `Name`, `Email`, `Number`, `Sched_Date`, `Sched_Time`) VALUES
(1, '', '', '', '2023-10-26', '04:15:00'),
(2, '', '', '', '2023-10-26', '07:58:00'),
(3, '', '', '', '2023-10-25', '05:02:00'),
(4, '', '', '', '2023-10-25', '05:02:00'),
(5, 'Test', 'test@gmail.com', '09123456789', '2023-10-25', '05:10:00'),
(6, 'tezzt', 'testt@gmail.com', '095555555', '2023-10-26', '06:02:00'),
(7, 'Mark', 'Tahimilik@gmail.com', '09457899', '2023-10-25', '06:08:00'),
(8, 'tezzt', 'kevin@gmail.com', '0955555', '2023-10-25', '06:12:00'),
(9, 'awit', 'wala@gmail.com', '095555', '2023-10-25', '06:21:00'),
(10, 'test2', 'test2@gmail.com', '0977777777', '2023-10-25', '06:46:00'),
(11, 'test3', 'yao@gmail.com', '0988888888', '2023-10-25', '06:48:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `req_appoint`
--
ALTER TABLE `req_appoint`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `req_appoint`
--
ALTER TABLE `req_appoint`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
