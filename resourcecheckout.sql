-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 31, 2012 at 06:16 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_resource_id` int(11) NOT NULL,
  `comment_user_id` int(11) NOT NULL,
  `comment_date` date NOT NULL,
  `comment_message` text NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_resource_id`, `comment_user_id`, `comment_date`, `comment_message`) VALUES
(1, 1, 1, '0000-00-00', 'Comments, really?'),
(2, 1, 1, '0000-00-00', 'second comment'),
(3, 1, 1, '2012-05-03', 'Comments yaya'),
(4, 1, 1, '2012-05-03', 'There are damages on this laptop. Bad ones.'),
(5, 1, 1, '2012-05-03', 'Commenting on stuff...');

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE IF NOT EXISTS `resources` (
  `resource_id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_type` varchar(100) NOT NULL,
  `resource_details` varchar(50) NOT NULL,
  `resource_identifier` varchar(50) NOT NULL,
  `resource_blocktype` enum('Half','Full') NOT NULL,
  PRIMARY KEY (`resource_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`resource_id`, `resource_type`, `resource_details`, `resource_identifier`, `resource_blocktype`) VALUES
(1, '1', '25 Computers', 'Room 234', 'Half'),
(4, '3', 'Fifty Pieces', 'Package 2', 'Full');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=68 ;

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
(25, 4, 4, '2012-01-17', 1),
(31, 1, 5, '2012-02-09', 11),
(33, 4, 1, '2012-02-15', 1),
(34, 1, 4, '2012-03-07', 11),
(35, 1, 4, '2012-03-13', 11),
(36, 1, 4, '2012-03-15', 11),
(37, 1, 4, '2012-03-14', 11),
(38, 1, 4, '2012-03-20', 11),
(39, 1, 1, '2012-05-04', 11),
(51, 1, 5, '2012-05-11', 42),
(50, 1, 5, '2012-05-11', 12),
(46, 1, 5, '2012-05-09', 11);

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
-- Table structure for table `types`
--

CREATE TABLE IF NOT EXISTS `types` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(100) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`type_id`, `type_name`) VALUES
(1, 'Computer Lab'),
(3, 'Candy');

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
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_firstname`, `user_lastname`, `user_username`, `user_password`, `user_email`) VALUES
(1, 'Tracy', 'Moody', 'tmoody', '5f4dcc3b5aa765d61d8327deb882cf99', 'tmoody@example.com'),
(2, 'Chris', 'Ramey', 'cramey', '02d8c4ac323c5df679077f020f170453', 'cramey@example.com'),
(5, 'Ben', 'Doan', 'simcaster', '5f4dcc3b5aa765d61d8327deb882cf99', 'ben@simcaster.net'),
(4, 'Ben', 'Doan', 'admin', '5f4dcc3b5aa765d61d8327deb882cf99', 'ben@simcaster.net'),
(8, 'First', 'Last', 'username', 'b01abf84324066bdb4eed4d5bf20f887', 'email@email.com');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
