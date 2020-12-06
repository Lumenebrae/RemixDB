-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Host: mydb.ics.purdue.edu
-- Generation Time: Oct 13, 2020 at 06:37 PM
-- Server version: 5.5.62-log
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cs348`
--

-- --------------------------------------------------------

--
-- Table structure for table `Albums`
--

CREATE TABLE IF NOT EXISTS `Albums` (
  `ALID` int(20) NOT NULL AUTO_INCREMENT,
  `AID` int(20) DEFAULT NULL,
  `GID` int(20) DEFAULT NULL,
  `Name` tinytext,
  PRIMARY KEY (`ALID`),
  KEY `AID` (`AID`),
  KEY `GID` (`GID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `AlbumTracks`
--

CREATE TABLE IF NOT EXISTS `AlbumTracks` (
  `ALID` int(20) NOT NULL DEFAULT '0',
  `TID` int(20) NOT NULL DEFAULT '0',
  `TrackNumber` int(20) DEFAULT NULL,
  PRIMARY KEY (`ALID`,`TID`),
  KEY `TID` (`TID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Artists`
--

CREATE TABLE IF NOT EXISTS `Artists` (
  `AID` int(20) NOT NULL AUTO_INCREMENT,
  `Name` tinytext,
  PRIMARY KEY (`AID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `BandGroups`
--

CREATE TABLE IF NOT EXISTS `BandGroups` (
  `GID` int(20) NOT NULL AUTO_INCREMENT,
  `Name` tinytext,
  `YearFormed` year(4) DEFAULT NULL,
  `type` tinytext,
  PRIMARY KEY (`GID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Member`
--

CREATE TABLE IF NOT EXISTS `Member` (
  `AID` int(20) NOT NULL DEFAULT '0',
  `GID` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`AID`,`GID`),
  KEY `GID` (`GID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Remix`
--

CREATE TABLE IF NOT EXISTS `Remix` (
  `TransformedID` int(20) NOT NULL DEFAULT '0',
  `OriginalID` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`TransformedID`,`OriginalID`),
  KEY `OriginalID` (`OriginalID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Track`
--

CREATE TABLE IF NOT EXISTS `Track` (
  `TID` int(20) NOT NULL AUTO_INCREMENT,
  `Name` tinytext,
  `Length` time DEFAULT NULL,
  `Genre` tinytext,
  `UID` int(20) DEFAULT NULL,
  PRIMARY KEY (`TID`),
  KEY `UID` (`UID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TrackCreditArtist`
--

CREATE TABLE IF NOT EXISTS `TrackCreditArtist` (
  `TID` int(20) NOT NULL DEFAULT '0',
  `AID` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`TID`,`AID`),
  KEY `AID` (`AID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TrackCreditGroup`
--

CREATE TABLE IF NOT EXISTS `TrackCreditGroup` (
  `TID` int(20) NOT NULL DEFAULT '0',
  `GID` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`TID`,`GID`),
  KEY `GID` (`GID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `UID` int(20) NOT NULL AUTO_INCREMENT,
  `UserName` tinytext,
  `Password` tinytext,
  `Realname` tinytext,
  `Email` tinytext,
  PRIMARY KEY (`UID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserTracks`
--

CREATE TABLE IF NOT EXISTS `UserTracks` (
  `UID` int(20) DEFAULT NULL,
  `TID` int(20) DEFAULT NULL,
  KEY `UID` (`UID`),
  KEY `TID` (`TID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Albums`
--
ALTER TABLE `Albums`
  ADD CONSTRAINT `Albums_ibfk_1` FOREIGN KEY (`AID`) REFERENCES `Artists` (`AID`),
  ADD CONSTRAINT `Albums_ibfk_2` FOREIGN KEY (`GID`) REFERENCES `BandGroups` (`GID`);

--
-- Constraints for table `AlbumTracks`
--
ALTER TABLE `AlbumTracks`
  ADD CONSTRAINT `AlbumTracks_ibfk_1` FOREIGN KEY (`ALID`) REFERENCES `Albums` (`ALID`),
  ADD CONSTRAINT `AlbumTracks_ibfk_2` FOREIGN KEY (`TID`) REFERENCES `Track` (`TID`);

--
-- Constraints for table `Member`
--
ALTER TABLE `Member`
  ADD CONSTRAINT `Member_ibfk_1` FOREIGN KEY (`AID`) REFERENCES `Artists` (`AID`),
  ADD CONSTRAINT `Member_ibfk_2` FOREIGN KEY (`GID`) REFERENCES `BandGroups` (`GID`);

--
-- Constraints for table `Remix`
--
ALTER TABLE `Remix`
  ADD CONSTRAINT `Remix_ibfk_1` FOREIGN KEY (`TransformedID`) REFERENCES `Track` (`TID`),
  ADD CONSTRAINT `Remix_ibfk_2` FOREIGN KEY (`OriginalID`) REFERENCES `Track` (`TID`);

--
-- Constraints for table `Track`
--
ALTER TABLE `Track`
  ADD CONSTRAINT `Track_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `User` (`UID`);

--
-- Constraints for table `TrackCreditArtist`
--
ALTER TABLE `TrackCreditArtist`
  ADD CONSTRAINT `TrackCreditArtist_ibfk_1` FOREIGN KEY (`TID`) REFERENCES `Track` (`TID`),
  ADD CONSTRAINT `TrackCreditArtist_ibfk_2` FOREIGN KEY (`AID`) REFERENCES `Artists` (`AID`);

--
-- Constraints for table `TrackCreditGroup`
--
ALTER TABLE `TrackCreditGroup`
  ADD CONSTRAINT `TrackCreditGroup_ibfk_1` FOREIGN KEY (`TID`) REFERENCES `Track` (`TID`),
  ADD CONSTRAINT `TrackCreditGroup_ibfk_2` FOREIGN KEY (`GID`) REFERENCES `BandGroups` (`GID`);

--
-- Constraints for table `UserTracks`
--
ALTER TABLE `UserTracks`
  ADD CONSTRAINT `UserTracks_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `User` (`UID`),
  ADD CONSTRAINT `UserTracks_ibfk_2` FOREIGN KEY (`TID`) REFERENCES `Track` (`TID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
