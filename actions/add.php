<?php
if ($_SESSION['user']['user_username'] != 'admin') {
    redirect('./');
}
$time = date('m/d/Y G:h');

extract($_POST);
printArray($_POST);

if ($type == 'user') {
    $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
    $password = md5($password);
    $sql = "INSERT INTO users (user_firstname, user_lastname, user_username, user_password) VALUES ('$firstname','$lastname','$username','$password')";
    $results = $conn->query($sql);
    writeLineToLog("$time - Added user $username");
}elseif ($type == 'resource'){
    $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
    $sql = "INSERT INTO resources (resource_type, resource_details, resource_identifier, resource_blocktype) VALUES ('$rType','$details','$identifier','$blocktype')";
    $results = $conn->query($sql);
    writeLineToLog("$time - Added resource $identifier");
}elseif ($type == 'request'){
	$timestamp = strtotime($date);
	$date = ($date != "") ? date("Y-m-d", $timestamp) : date('Y-m-d');
    $username = getUserId($username);

    $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
    $sql = "INSERT INTO schedule (schedule_resource_id, schedule_user_id, schedule_date, schedule_block) VALUES ('$rtype','$username','$date','$block')";
    $results = $conn->query($sql);
    writeLineToLog("$time - Added request $rtype");
}
$cap_type = ucfirst($type);
$_SESSION['tab'] = $type;
redirect("./", "$cap_type successfully added");
?>
