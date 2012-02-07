-- phpMyAdmin SQL Dump
-- version 3.3.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 06, 2012 at 11:20 PM
-- Server version: 5.1.44
-- PHP Version: 5.2.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `resourcecheckout`
--

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `schedule_resource_id`, `schedule_user_id`, `schedule_date`, `schedule_block`) VALUES
(46, 1, 5, '2012-03-01', 11),
(45, 1, 5, '2012-04-19', 12),
(44, 1, 5, '2012-04-19', 21),
(43, 1, 5, '2012-04-19', 11),
(23, 6, 2, '2012-03-25', 22),
(25, 4, 4, '2012-01-17', 1),
(26, 2, 4, '2012-01-17', 1),
(27, 2, 4, '2012-01-25', 1),
(31, 1, 5, '2012-02-09', 11);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_firstname`, `user_lastname`, `user_username`, `user_password`) VALUES
(1, 'Tracy', 'Moody', 'tmoody', '5f4dcc3b5aa765d61d8327deb882cf99'),
(48, 'Tom', 'McClenahan', 'rick', '202cb962ac59075b964b07152d234b70'),
(5, 'Ben', 'Doan', 'simcaster', '5f4dcc3b5aa765d61d8327deb882cf99'),
(4, 'Admin', '', 'admin', '5f4dcc3b5aa765d61d8327deb882cf99'),
(49, 'gtht', 'tr5tht', 'tgrgt', 'd41d8cd98f00b204e9800998ecf8427e');
