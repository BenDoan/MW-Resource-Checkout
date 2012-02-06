<?php

// Start the session
session_start();

// Load configuration files
require_once('config/db.php');
require_once('config/app.php');
require_once('functions.php');

// Set current page
if(isLoggedIn() && $_SESSION['user']['user_username'] == 'admin'){
    $CURR_PAGE = isset($_GET['p']) ? $_GET['p'] : 'adminPage';
}else{
    $CURR_PAGE = isset($_GET['p']) ? $_GET['p'] : DEFAULT_VIEW;
}
$action = isset($_GET['action']) ? $_GET['action'] : null;

// If user is logged in, or is trying to login, let them
if(isLoggedIn() || $action == 'authenticate' || $CURR_PAGE == 'login') {
	// If no action is specified
	if($action == null) {
		require_once('template.php');
	} else {
		$file = "actions/$action.php";
		loadFile($file);
	}
} else { // Otherwise, force them to login
	redirect('./?p=login','Please login.');
}

/**
 * Determines whether or not the user is logged in
 * @return True if logged in, false if not
 */
function isLoggedIn() {
	return isset($_SESSION['user']);
}

/**
 * Loads the file, if it exists. If the file doesn't exist,
 * a location header for the 404 page is sent back to the browser
 * @param String $file File to load
 */
function loadFile($file) {
	if(file_exists($file)) {
		require_once($file);
	} else {
		redirect('Location:./?p=404', 'Error. Page does not exist.');
	}
}

/**
 * Helper function to send location headers, with an optional message
 * @param String $location Absolute or relative URL of destination
 * @param String $message Optional message to display upon redirection
 */
function redirect($location,$message=null) {
	if($message != null) {
		$_SESSION['message'] = $message;
	}
	header("Location:$location");
}
?>
