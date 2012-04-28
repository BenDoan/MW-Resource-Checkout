<?php
if ($_SESSION['user']['user_username'] != ADMIN_USERNAME) {
    redirect('./');
}
$time = date('m/d/Y G:h');
$page_string = 'current' . $_GET['type'] . 'page';
$page = $_GET['page'];


extract($_GET);
if (isset($type)) {
    $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
    switch ($type) {
    case 'user':
        //delete user
        $user_name = getUsername($user);
        writeLineToLog("$time - Admin - Deleted user $user_name");
        $sql = "DELETE FROM users WHERE user_id={$user}";
        $results = $conn->query($sql);

        //delete requests that match deleted user
        $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
        $sql = "DELETE FROM schedule WHERE schedule_user_id={$user}";
        $results = $conn->query($sql);
        break;

    case 'request':
        $sql = "DELETE FROM schedule WHERE schedule_id=$request";
        $results = $conn->query($sql);
        $message = $conn->error;
        writeLineToLog("$time - Admin -Deleted request $request");
        break;

    case 'resource':
        $sql = "DELETE FROM resources WHERE resource_id={$resource}";
        $results = $conn->query($sql);
        $resourceDesc = getResourceDesc($resource);
        writeLineToLog("$time - Admin - Deleted resource $resourceDesc");

        //delete requests that match deleted resource
        $sql = "DELETE FROM schedule WHERE schedule_resource_id={$resource}";
        $results = $conn->query($sql);
        break;
    }
    $conn->close();
}
$_SESSION['tab'] = $type;
redirect("./?action=redirect&type=$type&$page_string=$page", "Deletion successful");
?>
