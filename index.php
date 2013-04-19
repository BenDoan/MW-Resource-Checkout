<?php
ob_start(); // turns on output buffering
session_start();
$isSetup = file_exists("isSetup");

// Load configuration files
require_once('functions.php');
if ($isSetup) {
    require_once('config/db.php');
    require_once('config/app.php');
}else {
    define('DEFAULT_VIEW', '');
}

$time = getTimestamp();

// Set current page
if(isAdmin()){
    $CURR_PAGE = isset($_GET['p']) ? $_GET['p'] : 'adminPage';
}else{
    $CURR_PAGE = isset($_GET['p']) ? $_GET['p'] : DEFAULT_VIEW;
}

$userAllowedActions = Array(
    'addComment',
    'authenticate',
    'cancel',
    'editUserSettings',
    'reserve',
    'resetPassword',
    'checkAvailability',
    'changeReserve',
    'cancelRequest');

$unregisteredUserAllowedActions = Array(
    'resetPassword',
    'authenticate');

$action = null;
if (!$isSetup) {
    if (isset($_GET['action'])) {
        $action = 'setup';
    }
}elseif (isset($_SESSION['user'])) {
    if (isAdmin()) {
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
        }
    }else{
        if (isset($_GET['action'])) {
            if (in_array($_GET['action'], $userAllowedActions, true)) {
                $action = $_GET['action'];
            }
        }
    }
}else{
    if (isset($_GET['action'])) {
        if (in_array($_GET['action'], $unregisteredUserAllowedActions, true)) {
            $action = $_GET['action'];
        }
    }
}

// If user is logged in, or is trying to login, let them
if(isLoggedIn() ||
    in_array($action, $unregisteredUserAllowedActions, true) ||
    $CURR_PAGE === 'login' ||
    $CURR_PAGE === 'resetPassword' ||
    !$isSetup) {

	// If no action is specified
	if($action == null) {
		require_once('template.php');
	} else {
		loadFile("actions/$action.php");
	}
} else { // Otherwise, force them to login
	redirect('./?p=login');
}
ob_flush(); // flushes the output buffer
?>
