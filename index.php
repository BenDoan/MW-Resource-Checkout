<?php
// Start the session
session_start();

$time = date('m/d/Y G:h');

// Load configuration files
require_once('config/db.php');
require_once('config/app.php');

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
 * @param String $type type of alert to display, types = alert-error,
 *                      alert-success, alert-info, alert-block
 */
function redirect($location,$message=null,$type="alert-success") {
	if($message != null) {
		$_SESSION['message'] = $message;
        $_SESSION['messagetype'] = $type;
	}
	header("Location:$location");
}

//returns the resource identifier matching the resource id param
function getResourceDesc($id){
    $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
    $sql = "SELECT * FROM resources WHERE resource_id={$id}";
    $results = $conn->query($sql);

    $resource_description = null;
    while($row = $results->fetch_assoc()){
        $resource_description = $row['resource_identifier'];
    }
    return $resource_description;
}

//returns the username matching the id param
function getUsername($id){
    $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
    $sql = "SELECT * FROM users WHERE user_id=$id";
    $results = $conn->query($sql);

    $username = "";
    while($row = $results->fetch_assoc()){
        $username = $row['user_username'];
    }
    $conn->close();
    return $username;
}

//returns the user_id matching the username param
function getUserId($user_name){
    $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
    $sql = "SELECT * FROM users WHERE user_username='$user_name'";
    $results = $conn->query($sql);

    $user_id= "";
    print $conn->error;
    while($row = $results->fetch_assoc()){
            $user_id= $row['user_id'];
    }
    $conn->close();
    return $user_id;
}

//writes $line to the log file
function writeLineToLog($line){
    $logFile = "log.txt";
    $fh = fopen($logFile, 'a') or die("can't open file");
    $line .= "\n";
    fwrite($fh, $line);
    fclose($fh);
}

//returns returns an array containing the whole log file
function readLog(){
    $file = "log.txt";
    $fh = fopen($file, 'r');
    $data = fread($fh, filesize($file));
    fclose($fh);
    $data = explode("\n", $data);
    return $data;
}

//prints the given array, surroundeed by pre tags
function printArray($array){
    print '<pre>';
    print_r($array);
    print '</pre>';
}

//adds a user to the database, and logs the action
function makeUser($firstname, $lastname, $username, $password){
    $time = date('m/d/Y G:h');

    $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
    $password = md5($password);
    $sql = "INSERT INTO users (user_firstname, user_lastname, user_username, user_password) VALUES ('$firstname','$lastname','$username','$password')";
    $results = $conn->query($sql);
    writeLineToLog("$time - Added user $username");
}

//adds a resource to the database, and logs the action
function makeResource($rType, $details, $identifier, $blocktype){
    $time = date('m/d/Y G:h');

    $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
    $sql = "INSERT INTO resources (resource_type, resource_details, resource_identifier, resource_blocktype) VALUES ('$rType','$details','$identifier','$blocktype')";
    $results = $conn->query($sql);
    writeLineToLog("$time - Added resource $identifier");
}

//adds a request to the database, and logs the action
function makeRequest($rType, $username, $date, $block){
    $time = date('m/d/Y G:h');

	$timestamp = strtotime($date);
	$date = ($date != "") ? date("Y-m-d", $timestamp) : date('Y-m-d');
    $username = getUserId($username);
    $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
    $sql = "INSERT INTO schedule (schedule_resource_id, schedule_user_id, schedule_date, schedule_block) VALUES ('$rType','$username','$date','$block')";
    $results = $conn->query($sql);
    writeLineToLog("$time - Added request $rType");
}

function updateSessionUser(){
	$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	$sql = "SELECT * FROM users WHERE user_id='{$_SESSION['user']['user_id']}'";
	$user = $conn->query($sql);
    $user = $user->fetch_assoc();
    $_SESSION['user'] = $user;
}
?>
