<?php
require_once('functions.php');

if ($_POST['password'] !== $_POST['password2']) {
    redirect('./', 'Passwords do not match');
}

$data = '<?php' . PHP_EOL;
$data .= 'define("DB_HOST", "' . $_POST["dbhost"] .'");' . PHP_EOL;
$data .= 'define("DB_NAME", "' . $_POST["dbname"] .'");' . PHP_EOL;
$data .= 'define("DB_USERNAME", "' . $_POST["dbusername"] . '");' . PHP_EOL;
$data .= 'define("DB_PASSWORD", "' . $_POST["dbpassword"] . '");';

file_put_contents('config/db.php', $data);
require_once('config/db.php');

//comments
$sql = "CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_resource_id` int(11) NOT NULL,
  `comment_user_id` int(11) NOT NULL,
  `comment_date` date NOT NULL,
  `comment_message` text NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;";
sqlQuery($sql);

//departments
$sql = "CREATE TABLE IF NOT EXISTS `departments` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(60) NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;";
sqlQuery($sql);

//resources
$sql = "CREATE TABLE IF NOT EXISTS `resources` (
  `resource_id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_type` varchar(100) NOT NULL,
  `resource_details` varchar(50) NOT NULL,
  `resource_identifier` varchar(50) NOT NULL,
  `resource_department` int(11) NOT NULL,
  PRIMARY KEY (`resource_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;";
sqlQuery($sql);


//schedules
$sql = "CREATE TABLE IF NOT EXISTS `schedule` (
  `schedule_id` int(11) NOT NULL AUTO_INCREMENT,
  `schedule_resource_id` int(11) NOT NULL,
  `schedule_user_id` int(11) NOT NULL,
  `schedule_date` date NOT NULL,
  `schedule_block` int(11) NOT NULL,
  PRIMARY KEY (`schedule_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;";
sqlQuery($sql);

//settings
$sql = "CREATE TABLE IF NOT EXISTS `settings` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_type` varchar(60) NOT NULL,
  `setting_value` varchar(100) NOT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;";
sqlQuery($sql);

$sql = "INSERT INTO settings (setting_type, setting_value) VALUES ('Site Name', 'Checkout')";
sqlQuery($sql);
$sql = "INSERT INTO settings (setting_type, setting_value) VALUES ('Number of Blocks', '4')";
sqlQuery($sql);
$sql = "INSERT INTO settings (setting_type, setting_value) VALUES ('Display table counts', 'true')";
sqlQuery($sql);

//types
$sql = "CREATE TABLE IF NOT EXISTS `types` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(100) NOT NULL,
  `type_blocktype` enum('full','half') NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;";
sqlQuery($sql);

//users
$sql = "CREATE TABLE IF NOT EXISTS `users` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
sqlQuery($sql);

$hashed_password = md5($_POST['password']);
$sql = "INSERT INTO `users` (`user_firstname`, `user_lastname`, `user_username`, `user_password`, `user_email`, `user_isadmin`, `user_isreadonly`, `user_department`) VALUES ('{$_POST['firstname']}', '{$_POST['lastname']}', '{$_POST['username']}', '$hashed_password', '{$_POST['email']}', 1, 0, 0)";
sqlQuery($sql);
file_put_contents('isSetup', '');
file_put_contents('log.txt', 'Begin log');
redirect("./", "Setup finished");
