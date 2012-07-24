<?php
extract($_POST);
// If the user is logging out
if(isset($_GET['logout'])) {
	// Remove user from session data
	unset($_SESSION['user']);
	$message = 'You have successfully logged out.';
	$location = './?p=login';
// If the user is trying to logging in
} elseif($username != '' && $password != '') {	// If a username AND password were entered
	$user = validateUser($username, $password);
	$user = $user->fetch_assoc();
	// User found
	if($user != null) {
        $_SESSION['user'] = $user;
        $message = 'Welcome back, '.$user['user_firstname'].'!';
        $location = './';
	// User not found
	} else {
		$message = 'You have entered an invalid username and password combination. Please try again.';
		$location = './?p=login';
	}
// If either username or password is missing
} else {
	$message = 'Please enter a username and password.';
	$location = './?p=login';
}
// Redirect
redirect($location,$message);

// Check if user is in database
// Return a result object
function validateUser($username, $password){
	$password = md5($password);
	$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	$sql="SELECT * FROM users WHERE user_username='$username' AND user_password='$password'";
	return $conn->query($sql);

	// Close Connection
	$conn->close();
}
