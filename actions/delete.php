<?php
$time = date('m/d/Y G:h');

extract($_GET);
if (isset($type)) {
    switch ($type) {
    case 'user':
        $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
        $sql = "DELETE FROM users WHERE user_id={$user}";
        $results = $conn->query($sql);
        $conn->close();
        $selection = 0;
        $user_id = getUsername($user);
        writeLineToLog("$time - Deleted user $username_id $user");
        break;

    case 'request':
        $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
        $sql = "DELETE FROM schedule WHERE schedule_id=$request";
        $results = $conn->query($sql);
        $selection = 1;
        $message = $conn->error;
        writeLineToLog("$time - Deleted request $request");
        break;

    case 'resource':
        $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
        $sql = "DELETE FROM resources WHERE resource_id={$resource}";
        $results = $conn->query($sql);
        $selection = 2;
        $resourceDesc = getResourceDesc($resource);
        writeLineToLog("$time - Deleted resource $resourceDesc");
        break;
    }
}
$_SESSION['type'] = $type;
redirect("./", "Deletion successfull");
?>
