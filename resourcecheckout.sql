-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2012 at 10:34 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `resourcecheckout`
--
CREATE DATABASE `resourcecheckout` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `resourcecheckout`;

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE IF NOT EXISTS `resources` (
  `resource_id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_type` enum('Computer Lab','Laptop Cart','Candy') NOT NULL,
  `resource_details` varchar(50) NOT NULL,
  `resource_identifier` varchar(50) NOT NULL,
  `resource_blocktype` enum('Half','Full') NOT NULL,
  PRIMARY KEY (`resource_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`resource_id`, `resource_type`, `resource_details`, `resource_identifier`, `resource_blocktype`) VALUES
(1, 'Computer Lab', '25 Computers', 'Room 234', 'Half'),
(2, 'Laptop Cart', '15 Computers', 'Cart A', 'Full'),
(4, 'Candy', 'Fifty Pieces', 'Package 2', 'Full'),
(5, 'Laptop Cart', '20 Laptops', 'Cart B', 'Full'),
(6, 'Computer Lab', '2 1/2 Computers', 'Room 199', 'Half');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE IF NOT EXISTS `schedule` (
  `schedule_id` int(11) NOT NULL AUTO_INCREMENT,
  `schedule_resource_id` int(11) NOT NULL,
  `schedule_user_id` int(11) NOT NULL,
  `schedule_date` date NOT NULL,
  `schedule_block` int(11) NOT NULL,
  PRIMARY KEY (`schedule_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `schedule_resource_id`, `schedule_user_id`, `schedule_date`, `schedule_block`) VALUES
(32, 1, 5, '2012-02-10', 11),
(13, 3, 1, '2011-12-20', 2),
(15, 1, 1, '2011-12-20', 42),
(16, 3, 1, '2011-12-21', 1),
(17, 3, 1, '2011-12-21', 2),
(22, 1, 1, '2012-03-25', 31),
(23, 6, 2, '2012-03-25', 22),
(25, 4, 4, '2012-01-17', 1),
(26, 2, 4, '2012-01-17', 1),
(27, 2, 4, '2012-01-25', 1),
(31, 1, 5, '2012-02-09', 11),
(33, 4, 1, '2012-02-15', 1),
(34, 1, 4, '2012-03-07', 11),
(35, 1, 4, '2012-03-13', 11),
(36, 1, 4, '2012-03-15', 11),
(37, 1, 4, '2012-03-14', 11),
(38, 1, 4, '2012-03-20', 11);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_type` varchar(60) NOT NULL,
  `setting_value` int(11) NOT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_id`, `setting_type`, `setting_value`) VALUES
(1, 'Number of Days Per Week', 3),
(2, 'Number of Days in a Row', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_firstname` varchar(50) NOT NULL,
  `user_lastname` varchar(50) NOT NULL,
  `user_username` varchar(50) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_firstname`, `user_lastname`, `user_username`, `user_password`) VALUES
(1, 'Tracy', 'Moody', 'tmoody', '5f4dcc3b5aa765d61d8327deb882cf99'),
(2, 'Chris', 'Ramey', 'cramey', '02d8c4ac323c5df679077f020f170453'),
(5, 'Ben', 'Doan', 'simcaster', '5f4dcc3b5aa765d61d8327deb882cf99'),
(4, 'Ben', 'Doan', 'admin', '5f4dcc3b5aa765d61d8327deb882cf99');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
