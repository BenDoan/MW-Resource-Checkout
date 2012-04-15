<?php
if ($_SESSION['user']['user_username'] != ADMIN_USERNAME) {
    redirect('./');
}
$time = date('m/d/Y G:h');
$page_string = 'current' . $_GET['type'] . 'page';
$page = $_GET['page'];


extract($_GET);
if (isset($type)) {
    switch ($type) {
    case 'user':
        //delete user
        $user_name = getUsername($user);
        writeLineToLog("$time - Admin - Deleted user $user_name");

        $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
        $sql = "DELETE FROM users WHERE user_id={$user}";
        $results = $conn->query($sql);
        $conn->close();

        //delete requests that match deleted user
        $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
        $sql = "DELETE FROM schedule WHERE schedule_user_id={$user}";
        $results = $conn->query($sql);
        $conn->close();
        break;

    case 'request':
        $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
        $sql = "DELETE FROM schedule WHERE schedule_id=$request";
        $results = $conn->query($sql);
        $message = $conn->error;
        writeLineToLog("$time - Admin -Deleted request $request");
        break;

    case 'resource':
        $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
        $sql = "DELETE FROM resources WHERE resource_id={$resource}";
        $results = $conn->query($sql);
        $resourceDesc = getResourceDesc($resource);
        writeLineToLog("$time - Admin - Deleted resource $resourceDesc");
        break;
    }
}
$_SESSION['tab'] = $type;
redirect("./?action=redirect&type=$type&$page_string=$page", "Deletion successful");
?>
