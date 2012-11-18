<?php
extract($_POST);
// If the user is logging out
if(isset($_GET['logout'])) {
	// Remove user from session data
	unset($_SESSION['user']);
	$message = '';
	$location = './?p=login';
// If the user is trying to logging in
} elseif($username != '' && $password != '') {	// If a username AND password were entered
	$user = validateUser($username, $password);
    $user = $user->fetch();
	// User found
	if($user != null && !isset($_SESSION['user'])) {
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
	return sqlSelect("SELECT * FROM users WHERE user_username='$username' AND user_password='$password'");
}
