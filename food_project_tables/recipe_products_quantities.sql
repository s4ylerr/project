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
-- Table structure for table `recipe_products_quantities`
--
-- Creation: Aug 01, 2015 at 07:18 PM
--

CREATE TABLE IF NOT EXISTS `recipe_products_quantities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recipe_id` int(11) NOT NULL,
  `product_id` int(20) NOT NULL,
  `measures_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `quantity_gr` float DEFAULT NULL COMMENT 'weight in the receipt in gr',
  `date_deleted` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `recipe_id` (`recipe_id`,`product_id`,`measures_id`),
  KEY `product_id` (`product_id`),
  KEY `measures_id` (`measures_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

--
-- RELATIONS FOR TABLE `recipe_products_quantities`:
--   `measures_id`
--       `measures` -> `id`
--   `product_id`
--       `products` -> `id`
--   `recipe_id`
--       `recipes` -> `id`
--

--
-- Constraints for dumped tables
--

--
-- Constraints for table `recipe_products_quantities`
--
ALTER TABLE `recipe_products_quantities`
  ADD CONSTRAINT `recipe_products_quantities_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`),
  ADD CONSTRAINT `recipe_products_quantities_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `recipe_products_quantities_ibfk_3` FOREIGN KEY (`measures_id`) REFERENCES `measures` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
