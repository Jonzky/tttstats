-- phpMyAdmin SQL Dump
-- version 3.4.11.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 05, 2013 at 01:17 PM
-- Server version: 5.5.23
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jonzky_sb`
--

-- --------------------------------------------------------

--
-- Table structure for table `server_track`
--

CREATE TABLE IF NOT EXISTS `server_track` (
  `hostip` text NOT NULL,
  `hostname` text NOT NULL,
  `maxplayers` int(10) NOT NULL,
  `map` text NOT NULL,
  `players` int(11) NOT NULL,
  `lastupdate` int(11) NOT NULL,
  PRIMARY KEY (`hostip`(20))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
