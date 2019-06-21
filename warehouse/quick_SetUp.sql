-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: mysql.practices.isaaczheli.com
-- Generation Time: Jun 19, 2019 at 12:35 AM
-- Server version: 5.6.38-log
-- PHP Version: 7.1.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zyxwstorage`
--

-- --------------------------------------------------------

--
-- Table structure for table `Agreement`
--

CREATE TABLE `Agreement` (
  `agrmtNum` int(8) NOT NULL,
  `startDay` date NOT NULL,
  `endDay` date NOT NULL,
  `payment` int(8) NOT NULL,
  `pickDay` date DEFAULT NULL,
  `fromResv` int(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Agreement`
--

INSERT INTO `Agreement` (`agrmtNum`, `startDay`, `endDay`, `payment`, `pickDay`, `fromResv`) VALUES
(1, '2019-06-19', '2022-03-26', 3, NULL, 3),
(2, '2019-06-19', '2019-06-27', 4, NULL, 4);

-- --------------------------------------------------------

--
-- Table structure for table `Branch`
--

CREATE TABLE `Branch` (
  `branchID` int(5) NOT NULL,
  `address` varchar(128) NOT NULL,
  `phoneNum` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Branch`
--

INSERT INTO `Branch` (`branchID`, `address`, `phoneNum`) VALUES
(10001, '1734 Cordova Street, Vancouver, BC, Canada, V6B1E1', '6045064608'),
(10002, '2897 Cordova Street, Vancouver, BC, Canada, V6B2T3', '6046038555'),
(10003, '4495 Tanner Street, Vancouver, BC, Canada, V5R2T4', '6044319045'),
(10004, '3836 Blanshard, Victoria, BC, Canada, V8W2H9', '2502131788'),
(10005, '1400 Borough Drive, Toronto, Ontario, M1P4W2', '4162966117');

-- --------------------------------------------------------

--
-- Table structure for table `Card`
--

CREATE TABLE `Card` (
  `cardNum` char(16) NOT NULL,
  `cardExp` date DEFAULT NULL,
  `method` char(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Card`
--

INSERT INTO `Card` (`cardNum`, `cardExp`, `method`) VALUES
('3321123487659090', '2025-09-01', 'AMEX'),
('3340989810002999', '2022-08-01', 'AMEX'),
('4500999988881717', '2019-09-01', 'VISA'),
('4534257638451234', '2022-02-01', 'VISA'),
('5784673876784777', '2022-06-01', 'MSTR');

-- --------------------------------------------------------

--
-- Table structure for table `Customer`
--

CREATE TABLE `Customer` (
  `username` varchar(12) NOT NULL,
  `password` varchar(16) NOT NULL,
  `IDNum` varchar(32) NOT NULL,
  `lName` varchar(32) DEFAULT NULL,
  `fName` varchar(32) NOT NULL,
  `phoneNum` char(10) NOT NULL,
  `address` varchar(128) NOT NULL,
  `email` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Customer`
--

INSERT INTO `Customer` (`username`, `password`, `IDNum`, `lName`, `fName`, `phoneNum`, `address`, `email`) VALUES
('gregor', '110', 'STUD56700778', 'Kz', 'Gregor', '7788887777', '77 Main Mall, Vancouver, BC, Canada, V9O 1N2', 'gregor@ubc.cs.ca'),
('justin218', 'password', 'STUD12345678', 'Wong', 'Justin', '7782888218', '2543 East 19th Avenue, Vancouver, BC, Canada, V5M2S2', 'justinc.s.wong@gmail.com'),
('lizhe918', 'yxsy0102', 'STUD88792486', 'Li', 'Zhe', '7785227568', '788-2205 Lower Mall, Vancouver, BC, Canada, V6T1Z4', 'lizhe1313@outlook.com'),
('yixuan99', '19990316', 'STUD98766110', 'Qi', 'Yi Xuan', '7788888888', '8888 8th Ave, Vancouver, BC, Canada, V8V 8V8', 'fakeemail@gmail.com'),
('yuxin', 'tyx0312', 'STUD59056218', 'Tian', 'Yuxin', '7788623284', '2205 Lower Mall, Vancouver, BC, Canada, V6T1Z4', 'tian19yuxin@163.com');

-- --------------------------------------------------------

--
-- Table structure for table `Director`
--

CREATE TABLE `Director` (
  `employID` int(4) NOT NULL,
  `username` varchar(12) NOT NULL,
  `password` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Director`
--

INSERT INTO `Director` (`employID`, `username`, `password`) VALUES
(1001, 'lizhe1313', 'yxsy0102'),
(1002, 'yixuan99', '19990316'),
(1003, 'justin', 'justinwong'),
(1004, 'yuxin', 'tyx0312');

-- --------------------------------------------------------

--
-- Table structure for table `Employee`
--

CREATE TABLE `Employee` (
  `employID` int(4) NOT NULL,
  `lName` varchar(32) DEFAULT NULL,
  `fName` varchar(32) NOT NULL,
  `SINNum` int(9) NOT NULL,
  `phoneNum` char(10) NOT NULL,
  `email` varchar(64) NOT NULL,
  `address` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Employee`
--

INSERT INTO `Employee` (`employID`, `lName`, `fName`, `SINNum`, `phoneNum`, `email`, `address`) VALUES
(1001, 'Li', 'Zhe', 967245188, '7785341276', 'lizhe1313@outlook.com', '788-2204 Lower Mall, Vancouver, BC, Canada, V6T1Z4'),
(1002, 'Qi', 'Yi Xuan', 987246993, '7782953334', 'yixuan99316@gmail.com', '152-2305 Wesbrook Mall, Vancouver, BC, Canada, V7Z2XT'),
(1003, 'Wong', 'Justin', 976245864, '7781923338', 'justinc.s.wong@gmail.com', '723-0864 University Boulevard, Vancouver, BC, Canada, T8ZU4C'),
(1004, 'Tian', 'Yuxin', 798246756, '7788623284', 'tian19yuxin@163.com', '786-2204 Lower Mall, Vancouver, BC, Canada, V6T1Z5'),
(1005, 'Xiao', 'Junyu', 678965432, '7765437799', 'xiaojunyu@gmail.com', '2205 Lower Mall, Vancouver, BC, Canada'),
(1006, 'Tang', 'XiaoShan', 989000222, '6045558888', 'ada@fake.com', '666 Main Mall, Vancouver, BC, Canada. V7L 7L7'),
(1008, 'Li', 'JiTong', 657654376, '6678987654', 'Lijitong@gmail.com', '2255 West Mall, Vancouver, BC, Canada'),
(1009, 'Estey', 'Anthony', 888110, '226778123', 'anthonyestey@fake.com', '1111 Univeristy Blvd, Vancouver,BC, Canada, V0M 3B1'),
(1010, 'Heeren', 'Cinda', 221221221, '998221665', 'cinda@fake.com', '99 West Mall, Vancouver, BC, Canada, V1L 4K1');

-- --------------------------------------------------------

--
-- Table structure for table `Item`
--

CREATE TABLE `Item` (
  `itemNum` int(12) NOT NULL,
  `agrmtNum` int(12) NOT NULL,
  `size` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Item`
--

INSERT INTO `Item` (`itemNum`, `agrmtNum`, `size`) VALUES
(1, 1, 2),
(2, 1, 3),
(3, 2, 4);

--
-- Triggers `Item`
--
DELIMITER $$
CREATE TRIGGER `totalItemClass` AFTER INSERT ON `Item` FOR EACH ROW INSERT INTO ItemClass(itemNUM, typeName) 

VALUES(new.itemNum, 'RGLR')
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ItemClass`
--

CREATE TABLE `ItemClass` (
  `itemNum` int(12) NOT NULL,
  `typeName` char(4) NOT NULL DEFAULT 'RGLR'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ItemClass`
--

INSERT INTO `ItemClass` (`itemNum`, `typeName`) VALUES
(1, 'RGLR'),
(2, 'RGLR'),
(3, 'RGLR');

-- --------------------------------------------------------

--
-- Table structure for table `ItemInfo`
--

CREATE TABLE `ItemInfo` (
  `agrmtNum` int(12) NOT NULL,
  `owner` varchar(12) NOT NULL,
  `branch` int(5) NOT NULL,
  `roomNum` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ItemInfo`
--

INSERT INTO `ItemInfo` (`agrmtNum`, `owner`, `branch`, `roomNum`) VALUES
(1, 'yixuan99', 10005, 101),
(2, 'lizhe918', 10001, 201);

-- --------------------------------------------------------

--
-- Table structure for table `ItemType`
--

CREATE TABLE `ItemType` (
  `typeName` char(4) NOT NULL,
  `rate` int(11) DEFAULT NULL,
  `comment` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ItemType`
--

INSERT INTO `ItemType` (`typeName`, `rate`, `comment`) VALUES
('CPGS', 3, 'Compressed Gas'),
('EXPL', 4, 'Explosive Material'),
('FLAM', 2, 'Flammable Material'),
('FRGL', 2, 'Fragile Material'),
('FRZN', 3, 'Freezing Required'),
('OXDZ', 4, 'Oxidizing Material'),
('RGLR', 1, 'Regular Material'),
('WEPN', 4, 'Weapon and Firearms');

-- --------------------------------------------------------

--
-- Table structure for table `Labourer`
--

CREATE TABLE `Labourer` (
  `employID` int(4) NOT NULL,
  `innerPIN` int(4) DEFAULT NULL,
  `branchID` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Labourer`
--

INSERT INTO `Labourer` (`employID`, `innerPIN`, `branchID`) VALUES
(1008, 7865, 10001),
(1009, 110, 10005),
(1010, 221, 10005);

-- --------------------------------------------------------

--
-- Table structure for table `Manager`
--

CREATE TABLE `Manager` (
  `employID` int(4) NOT NULL,
  `username` varchar(12) NOT NULL,
  `password` varchar(16) NOT NULL,
  `branchID` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Manager`
--

INSERT INTO `Manager` (`employID`, `username`, `password`, `branchID`) VALUES
(1005, 'JunYu', 'xiaojunyu', 10001),
(1006, 'ada728', '19990728', 10005);

-- --------------------------------------------------------

--
-- Table structure for table `Payment`
--

CREATE TABLE `Payment` (
  `payNum` int(8) NOT NULL,
  `amount` double NOT NULL,
  `cardNum` char(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Payment`
--

INSERT INTO `Payment` (`payNum`, `amount`, `cardNum`) VALUES
(1, 1, '5784673876784777'),
(2, 66, '4500999988881717'),
(3, 360, '3340989810002999'),
(4, 140, '4534257638451234'),
(5, 64, '3321123487659090');

-- --------------------------------------------------------

--
-- Table structure for table `Reservation`
--

CREATE TABLE `Reservation` (
  `confNum` int(8) NOT NULL,
  `reserver` varchar(12) NOT NULL,
  `startDay` date NOT NULL,
  `endDay` date NOT NULL,
  `rsvSpace` double NOT NULL,
  `branch` int(5) DEFAULT NULL,
  `roomNum` int(3) DEFAULT NULL,
  `payment` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Reservation`
--

INSERT INTO `Reservation` (`confNum`, `reserver`, `startDay`, `endDay`, `rsvSpace`, `branch`, `roomNum`, `payment`) VALUES
(1, 'yuxin', '2019-06-20', '2019-06-21', 1, 10001, 103, 1),
(2, 'yixuan99', '2019-07-02', '2019-07-13', 2, 10005, 101, 2),
(3, 'yixuan99', '2022-03-02', '2022-03-26', 5, 10005, 101, 3),
(4, 'lizhe918', '2019-06-20', '2019-06-27', 5, 10001, 201, 4),
(5, 'gregor', '2019-09-19', '2019-09-27', 8, 10005, 201, 5);

-- --------------------------------------------------------

--
-- Table structure for table `Room_Type`
--

CREATE TABLE `Room_Type` (
  `roomNum` int(3) NOT NULL,
  `branchID` int(5) NOT NULL,
  `typeName` char(4) NOT NULL DEFAULT 'RGLR'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Room_Type`
--

INSERT INTO `Room_Type` (`roomNum`, `branchID`, `typeName`) VALUES
(101, 10001, 'CPGS'),
(201, 10001, 'CPGS'),
(101, 10002, 'CPGS'),
(103, 10005, 'CPGS'),
(102, 10001, 'EXPL'),
(104, 10001, 'EXPL'),
(201, 10001, 'EXPL'),
(102, 10002, 'EXPL'),
(101, 10003, 'EXPL'),
(401, 10003, 'EXPL'),
(102, 10001, 'FLAM'),
(104, 10001, 'FLAM'),
(201, 10001, 'FLAM'),
(102, 10002, 'FLAM'),
(201, 10003, 'FLAM'),
(401, 10003, 'FLAM'),
(102, 10005, 'FLAM'),
(101, 10002, 'FRGL'),
(103, 10002, 'FRGL'),
(301, 10003, 'FRGL'),
(101, 10004, 'FRGL'),
(101, 10005, 'FRGL'),
(103, 10002, 'FRZN'),
(101, 10004, 'FRZN'),
(101, 10005, 'FRZN'),
(101, 10001, 'OXDZ'),
(201, 10002, 'OXDZ'),
(301, 10003, 'OXDZ'),
(103, 10005, 'OXDZ'),
(101, 10001, 'RGLR'),
(102, 10001, 'RGLR'),
(103, 10001, 'RGLR'),
(104, 10001, 'RGLR'),
(201, 10001, 'RGLR'),
(101, 10002, 'RGLR'),
(102, 10002, 'RGLR'),
(103, 10002, 'RGLR'),
(201, 10002, 'RGLR'),
(202, 10002, 'RGLR'),
(301, 10002, 'RGLR'),
(101, 10003, 'RGLR'),
(201, 10003, 'RGLR'),
(301, 10003, 'RGLR'),
(401, 10003, 'RGLR'),
(501, 10003, 'RGLR'),
(101, 10004, 'RGLR'),
(201, 10004, 'RGLR'),
(101, 10005, 'RGLR'),
(102, 10005, 'RGLR'),
(103, 10005, 'RGLR'),
(201, 10005, 'RGLR'),
(104, 10001, 'WEPN'),
(202, 10002, 'WEPN'),
(101, 10003, 'WEPN'),
(102, 10005, 'WEPN');

-- --------------------------------------------------------

--
-- Table structure for table `Storeroom`
--

CREATE TABLE `Storeroom` (
  `roomNum` int(3) NOT NULL,
  `branchID` int(5) NOT NULL,
  `maxSpace` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Storeroom`
--

INSERT INTO `Storeroom` (`roomNum`, `branchID`, `maxSpace`) VALUES
(101, 10001, 100),
(101, 10002, 200),
(101, 10003, 300),
(101, 10004, 800),
(101, 10005, 150),
(102, 10001, 150),
(102, 10002, 200),
(102, 10005, 150),
(103, 10001, 200),
(103, 10002, 200),
(103, 10005, 150),
(104, 10001, 250),
(201, 10001, 700),
(201, 10002, 400),
(201, 10003, 300),
(201, 10004, 800),
(201, 10005, 450),
(202, 10002, 200),
(301, 10002, 600),
(301, 10003, 300),
(401, 10003, 300),
(501, 10003, 300);

--
-- Triggers `Storeroom`
--
DELIMITER $$
CREATE TRIGGER `totalRoomClass` AFTER INSERT ON `Storeroom` FOR EACH ROW INSERT INTO Room_Type(roomNUM, branchID, typeName) 

VALUES(new.roomNUM, new.branchID, 'RGLR')
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `UsedSpace`
--

CREATE TABLE `UsedSpace` (
  `roomNum` int(3) NOT NULL,
  `branchID` int(5) NOT NULL,
  `date` date NOT NULL,
  `space` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `UsedSpace`
--

INSERT INTO `UsedSpace` (`roomNum`, `branchID`, `date`, `space`) VALUES
(101, 10005, '2019-07-02', 2),
(101, 10005, '2019-07-03', 2),
(101, 10005, '2019-07-04', 2),
(101, 10005, '2019-07-05', 2),
(101, 10005, '2019-07-06', 2),
(101, 10005, '2019-07-07', 2),
(101, 10005, '2019-07-08', 2),
(101, 10005, '2019-07-09', 2),
(101, 10005, '2019-07-10', 2),
(101, 10005, '2019-07-11', 2),
(101, 10005, '2019-07-12', 2),
(101, 10005, '2022-03-02', 5),
(101, 10005, '2022-03-03', 5),
(101, 10005, '2022-03-04', 5),
(101, 10005, '2022-03-05', 5),
(101, 10005, '2022-03-06', 5),
(101, 10005, '2022-03-07', 5),
(101, 10005, '2022-03-08', 5),
(101, 10005, '2022-03-09', 5),
(101, 10005, '2022-03-10', 5),
(101, 10005, '2022-03-11', 5),
(101, 10005, '2022-03-12', 5),
(101, 10005, '2022-03-13', 5),
(101, 10005, '2022-03-14', 5),
(101, 10005, '2022-03-15', 5),
(101, 10005, '2022-03-16', 5),
(101, 10005, '2022-03-17', 5),
(101, 10005, '2022-03-18', 5),
(101, 10005, '2022-03-19', 5),
(101, 10005, '2022-03-20', 5),
(101, 10005, '2022-03-21', 5),
(101, 10005, '2022-03-22', 5),
(101, 10005, '2022-03-23', 5),
(101, 10005, '2022-03-24', 5),
(101, 10005, '2022-03-25', 5),
(103, 10001, '2019-06-20', 1),
(201, 10001, '2019-06-20', 5),
(201, 10001, '2019-06-21', 5),
(201, 10001, '2019-06-22', 5),
(201, 10001, '2019-06-23', 5),
(201, 10001, '2019-06-24', 5),
(201, 10001, '2019-06-25', 5),
(201, 10001, '2019-06-26', 5),
(201, 10005, '2019-09-19', 8),
(201, 10005, '2019-09-20', 8),
(201, 10005, '2019-09-21', 8),
(201, 10005, '2019-09-22', 8),
(201, 10005, '2019-09-23', 8),
(201, 10005, '2019-09-24', 8),
(201, 10005, '2019-09-25', 8),
(201, 10005, '2019-09-26', 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Agreement`
--
ALTER TABLE `Agreement`
  ADD PRIMARY KEY (`agrmtNum`),
  ADD UNIQUE KEY `payment` (`payment`),
  ADD UNIQUE KEY `fromResv` (`fromResv`);

--
-- Indexes for table `Branch`
--
ALTER TABLE `Branch`
  ADD PRIMARY KEY (`branchID`),
  ADD UNIQUE KEY `address` (`address`),
  ADD UNIQUE KEY `phoneNum` (`phoneNum`);

--
-- Indexes for table `Card`
--
ALTER TABLE `Card`
  ADD PRIMARY KEY (`cardNum`);

--
-- Indexes for table `Customer`
--
ALTER TABLE `Customer`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `IDNum` (`IDNum`),
  ADD UNIQUE KEY `phoneNum` (`phoneNum`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `Director`
--
ALTER TABLE `Director`
  ADD PRIMARY KEY (`employID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `Employee`
--
ALTER TABLE `Employee`
  ADD PRIMARY KEY (`employID`),
  ADD UNIQUE KEY `SINNum` (`SINNum`),
  ADD UNIQUE KEY `phoneNum` (`phoneNum`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `Item`
--
ALTER TABLE `Item`
  ADD PRIMARY KEY (`itemNum`),
  ADD KEY `agrmtNum` (`agrmtNum`);

--
-- Indexes for table `ItemClass`
--
ALTER TABLE `ItemClass`
  ADD PRIMARY KEY (`itemNum`,`typeName`),
  ADD KEY `typeName` (`typeName`);

--
-- Indexes for table `ItemInfo`
--
ALTER TABLE `ItemInfo`
  ADD PRIMARY KEY (`agrmtNum`),
  ADD KEY `owner` (`owner`),
  ADD KEY `branch` (`branch`),
  ADD KEY `roomNum` (`roomNum`,`branch`);

--
-- Indexes for table `ItemType`
--
ALTER TABLE `ItemType`
  ADD PRIMARY KEY (`typeName`);

--
-- Indexes for table `Labourer`
--
ALTER TABLE `Labourer`
  ADD PRIMARY KEY (`employID`),
  ADD UNIQUE KEY `innerPIN` (`innerPIN`),
  ADD KEY `branchID` (`branchID`);

--
-- Indexes for table `Manager`
--
ALTER TABLE `Manager`
  ADD PRIMARY KEY (`employID`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `branchID` (`branchID`);

--
-- Indexes for table `Payment`
--
ALTER TABLE `Payment`
  ADD PRIMARY KEY (`payNum`),
  ADD KEY `cardNum` (`cardNum`);

--
-- Indexes for table `Reservation`
--
ALTER TABLE `Reservation`
  ADD PRIMARY KEY (`confNum`),
  ADD UNIQUE KEY `payment` (`payment`),
  ADD KEY `reserver` (`reserver`),
  ADD KEY `branch` (`branch`),
  ADD KEY `roomNum` (`roomNum`,`branch`);

--
-- Indexes for table `Room_Type`
--
ALTER TABLE `Room_Type`
  ADD PRIMARY KEY (`branchID`,`roomNum`,`typeName`),
  ADD KEY `roomNum` (`roomNum`,`branchID`),
  ADD KEY `typeName` (`typeName`);

--
-- Indexes for table `Storeroom`
--
ALTER TABLE `Storeroom`
  ADD PRIMARY KEY (`roomNum`,`branchID`),
  ADD KEY `branchID` (`branchID`);

--
-- Indexes for table `UsedSpace`
--
ALTER TABLE `UsedSpace`
  ADD PRIMARY KEY (`roomNum`,`branchID`,`date`),
  ADD KEY `branchID` (`branchID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Agreement`
--
ALTER TABLE `Agreement`
  MODIFY `agrmtNum` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Branch`
--
ALTER TABLE `Branch`
  MODIFY `branchID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10006;

--
-- AUTO_INCREMENT for table `Employee`
--
ALTER TABLE `Employee`
  MODIFY `employID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1011;

--
-- AUTO_INCREMENT for table `Item`
--
ALTER TABLE `Item`
  MODIFY `itemNum` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Payment`
--
ALTER TABLE `Payment`
  MODIFY `payNum` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `Reservation`
--
ALTER TABLE `Reservation`
  MODIFY `confNum` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Agreement`
--
ALTER TABLE `Agreement`
  ADD CONSTRAINT `agreement_ibfk_1` FOREIGN KEY (`payment`) REFERENCES `Payment` (`payNum`) ON UPDATE CASCADE,
  ADD CONSTRAINT `agreement_ibfk_2` FOREIGN KEY (`fromResv`) REFERENCES `Reservation` (`confNum`) ON UPDATE CASCADE;

--
-- Constraints for table `Director`
--
ALTER TABLE `Director`
  ADD CONSTRAINT `director_ibfk_1` FOREIGN KEY (`employID`) REFERENCES `Employee` (`employID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Item`
--
ALTER TABLE `Item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`agrmtNum`) REFERENCES `Agreement` (`agrmtNum`) ON UPDATE CASCADE;

--
-- Constraints for table `ItemClass`
--
ALTER TABLE `ItemClass`
  ADD CONSTRAINT `itemclass_ibfk_1` FOREIGN KEY (`itemNum`) REFERENCES `Item` (`itemNum`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `itemclass_ibfk_2` FOREIGN KEY (`typeName`) REFERENCES `ItemType` (`typeName`) ON UPDATE CASCADE;

--
-- Constraints for table `ItemInfo`
--
ALTER TABLE `ItemInfo`
  ADD CONSTRAINT `iteminfo_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `Customer` (`username`) ON UPDATE CASCADE,
  ADD CONSTRAINT `iteminfo_ibfk_2` FOREIGN KEY (`agrmtNum`) REFERENCES `Agreement` (`agrmtNum`) ON UPDATE CASCADE,
  ADD CONSTRAINT `iteminfo_ibfk_3` FOREIGN KEY (`branch`) REFERENCES `Branch` (`branchID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `iteminfo_ibfk_4` FOREIGN KEY (`roomNum`,`branch`) REFERENCES `Storeroom` (`roomNum`, `branchID`) ON UPDATE CASCADE;

--
-- Constraints for table `Labourer`
--
ALTER TABLE `Labourer`
  ADD CONSTRAINT `labourer_ibfk_1` FOREIGN KEY (`employID`) REFERENCES `Employee` (`employID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `labourer_ibfk_2` FOREIGN KEY (`branchID`) REFERENCES `Branch` (`branchID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Manager`
--
ALTER TABLE `Manager`
  ADD CONSTRAINT `manager_ibfk_1` FOREIGN KEY (`employID`) REFERENCES `Employee` (`employID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `manager_ibfk_2` FOREIGN KEY (`branchID`) REFERENCES `Branch` (`branchID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Payment`
--
ALTER TABLE `Payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`cardNum`) REFERENCES `Card` (`cardNum`);

--
-- Constraints for table `Reservation`
--
ALTER TABLE `Reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`reserver`) REFERENCES `Customer` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`branch`) REFERENCES `Branch` (`branchID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_3` FOREIGN KEY (`roomNum`,`branch`) REFERENCES `Storeroom` (`roomNum`, `branchID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_4` FOREIGN KEY (`payment`) REFERENCES `Payment` (`payNum`) ON UPDATE CASCADE;

--
-- Constraints for table `Room_Type`
--
ALTER TABLE `Room_Type`
  ADD CONSTRAINT `room_type_ibfk_1` FOREIGN KEY (`roomNum`,`branchID`) REFERENCES `Storeroom` (`roomNum`, `branchID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `room_type_ibfk_2` FOREIGN KEY (`branchID`) REFERENCES `Branch` (`branchID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `room_type_ibfk_3` FOREIGN KEY (`typeName`) REFERENCES `ItemType` (`typeName`) ON UPDATE CASCADE;

--
-- Constraints for table `Storeroom`
--
ALTER TABLE `Storeroom`
  ADD CONSTRAINT `storeroom_ibfk_1` FOREIGN KEY (`branchID`) REFERENCES `Branch` (`branchID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `UsedSpace`
--
ALTER TABLE `UsedSpace`
  ADD CONSTRAINT `usedspace_ibfk_1` FOREIGN KEY (`roomNum`,`branchID`) REFERENCES `Storeroom` (`roomNum`, `branchID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usedspace_ibfk_2` FOREIGN KEY (`branchID`) REFERENCES `Branch` (`branchID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
