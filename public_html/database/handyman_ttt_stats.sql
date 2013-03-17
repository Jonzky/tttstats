-- phpMyAdmin SQL Dump
-- version 3.4.11.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 17, 2013 at 07:17 AM
-- Server version: 5.5.23
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `handyman_ttt_stats`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE IF NOT EXISTS `admin_users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `email` text COLLATE utf8_unicode_ci NOT NULL,
  `user` text COLLATE utf8_unicode_ci NOT NULL,
  `pass` text COLLATE utf8_unicode_ci NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `last_ip` text COLLATE utf8_unicode_ci NOT NULL,
  `steamID` text COLLATE utf8_unicode_ci NOT NULL,
  `isadmin` int(11) NOT NULL,
  `hash` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `unique usernames` (`user`(100))
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=54 ;

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

-- --------------------------------------------------------

--
-- Table structure for table `ttt_report`
--

CREATE TABLE IF NOT EXISTS `ttt_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `steamid` text COLLATE utf8_unicode_ci NOT NULL,
  `nickname` text COLLATE utf8_unicode_ci NOT NULL,
  `lKarma` int(5) NOT NULL,
  `opKills` int(5) NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `repID` text COLLATE utf8_unicode_ci NOT NULL,
  `repNick` text COLLATE utf8_unicode_ci NOT NULL,
  `report_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=75 ;

-- --------------------------------------------------------

--
-- Table structure for table `ttt_stats`
--

CREATE TABLE IF NOT EXISTS `ttt_stats` (
  `steamid` text NOT NULL,
  `nickname` text NOT NULL,
  `playtime` bigint(20) NOT NULL DEFAULT '1',
  `roundsplayed` int(10) NOT NULL,
  `innocenttimes` int(10) NOT NULL,
  `detectivetimes` int(10) NOT NULL,
  `traitortimes` int(10) NOT NULL,
  `deaths` int(10) NOT NULL,
  `kills` int(10) NOT NULL,
  `points` int(11) NOT NULL,
  `maxfrags` int(10) NOT NULL,
  `headshots` int(11) NOT NULL,
  `first_joined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_seen` text NOT NULL,
  `isadmin` int(11) NOT NULL,
  PRIMARY KEY (`steamid`(15))
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
