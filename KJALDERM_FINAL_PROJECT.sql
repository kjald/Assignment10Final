-- phpMyAdmin SQL Dump
-- version 4.2.9
-- http://www.phpmyadmin.net
--
-- Host: webdb.uvm.edu
-- Generation Time: Dec 05, 2014 at 04:33 PM
-- Server version: 5.5.40-36.1-log
-- PHP Version: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `KJALDERM_FINAL_PROJECT`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblAdmin`
--

CREATE TABLE IF NOT EXISTS `tblAdmin` (
`pmkAdminID` int(11) NOT NULL,
  `fldAdminUsername` varchar(25) NOT NULL,
  `fldPassword` varchar(10) NOT NULL,
  `fldVerifiedAdmin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblPromotion`
--

CREATE TABLE IF NOT EXISTS `tblPromotion` (
`pmkPromotionID` int(11) NOT NULL,
  `fnkUserID` int(11) NOT NULL,
  `fldEmails` tinyint(1) DEFAULT NULL,
  `fldItems` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblPromotion`
--

INSERT INTO `tblPromotion` (`pmkPromotionID`, `fnkUserID`, `fldEmails`, `fldItems`) VALUES
(40, 0, NULL, NULL),
(41, 0, 1, 1),
(42, 0, 1, 1),
(43, 0, 1, 1),
(44, 0, 0, 1),
(45, 0, NULL, NULL),
(46, 0, 0, 1),
(47, 0, 0, 1),
(48, 0, 1, 0),
(49, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblShopping`
--

CREATE TABLE IF NOT EXISTS `tblShopping` (
`pmkShoppingID` int(11) NOT NULL,
  `fnkUserID` int(11) NOT NULL,
  `fldMon` tinyint(1) DEFAULT NULL,
  `fldTue` tinyint(1) DEFAULT NULL,
  `fldWed` tinyint(1) DEFAULT NULL,
  `fldThu` tinyint(1) DEFAULT NULL,
  `fldFri` tinyint(1) DEFAULT NULL,
  `fldSat` tinyint(1) DEFAULT NULL,
  `fldSun` tinyint(1) DEFAULT NULL,
  `fldGroupSize` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblShopping`
--

INSERT INTO `tblShopping` (`pmkShoppingID`, `fnkUserID`, `fldMon`, `fldTue`, `fldWed`, `fldThu`, `fldFri`, `fldSat`, `fldSun`, `fldGroupSize`) VALUES
(40, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 0, 1, 1, 1, 1, 1, 1, 1, 'One'),
(42, 0, 1, 1, 1, 1, 1, 1, 1, 'One'),
(43, 0, 1, 1, 1, 1, 1, 1, 1, 'One'),
(44, 0, 1, 0, 0, 0, 0, 0, 0, 'Two'),
(45, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(46, 0, 1, 0, 0, 1, 0, 0, 0, 'One'),
(47, 0, 1, 0, 0, 1, 0, 0, 0, 'One');

-- --------------------------------------------------------

--
-- Table structure for table `tblUser`
--

CREATE TABLE IF NOT EXISTS `tblUser` (
`pmkUserId` int(11) NOT NULL,
  `fnkShoppingID` int(11) NOT NULL,
  `fnkPromotionID` int(11) NOT NULL,
  `fldFirstName` varchar(100) NOT NULL,
  `fldLastName` varchar(100) NOT NULL,
  `fldEmail` varchar(65) DEFAULT NULL,
  `fldZip` int(10) DEFAULT NULL,
  `fldDateJoined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fldConfirmed` tinyint(1) NOT NULL DEFAULT '0',
  `fldApproved` tinyint(4) NOT NULL DEFAULT '0',
  `fldExist` tinyint(2) NOT NULL DEFAULT '13'
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblUser`
--

INSERT INTO `tblUser` (`pmkUserId`, `fnkShoppingID`, `fnkPromotionID`, `fldFirstName`, `fldLastName`, `fldEmail`, `fldZip`, `fldDateJoined`, `fldConfirmed`, `fldApproved`, `fldExist`) VALUES
(40, 0, 0, '', '', NULL, NULL, '2014-12-05 19:29:18', 0, 0, 13);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblAdmin`
--
ALTER TABLE `tblAdmin`
 ADD PRIMARY KEY (`pmkAdminID`);

--
-- Indexes for table `tblPromotion`
--
ALTER TABLE `tblPromotion`
 ADD PRIMARY KEY (`pmkPromotionID`), ADD KEY `fnkUserID` (`fnkUserID`);

--
-- Indexes for table `tblShopping`
--
ALTER TABLE `tblShopping`
 ADD PRIMARY KEY (`pmkShoppingID`), ADD KEY `fnkUserID` (`fnkUserID`);

--
-- Indexes for table `tblUser`
--
ALTER TABLE `tblUser`
 ADD PRIMARY KEY (`pmkUserId`), ADD UNIQUE KEY `fnkShoppingID` (`fnkShoppingID`), ADD UNIQUE KEY `fnkPromotionID` (`fnkPromotionID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblAdmin`
--
ALTER TABLE `tblAdmin`
MODIFY `pmkAdminID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblPromotion`
--
ALTER TABLE `tblPromotion`
MODIFY `pmkPromotionID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `tblShopping`
--
ALTER TABLE `tblShopping`
MODIFY `pmkShoppingID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `tblUser`
--
ALTER TABLE `tblUser`
MODIFY `pmkUserId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
