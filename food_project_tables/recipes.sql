-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2015 at 02:21 PM
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
-- Table structure for table `recipes`
--
-- Creation: Aug 02, 2015 at 02:41 PM
--

CREATE TABLE IF NOT EXISTS `recipes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `id_food_type` int(11) NOT NULL,
  `cal_recipe` int(11) DEFAULT NULL COMMENT 'calories in 100 g of the meal',
  `gi_recipe` int(11) DEFAULT NULL COMMENT 'gi of 100 gr of the meal',
  `description` text NOT NULL,
  `content_photo` longblob NOT NULL,
  `name_photo` varchar(200) NOT NULL,
  `type_photo` varchar(200) NOT NULL,
  `size_photo` int(11) NOT NULL,
  `date_published` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_deleted` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `name_2` (`name`),
  KEY `user_id` (`user_id`),
  KEY `id_food_type` (`id_food_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- RELATIONS FOR TABLE `recipes`:
--   `id_food_type`
--       `food_types` -> `id_food`
--   `user_id`
--       `users` -> `id`
--

--
-- Constraints for dumped tables
--

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
