<?php
require_once('xmlToArrayParser.php');
require_once('User.php');

if(isset($_GET['action'])){
	if($_GET['action'] == "generate"){
		$users = generateUsers();
		foreach($users as $user){
			addUser($user);
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
		if($currUser->userName == $user->userName){
			$isNewUser = false;
		}
	}

	//add new user to database
	$sql = "INSERT INTO users (user_firstname, user_lastname, user_username, user_password) VALUES ('$user->firstName', '$suer->lastName', '$user->userName', '$user->password')";
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
						//create a temporary password by taking the first 10 characters of the hash of the username
						$password = substr(md5($username),0,10);
						$currUser = new User($username, $first, $last, $password);
						
						$users[] = $currUser;
						var_dump($currUser);
				}
			}
		}
	}
	//i am making a change to this file
	return $users;

}
?>
<a href = "reg.php?action=generate">Generate Users</a>
