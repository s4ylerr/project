-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2015 at 02:19 PM
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
-- Table structure for table `food_types`
--
-- Creation: Aug 02, 2015 at 04:06 PM
--

CREATE TABLE IF NOT EXISTS `food_types` (
  `id_food` int(11) NOT NULL AUTO_INCREMENT,
  `food_type` varchar(50) NOT NULL,
  PRIMARY KEY (`id_food`),
  UNIQUE KEY `food_type` (`food_type`),
  KEY `id` (`id_food`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `food_types`
--

INSERT INTO `food_types` (`id_food`, `food_type`) VALUES
(11, 'коктейли'),
(10, 'напитки'),
(5, 'постни ястия'),
(1, 'предястия'),
(2, 'салати'),
(4, 'сосове'),
(3, 'супи'),
(9, 'тестени изделия и десерти'),
(8, 'ястия с месо'),
(7, 'ястия с птици и дивеч'),
(6, 'ястия с риба и морски деликатеси');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
