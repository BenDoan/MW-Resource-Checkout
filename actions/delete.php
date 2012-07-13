<?php
if (!isAdmin()) {
    redirect("./");
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
        sqlQuery("DELETE FROM users WHERE user_id=$user");

        ////delete requests that match deleted user
        sqlQuery("DELETE FROM schedule WHERE schedule_user_id={$user}");
        break;

    case 'request':
        sqlQuery("DELETE FROM schedule WHERE schedule_id=$request");
        writeLineToLog("$time - Admin - Deleted request $request");
        break;

    case 'resource':
        $resourceDesc = getResourceDesc($resource);
        writeLineToLog("$time - Admin - Deleted resource $resourceDesc");
        sqlQuery("DELETE FROM resources WHERE resource_id={$resource}");

        //delete requests that match deleted resource
        sqlQuery("DELETE FROM schedule WHERE schedule_resource_id={$resource}");
        break;

    case 'comment':
        sqlQuery("DELETE FROM comments WHERE comment_id={$comment_id}");
        writeLineToLog("$time - Admin - Deleted comment $comment_id");
        break;

    //TODO: this should be moved over to PDO
    case 'rType':
        $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
        $sql = "SELECT * FROM resources WHERE resource_type={$type_id}";
        $results = $conn->query($sql);

        while($row = $results->fetch_assoc()){
            $resourceDesc = getResourceDesc($row['resource_id']);
            writeLineToLog("$time - Admin - Deleted resource $resourceDesc");

            $sql = "DELETE FROM resources WHERE resource_id={$row['resource_id']}";
            $results = $conn->query($sql);

            //delete requests that match deleted resource
            $sql = "DELETE FROM schedule WHERE schedule_resource_id={$row['resource_id']}";
            $results = $conn->query($sql);
        }

        $results = $conn->query($sql);

        $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
        $sql = "DELETE FROM types WHERE type_id={$type_id}";
        $results = $conn->query($sql);

        $type_name = getTypeName($type_id);
        writeLineToLog("$time - Admin - Deleted type $type_name");
        break;
    }
    $conn->close();
}
$_SESSION['tab'] = $type;
redirect("./?action=redirect&type=$type&$page_string=$page", "Deletion successful");
?>
