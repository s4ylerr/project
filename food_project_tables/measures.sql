-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2015 at 02:20 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `foods_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `measures`
--
-- Creation: Jul 28, 2015 at 06:22 PM
--

CREATE TABLE IF NOT EXISTS `measures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `measure` varchar(30) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `measure` (`measure`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=37 ;

--
-- Dumping data for table `measures`
--

INSERT INTO `measures` (`id`, `measure`) VALUES
(32, 'бр.'),
(35, 'връзка'),
(33, 'гл.'),
(28, 'гр'),
(31, 'к. л.'),
(29, 'мл'),
(34, 'стрък'),
(30, 'ч. л.'),
(36, 'щипка');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
