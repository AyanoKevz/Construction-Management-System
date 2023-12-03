-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2023 at 08:27 PM
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
-- Table structure for table `covered court`
--

CREATE TABLE `covered court` (
  `ID` int(11) NOT NULL,
  `projectID` int(11) NOT NULL,
  `foundation` int(11) NOT NULL DEFAULT 0,
  `roofing` int(11) NOT NULL DEFAULT 0,
  `walls` int(11) NOT NULL DEFAULT 0,
  `flooring` int(11) NOT NULL DEFAULT 0,
  `utilities` int(11) NOT NULL DEFAULT 0,
  `pic1` varchar(255) NOT NULL,
  `pic2` varchar(255) NOT NULL,
  `pic3` varchar(255) NOT NULL,
  `pic4` varchar(255) NOT NULL,
  `pic5` varchar(255) NOT NULL,
  `updateDate` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `ID` int(11) NOT NULL,
  `teamID` int(11) DEFAULT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `number` varchar(128) NOT NULL,
  `gender` varchar(128) NOT NULL,
  `position` varchar(128) NOT NULL,
  `emp_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`ID`, `teamID`, `fname`, `lname`, `number`, `gender`, `position`, `emp_img`) VALUES
(1, 1, 'Joshua', 'Mislang', '09898113131', 'Male', 'Worker', '../assets/emp_pic/mislang.jpg'),
(2, 1, 'Mark', 'Zucker', '09949494946', 'Male', 'Worker', '../assets/images/no_img.jpg'),
(3, 1, 'Jared', 'Dillinger', '09594640643', 'Male', 'Foreman', '../assets/images/no_img.jpg'),
(4, 1, 'Gerald', 'Underscore', '09594456464', 'Male', 'Worker', '../assets/images/no_img.jpg'),
(5, 2, 'Coco', 'Maja', '09894949405', 'Male', 'Worker', '../assets/images/no_img.jpg'),
(6, 2, 'Sam', 'Misth', '08948440949', 'Male', 'Worker', '../assets/images/no_img.jpg'),
(7, 1, 'Ryan ', 'Owen', '09942549529', 'Male', 'Engineer', '../assets/images/no_img.jpg'),
(8, NULL, 'Alyanna', 'Sibal', '09949494949', 'Female', 'Human Resource', '../assets/images/no_img.jpg'),
(9, NULL, 'Ralf', 'Ureta', '09907979041', 'Male', 'Human Resource', '../assets/images/no_img.jpg'),
(10, 2, 'Joshua', 'Langmis', '09095495095', 'Male', 'Foreman', '../assets/images/no_img.jpg'),
(11, NULL, 'Ivana', 'Mulawin', '09594064644', 'Female', 'Human Resource', '../assets/images/no_img.jpg'),
(12, 2, 'Kevin', 'Caezar', '09987165010', 'Male', 'Engineer', '../assets/images/no_img.jpg'),
(13, NULL, 'Tyler', 'Bey', '09984651616', 'Male', 'Foreman', '../assets/images/no_img.jpg'),
(14, NULL, 'Jun', 'Ramos', '09080446131', 'Male', 'Foreman', '../assets/images/no_img.jpg'),
(15, 2, 'Jhong', 'Hillario', '09589449494', 'Male', 'Worker', '../assets/images/no_img.jpg'),
(16, 2, 'Donny', 'Narcos', '09898090449', 'Male', 'Worker', '../assets/images/no_img.jpg'),
(17, NULL, 'Mariel', 'Santos', '09097644646', 'Female', 'Human Resource', '../assets/images/no_img.jpg'),
(18, 2, 'Bryan', 'Aguilar', '09744946464', 'Male', 'Worker', '../assets/images/no_img.jpg'),
(19, NULL, 'Justin', 'Lee', '09789498409', 'Male', 'Engineer', '../assets/images/no_img.jpg'),
(20, NULL, 'Katrina', 'Almarez', '09979749904', 'Female', 'Engineer', '../assets/images/no_img.jpg'),
(21, NULL, 'Jonathan', 'Kuminga', '09794949494', 'Male', 'Engineer', '../assets/images/no_img.jpg'),
(22, NULL, 'Sandra', 'Marcas', '09494944949', 'Female', 'Human Resource', '../assets/images/no_img.jpg'),
(23, NULL, 'Christian', 'Mercado', '09589089979', 'Male', 'Human Resource', '../assets/images/no_img.jpg'),
(24, NULL, 'Nelson', 'Guimbao', '09859094949', 'Male', 'Worker', '../assets/images/no_img.jpg'),
(25, NULL, 'Nardo', 'Putin', '09565549646', 'Male', 'Worker', '../assets/images/no_img.jpg'),
(26, NULL, 'Eren', 'Yeager', '09494640616', 'Male', 'Foreman', '../assets/images/no_img.jpg'),
(27, NULL, 'Chris', 'Newsome', '09594090979', 'Male', 'Engineer', '../assets/images/no_img.jpg'),
(28, NULL, 'Alex', 'Mewing', '09879494094', 'Male', 'Foreman', '../assets/images/no_img.jpg'),
(29, NULL, 'Marco', 'Gumabao', '09940904940', 'Male', 'Foreman', '../assets/images/no_img.jpg'),
(30, NULL, 'Juan', 'Tuna', '09894940904', 'Male', 'Foreman', '../assets/images/no_img.jpg'),
(31, NULL, 'Jerry', 'Galinato', '09094949409', 'Male', 'Engineer', '../assets/images/no_img.jpg'),
(32, NULL, 'David', 'Nagiba', '09890490494', 'Male', 'Worker', '../assets/images/no_img.jpg'),
(33, NULL, 'Joseph', 'Ilao', '09979090494', 'Male', 'Worker', '../assets/images/no_img.jpg'),
(34, NULL, 'Jason', 'Dela Cruz', '09797797979', 'Male', 'Worker', '../assets/images/no_img.jpg'),
(35, NULL, 'Diexter', 'Goto', '09451874230', 'Male', 'Engineer', '../assets/images/no_img.jpg'),
(36, NULL, 'Gian', 'Conception', '09048451518', 'Male', 'Engineer', '../assets/images/no_img.jpg'),
(37, NULL, 'Justine', 'Balboa', '09590494040', 'Male', 'Worker', '../assets/images/no_img.jpg'),
(38, NULL, 'Zaki', 'Mcario', '09453842064', 'Male', 'Foreman', '../assets/images/no_img.jpg'),
(39, NULL, 'Bianca', 'Gomez', '09561564879', 'Female', 'Engineer', '../assets/images/no_img.jpg'),
(40, NULL, 'Jude', 'Marcos', '09218787984', 'Male', 'Foreman', '../assets/images/no_img.jpg'),
(41, NULL, 'Steven', 'Perez', '09051564694', 'Male', 'Worker', '../assets/images/no_img.jpg'),
(42, NULL, 'Mavi', 'Espanto', '09164646460', 'Male', 'Worker', '../assets/images/no_img.jpg'),
(43, NULL, 'Kevin', 'Goto', '09458526487', 'Male', 'Human Resource', '../assets/images/no_img.jpg'),
(44, NULL, 'Tristan', 'Cabrera', '08979464161', 'Male', 'Worker', '../assets/images/no_img.jpg'),
(45, NULL, 'Juan', 'Gonzaga', '09797090494', 'Male', 'Worker', '../assets/images/no_img.jpg'),
(46, NULL, 'James', 'yhup', '09790446565', 'Male', 'Worker', '../assets/images/no_img.jpg'),
(47, NULL, 'Rodrigo', 'Dulerte', '09421574842', 'Male', 'Worker', '../assets/images/no_img.jpg'),
(48, NULL, 'Samson', 'Aguilar', '09506166616', 'Male', 'Foreman', '../assets/images/no_img.jpg'),
(49, NULL, 'Julius', 'Antabay', '09740600464', 'Male', 'Worker', '../assets/images/no_img.jpg'),
(50, NULL, 'Lea', 'Salom', '09461118748', 'Female', 'Human Resource', '../assets/images/no_img.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `hauling transport`
--

CREATE TABLE `hauling transport` (
  `ID` int(11) NOT NULL,
  `projectID` int(11) NOT NULL,
  `removal` int(11) NOT NULL DEFAULT 0,
  `transport` int(11) NOT NULL DEFAULT 0,
  `pic1` varchar(255) NOT NULL,
  `pic2` varchar(255) NOT NULL,
  `pic3` varchar(255) NOT NULL,
  `pic4` varchar(255) NOT NULL,
  `pic5` varchar(255) NOT NULL,
  `updateDate` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hauling transport`
--

INSERT INTO `hauling transport` (`ID`, `projectID`, `removal`, `transport`, `pic1`, `pic2`, `pic3`, `pic4`, `pic5`, `updateDate`) VALUES
(1, 2, 0, 0, '../assets/images/default_house.jpg', '../assets/images/default_house.jpg', '../assets/images/default_house.jpg', '../assets/images/default_house.jpg', '../assets/images/default_house.jpg', '2023-12-01');

-- --------------------------------------------------------

--
-- Table structure for table `house/building`
--

CREATE TABLE `house/building` (
  `ID` int(11) NOT NULL,
  `projectID` int(11) NOT NULL,
  `foundation` int(11) NOT NULL DEFAULT 0,
  `structure` int(11) NOT NULL DEFAULT 0,
  `exterior` int(11) NOT NULL DEFAULT 0,
  `interior` int(11) NOT NULL DEFAULT 0,
  `utilities` int(11) NOT NULL DEFAULT 0,
  `pic1` varchar(255) NOT NULL,
  `pic2` varchar(255) NOT NULL,
  `pic3` varchar(255) NOT NULL,
  `pic4` varchar(255) NOT NULL,
  `pic5` varchar(255) NOT NULL,
  `updateDate` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `house/building`
--

INSERT INTO `house/building` (`ID`, `projectID`, `foundation`, `structure`, `exterior`, `interior`, `utilities`, `pic1`, `pic2`, `pic3`, `pic4`, `pic5`, `updateDate`) VALUES
(1, 1, 0, 0, 0, 0, 0, '../assets/images/default_house.jpg', '../assets/images/default_house.jpg', '../assets/images/default_house.jpg', '../assets/images/default_house.jpg', '../assets/images/default_house.jpg', '2023-12-01');

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
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `ID` int(11) NOT NULL,
  `projectID` int(11) NOT NULL,
  `concrete` varchar(255) NOT NULL,
  `lumber` varchar(255) NOT NULL,
  `steel` varchar(255) NOT NULL,
  `aggregates` varchar(255) NOT NULL,
  `bricks` varchar(255) NOT NULL,
  `roofing` varchar(255) NOT NULL,
  `finishing` varchar(255) NOT NULL,
  `deliDate` date NOT NULL DEFAULT current_timestamp(),
  `deliTime` time NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`ID`, `projectID`, `concrete`, `lumber`, `steel`, `aggregates`, `bricks`, `roofing`, `finishing`, `deliDate`, `deliTime`) VALUES
(1, 1, 'try', 'try', 'None', 'None', 'None', 'None', 'None', '2023-12-02', '21:26:00'),
(2, 2, 'None', 'None', 'None', 'None', 'None', 'None', 'None', '2023-12-02', '22:08:00'),
(3, 1, 'None', 'None', 'None', 'None', 'None', 'None', 'None', '2023-12-02', '22:09:00');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `ID` int(11) NOT NULL,
  `teamID` int(11) NOT NULL,
  `projectCode` varchar(255) NOT NULL,
  `projectType` varchar(255) NOT NULL,
  `projectName` varchar(255) NOT NULL,
  `cost` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `startingDate` date NOT NULL DEFAULT current_timestamp(),
  `deadline` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`ID`, `teamID`, `projectCode`, `projectType`, `projectName`, `cost`, `location`, `startingDate`, `deadline`, `status`) VALUES
