-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 03, 2024 at 06:48 AM
-- Server version: 8.0.18
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user_form`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`cart_id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `product_id`, `quantity`) VALUES
(24, 15, 19, NULL),
(18, 15, 13, NULL),
(3, 15, 11, NULL),
(4, 15, 4, NULL),
(23, 15, 21, NULL),
(26, 40, 19, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_read` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`notification_id`)
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `user_id`, `admin_id`, `message`, `timestamp`, `is_read`) VALUES
(77, 40, NULL, 'all the users', '2023-12-09 06:00:32', 0),
(68, 36, NULL, 'test', '2023-11-24 07:10:03', 0),
(67, 35, NULL, 'test', '2023-11-24 07:10:03', 0),
(66, 15, NULL, 'test', '2023-11-24 07:10:03', 0),
(65, 3, NULL, 'test', '2023-11-24 07:10:03', 0),
(42, 15, NULL, 'last', '2023-11-22 17:50:23', 0),
(43, 32, NULL, 'last', '2023-11-22 17:50:23', 0),
(69, 37, NULL, 'new', '2023-11-28 10:00:13', 0),
(76, 39, NULL, 'all the users', '2023-12-09 06:00:32', 0),
(70, 3, NULL, 'test', '2023-12-04 10:51:03', 0),
(71, 15, NULL, 'test', '2023-12-04 10:51:03', 0),
(72, 35, NULL, 'test', '2023-12-04 10:51:03', 0),
(73, 3, NULL, 'all the users', '2023-12-09 06:00:32', 0),
(74, 15, NULL, 'all the users', '2023-12-09 06:00:32', 0),
(75, 35, NULL, 'all the users', '2023-12-09 06:00:32', 0);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `pid` int(225) NOT NULL AUTO_INCREMENT,
  `userid` int(225) NOT NULL,
  `name` varchar(225) NOT NULL,
  `price` varchar(225) NOT NULL,
  `image` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `image2` varchar(255) NOT NULL,
  `image3` varchar(255) NOT NULL,
  `description` varchar(2000) NOT NULL,
  `nameAddress` varchar(255) NOT NULL,
  `pnumber` varchar(100) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pid`, `userid`, `name`, `price`, `image`, `image2`, `image3`, `description`, `nameAddress`, `pnumber`, `user_id`) VALUES
(19, 3, 'Fresh Carrots', '200', 'pexels-mali-maeder-65174.jpg', 'carrots-basket-vegetables-market.jpg', 'efcarrots-960x720.jpg', 'Packed with vitamins and a burst of sweetness, these vibrant orange wonders are perfect for crunchy munching, salads, or cooking up a storm', 'Badulla Road, Haputale.', '6786786783', NULL),
(20, 15, 'Tomatoes', '150', 'Tomato-2.jpeg', 'tomatoes.jpg', 'Wholesale-Tomato-Products.jpg', 'Taste of pure summer in every bite! Grown under the sun and nurtured with care, these vibrant red gems are ready to add a fresh twist to your meals.', 'Bandarawela.', '0713456788', NULL),
(21, 15, 'Potatoes', '250', 'r0_0_5000_2811_w1200_h678_fmax.jpg', 'Potatoes-shutterstock-1721688538.jpg', 'iC7HBvohbJqExqvbKcV3pP.jpg', 'Fresh, farm-grown potatoes – a pure, natural delight that adds wholesome goodness to every meal.', 'Walimada', '0781234568', NULL),
(22, 15, 'Mangoes', '500', 'pexels-abdul-sameer-7641473-1020x680-1.jpg', 'Mango-Kesar-semi-ripe.png', '7501061_mango varieties in Bangladesh.jpg', 'Picked at the peak of ripeness for a burst of sweet, juicy flavor.', 'Bandarawela', '0771234568', NULL),
(23, 16, 'leeks', '260', 'Leeks_11.jpg', 'Leeks-vs-green-onion-4x3-2e2ab0de521b4f3abcc4e9776c8c9114.jpg', 'The-Difference-Between-Green-Onions-FT-BLOG0622-7c4233afb0a246ca8bf07b45df9b4a5f.jpg', 'leeks', 'user', '6786786783', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user',
  `image` varchar(100) NOT NULL,
  `cart_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `image`, `cart_id`) VALUES
(3, 'Shashintha s', 'shashin@gmail.com', 'c7f638d94510f501a22dc61a4f15bcfc', 'admin', 'tuxpi.com.1673070642.jpg', NULL),
(15, 'Sineth Shashintha', 'sineth@gmail.com', '3f0fd0b139458151e5985db6ce6ae0cf', 'user', 'Untitled design (1).png', NULL),
(35, 'test', 'test@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 'admin', 'hr.png', NULL),
(39, 'Admin', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'Admin-Profile-Vector-PNG-Clipart.png', NULL),
(40, 'user', 'user@gmail.com', 'ee11cbb19052e40b07aac0ca060c23ee', 'user', 'images.png', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
