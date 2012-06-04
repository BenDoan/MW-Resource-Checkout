<?php
ob_start(); // turns on output buffering
session_start();

$time = date('m/d/Y G:h');

// Load configuration files
require_once('config/db.php');
require_once('config/app.php');
require_once('functions.php');

// Set current page
if(isLoggedIn() && isAdmin()){
    $CURR_PAGE = isset($_GET['p']) ? $_GET['p'] : 'adminPage';
}else{
    $CURR_PAGE = isset($_GET['p']) ? $_GET['p'] : DEFAULT_VIEW;
}
$action = isset($_GET['action']) ? $_GET['action'] : null;

// If user is logged in, or is trying to login, let them
if(isLoggedIn() ||
    $action === 'authenticate' ||
    $CURR_PAGE === 'login' ||
    $CURR_PAGE === 'resetPassword' ||
    $action === 'resetPassword') {

	// If no action is specified
	if($action == null) {
		require_once('template.php');
	} else {
		loadFile("actions/$action.php");
	}
} else { // Otherwise, force them to login
	redirect('./?p=login','Please login.');
}
ob_flush(); // flushes the output buffer
?>
