-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 29, 2013 at 06:54 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

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
-- Table structure for table `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(60) NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department_name`) VALUES
(1, 'Computer Science'),
(2, 'English'),
(3, 'Foreign Language'),
(4, 'Administrative'),
(5, 'Special Education'),
(6, 'Family and Consumer Science'),
(7, 'Science'),
(8, 'Industrial Technology'),
(9, 'Music'),
(10, 'Social Studies'),
(11, 'Counseling'),
(12, 'Mathematics'),
(13, 'Business'),
(14, 'Media'),
(15, 'Custodial'),
(16, 'Physical Education'),
(17, 'Art'),
(18, 'General');

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE IF NOT EXISTS `resources` (
  `resource_id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_type` varchar(100) NOT NULL,
  `resource_details` varchar(50) NOT NULL,
  `resource_identifier` varchar(50) NOT NULL,
  `resource_department` int(11) NOT NULL,
  PRIMARY KEY (`resource_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`resource_id`, `resource_type`, `resource_details`, `resource_identifier`, `resource_department`) VALUES
(1, '1', '25 Computers', 'Room 234', 0),
(4, '3', 'Fifty Pieces', 'Package 2', 1),
(29, '1', '50 Computers', 'room 222', 0),
(30, '1', '25 computers', 'room 1', 0),
(31, '1', '25 computers', 'Room 101', 0),
(32, '1', '25 computers', 'room 3', 0),
(33, '1', '29 computers', 'room 1337', 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=267 ;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `schedule_resource_id`, `schedule_user_id`, `schedule_date`, `schedule_block`) VALUES
(13, 3, 1, '2011-12-20', 2),
(15, 1, 1, '2011-12-20', 42),
(16, 3, 1, '2011-12-21', 1),
(17, 3, 1, '2011-12-21', 2),
(22, 1, 1, '2012-03-25', 31),
(25, 4, 4, '2012-01-17', 1),
(33, 4, 1, '2012-02-15', 1),
(34, 1, 4, '2012-03-07', 11),
(35, 1, 4, '2012-03-13', 11),
(36, 1, 4, '2012-03-15', 11),
(37, 1, 4, '2012-03-14', 11),
(38, 1, 4, '2012-03-20', 11),
(39, 1, 1, '2012-05-04', 11),
(89, 1, 4, '2012-09-19', 11),
(90, 1, 4, '2012-09-20', 11),
(99, 1, 4, '2012-11-06', 21),
(264, 1, 5, '2013-01-31', 11),
(257, 4, 5, '2013-01-31', 5),
(256, 1, 5, '2013-01-28', 41);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_type` varchar(60) NOT NULL,
  `setting_value` varchar(100) NOT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_id`, `setting_type`, `setting_value`) VALUES
(3, 'Number of Blocks', '4'),
(6, 'Site Name', 'MW Checkout'),
(7, 'Display table counts', 'true');
-- -------------------------------------------------------- -- -- Table structure for table `types` -- CREATE TABLE IF NOT EXISTS `types` ( `type_id` int(11) NOT NULL AUTO_INCREMENT, `type_name` varchar(100) NOT NULL,
  `type_blocktype` enum('full','half') NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`type_id`, `type_name`, `type_blocktype`) VALUES
(1, 'Computer Lab', 'half'),
(3, 'Candy', 'full');

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
  `user_isadmin` tinyint(1) NOT NULL,
  `user_isreadonly` tinyint(1) NOT NULL DEFAULT '0',
  `user_department` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=186 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_firstname`, `user_lastname`, `user_username`, `user_password`, `user_email`, `user_isadmin`, `user_isreadonly`, `user_department`) VALUES
(1, 'Tracy', 'Moody', 'tmoody', '5f4dcc3b5aa765d61d8327deb882cf99', 'tmoody@example.com', 0, 0, 1),
(30, 'Tom', 'McClenahan', 'neanderman', '52bdc21a9b5d97af8777b495da6c3876', 'neanderman@gmail.com', 0, 0, 1),
(5, 'Ben', 'Doan', 'simcaster', '5f4dcc3b5aa765d61d8327deb882cf99', 'bendoan5@gmail.com', 0, 0, 1),
(4, 'Admin', '', 'admin', '5f4dcc3b5aa765d61d8327deb882cf99', 'ben@simcaster.net', 1, 0, 1),
(8, 'First', 'Last', 'Username', 'b01abf84324066bdb4eed4d5bf20f887', 'email@email.com', 0, 0, 1),
(19, 'Tom', 'McClenahan', 'tmcclenahan', 'f56c038b2532a0670ff4033fae7950a0', 'neanderman@gmail.com', 0, 0, 1),
(31, 'Ben', 'Doan', 'bendoan5', '87dd972215de30d47f0ebaa468233154', 'bendoan5@gmail.com', 0, 0, 1),
(21, 'Cathy', 'Clifford', 'cclifford', '369c9810a558b78279e4e5066c355af2', 'kwclifford@mpsomaha.org', 0, 0, 1),
(22, 'Lukecart', 'Lisa', 'llisa', 'd2e5c7a35549ac76d262ddb8ded5ce09', 'lrlukecart@mpsomaha.org', 0, 0, 1),
(28, 'Ben', 'Doan', 'bdoan', '2ab9aeb3f4bc5da04df5cde8f3bc5455', 'bendoan5@gmail.com', 0, 0, 1),
(32, 'Chris', 'Ramey', 'cjramey', '5588da85b6c142b57215c97990fd9b06', 'cjramey@gmail.com', 0, 0, 12),
(33, 'Cathy', 'Clifford', 'kwclifford', '42af95ee8a94b0a7c88e8bbea9b5f2f2', 'kwclifford@mpsomaha.org', 0, 0, 14),
(34, 'Lukecart', 'Lisa', 'lrlukecart', 'a22f7e7be6d742eb375c0ab20a414dc6', 'lrlukecart@mpsomaha.org', 0, 0, 2),
(36, 'Juan', 'Aguirre', 'jmaguirre', '057a62217e30c7d806ca948d7995431c', 'jmaguirre@mpsomaha.org', 0, 0, 3),
(37, 'Amy', 'Anderson', 'aeanderson', 'b742666e9519343c04a7de57016c1002', 'aeanderson@mpsomaha.org', 0, 0, 5),
(38, 'Janet', 'Beckstead', 'jcbeckstead', 'bb64523a60f6774a4a50fdda1899a671', 'jcbeckstead@mpsomaha.org', 0, 0, 3),
(39, 'Ron', 'Beernink', 'rbeernin', '166cc4c11050878317aea2dea1356eef', 'rbeernin@mpsomaha.org', 0, 0, 3),
(40, 'Kate', 'Beiting', 'kbeiting', 'bf52e3f94ff81144f5a72a78b0048880', 'kbeiting@mpsomaha.org', 0, 0, 6),
(41, 'Tyler', 'Berzina', 'jtberzin', '149b49ebe11beab8234b7946e3181f09', 'jtberzin@mpsomaha.org', 0, 0, 7),
(42, 'Steve', 'Besch', 'skbesch', '280826b73e2c773fc65b67824af13021', 'skbesch@mpsomaha.org', 0, 0, 8),
(43, 'Zack', 'Bjornsen', 'zpbjornsen', 'ffdab90522d357900e872e39bfe775b2', 'zpbjornsen@mpsomaha.org', 0, 0, 9),
(44, 'Dana', 'Blakely', 'dlblakely', '47fb242f421f8dadf959cc77561f0ef9', 'dlblakely@mpsomaha.org', 0, 0, 10),
(45, 'Doug', 'Bogatz', 'djbogatz', 'a22c049d9d886878de3cb5717acf0a1d', 'djbogatz@mpsomaha.org', 0, 0, 9),
(46, 'Scott', 'Bohlken', 'sbohlken', 'f655ffca141ab7cc59bff952db16276a', 'sbohlken@mpsomaha.org', 0, 0, 8),
(47, 'Sydney', 'Bowcott', 'sjbowcott', '066664fb7f709445a9bc9cdfab27eb63', 'sjbowcott@mpsomaha.org', 0, 0, 3),
(48, 'Michael', 'Bowker', 'msbowker', '9875a9f6038ed762907a70dfc3a2489d', 'msbowker@mpsomaha.org', 0, 0, 10),
(49, 'Alicia', 'Bragg', 'aabragg', '6b49c1e0d548c503fa840e0225722d98', 'aabragg@mpsomaha.org', 0, 0, 10),
(50, 'Cathy', 'Bremer', 'cjbremer', '2a5c40930dc3e042919456649028caa2', 'cjbremer@mpsomaha.org', 0, 0, 12),
(51, 'Bryant', 'Bull', 'bcbull', '20ebc7ea51085472274c5f84ac9af3d2', 'bcbull@mpsomaha.org', 0, 0, 10),
(52, 'Kathleen', 'Burket', 'kbburket', '5db2ac6610ab0991aae4dea11c0c712b', 'kbburket@mpsomaha.org', 0, 0, 5),
(53, 'Janet', 'Butler', 'jbutler', '56a6fc221f7a1755b1406020dc6b82be', 'jbutler@mpsomaha.org', 0, 0, 13),
(54, 'Erika', 'Campbell', 'eccampbell', 'b04cd57e9912444fe5982522665f75cc', 'eccampbell@mpsomaha.org', 0, 0, 5),
(55, 'Dian', 'Carlson', 'dhcarlson', 'fed169e3e16600ae6a2b2a309292ba25', 'dhcarlson@mpsomaha.org', 0, 0, 6),
(56, 'Jay', 'Carlson', 'jcarlson', 'fcb7e5ef285a6d72131542454deecc82', 'jcarlson@mpsomaha.org', 0, 0, 7),
(57, 'Ann', 'Carmoney', 'amcarmoney', '8432735dbc239ce13915006b485dc255', 'amcarmoney@mpsomaha.org', 0, 0, 5),
(58, 'Andrea', 'Carson', 'amcarson', '8781d544489ec31e25081f1c169d0013', 'amcarson@mpsomaha.org', 0, 0, 13),
(59, 'Mike', 'Catron', 'macatron', '61ff5df8f58b99e894cd5f82e867034e', 'macatron@mpsomaha.org', 0, 0, 2),
(60, 'Rhonda', 'Chomos', 'rlchomos', 'fd6b82f0e3a88ec2f6f14a4d8944e40b', 'rlchomos@mpsomaha.org', 0, 0, 13),
(61, 'Hayley', 'Clevenger', 'hdclevenger', 'ab254859cfdaf4d8bca387e3e8a4f0a5', 'hdclevenger@mpsomaha.org', 0, 0, 5),
(62, 'Kip', 'Colony', 'kcolony', 'ed5c6509e53e63a0d1a37aca1b649a12', 'kcolony@mpsomaha.org', 0, 0, 2),
(63, 'Jane', 'Couture', 'jlcoutur', 'e09f578dbd04ef4c5554018f136e8d91', 'jlcoutur@mpsomaha.org', 0, 0, 3),
(64, 'Michael', 'Davis', 'mjdavis', '7857bb5c4d7a1ff8d369a83fc3b5aad9', 'mjdavis@mpsomaha.org', 0, 0, 2),
(65, 'Tammy', 'Davis', 'tldavis', 'e829d799c90bf5bf7e9d1522f01cc796', 'tldavis@mpsomaha.org', 0, 0, 7),
(66, 'Maggie', 'Day', 'mpday1', '57788d274f1f7c3f97c1598410c408fd', 'mpday1@mpsomaha.org', 0, 0, 7),
(67, 'Amy', 'Delehant', 'aldelehant', 'a059d9880a75c91862543a0c8a40cebb', 'aldelehant@mpsomaha.org', 0, 0, 12),
(68, 'Kirsten', 'Ehrke', 'klehrke', '857a14d7956bf2c30d83ca139e5b8eb2', 'klehrke@mpsomaha.org', 0, 0, 3),
(69, 'Janine', 'Ellis', 'jsellis', '03572006403d9085ad1c6de4182c1e06', 'jsellis@mpsomaha.org', 0, 0, 13),
(70, 'Alexander', 'Fields', 'agfields', '45b7b3e04e2517f226fcfc33c7c6b211', 'agfields@mpsomaha.org', 0, 0, 10),
(71, 'Gwen', 'Fox', 'gefox', '899e449195e67a39459bd99499591a05', 'gefox@mpsomaha.org', 0, 0, 12),
(72, 'Nick', 'Friedrichsen', 'nsfriedrichsen', '0780205b7c1af1119e1a041e405b5ad6', 'nsfriedrichsen@mpsomaha.org', 0, 0, 8),
(73, 'Luke', 'Furman', 'lefurman', '1a649d21a86bec053653003d9579f1da', 'lefurman@mpsomaha.org', 0, 0, 9),
(74, 'Dennis', 'Gehringer', 'dmgehringer', 'ed473bacd23518d16533e5411318d437', 'dmgehringer@mpsomaha.org', 0, 0, 7),
(75, 'Jeff', 'Gehrke', 'jtgehrke', '3bef217ea176d531afa4fac54f824a69', 'jtgehrke@mpsomaha.org', 0, 0, 7),
(76, 'Vickie', 'Glesmann', 'vlglesma', 'd62bb401e112bcb25db57e0c1df647d2', 'vlglesma@mpsomaha.org', 0, 0, 16),
(77, 'Kim', 'Hagedorn', 'knhagedorn', 'aedde29b1368e18119c70329d01c53d9', 'knhagedorn@mpsomaha.org', 0, 0, 12),
(78, 'Daniel', 'Hall', 'dthall', '347ffa077d57707dbffb8989cf2ac959', 'dthall@mpsomaha.org', 0, 0, 12),
(79, 'Kelsey', 'Hannon', 'kmhannon', 'e0f2b7c6514d435d92ab6eb1b23b985e', 'kmhannon@mpsomaha.org', 0, 0, 6),
(80, 'Brooke', 'Hartnett', 'blhartnett', '6741372b7821460e9424fd2fd660ae51', 'blhartnett@mpsomaha.org', 0, 0, 12),
(81, 'Matt', 'Heys', 'mheys', 'a6945dfb204feb7d0e6954db2736d0bc', 'mheys@mpsomaha.org', 0, 0, 10),
(82, 'Justin', 'Higgins', 'jahiggins', '25f40349644b5abcdce66c99663d3769', 'jahiggins@mpsomaha.org', 0, 0, 7),
(83, 'Mark', 'Hilburn', 'mrhilburn', '63d3c97f07107f0549f965532a3a6952', 'mrhilburn@mpsomaha.org', 0, 0, 2),
(84, 'Kristin', 'Hoffman', 'khoffman', '7cc291c47e0f6a67fcdab42af8a32ca2', 'khoffman@mpsomaha.org', 0, 0, 17),
(85, 'Kristen', 'Holzer', 'kdholzer', '00db5246c49ff4ea6ffdcfd592f442a8', 'kdholzer@mpsomaha.org', 0, 0, 7),
(86, 'Lloyd', 'Hoshaw', 'lmhoshaw', 'a12d1564a46ec822f3b283faf49da2d8', 'lmhoshaw@mpsomaha.org', 0, 0, 2),
(87, 'Theresa', 'Hovorka', 'thovorka', 'f26fb419ce401b431c181181eb323c1c', 'thovorka@mpsomaha.org', 0, 0, 13),
(88, 'Casey', 'Hurner', 'cjhurner', 'd4e4a3aa8c4b5670773c141b0b42c5ff', 'cjhurner@mpsomaha.org', 0, 0, 5),
(89, 'Megan', 'Hylok', 'mjhylok', '29df3d4464c472be701dd272cd738790', 'mjhylok@mpsomaha.org', 0, 0, 7),
(90, 'Gail', 'Illg', 'gjillg', '745a6665655ac73d04f841ac1f51e69e', 'gjillg@mpsomaha.org', 0, 0, 5),
(91, 'Christine', 'Ingram', 'cingram', '39f481510d9f48fb6d71e7e07ec9df6a', 'cingram@mpsomaha.org', 0, 0, 7),
(92, 'Jennifer', 'Jerome', 'jmjerome', '78dbcc11e03178cd085b920ef1c74e65', 'jmjerome@mpsomaha.org', 0, 0, 2),
(93, 'Anne', 'Johnson', 'aejohnson', 'f8fbbf94ff3ea1e45e07a8f6df1eea66', 'aejohnson@mpsomaha.org', 0, 0, 3),
(94, 'Colin', 'Johnston', 'ctjohnston', '8812e4e73b3190180b0bd5cf7ba7964e', 'ctjohnston@mpsomaha.org', 0, 0, 16),
(95, 'Jim', 'Johnston', 'jajohnst', '1e971c9ffda4ce90e54c94fbd026154b', 'jajohnst@mpsomaha.org', 0, 0, 7),
(96, 'Lindsey', 'Kaiser', 'lrkaiser', 'd64e1a6b9ed42880d72d165125478c30', 'lrkaiser@mpsomaha.org', 0, 0, 3),
(97, 'Stacy', 'Kastanek', 'srkastanek', '344aa886fb8f907cf3fc029d46300f1a', 'srkastanek@mpsomaha.org', 0, 0, 10),
(98, 'John', 'Keith', 'jrkeith', '7e75ededcfc71520835fea0a3ef79a7a', 'jrkeith@mpsomaha.org', 0, 0, 9),
(99, 'Marilyn', 'Kerkhove', 'mbkerkhove', '739cb190d5d9f291d7f1d34f4558b1a6', 'mbkerkhove@mpsomaha.org', 0, 0, 2),
(100, 'Mark', 'Klein', 'mklein', 'e07a80fad3bcf7da95b417c7c9099645', 'mklein@mpsomaha.org', 0, 0, 10),
(101, 'Lori', 'Klug', 'lklug', 'de4a472fd575f769e82b216b8c0b5e9a', 'lklug@mpsomaha.org', 0, 0, 5),
(102, 'Karen', 'Kneifl', 'kkneifl', '57e1ff451f08c6bfaa998d58e6dd1c41', 'kkneifl@mpsomaha.org', 0, 0, 12),
(103, 'Patty', 'Knudson', 'pmknudson', 'ea23f75d1217ecc270ff5016519a6f41', 'pmknudson@mpsomaha.org', 0, 0, 2),
(104, 'Candida', 'Kraska', 'crkraska', 'af27a3950f14fc85492154d63843e6aa', 'crkraska@mpsomaha.org', 0, 0, 3),
(105, 'Melissa', 'Krebs', 'mtkrebs', '8f1d575bb2ca18ab3daa11d2642d4e1a', 'mtkrebs@mpsomaha.org', 0, 0, 17),
(106, 'Jason', 'Krska', 'jmkrska', 'b18f6f5b018ce229f6f169383b1241c2', 'jmkrska@mpsomaha.org', 0, 0, 7),
(107, 'Max', 'Kurz', 'mkurz', 'c60748c95a0e8c0f2717c6dee02e064e', 'mkurz@mpsomaha.org', 0, 0, 16),
(108, 'Susan', 'Kvasnicka', 'skvasnic', '0f653635587e99daf9418ad09abfc0b7', 'skvasnic@mpsomaha.org', 0, 0, 2),
(109, 'Julie', 'Lade-Wills', 'jladewil', '804d6dc0bcd6d279d38583099f15c941', 'jladewil@mpsomaha.org', 0, 0, 17),
(110, 'Bonnie', 'LaMay', 'blamay', '6b602c2cc68bce2b6e168a5077ae8905', 'blamay@mpsomaha.org', 0, 0, 5),
(111, 'Wendy', 'Langer', 'whlanger', '8776fd7b46487e39206addff8de654a6', 'whlanger@mpsomaha.org', 0, 0, 3),
(112, 'Kristen', 'Larson', 'kllarson', 'd93f56f69e95e27abef4f28fa5de09c7', 'kllarson@mpsomaha.org', 0, 0, 10),
(113, 'Jan', 'Lehms', 'jlehms', '4aae319e778ba0daf8f4eec667ee5750', 'jlehms@mpsomaha.org', 0, 0, 16),
(114, 'Jeff', 'Lollar', 'jslollar', '358814776e11f5f91e673aced4bb47f5', 'jslollar@mpsomaha.org', 0, 0, 10),
(115, 'Mindy', 'Longe', 'mslonge', '3188aff7acb34c6abbb843538562f23b', 'mslonge@mpsomaha.org', 0, 0, 2),
(116, 'Natasha', 'Ludwig-Page', 'neludwig', '11bb42c2e6326e701b506f3199b5e03f', 'neludwig@mpsomaha.org', 0, 0, 3),
(117, 'Whitney', 'Matson', 'wamatson', '2bfabec40feee61f46bbb3e2cb7dcd1c', 'wamatson@mpsomaha.org', 0, 0, 6),
(118, 'John', 'May', 'jmay', '9cdde746fc04d36333abb140c8c4391f', 'jmay@mpsomaha.org', 0, 0, 12),
(119, 'Leigha', 'McDonald', 'lmmcdonald', '0ec072c98c35e8c6bc896185e514d877', 'lmmcdonald@mpsomaha.org', 0, 0, 12),
(120, 'Tracie', 'McDonald', 'tmcdonal', 'c89679d7a75dee6dd785d65578b5d61e', 'tmcdonal@mpsomaha.org', 0, 0, 12),
(121, 'Megan', 'McEnaney', 'mnmcenaney', '885265d7d32d6f4d955b889167c6bda7', 'mnmcenaney@mpsomaha.org', 0, 0, 10),
(122, 'Jane', 'McIntyre', 'jmmcintyre', '3745a35395760fb09dc4e1053b9d73e7', 'jmmcintyre@mpsomaha.org', 0, 0, 2),
(123, 'Lauren', 'McKenzie', 'lkmckenzie', '48ba5dcd0479d8df9fae099ebbff8641', 'lkmckenzie@mpsomaha.org', 0, 0, 2),
(124, 'Bob', 'Meeker', 'bmeeker', '96e42d6483e4a59895c2e429f9604bd1', 'bmeeker@mpsomaha.org', 0, 0, 10),
(125, 'Mitch', 'Mentzer', 'mbmentzer', '08a201f8c685cb3b46cf7e4471feabc9', 'mbmentzer@mpsomaha.org', 0, 0, 8),
(126, 'Jim', 'Mercer', 'jmercer', 'a0a38d228958a91bed68dc041b86f8e0', 'jmercer@mpsomaha.org', 0, 0, 2),
(127, 'Bill', 'Morrison', 'wtmorrison', 'b21b932dd3d749c0a86a38cf10bdc668', 'wtmorrison@mpsomaha.org', 0, 0, 12),
(128, 'Ryan', 'Moseley', 'rmmoseley', 'bcd46ce7ae6e6f4e982cabccae51c451', 'rmmoseley@mpsomaha.org', 0, 0, 10),
(129, 'Chad', 'Mustard', 'camustard', '9937763812cf87b8c09e039a3f1e41ba', 'camustard@mpsomaha.org', 0, 0, 12),
(130, 'Jennifer', 'Myers', 'jjmyers', '0149e5f2e1fb790060c42efca241fa59', 'jjmyers@mpsomaha.org', 0, 0, 12),
(131, 'Tory', 'Nixon', 'tjnixon', '3107716b91d121c86addff55aeff499f', 'tjnixon@mpsomaha.org', 0, 0, 2),
(132, 'Amy', 'Opitz', 'alopitz', '31efebf0aa9ce14caaf1918f71769cde', 'alopitz@mpsomaha.org', 0, 0, 2),
(133, 'Maureen', 'Ord', 'mpord', '8292a92186e787f03f67f5242f9620ad', 'mpord@mpsomaha.org', 0, 0, 7),
(134, 'Karen', 'Palmer', 'kbpalmer', '8a104181f2610416f8d7ae0ca9bc5cac', 'kbpalmer@mpsomaha.org', 0, 0, 2),
(135, 'Kendra', 'Person', 'krperson', '940e7e2ea6bc2ced954bc67112aede36', 'krperson@mpsomaha.org', 0, 0, 13),
(136, 'Kirk', 'Peterson', 'kapeters', 'ab4e724745babac0dd207eaeb86f968f', 'kapeters@mpsomaha.org', 0, 0, 16),
(137, 'Brooke', 'Phillips', 'bmphillips', '4fcde8fbf8f92637c55b84ffc1a7a8b4', 'bmphillips@mpsomaha.org', 0, 0, 2),
(138, 'Steven', 'Powell', 'smpowell', 'f89a0b9b36ab31a460594c06a7f8a298', 'smpowell@mpsomaha.org', 0, 0, 2),
(139, 'Jennifer', 'Priest', 'jmpriest', 'aa73b25e44212e576367c71c046d9560', 'jmpriest@mpsomaha.org', 0, 0, 2),
(140, 'Maggi', 'Recob', 'marecob', '4ba718ad271c8c6f31bf83eb784951ce', 'marecob@mpsomaha.org', 0, 0, 5),
(141, 'Patty', 'Ritchie', 'pritchie', '6683fb4b4028b77cc70be7b0ddfefc4d', 'pritchie@mpsomaha.org', 0, 0, 9),
(142, 'Fred', 'Robertson', 'fdrobertson', '34d529e6c346419e1ddf7aa9b1d0e6f5', 'fdrobertson@mpsomaha.org', 0, 0, 2),
(143, 'Tim', 'Royers', 'tdroyers', '607a9b6c99e249aa475b375edd46246f', 'tdroyers@mpsomaha.org', 0, 0, 10),
(144, 'Frank', 'Ryan', 'fryan', 'a9c7aff11b5fe8910a2f7e63de2e6444', 'fryan@mpsomaha.org', 0, 0, 16),
(145, 'Heather', 'Ryan', 'hsryan', '6c55205ceed9b473f7edbdd418180139', 'hsryan@mpsomaha.org', 0, 0, 3),
(146, 'Will', 'Sadowski', 'wjsadowski', '0090ce7403aa8d0c24e794af07bf8e44', 'wjsadowski@mpsomaha.org', 0, 0, 12),
(147, 'Joanie', 'Sanders', 'jsanders', '37c2189299194c46949a07f238bb5190', 'jsanders@mpsomaha.org', 0, 0, 17),
(148, 'Jane', 'Sandoz', 'jsandoz', 'b04cf3a48a8bc8a352df0f64106efd5f', 'jsandoz@mpsomaha.org', 0, 0, 2),
(149, 'Brenda', 'Schmidt', 'blschmidt', '4e8a0c1732a026c5b87f84d4a06865bd', 'blschmidt@mpsomaha.org', 0, 0, 6),
(150, 'Melissa', 'Schram', 'mnschram', 'e342cbd90f0c88050f4711dd797ed8e2', 'mnschram@mpsomaha.org', 0, 0, 13),
(151, 'Lori', 'Scolaro', 'lscolaro', '933fe5897599530ee0284a765688d964', 'lscolaro@mpsomaha.org', 0, 0, 13),
(152, 'Nate', 'Seggerman', 'naseggerman', 'ed26e181a68794f1554184799139cff3', 'naseggerman@mpsomaha.org', 0, 0, 7),
(153, 'Sue', 'Selega', 'smselega', '7fbaef234b60b8c7ae7e279a39f52a42', 'smselega@mpsomaha.org', 0, 0, 5),
(154, 'Bret', 'Siepker', 'bmsiepker', 'b39860dec0b2737725bfb427b5ec0bc3', 'bmsiepker@mpsomaha.org', 0, 0, 5),
(155, 'Katherine', 'Simpson', 'kmsimpson', '020ddfb8350bd938e871b04c35f9f491', 'kmsimpson@mpsomaha.org', 0, 0, 9),
(156, 'Lance', 'Smith', 'lmsmith', '659d15b0a165bd20b3bc78f7276a99fc', 'lmsmith@mpsomaha.org', 0, 0, 12),
(157, 'Matt', 'Smith', 'mlsmith', 'b131f781b57dd3b8a180bbe27243f1c6', 'mlsmith@mpsomaha.org', 0, 0, 2),
(158, 'Megan', 'Smith', 'mmsmith1', 'b26af15e0156d7cdda876cada6751720', 'mmsmith1@mpsomaha.org', 0, 0, 12),
(159, 'Cathy', 'Squires', 'csquires', '59839803ec23300ed63ce86835b5ede1', 'csquires@mpsomaha.org', 0, 0, 2),
(160, 'Tracy', 'Stauffer', 'tstauffe', 'ee49197210ddb623c53e1f4ca0896905', 'tstauffe@mpsomaha.org', 0, 0, 16),
(161, 'Beth', 'Stilwell', 'brstilwell', '363e3a021e4b5b249c36f60fb3fe1a8c', 'brstilwell@mpsomaha.org', 0, 0, 12),
(162, 'Lindsey', 'Sullivan', 'llsullivan', 'b0e9d4809b477121c1a08a5cf7c0bce9', 'llsullivan@mpsomaha.org', 0, 0, 10),
(163, 'Lydia', 'Swanson', 'lvswanson', '44055d06e55d77c7d67073bc88b99025', 'lvswanson@mpsomaha.org', 0, 0, 13),
(164, 'Therese', 'Terschuren', 'tterschu', '89134aa6c3a8c32bad0b9e229798f8fe', 'tterschu@mpsomaha.org', 0, 0, 3),
(165, 'Jacque', 'Tevis-Butler', 'jtevis', 'ca3fbd522db5db5e4f9aa18ca348c105', 'jtevis@mpsomaha.org', 0, 0, 10),
(166, 'Rick', 'Thaden', 'rdthaden', 'd196f74b651a4992fef80d1dda366f63', 'rdthaden@mpsomaha.org', 0, 0, 8),
(167, 'Jacob', 'Thompson-Krug', 'jlkrug', '47fcf685c9261239fc51d46801274a54', 'jlkrug@mpsomaha.org', 0, 0, 5),
(168, 'Scott', 'Townsley', 'setownsley', '5b1800cc8813d017a953b23f27bd6975', 'setownsley@mpsomaha.org', 0, 0, 10),
(169, 'Seth', 'Turman', 'sbturman', 'c352024825fd545340a1a2842671a836', 'sbturman@mpsomaha.org', 0, 0, 12),
(170, 'Earlene', 'Uhrig', 'eguhrig', 'e056d888e5abe5a694c590b1279f57d1', 'eguhrig@mpsomaha.org', 0, 0, 7),
(171, 'Kayla', 'Vavra', 'kovavra', 'cef14a01e7b7639343ec8a2aed81926d', 'kovavra@mpsomaha.org', 0, 0, 2),
(172, 'Susan', 'Waldron', 'sewaldron', 'b04f14435a96927992398b57ced08857', 'sewaldron@mpsomaha.org', 0, 0, 6),
(173, 'Alyssa', 'Watson', 'aswatson', '163fef318c58d27bd41c4011846d6752', 'aswatson@mpsomaha.org', 0, 0, 10),
(174, 'Joshua', 'Weber', 'jrweber', 'aa87f5f0beae5496bb429c67c6d59236', 'jrweber@mpsomaha.org', 0, 0, 5),
(175, 'Kathern', 'Wendt', 'klwendt', '0253e9ded017adcc84c8ca96e3b71f3f', 'klwendt@mpsomaha.org', 0, 0, 7),
(176, 'Valerie', 'Wentworth', 'vswentworth', 'ee1d07364d917b9847113fba1d7aed84', 'vswentworth@mpsomaha.org', 0, 0, 7),
(177, 'Leslie', 'Wilkinson', 'llwilkinson', 'b21796b3fa05d6548bc479189c440998', 'llwilkinson@mpsomaha.org', 0, 0, 5),
(178, 'Aaron', 'Willems', 'ajwillems', '977c3543927e4e6ddc5f7fde32f8ca6e', 'ajwillems@mpsomaha.org', 0, 0, 7),
(179, 'Trevor', 'Wiltse', 'tmwiltse', '47e204006de13c7fb0783e199172faee', 'tmwiltse@mpsomaha.org', 0, 0, 12),
(180, 'Chad', 'Young', 'chyoung', '30a1b4849690e29accc105f494cb2e18', 'chyoung@mpsomaha.org', 0, 0, 10),
(181, 'Ramsey', 'Young', 'rdyoung', '265caf7559741445b3276a8c9ba4dd6b', 'rdyoung@mpsomaha.org', 0, 0, 2),
(183, 'Guest', 'User', 'GuestUser', '5f4dcc3b5aa765d61d8327deb882cf99', 'guestUser@simcaster.net', 0, 1, 1),
(184, 'test', 'test', 'test', 'ce7770b6a2833d0e9a84014741d17c86', 'bendoan5@gmail.com', 0, 0, 1),
(185, 'test', 'test', 'test', '', 'test@simcaster.net', 0, 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
