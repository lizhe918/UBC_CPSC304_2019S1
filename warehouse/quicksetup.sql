-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2019-06-16 17:21:48
-- 服务器版本： 10.1.40-MariaDB
-- PHP 版本： 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `zyxwstorage`
--

-- --------------------------------------------------------

--
-- 表的结构 `agreement`
--

CREATE TABLE `agreement` (
  `agrmtNum` int(8) NOT NULL,
  `startDay` date NOT NULL,
  `endDay` date NOT NULL,
  `payment` int(8) NOT NULL,
  `pickDay` date DEFAULT NULL,
  `fromResv` int(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `agreement`
--

INSERT INTO `agreement` (`agrmtNum`, `startDay`, `endDay`, `payment`, `pickDay`, `fromResv`) VALUES
(1, '2019-05-01', '2019-05-31', 10000001, NULL, NULL),
(2, '2019-05-02', '2019-06-01', 10000002, NULL, NULL),
(3, '2019-05-03', '2019-06-03', 10000003, NULL, NULL),
(4, '2019-05-04', '2019-06-04', 10000004, NULL, NULL),
(5, '2019-05-05', '2019-05-05', 10000005, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `branch`
--

CREATE TABLE `branch` (
  `branchID` int(5) NOT NULL,
  `address` varchar(128) NOT NULL,
  `phoneNum` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `branch`
--

INSERT INTO `branch` (`branchID`, `address`, `phoneNum`) VALUES
(1, '9 Hurricane Avenue, Surry, BC', '6045555555'),
(2, '2205 Lower Mall, Vancouver, BC', '7788623284'),
(3, '798-47 Main Mall, Vancouver, BC', '7782936837'),
(4, '58-889 W45 Street, Delta, BC', '7092735887'),
(5, '173 Robson Street, Vancouver, BC', '8398476593');

-- --------------------------------------------------------

--
-- 表的结构 `card`
--

CREATE TABLE `card` (
  `cardNum` char(16) NOT NULL,
  `cardExp` date DEFAULT NULL,
  `method` char(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `card`
--

INSERT INTO `card` (`cardNum`, `cardExp`, `method`) VALUES
('4514025831240001', '2019-09-19', 'VISA'),
('4514025831240002', '2019-05-31', 'VISA'),
('6002025831240003', '2019-12-26', 'MSTR'),
('6475836478950004', '2021-05-21', 'MSTR'),
('6882199231240005', '2019-09-25', 'MSTR');

-- --------------------------------------------------------

--
-- 表的结构 `customer`
--

CREATE TABLE `customer` (
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
-- 转存表中的数据 `customer`
--

INSERT INTO `customer` (`username`, `password`, `IDNum`, `lName`, `fName`, `phoneNum`, `address`, `email`) VALUES
('ada728', '19990728', 'STUC88888888', 'Tang', 'Ada', '7783021185', '888 61 St Vancouver', 'tangadaa@hotmail,com'),
('justin218', 'password', 'PSPTE12345678', 'Wong', 'Justin', '7782888218', '2600 East Broadway Street, Vancouver, BC, V5B 1Y5', 'justinc.s.wong@gmail.com'),
('lizhe1313', 'yxsy0102', 'STUC88792486', 'Li', 'Zhe', '7785227568', '788-2205 Lower Mall, Vancouver, BC, V6T1Z4', 'lizhe1313@outlook.com'),
('yixuan99', '19990316', 'STUC95411336', 'Qi', 'YiXuan', '7788989567', '2127 W 21 Ave, Vancouver, BC, V7S2Z4', ' yixuan99316@gmail.com '),
('yuxin', '19990312', 'STUC59056218', 'Tian', 'Yuxin', '7788623284', '2205 Lower Mall', 't1213528570@gmail.com');

-- --------------------------------------------------------

--
-- 表的结构 `director`
--

CREATE TABLE `director` (
  `employID` int(4) NOT NULL,
  `username` varchar(12) NOT NULL,
  `password` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `director`
--

INSERT INTO `director` (`employID`, `username`, `password`) VALUES
(3001, 'gary1999', '12345678');

-- --------------------------------------------------------

--
-- 表的结构 `employee`
--

CREATE TABLE `employee` (
  `employID` int(4) NOT NULL,
  `lName` varchar(32) DEFAULT NULL,
  `fName` varchar(32) NOT NULL,
  `SINNum` int(10) NOT NULL,
  `phoneNum` char(10) NOT NULL,
  `email` varchar(64) NOT NULL,
  `address` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `employee`
--

INSERT INTO `employee` (`employID`, `lName`, `fName`, `SINNum`, `phoneNum`, `email`, `address`) VALUES
(1001, 'Jefferson', 'Thomas', 123468592, '5781657923', 'jthomas@outlook.com', '8973 Penn Avenue, DC, US'),
(1002, 'Chen', 'Kevin', 123456780, '6048749999', 'kevinchen@gmail.com', '1235 Lois Lane, Gotham City, BC, V2Y 5X3'),
(1003, 'Chen', 'Xian', 123123123, '6046046044', 'xianchen@gmail.com', '1234 Candycane Lane, Chocklit City, BC, V3Y 3X4'),
(1004, 'Ava', 'Lily', 102465783, '3460827621', 'alily@163.com', '2223 West Mall, Vancouver, BC'),
(1005, 'Zhou', 'Jay', 453679809, '8857463527', 'zhoujielun@gmail.com', 'Tai bei road'),
(2001, 'Mia', 'Sophia', 187952389, '1357924862', 'msophia@gmail.com', '1247 East Mall, Vancouver, BC'),
(2002, 'Washinton', 'George', 435792568, '1234689995', 'wgeorge@gmail.com', '1247 East Mall, Vancouver, BC'),
(2003, 'Jack', 'Ben', 20154768, '7321654449', 'jackben@gmail.com', '1247 East Mall, Vancouver, BC'),
(2004, 'Josh', 'Smith', 202132112, '7685920003', 'jsmith@gmail.com', '1247 East Mall, Vancouver, BC'),
(2005, 'Alice', 'Zhang', 302165787, '2254687998', 'alicez@gmail.com', '1247 East Mall, Vancouver, BC'),
(3001, 'Zhang', 'Zijia', 1234567890, '7785227569', 'zijia@gmail.com', '788-2205 Lower Mall');

-- --------------------------------------------------------

--
-- 表的结构 `item`
--

CREATE TABLE `item` (
  `itemNum` int(12) NOT NULL,
  `agrmtNum` int(12) NOT NULL,
  `size` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `item`
--

INSERT INTO `item` (`itemNum`, `agrmtNum`, `size`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5);

--
-- 触发器 `item`
--
DELIMITER $$
CREATE TRIGGER `totalItemClass` AFTER INSERT ON `item` FOR EACH ROW INSERT INTO ItemClass(itemNUM, typeName) 

VALUES(new.itemNum, 'RGLR')
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `itemclass`
--

CREATE TABLE `itemclass` (
  `itemNum` int(12) NOT NULL,
  `typeName` char(4) NOT NULL DEFAULT 'RGLR'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `itemclass`
--

INSERT INTO `itemclass` (`itemNum`, `typeName`) VALUES
(1, 'RGLR'),
(2, 'RGLR'),
(3, 'RGLR'),
(4, 'RGLR'),
(5, 'RGLR');

-- --------------------------------------------------------

--
-- 表的结构 `iteminfo`
--

CREATE TABLE `iteminfo` (
  `agrmtNum` int(12) NOT NULL,
  `owner` varchar(12) NOT NULL,
  `branch` int(5) NOT NULL,
  `roomNum` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `iteminfo`
--

INSERT INTO `iteminfo` (`agrmtNum`, `owner`, `branch`, `roomNum`) VALUES
(1, 'ada728', 1, 101),
(2, 'justin218', 2, 101),
(3, 'lizhe1313', 3, 101),
(4, 'yixuan99', 4, 101),
(5, 'yuxin', 5, 101);

-- --------------------------------------------------------

--
-- 表的结构 `itemtype`
--

CREATE TABLE `itemtype` (
  `typeName` char(4) NOT NULL,
  `rate` int(11) DEFAULT NULL,
  `comment` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `itemtype`
--

INSERT INTO `itemtype` (`typeName`, `rate`, `comment`) VALUES
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
-- 表的结构 `labourer`
--

CREATE TABLE `labourer` (
  `employID` int(4) NOT NULL,
  `innerPIN` int(4) DEFAULT NULL,
  `branchID` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `labourer`
--

INSERT INTO `labourer` (`employID`, `innerPIN`, `branchID`) VALUES
(2001, 20000001, 1),
(2002, 20000002, 2),
(2003, 20000003, 3),
(2004, 20000004, 4),
(2005, 20000005, 5);

-- --------------------------------------------------------

--
-- 表的结构 `manager`
--

CREATE TABLE `manager` (
  `employID` int(4) NOT NULL,
  `username` varchar(12) NOT NULL,
  `password` varchar(16) NOT NULL,
  `branchID` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `manager`
--

INSERT INTO `manager` (`employID`, `username`, `password`, `branchID`) VALUES
(1001, 'jeff01', '00000001', 1),
(1002, 'kevin02', '00000002', 2),
(1003, 'chen03', '00000003', 3),
(1004, 'ava04', '00000004', 4),
(1005, 'jay05', '00000005', 5);

-- --------------------------------------------------------

--
-- 表的结构 `payment`
--

CREATE TABLE `payment` (
  `payNum` int(8) NOT NULL,
  `amount` double NOT NULL,
  `cardNum` char(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `payment`
--

INSERT INTO `payment` (`payNum`, `amount`, `cardNum`) VALUES
(10000001, 50, '4514025831240001'),
(10000002, 55, '4514025831240002'),
(10000003, 60, '6002025831240003'),
(10000004, 65, '6475836478950004'),
(10000005, 70, '6882199231240005'),
(10000006, 10, '4514025831240001'),
(10000007, 10, '4514025831240002'),
(10000008, 10, '6002025831240003'),
(10000009, 10, '6475836478950004'),
(10000010, 10, '6882199231240005');

-- --------------------------------------------------------

--
-- 表的结构 `reservation`
--

CREATE TABLE `reservation` (
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
-- 转存表中的数据 `reservation`
--

INSERT INTO `reservation` (`confNum`, `reserver`, `startDay`, `endDay`, `rsvSpace`, `branch`, `roomNum`, `payment`) VALUES
(10000001, 'ada728', '2019-06-01', '2019-06-03', 1, 1, 101, 10000006),
(10000002, 'justin218', '2019-06-01', '2019-06-07', 2, 2, 101, 10000007),
(10000003, 'lizhe1313', '2019-06-13', '2019-05-17', 3, 3, 101, 10000008),
(10000004, 'yixuan99', '2019-06-20', '2019-06-22', 4, 4, 101, 10000009),
(10000005, 'yuxin', '2019-06-19', '2019-06-24', 5, 5, 101, 10000010);

-- --------------------------------------------------------

--
-- 表的结构 `room_type`
--

CREATE TABLE `room_type` (
  `roomNum` int(3) NOT NULL,
  `branchID` int(5) NOT NULL,
  `typeName` char(4) NOT NULL DEFAULT 'RGLR'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `room_type`
--

INSERT INTO `room_type` (`roomNum`, `branchID`, `typeName`) VALUES
(101, 1, 'FLAM'),
(101, 1, 'FRZN'),
(101, 1, 'RGLR'),
(201, 1, 'RGLR'),
(101, 2, 'FRZN'),
(101, 2, 'RGLR'),
(102, 2, 'RGLR'),
(101, 3, 'RGLR'),
(101, 4, 'RGLR'),
(101, 5, 'RGLR');

-- --------------------------------------------------------

--
-- 表的结构 `storeroom`
--

CREATE TABLE `storeroom` (
  `roomNum` int(3) NOT NULL,
  `branchID` int(5) NOT NULL,
  `maxSpace` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `storeroom`
--

INSERT INTO `storeroom` (`roomNum`, `branchID`, `maxSpace`) VALUES
(101, 1, 100),
(101, 2, 200),
(101, 3, 300),
(101, 4, 400),
(101, 5, 500),
(102, 2, 500),
(201, 1, 500);

--
-- 触发器 `storeroom`
--
DELIMITER $$
CREATE TRIGGER `totalRoomClass` AFTER INSERT ON `storeroom` FOR EACH ROW INSERT INTO Room_Type(roomNUM, branchID, typeName) 

VALUES(new.roomNUM, new.branchID, 'RGLR')
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `usedspace`
--

CREATE TABLE `usedspace` (
  `roomNum` int(3) NOT NULL,
  `branchID` int(5) NOT NULL,
  `date` date NOT NULL,
  `space` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转储表的索引
--

--
-- 表的索引 `agreement`
--
ALTER TABLE `agreement`
  ADD PRIMARY KEY (`agrmtNum`),
  ADD UNIQUE KEY `payment` (`payment`),
  ADD UNIQUE KEY `fromResv` (`fromResv`);

--
-- 表的索引 `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branchID`),
  ADD UNIQUE KEY `address` (`address`),
  ADD UNIQUE KEY `phoneNum` (`phoneNum`);

--
-- 表的索引 `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`cardNum`);

--
-- 表的索引 `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `IDNum` (`IDNum`),
  ADD UNIQUE KEY `phoneNum` (`phoneNum`),
  ADD UNIQUE KEY `email` (`email`);

--
-- 表的索引 `director`
--
ALTER TABLE `director`
  ADD PRIMARY KEY (`employID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- 表的索引 `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employID`),
  ADD UNIQUE KEY `SINNum` (`SINNum`),
  ADD UNIQUE KEY `phoneNum` (`phoneNum`),
  ADD UNIQUE KEY `email` (`email`);

--
-- 表的索引 `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`itemNum`),
  ADD KEY `agrmtNum` (`agrmtNum`);

--
-- 表的索引 `itemclass`
--
ALTER TABLE `itemclass`
  ADD PRIMARY KEY (`itemNum`,`typeName`),
  ADD KEY `typeName` (`typeName`);

--
-- 表的索引 `iteminfo`
--
ALTER TABLE `iteminfo`
  ADD PRIMARY KEY (`agrmtNum`),
  ADD KEY `owner` (`owner`),
  ADD KEY `branch` (`branch`),
  ADD KEY `roomNum` (`roomNum`,`branch`);

--
-- 表的索引 `itemtype`
--
ALTER TABLE `itemtype`
  ADD PRIMARY KEY (`typeName`);

--
-- 表的索引 `labourer`
--
ALTER TABLE `labourer`
  ADD PRIMARY KEY (`employID`),
  ADD UNIQUE KEY `innerPIN` (`innerPIN`),
  ADD KEY `branchID` (`branchID`);

--
-- 表的索引 `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`employID`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `branchID` (`branchID`);

--
-- 表的索引 `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payNum`),
  ADD KEY `cardNum` (`cardNum`);

--
-- 表的索引 `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`confNum`),
  ADD UNIQUE KEY `payment` (`payment`),
  ADD KEY `reserver` (`reserver`),
  ADD KEY `branch` (`branch`),
  ADD KEY `roomNum` (`roomNum`,`branch`);

--
-- 表的索引 `room_type`
--
ALTER TABLE `room_type`
  ADD PRIMARY KEY (`branchID`,`roomNum`,`typeName`),
  ADD KEY `roomNum` (`roomNum`,`branchID`),
  ADD KEY `typeName` (`typeName`);

--
-- 表的索引 `storeroom`
--
ALTER TABLE `storeroom`
  ADD PRIMARY KEY (`roomNum`,`branchID`),
  ADD KEY `branchID` (`branchID`);

--
-- 表的索引 `usedspace`
--
ALTER TABLE `usedspace`
  ADD PRIMARY KEY (`roomNum`,`branchID`,`date`),
  ADD KEY `branchID` (`branchID`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `agreement`
--
ALTER TABLE `agreement`
  MODIFY `agrmtNum` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `branch`
--
ALTER TABLE `branch`
  MODIFY `branchID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `employee`
--
ALTER TABLE `employee`
  MODIFY `employID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3002;

--
-- 使用表AUTO_INCREMENT `item`
--
ALTER TABLE `item`
  MODIFY `itemNum` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `payment`
--
ALTER TABLE `payment`
  MODIFY `payNum` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000011;

--
-- 使用表AUTO_INCREMENT `reservation`
--
ALTER TABLE `reservation`
  MODIFY `confNum` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000006;

--
-- 限制导出的表
--

--
-- 限制表 `agreement`
--
ALTER TABLE `agreement`
  ADD CONSTRAINT `agreement_ibfk_1` FOREIGN KEY (`payment`) REFERENCES `payment` (`payNum`) ON UPDATE CASCADE,
  ADD CONSTRAINT `agreement_ibfk_2` FOREIGN KEY (`fromResv`) REFERENCES `reservation` (`confNum`) ON UPDATE CASCADE;

--
-- 限制表 `director`
--
ALTER TABLE `director`
  ADD CONSTRAINT `director_ibfk_1` FOREIGN KEY (`employID`) REFERENCES `employee` (`employID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`agrmtNum`) REFERENCES `agreement` (`agrmtNum`) ON UPDATE CASCADE;

--
-- 限制表 `itemclass`
--
ALTER TABLE `itemclass`
  ADD CONSTRAINT `itemclass_ibfk_1` FOREIGN KEY (`itemNum`) REFERENCES `item` (`itemNum`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `itemclass_ibfk_2` FOREIGN KEY (`typeName`) REFERENCES `itemtype` (`typeName`) ON UPDATE CASCADE;

--
-- 限制表 `iteminfo`
--
ALTER TABLE `iteminfo`
  ADD CONSTRAINT `iteminfo_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `customer` (`username`) ON UPDATE CASCADE,
  ADD CONSTRAINT `iteminfo_ibfk_2` FOREIGN KEY (`agrmtNum`) REFERENCES `agreement` (`agrmtNum`) ON UPDATE CASCADE,
  ADD CONSTRAINT `iteminfo_ibfk_3` FOREIGN KEY (`branch`) REFERENCES `branch` (`branchID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `iteminfo_ibfk_4` FOREIGN KEY (`roomNum`,`branch`) REFERENCES `storeroom` (`roomNum`, `branchID`) ON UPDATE CASCADE;

--
-- 限制表 `labourer`
--
ALTER TABLE `labourer`
  ADD CONSTRAINT `labourer_ibfk_1` FOREIGN KEY (`employID`) REFERENCES `employee` (`employID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `labourer_ibfk_2` FOREIGN KEY (`branchID`) REFERENCES `branch` (`branchID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `manager`
--
ALTER TABLE `manager`
  ADD CONSTRAINT `manager_ibfk_1` FOREIGN KEY (`employID`) REFERENCES `employee` (`employID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `manager_ibfk_2` FOREIGN KEY (`branchID`) REFERENCES `branch` (`branchID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`cardNum`) REFERENCES `card` (`cardNum`);

--
-- 限制表 `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`reserver`) REFERENCES `customer` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`branch`) REFERENCES `branch` (`branchID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_3` FOREIGN KEY (`roomNum`,`branch`) REFERENCES `storeroom` (`roomNum`, `branchID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_4` FOREIGN KEY (`payment`) REFERENCES `payment` (`payNum`) ON UPDATE CASCADE;

--
-- 限制表 `room_type`
--
ALTER TABLE `room_type`
  ADD CONSTRAINT `room_type_ibfk_1` FOREIGN KEY (`roomNum`,`branchID`) REFERENCES `storeroom` (`roomNum`, `branchID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `room_type_ibfk_2` FOREIGN KEY (`branchID`) REFERENCES `branch` (`branchID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `room_type_ibfk_3` FOREIGN KEY (`typeName`) REFERENCES `itemtype` (`typeName`) ON UPDATE CASCADE;

--
-- 限制表 `storeroom`
--
ALTER TABLE `storeroom`
  ADD CONSTRAINT `storeroom_ibfk_1` FOREIGN KEY (`branchID`) REFERENCES `branch` (`branchID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `usedspace`
--
ALTER TABLE `usedspace`
  ADD CONSTRAINT `usedspace_ibfk_1` FOREIGN KEY (`roomNum`,`branchID`) REFERENCES `storeroom` (`roomNum`, `branchID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usedspace_ibfk_2` FOREIGN KEY (`branchID`) REFERENCES `branch` (`branchID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
