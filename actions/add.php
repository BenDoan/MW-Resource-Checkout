<?php
extract($_POST);

if ($type == 'user') {
    $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
    $sql = "INSERT INTO users (user_firstname, user_lastname, user_username, user_password) VALUES ('$firstname','$lastname','$username','{md5($password)}')";
    $results = $conn->query($sql);
}elseif ($type == 'resource'){
    $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
    $sql = "INSERT INTO resources (resource_type, resource_details, resource_identifier, resource_blocktype) VALUES ('$name','$details','$identifier','$blocktype')";
    $results = $conn->query($sql);
}elseif ($type == 'request'){
    $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
    $sql = "INSERT INTO schedule (schedule_resource_id, schedule_user_id, schedule_date, schedule_block) VALUES ('$rtype','$username','$date','$block')";
    $results = $conn->query($sql);
}
$cap_type = ucfirst($type);
$_SESSION['type'] = $type;
redirect("./", "$cap_type successfully added");
?>
