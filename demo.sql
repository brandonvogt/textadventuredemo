-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2017 at 07:31 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `text` longtext COLLATE utf8mb4_bin NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `io_bit` int(11) NOT NULL,
  `place_context` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F08FC65CA76ED395` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin AUTO_INCREMENT=708 ;

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE IF NOT EXISTS `places` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `base_desc` longtext COLLATE utf8mb4_bin NOT NULL,
  `with_sword` varchar(1024) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin AUTO_INCREMENT=137 ;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`id`, `title`, `base_desc`, `with_sword`) VALUES
(100, 'Place 1', 'This is the description for Place 1. Try to <b>look</b>, go <b>north</b>, or get <b>help</b>.\r\n', 'This is the first place again, but now it''s acknowledging the sword in your inventory.'),
(101, 'Place 2', 'This is place 2. Go <b>south</b> to get back to Place 1. Or <b>take sword</b> to pick up a sword.', 'This is Place 2, modified due to player''s inventory. ');

-- --------------------------------------------------------

--
-- Table structure for table `responses`
--

CREATE TABLE IF NOT EXISTS `responses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `place_id` int(11) NOT NULL,
  `logic_flag` int(11) NOT NULL,
  `input` longtext COLLATE utf8mb4_bin NOT NULL,
  `output` longtext COLLATE utf8mb4_bin NOT NULL,
  `conditional_output` longtext COLLATE utf8mb4_bin,
  `new_place` int(11) DEFAULT NULL,
  `conditional_new_place` int(11) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `conditional_item` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_315F9F94DA6A219` (`place_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin AUTO_INCREMENT=778 ;

--
-- Dumping data for table `responses`
--

INSERT INTO `responses` (`id`, `place_id`, `logic_flag`, `input`, `output`, `conditional_output`, `new_place`, `conditional_new_place`, `item`, `conditional_item`) VALUES
(773, 100, 1, 'north', 'Heading to...', NULL, 101, NULL, NULL, NULL),
(774, 101, 1, 'south', 'Heading back to...', NULL, 100, NULL, NULL, NULL),
(775, 100, 0, 'look', 'You see a place. With things. Obvious exit is north.', NULL, NULL, NULL, NULL, NULL),
(776, 101, 2, 'take sword', 'You took the sword. Now what?', 'This is text to denote that you''ve ALREADY taken the sword. ', NULL, NULL, 1, NULL),
(777, 101, 0, 'look', 'The look command is different for this place or context.', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `place_id` int(11) NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_bin NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_bin NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8mb4_bin NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8mb4_bin DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:array)',
  `sword` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_1483A5E9C05FB297` (`confirmation_token`),
  KEY `IDX_1483A5E9DA6A219` (`place_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin AUTO_INCREMENT=24 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `FK_F08FC65CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `responses`
--
ALTER TABLE `responses`
  ADD CONSTRAINT `FK_315F9F94DA6A219` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_1483A5E9DA6A219` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
