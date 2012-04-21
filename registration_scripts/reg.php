<?php
//takes the table from the staff directory as input in table.php
//registers all users in that table, and emails them a registration email

require_once('xmlToArrayParser.php');
require_once('User.php');

define('EMAIL_SUBJECT', 'TODO:Needs subject');
define('EMAIL_MESSAGE', 'TODO:Needs message');

if(isset($_GET['action'])){
	if($_GET['action'] == "generate"){
		$users = generateUsers();
		foreach($users as $user){
			addUser($user);
			//TODO: test email
            //mail($user->email, EMAIL_SUBJECT, EMAIL_MESSAGE);
		}
	}
}
function addUser($user){
	//get list of users from database
	$conn = new mysqli('localhost', 'root', '', 'resourcecheckout');
	$users = $conn->query("SELECT * FROM users");
	//check if current user already exists
	$isNewUser = true;
	while($currUser = $users->fetch_object()){
		if($currUser->user_userName == $user->userName){
			$isNewUser = false;
		}
	}

	//add new user to database
	$sql = "INSERT INTO users (user_firstname, user_lastname, user_username, user_password) VALUES ('$user->firstName', '$user->lastName', '$user->userName', 'md5($user->password')";
	if(!$conn->query($sql)){
		echo 'Error #'.$conn->errorno. ': ', $conn->error;
	}

	//close database connection
	$conn->close();
}
function generateUsers(){
	//open the html table
	$table = file_get_contents("table.php");
	//parse the html into nice arrays
	$parser = new xmlToArrayParser($table);
	$domObj = $parser -> array;
	$users = array();
	//drill down through the dom
	foreach($domObj as $table){
		foreach($table as $table2){
			foreach($table2 as $tbody){
				foreach($tbody as $tr){
					$td = $tr[0];
						//var_dump( $td);
						$a = $td['a'];
						$attrib = $a['attrib'];
						$email = $attrib['title'];
						$name = $a['cdata'];
						//split name into first and last
						$lastAndFirst = explode(", ", $name);
						$last = $lastAndFirst[0];
						$first = $lastAndFirst[1];
						//create a username (first initial + lastname)
						$username = strtolower($first[0] . $last);
						//create a temporary password by taking the lastname plus a few random numbers
						$password = strtolower($last) . rand(0,9). rand(0,9). rand(0,9);
						$currUser = new User($username, $first, $last, $password, $email);

						$users[] = $currUser;
						//for debugging purposes
						echo "</br>username: ".$username.
							"</br>password: ".$password."</br>";

				}
			}
		}
	}
	return $users;

}
?>
<a href = "reg.php?action=generate">Generate Users</a>
