<?php
//takes the table from the staff directory as input in table.php
//registers all users in that table, and emails them a registration email

require_once('xmlToArrayParser.php');
require_once('User.php');
require_once('../config/db.php');
require_once('../functions.php');
define('EMAIL_SUBJECT', 'MW Resource Checkout');
$from = "noreply@westwildcats.org";

if(isset($_GET['action'])){
	if($_GET['action'] == "generate"){
		$users = generateUsers();
		foreach($users as $user){
			addUser($user);
            $headers  = "From: $from\r\n";
            $headers .= "Content-type: text/html\r\n";
            //mail($user->email, EMAIL_SUBJECT, genSignupEmail($user->username, $user->password), $headers);
		}
	}
}
function addUser($user){
	//get list of users from database
    $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
	$users = $conn->query("SELECT * FROM users");
	//check if current user already exists
	$isNewUser = true;
	while($currUser = $users->fetch_object()){
		if($currUser->user_username == $user->username){
			$isNewUser = false;
		}
	}

	//add new user to database
    $md5_pass = md5($user->password);
	$sql = "INSERT INTO users (user_firstname, user_lastname, user_username, user_password, user_email) VALUES ('$user->firstName', '$user->lastName', '$user->username', '$md5_pass', '$user->email'";
	//close database connection
	$conn->close();
}
function generateUsers(){
	//open the html table
	$table = file_get_contents("table_test.php");
	//parse the html into nice arrays
	$parser = new xmlToArrayParser($table);
	$domObj = $parser->array;
	$users = array();
	//drill down through the dom
	foreach($domObj as $table){
		foreach($table as $table2){
			foreach($table2 as $tbody){
				foreach($tbody as $tr){
					if($tr[1] != 'Administrative' &&
					$tr[1] != 'Counseling' &&
					$tr[1] !='Custodial' &&
					$tr[1] != 'General'){
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

						$password = genPassword(7);
						$currUser = new User($username, $first, $last, $password, $email);

						$users[] = $currUser;
						//for debugging purposes
						echo "</br>username: ".$username.
							"</br>password: ".$password."</br>";
					}

				}
			}
		}
	}
	return $users;

}

// returns a signup email based on the username and password supplied
function genSignupEmail($username, $password){
    $reg_email = "
    <h3>Welcome to Millard West Resource Checkout</h3>

    <p>
    Your new login information is:
        Username: $username
        Password: $password
    </p>

    <p>Please change your password the first time you login.</p>

    <p>To do this:</p>
    <ol>
        <li>Go to the settings tab
        <li>Type in your current password
        <li>Enter your new password twice
    </ol>
    ";
    return $reg_email;
}
?>
<a href = "reg.php?action=generate">Generate Users</a>
