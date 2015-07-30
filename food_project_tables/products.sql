-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2015 at 01:00 PM
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
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product` varchar(200) NOT NULL,
  `product_type` int(11) DEFAULT NULL,
  `calories` int(11) NOT NULL,
  `gi` int(11) NOT NULL,
  `picture` blob,
  `user_id` int(11) NOT NULL,
  `date_deleted` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product` (`product`),
  KEY `product_type` (`product_type`),
  KEY `users_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=109 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product`, `product_type`, `calories`, `gi`, `picture`, `user_id`, `date_deleted`) VALUES
(3, 'пълнозърнест хляб', NULL, 180, 35, NULL, 7, NULL),
(4, 'ръжен хляб', NULL, 170, 40, NULL, 7, NULL),
(5, 'овесени ядки', NULL, 384, 45, NULL, 7, NULL),
(6, 'качамак', NULL, 72, 40, NULL, 7, NULL),
(7, 'булгур', NULL, 342, 22, NULL, 7, NULL),
(8, 'мляко, 3,2%', NULL, 60, 25, NULL, 7, NULL),
(9, 'ядки', NULL, 21, 20, NULL, 7, NULL),
(14, 'хляб', NULL, 200, 100, NULL, 7, '2015-07-28'),
(15, 'продукт', NULL, 100, 100, NULL, 7, NULL),
(16, 'орехи', NULL, 654, 15, NULL, 7, NULL),
(18, 'фъстъци', NULL, 567, 18, NULL, 7, NULL),
(19, 'слънчогледово семе', NULL, 570, 6, NULL, 7, NULL),
(20, 'фъстъчено масло', NULL, 589, 32, NULL, 7, NULL),
(21, 'продукт2', NULL, 2, 2, NULL, 7, '2015-07-30'),
(22, 'бира', NULL, 41, 45, NULL, 7, NULL),
(23, 'вино, десертно', NULL, 68, 20, NULL, 7, NULL),
(24, 'шампанскор полусухо', NULL, 133, 20, NULL, 7, NULL),
(25, 'кренвирши', NULL, 301, 28, NULL, 7, NULL),
(26, 'вишни', NULL, 72, 23, NULL, 7, NULL),
(27, 'череши', NULL, 72, 23, NULL, 7, NULL),
(28, 'кайсии', NULL, 48, 35, NULL, 7, NULL),
(29, 'ябълки', NULL, 59, 35, NULL, 7, NULL),
(30, 'круши', NULL, 59, 35, NULL, 7, NULL),
(31, 'сливи', NULL, 55, 25, NULL, 7, NULL),
(32, 'праскови', NULL, 43, 30, NULL, 7, NULL),
(33, 'грозде', NULL, 71, 46, NULL, 7, NULL),
(34, 'пъпеш', NULL, 35, 44, NULL, 7, NULL),
(35, 'нар', NULL, 68, 30, NULL, 7, NULL),
(36, 'портокали', NULL, 47, 40, NULL, 7, NULL),
(37, 'грейпфрут', NULL, 32, 25, NULL, 7, NULL),
(38, 'лимони', NULL, 29, 20, NULL, 7, NULL),
(39, 'ягоди', NULL, 30, 40, NULL, 7, NULL),
(40, 'къпини', NULL, 52, 27, NULL, 7, NULL),
(41, 'грейпфрут, натурален сок', NULL, 39, 40, NULL, 7, NULL),
(42, 'ананаср натурален сок', NULL, 56, 46, NULL, 7, NULL),
(43, 'портокал, натурален сок', NULL, 43, 45, NULL, 7, NULL),
(44, 'грозде, натурален сок', NULL, 50, 40, NULL, 7, NULL),
(45, 'ябълки, натурален сок', NULL, 50, 40, NULL, 7, NULL),
(46, 'вишни, натурален сок', NULL, 50, 40, NULL, 7, NULL),
(47, 'праскови, натурален сок', NULL, 50, 40, NULL, 7, NULL),
(48, 'сливи, натурален сок', NULL, 50, 40, NULL, 7, NULL),
(49, 'аспержи', NULL, 23, 15, NULL, 7, NULL),
(50, 'броколи', NULL, 28, 10, NULL, 7, NULL),
(51, 'карфиол', NULL, 25, 15, NULL, 7, NULL),
(52, 'краставици', NULL, 13, 20, NULL, 7, NULL),
(53, 'патраджани', NULL, 26, 12, NULL, 7, NULL),
(54, 'чушки, зелени', NULL, 27, 10, NULL, 7, NULL),
(55, 'чушки, червени', NULL, 27, 15, NULL, 7, NULL),
(56, 'моркови', NULL, 43, 35, NULL, 7, NULL),
(57, 'спанак', NULL, 22, 15, NULL, 7, NULL),
(58, 'домати', NULL, 21, 10, NULL, 7, NULL),
(59, 'тиквички', NULL, 14, 15, NULL, 7, NULL),
(60, 'зелен фасул', NULL, 31, 32, NULL, 7, NULL),
(61, 'зрял боб', NULL, 333, 40, NULL, 7, NULL),
(62, 'боб, червен', NULL, 333, 19, NULL, 7, NULL),
(63, 'леща', NULL, 338, 28, NULL, 7, NULL),
(64, 'леща, червена', NULL, 346, 36, NULL, 7, NULL),
(65, 'нахут', NULL, 364, 33, NULL, 7, NULL),
(66, 'маруля', NULL, 13, 10, NULL, 7, NULL),
(67, 'салата, зелена', NULL, 14, 10, NULL, 7, NULL),
(68, 'гъби, пресни', NULL, 25, 10, NULL, 7, NULL),
(69, 'зеле, бяло', NULL, 25, 15, NULL, 7, NULL),
(70, 'ряпа', NULL, 27, 15, NULL, 7, NULL),
(71, 'репички', NULL, 27, 15, NULL, 7, NULL),
(72, 'хляб, типов', NULL, 230, 69, NULL, 7, NULL),
(73, 'питка от бяло брашно', NULL, 275, 75, NULL, 7, NULL),
(74, 'франзела', NULL, 274, 75, NULL, 7, NULL),
(75, 'фиде, оризово', NULL, 351, 58, NULL, 7, NULL),
(76, 'кус-кус', NULL, 376, 65, NULL, 7, NULL),
(77, 'брашно, бяло', NULL, 364, 70, NULL, 7, NULL),
(78, 'брашно, оризово', NULL, 366, 95, NULL, 7, NULL),
(79, 'бисквити', NULL, 364, 60, NULL, 7, NULL),
(80, 'спагети от твърда пшеница', NULL, 371, 53, NULL, 7, NULL),
(81, 'спагети, оризови', NULL, 351, 58, NULL, 7, NULL),
(82, 'макарони', NULL, 371, 60, NULL, 7, NULL),
(83, 'галета', NULL, 367, 74, NULL, 7, NULL),
(84, 'ориз, бял', NULL, 365, 60, NULL, 7, NULL),
(85, 'царевица, варена', NULL, 86, 70, NULL, 7, NULL),
(86, 'царевица, сладка, консервирана', NULL, 65, 59, NULL, 7, NULL),
(87, 'корнфлейкс', NULL, 361, 82, NULL, 7, NULL),
(88, 'елда', NULL, 343, 55, NULL, 7, NULL),
(89, 'глюкоза', NULL, 387, 100, NULL, 7, NULL),
(90, 'захар', NULL, 387, 60, NULL, 7, NULL),
(91, 'мед', NULL, 304, 84, NULL, 7, NULL),
(92, 'конфитюр', NULL, 278, 60, NULL, 7, NULL),
(93, 'мармалад', NULL, 278, 60, NULL, 7, NULL),
(94, 'шоколад, млечен', NULL, 513, 70, NULL, 7, NULL),
(95, 'халва, тахан, слънчогледова', NULL, 469, 70, NULL, 7, NULL),
(96, 'киви', NULL, 61, 52, NULL, 7, NULL),
(97, 'банани', NULL, 92, 61, NULL, 7, NULL),
(98, 'манго', NULL, 65, 52, NULL, 7, NULL),
(99, 'ананас', NULL, 49, 68, NULL, 7, NULL),
(100, 'диня', NULL, 32, 71, NULL, 7, NULL),
(101, 'картофи', NULL, 77, 74, NULL, 7, NULL),
(102, 'пюре, картофено', NULL, 79, 75, NULL, 7, NULL),
(103, 'тиква', NULL, 26, 75, NULL, 7, NULL),
(104, 'цвекло, сурово', NULL, 43, 64, NULL, 7, NULL),
(105, 'цвекло, варено', NULL, 40, 70, NULL, 7, NULL),
(106, 'доматен сос, лют', NULL, 33, 50, NULL, 7, NULL),
(107, 'пюре, доматено', NULL, 40, 50, NULL, 7, NULL),
(108, 'супа, доматена', NULL, 73, 52, NULL, 7, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`product_type`) REFERENCES `product_types` (`type_name`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