(1, 1, 'ROS-474354', 'House/Building', 'House of Collab', '1,200,000', 'Quezon City', '2023-12-22', '2023-12-01', 'On-Going'),
(2, 2, 'ROS-443553', 'Hauling Transport', 'Bridge Hauling', '50000', 'Caloocan', '2023-12-02', '2023-12-03', 'On-Going');

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

-- --------------------------------------------------------

--
-- Table structure for table `road/highway`
--

CREATE TABLE `road/highway` (
  `ID` int(11) NOT NULL,
  `projectID` int(11) NOT NULL,
  `earthwork` int(11) NOT NULL DEFAULT 0,
  `roadsurface` int(11) NOT NULL DEFAULT 0,
  `drainage` int(11) NOT NULL DEFAULT 0,
  `utilities` int(11) NOT NULL DEFAULT 0,
  `pic1` varchar(255) NOT NULL,
  `pic2` varchar(255) NOT NULL,
  `pic3` varchar(255) NOT NULL,
  `pic4` varchar(255) NOT NULL,
  `pic5` varchar(255) NOT NULL,
  `updateDate` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `ID` int(11) NOT NULL,
  `teamName` varchar(255) NOT NULL,
  `projectID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`ID`, `teamName`, `projectID`) VALUES
(1, 'Iqor', 1),
(2, 'TeamAction', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `covered court`
--
ALTER TABLE `covered court`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `hauling transport`
--
ALTER TABLE `hauling transport`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `house/building`
--
ALTER TABLE `house/building`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `req_appoint`
--
ALTER TABLE `req_appoint`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `road/highway`
--
ALTER TABLE `road/highway`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `covered court`
--
ALTER TABLE `covered court`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `hauling transport`
--
ALTER TABLE `hauling transport`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `house/building`
--
ALTER TABLE `house/building`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `req_appoint`
--
ALTER TABLE `req_appoint`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `road/highway`
--
ALTER TABLE `road/highway`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
