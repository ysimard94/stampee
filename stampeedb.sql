-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 03, 2023 at 03:13 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stampee`
--
CREATE DATABASE IF NOT EXISTS `stampee` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
USE `stampee`;

-- --------------------------------------------------------

--
-- Table structure for table `auction`
--

DROP TABLE IF EXISTS `auction`;
CREATE TABLE IF NOT EXISTS `auction` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `floor_price` double NOT NULL,
  `current_price` double NOT NULL,
  `bid_number` int NOT NULL,
  `auction_status_id` int NOT NULL,
  `stamp_id` int NOT NULL,
  PRIMARY KEY (`id`,`stamp_id`),
  KEY `fk_auction_stamp1_idx` (`stamp_id`),
  KEY `fk_auction_auction_status1_idx` (`auction_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `auction`
--

INSERT INTO `auction` (`id`, `date_start`, `date_end`, `floor_price`, `current_price`, `bid_number`, `auction_status_id`, `stamp_id`) VALUES
(1, '2023-02-03', '2023-02-16', 2.55, 2.56, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `auction_status`
--

DROP TABLE IF EXISTS `auction_status`;
CREATE TABLE IF NOT EXISTS `auction_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `status` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `auction_status`
--

INSERT INTO `auction_status` (`id`, `status`) VALUES
(1, 'active'),
(2, 'finished'),
(3, 'archived');

-- --------------------------------------------------------

--
-- Table structure for table `bid`
--

DROP TABLE IF EXISTS `bid`;
CREATE TABLE IF NOT EXISTS `bid` (
  `user_id` int NOT NULL,
  `auction_id` int NOT NULL,
  `auction_stamp_id` int NOT NULL,
  `bid` double NOT NULL,
  KEY `fk_user_has_auction1_auction1_idx` (`auction_id`,`auction_stamp_id`),
  KEY `fk_user_has_auction1_user1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `bid`
--

INSERT INTO `bid` (`user_id`, `auction_id`, `auction_stamp_id`, `bid`) VALUES
(1, 1, 1, 2.56);

-- --------------------------------------------------------

--
-- Table structure for table `certification`
--

DROP TABLE IF EXISTS `certification`;
CREATE TABLE IF NOT EXISTS `certification` (
  `id` int NOT NULL AUTO_INCREMENT,
  `certification` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `certification`
--

INSERT INTO `certification` (`id`, `certification`) VALUES
(1, 'Oui'),
(2, 'Non');

-- --------------------------------------------------------

--
-- Table structure for table `condition`
--

DROP TABLE IF EXISTS `condition`;
CREATE TABLE IF NOT EXISTS `condition` (
  `id` int NOT NULL AUTO_INCREMENT,
  `condition` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `condition`
--

INSERT INTO `condition` (`id`, `condition`) VALUES
(1, 'Parfaite'),
(2, 'Excellente'),
(3, 'Bonne'),
(4, 'Moyenne'),
(5, 'Endommagé');

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `id` int NOT NULL AUTO_INCREMENT,
  `stamp_image_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_image_stamp1_idx` (`stamp_image_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id`, `stamp_image_id`, `name`, `path`) VALUES
(1, 1, 'cardimg1.png', 'C:\\wamp64\\www\\stampee/public/assets/stamps_img/cardimg1.png');

-- --------------------------------------------------------

--
-- Table structure for table `privilege`
--

DROP TABLE IF EXISTS `privilege`;
CREATE TABLE IF NOT EXISTS `privilege` (
  `id` int NOT NULL AUTO_INCREMENT,
  `privilege` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `privilege`
--

INSERT INTO `privilege` (`id`, `privilege`) VALUES
(1, 'master'),
(2, 'employee'),
(3, 'member');

-- --------------------------------------------------------

--
-- Table structure for table `stamp`
--

DROP TABLE IF EXISTS `stamp`;
CREATE TABLE IF NOT EXISTS `stamp` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL,
  `country` varchar(45) NOT NULL,
  `creation_date` date DEFAULT NULL,
  `colors` varchar(100) DEFAULT NULL,
  `dimensions` varchar(45) DEFAULT NULL,
  `condition_id` int NOT NULL,
  `certification_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_stamp_condition1_idx` (`condition_id`),
  KEY `fk_stamp_certification1_idx` (`certification_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `stamp`
--

INSERT INTO `stamp` (`id`, `title`, `country`, `creation_date`, `colors`, `dimensions`, `condition_id`, `certification_id`) VALUES
(1, 'Cambodia 1598-1603 set MNH', 'Cambodge', '2023-02-16', 'Bleu & Rouge', '12w 18h', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(80) NOT NULL,
  `birthday` date DEFAULT NULL,
  `gender` varchar(15) DEFAULT NULL,
  `country` varchar(30) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `postalcode` varchar(10) DEFAULT NULL,
  `privilege_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_privilege1_idx` (`privilege_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `birthday`, `gender`, `country`, `city`, `address`, `postalcode`, `privilege_id`) VALUES
(1, 'test', '$2y$10$T/YkVJqqnHzKWg1CCzxOpeQg.odZdBJk9pTvtfEbDzz4QT9ogWeKS', 'test@gmail.com', '2022-01-01', 'Femme', 'Canada', 'Montréal', '22 3e avenue', 'H1V 3C3', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_has_auction`
--

DROP TABLE IF EXISTS `user_has_auction`;
CREATE TABLE IF NOT EXISTS `user_has_auction` (
  `user_id` int NOT NULL,
  `auction_id` int NOT NULL,
  `auction_stamp_id` int NOT NULL,
  PRIMARY KEY (`user_id`,`auction_id`,`auction_stamp_id`),
  KEY `fk_user_has_auction_auction2_idx` (`auction_id`,`auction_stamp_id`),
  KEY `fk_user_has_auction_user2_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_has_auction`
--

INSERT INTO `user_has_auction` (`user_id`, `auction_id`, `auction_stamp_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `watchlist`
--

DROP TABLE IF EXISTS `watchlist`;
CREATE TABLE IF NOT EXISTS `watchlist` (
  `auction_id` int NOT NULL,
  `auction_stamp_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`auction_id`,`auction_stamp_id`,`user_id`),
  KEY `fk_auction_has_user_user1_idx` (`user_id`),
  KEY `fk_auction_has_user_auction1_idx` (`auction_id`,`auction_stamp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auction`
--
ALTER TABLE `auction`
  ADD CONSTRAINT `fk_auction_auction_status1` FOREIGN KEY (`auction_status_id`) REFERENCES `auction_status` (`id`),
  ADD CONSTRAINT `fk_auction_stamp1` FOREIGN KEY (`stamp_id`) REFERENCES `stamp` (`id`);

--
-- Constraints for table `bid`
--
ALTER TABLE `bid`
  ADD CONSTRAINT `fk_user_has_auction1_auction1` FOREIGN KEY (`auction_id`,`auction_stamp_id`) REFERENCES `auction` (`id`, `stamp_id`),
  ADD CONSTRAINT `fk_user_has_auction1_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `fk_image_stamp1` FOREIGN KEY (`stamp_image_id`) REFERENCES `stamp` (`id`);

--
-- Constraints for table `stamp`
--
ALTER TABLE `stamp`
  ADD CONSTRAINT `fk_stamp_certification1` FOREIGN KEY (`certification_id`) REFERENCES `certification` (`id`),
  ADD CONSTRAINT `fk_stamp_condition1` FOREIGN KEY (`condition_id`) REFERENCES `condition` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_privilege1` FOREIGN KEY (`privilege_id`) REFERENCES `privilege` (`id`);

--
-- Constraints for table `user_has_auction`
--
ALTER TABLE `user_has_auction`
  ADD CONSTRAINT `fk_user_has_auction_auction2` FOREIGN KEY (`auction_id`,`auction_stamp_id`) REFERENCES `auction` (`id`, `stamp_id`),
  ADD CONSTRAINT `fk_user_has_auction_user2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `watchlist`
--
ALTER TABLE `watchlist`
  ADD CONSTRAINT `fk_auction_has_user_auction1` FOREIGN KEY (`auction_id`,`auction_stamp_id`) REFERENCES `auction` (`id`, `stamp_id`),
  ADD CONSTRAINT `fk_auction_has_user_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
