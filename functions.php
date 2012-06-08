<?php

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
function redirect($location, $message=null, $type="alert-success") {
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
    $sql = "SELECT * FROM users WHERE user_id={$id}";
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

//returns the name of the type with id $id
function getTypeName($id){
    $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
    $sql = "SELECT * FROM types WHERE type_id={$id}";
    $results = $conn->query($sql);

    $name = "";
    while($row = $results->fetch_assoc()){
        $name = $row['type_name'];
    }
    $conn->close();
    return $name;
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
function makeUser($firstname, $lastname, $username, $email, $password){
    $time = date('m/d/Y G:h');

    $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
    $password = md5($password);
    $sql = "INSERT INTO users (user_firstname, user_lastname, user_username, user_email, user_password) VALUES ('$firstname', '$lastname', '$username', '$email', '$password')";
    $results = $conn->query($sql);
    writeLineToLog("$time - Admin - Added user $username");
}

//adds a resource to the database, and logs the action
function makeResource($rType, $details, $identifier, $blocktype){
    $time = date('m/d/Y G:h');

    $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
    $sql = "INSERT INTO resources (resource_type, resource_details, resource_identifier, resource_blocktype) VALUES ('$rType','$details','$identifier','$blocktype')";
    $results = $conn->query($sql);
    writeLineToLog("$time -Admin - Added resource $identifier");
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
    writeLineToLog("$time - Admin - Added request $rType");
}

//adds a request to the database, and logs the action
function makeType($rType){
    $time = date('m/d/Y G:h');

    $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
    $sql = "INSERT INTO types (type_name) VALUES ('$rType')";
    $results = $conn->query($sql);
    writeLineToLog("$time - Admin - Added type $rType");
}

//updates the current user data in SESSION
function updateSessionUser(){
	$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	$sql = "SELECT * FROM users WHERE user_id='{$_SESSION['user']['user_id']}'";
	$user = $conn->query($sql);
    $user = $user->fetch_assoc();
    $_SESSION['user'] = $user;
}

//returns a slice of $array containing all entries that match $pattern
function getMatchingLines($pattern, $array){
    $returnArray = Array();
    foreach ($array as $x) {
        if (preg_match($pattern, $x) == 1) {
            $returnArray[] = $x;
        }
    }
    return $returnArray;
}

//returns an double scripted array containing all resource types -> type_name
//& type_id
function getRTypesArray(){
	$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	$sql = "SELECT * FROM types";
    $results = $conn->query($sql);

    $returnArray = Array();
    while($row = $results->fetch_assoc()){
        $rtype = Array();
        $rType['type_id'] = $row['type_id'];
        $rType['type_name'] = $row['type_name'];
        $returnArray[] = $rType;
    }
    return $returnArray;
}

//returns the name of the resource type matching $id
function getResourceTypeName($id){
	$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	$sql = "SELECT * FROM types WHERE type_id='$id'";
    $results = $conn->query($sql);

    while($row = $results->fetch_assoc()){
        return $row['type_name'];
    }
}

//returns the email of the user matching $id
function getUserEmail($id){
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $sql = "SELECT * FROM users WHERE user_id='$id'";
    $results = $conn->query($sql);

    while($row = $results->fetch_assoc()){
        return $row['user_email'];
    }
}

//returns true if the username matches a user
function isUser($username){
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $sql = "SELECT * FROM users WHERE user_username='$username'";
    $results = $conn->query($sql);
    if ($results === null) {
        return false;
    }
    return true;
}

// changes a user's password
function changeUserPassword($user_id, $password){
    $md5_password = md5($password);
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $sql = "UPDATE users SET user_password='$md5_password' WHERE user_id='$user_id'";
    $results = $conn->query($sql);
    if ($results === null) {
        return 0;
    }
    return 1;
}

// generates and returns a password randomly composed
// of uper and lower case letters and numbers
// of length $length
function genPassword($length){
    $newPass = "";
    for ($i = 0; $i < $length; $i++) {
        if (rand(0,1)){
            if (rand(0,1)){
                $newPass .= chr(rand(97,122));
            }else{
                $newPass .= chr(rand(65,90));
            }
        }else{
            $newPass .= chr(rand(48,57));
        }
    }
    return $newPass;
}

function isAdmin(){
	$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	$sql = "SELECT * FROM users WHERE user_id='{$_SESSION['user']['user_id']}'";
    $results = $conn->query($sql);

    while($row = $results->fetch_assoc()){
        if (1 == $row['user_isadmin']) {
            return true;
        }
        return false;
    }
}

function getUrl(){
    return (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
}

function getBaseUrl(){
    return $_SERVER['SERVER_NAME'];
}
