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
    if ($isNewUser) {
        $md5_pass = md5($user->password);
        $sql = "INSERT INTO users (user_firstname, user_lastname, user_username, user_password, user_email) VALUES ('$user->firstName', '$user->lastName', '$user->username', '$md5_pass', '$user->email')";
        sqlQuery($sql);
        print "made new user:" . $user->username . "<br />";
        $headers  = "From: $from\r\n";
        $headers .= "Content-type: text/html\r\n";
        //mail($user->email, EMAIL_SUBJECT, genSignupEmail($user->username, $user->password), $headers);
    }
	//close database connection
	$conn->close();
}
function generateUsers(){
	//open the html table
	$table = file_get_contents("final_table.php");
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
                        $user_exploded = explode("@", $email);
						$username = $user_exploded[0];

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
    <ul>
        <li>You can use this web app to checkout school resources
        <li>This is the sole method for checking out laptop carts and computer labs
        <li>The Media Center computers are <em>not</em> managed by this system
    </ul>

    <p>
    Your new login information is:
    <ul style=\"list-style-type:none;\">
        <li>Username: $username
        <li>Password: $password
    </ul>
    </p>

    <p>Please change your password the first time you login.</p>

    <p>To do this:</p>
    <ol>
        <li>Go to the settings tab
        <li>Type in your current password
        <li>Enter your new password twice
    </ol>

    <a href=\"http://i.westwildcats.org/checkout/\">MW Checkout</a>
    ";
    return $reg_email;
}
?>
<a href = "reg.php?action=generate">Generate Users</a>
