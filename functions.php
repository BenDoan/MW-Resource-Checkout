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
//returns null if no matches are found
function getResourceDesc($id){
    return sqlSelectOne("SELECT * FROM resources WHERE resource_id={$id}", 'resource_identifier');
}

//returns the username matching the id param
function getUsername($id){
    return sqlSelectOne("SELECT * FROM users WHERE user_id={$id}", 'user_username');
}

// returns the full name of the user matching id
function getFullName($id){
    $firstname = sqlSelectOne("SELECT * FROM users WHERE user_id={$id}", 'user_firstname');
    $lastname = sqlSelectOne("SELECT * FROM users WHERE user_id={$id}", 'user_lastname');

    return $firstname . ' ' . $lastname;
}

//returns the user_id matching the username param
function getUserId($user_name){
    return sqlSelectOne("SELECT * FROM users WHERE user_username='$user_name'", 'user_id');
}

//returns the name of the type with id $id
function getTypeName($id){
    return sqlSelectOne("SELECT * FROM types WHERE type_id={$id}", 'type_name');
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
function makeUser($firstname, $lastname, $username, $email, $isReadOnly){
    $cur_user = $_SESSION['user']['user_username'];
    $password = genPassword(7);
    $md5_password = md5($password);
    sqlQuery("INSERT INTO users (user_firstname, user_lastname, user_username, user_email, user_password, user_isreadonly) VALUES ('$firstname', '$lastname', '$username', '$email', '$md5_password', '$isReadOnly')");
    $time = getTimestamp();
    sendSignupEmail(getUserId($username), $password);
    writeLineToLog("$time - $cur_user - Added user $username");
}

//adds a resource to the database, and logs the action
function makeResource($rType, $details, $identifier, $blocktype){
    $cur_user = $_SESSION['user']['user_username'];
    sqlQuery("INSERT INTO resources (resource_type, resource_details, resource_identifier, resource_blocktype) VALUES ('$rType','$details','$identifier','$blocktype')");
    $time = getTimestamp();
    writeLineToLog("$time -$cur_user - Added resource $identifier");
}

//adds a request to the database, and logs the action
function makeRequest($rType, $username, $date, $block){
    $cur_user = $_SESSION['user']['user_username'];
	$date = date("Y-m-d", strtotime($date));
    $username = getUserId($username);

    sqlQuery("INSERT INTO schedule (schedule_resource_id, schedule_user_id, schedule_date, schedule_block) VALUES ('$rType','$username','$date','$block')");
    $time = getTimestamp();
    writeLineToLog("$time - $cur_user - Added request $rType");
}

//adds a request to the database, and logs the action
function makeType($rType){
    $cur_user = $_SESSION['user']['user_username'];
    sqlQuery("INSERT INTO types (type_name) VALUES ('$rType')");
    $time = getTimestamp();
    writeLineToLog("$time - $cur_user - Added type $rType");
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
    $STH = sqlSelect("SELECT * FROM types");
    $returnArray = Array();
    while($row = $STH->fetch()) {
        $rtype = Array();
        $rType['type_id'] = $row['type_id'];
        $rType['type_name'] = $row['type_name'];
        $returnArray[] = $rType;
    }

    return $returnArray;
}

//returns the name of the resource type matching $id
function getResourceTypeName($id){
    return sqlSelectOne("SELECT * FROM types WHERE type_id='$id'", 'type_name');
}

//returns the id of the resource type matching $name
function getResourceTypeId($name){
    return sqlSelectOne("SELECT * FROM types WHERE type_name='$name'", 'type_id');
}

//returns the id of the resource type matching $id
function getResourceTypeIdFromResource($id){
    return sqlSelectOne("SELECT * FROM resources WHERE resource_id='$id'", 'resource_type');
}

//returns the email of the user matching $id
function getUserEmail($id){
    return sqlSelectOne("SELECT * FROM users WHERE user_id='$id'", 'user_email');
}

//returns true if the username matches a user
function isUser($username){
    $results = sqlSelectOne("SELECT * FROM users WHERE user_username='$username'", 'user_username');
    if ($results === null) {
        return false;
    }
    return true;
}

//changes a user's password
function changeUserPassword($user_id, $password){
    $md5_password = md5($password);
    sqlQuery("UPDATE users SET user_password='$md5_password' WHERE user_id='$user_id'");
}

//generates and returns a password randomly composed
//of uper and lower case letters and numbers
//of length $length
function genPassword($length=7){
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

//returns true if the current user is an admin
//returns false if the user is not, or if the user
//is not logged in
function isAdmin(){
    if (!isset($_SESSION['user'])) {
        return false;
    }else if (sqlSelectOne("SELECT * FROM users WHERE user_id='{$_SESSION['user']['user_id']}'", 'user_isadmin') == 1) {
        return true;
    }else{
        return false;
    }
}

//returns the current url
function getUrl(){
    return (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
}

//returns the base url:
//ex: localhost, google.com
function getBaseUrl(){
    return $_SERVER['SERVER_NAME'];
}

//executes 1 sql statement
//returns the number of affected rows
function sqlQuery($sql){
    try {
        $DBH = new PDO("mysql:host=localhost;dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);

        $stmt = $DBH->prepare($sql);
        $stmt->bindParam(':id', filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT), PDO::PARAM_INT);
        return $stmt->execute();
    }catch(PDOException $e){
        redirect('./', 'DB Error: ' . $e->getMessage());
    }
}

//executes an sql select statement and returns a
//pdo object with the results
//see the sqlSelectOne function for usage
function sqlSelect($sql){
    try {
        $DBH = new PDO("mysql:host=localhost;dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
        $STH = $DBH->query($sql);
        $STH->setFetchMode(PDO::FETCH_ASSOC);
        return $STH;
    }catch(PDOException $e){
        redirect('./', 'DB Error: ' . $e->getMessage());
    }
}

//executes an sql select statement and returns
//the [$col] of the first occurance
function sqlSelectOne($sql, $col){
    try {
        $DBH = new PDO("mysql:host=localhost;dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
        $STH = $DBH->query($sql);
        $STH->setFetchMode(PDO::FETCH_ASSOC);

        $result = null;
        while($row = $STH->fetch()) {
            $result = $row[$col];
        }
        return $result;
    }catch(PDOException $e){
        redirect('./', 'DB Error: ' . $e->getMessage());
    }
}

//returns a time stamp suitable
//for use in logs
function getTimestamp(){
    return date('m/d/Y G:h');
}

//returns the blocktype of the resource
//associated with the specified request
function getRequestBlockType($request_id){
    $resource_id = sqlSelectOne("SELECT * FROM schedule WHERE 'schedule_id=$request_id", 'schedule_resource_id');
    return sqlSelectOne("SELECT * FROM resources WHERE 'resource_id=$resource_id'",'resource_blocktype');
}

//returns the blocktype of the resource
//specified
function getResourceBlockType($resource_id){
    return sqlSelectOne("SELECT * FROM resources WHERE 'resource_id=$resource_id'",'resource_blocktype');
}

//changes the database notation for blocks
//to human readable text
function blockToHuman($block){
    switch ($block) {
        case 1:
            return "Block 1";
            break;
        case 2:
            return "Block 2";
            break;
        case 3:
            return "Block 3";
            break;
        case 4:
            return "Block 4";
            break;
        case 11:
            return "Block 1 first half";
            break;
        case 12:
            return "Block 1 second half";
            break;
        case 21:
            return "Block 2 first half";
            break;
        case 22:
            return "Block 2 second half";
            break;
        case 31:
            return "Block 3 first half";
            break;
        case 32:
            return "Block 3 second half";
            break;
        case 41:
            return "Block 4 first half";
            break;
        case 42:
            return "Block 4 second half";
            break;
        default:
            return "Error";
            break;
    }
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

//sends a signup email to the specified user, containing
//the specified password
function sendSignupEmail($user_id, $password){
    define('EMAIL_SUBJECT', 'MW Resource Checkout');
    $from = "noreply@westwildcats.org";
    $headers  = "From: $from\r\n";
    $headers .= "Content-type: text/html\r\n";
    mail(getUserEmail($user_id), EMAIL_SUBJECT, genSignupEmail(getUsername($user_id), $password), $headers);
}

//returns true if the current user is a read only user, and
//false if they are not
function isReadOnly(){
    if (!isset($_SESSION['user'])) {
        return false;
    }else if (sqlSelectOne("SELECT * FROM users WHERE user_id='{$_SESSION['user']['user_id']}'", 'user_isreadonly') == 1) {
        return true;
    }else{
        return false;
    }

}
