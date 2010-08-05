-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 05, 2010 at 08:50 AM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `mgrsys`
--

-- --------------------------------------------------------

--
-- Table structure for table `accesslog`
--

CREATE TABLE IF NOT EXISTS `accesslog` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `pageID` int(11) NOT NULL,
  `timeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ipAddress` varchar(16) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `accesslog`
--


-- --------------------------------------------------------

--
-- Table structure for table `messengers`
--

CREATE TABLE IF NOT EXISTS `messengers` (
  `userID` int(11) NOT NULL,
  `aim` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `msn` varchar(100) CHARACTER SET latin1 NOT NULL,
  `gtalk` varchar(100) CHARACTER SET latin1 NOT NULL,
  `yahoo` varchar(100) CHARACTER SET latin1 NOT NULL,
  KEY `userID` (`userID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `messengers`
--


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `displayName` varchar(50) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `password` varchar(25) NOT NULL,
  `Active` bit(1) NOT NULL,
  `lastLogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `user`
--


-- --------------------------------------------------------

--
-- Table structure for table `userdetails`
--

CREATE TABLE IF NOT EXISTS `userdetails` (
  `userID` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `DOB` date NOT NULL,
  KEY `userID` (`userID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userdetails`
--

