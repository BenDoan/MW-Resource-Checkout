<?php
if (!isAdmin()) {
    redirect("./");
}
$time = getTimestamp();
$page_string = 'current' . $_GET['type'] . 'page';
$page = $_GET['page'];
$deleted = '';


extract($_GET);
if (isset($type)) {
    switch ($type) {
    case 'user':
        //delete user
        $user_name = getUsername($user);
        $deleted = $user_name;
        writeLineToLog("$time - Admin - Deleted user $user_name");
        sqlQuery("DELETE FROM users WHERE user_id=$user");

        ////delete requests that match deleted user
        sqlQuery("DELETE FROM schedule WHERE schedule_user_id={$user}");
        break;

    case 'request':
        sqlQuery("DELETE FROM schedule WHERE schedule_id=$request");
        writeLineToLog("$time - Admin - Deleted request $request");
        $deleted = $request;
        break;

    case 'resource':
        $resourceDesc = getResourceDesc($resource);
        writeLineToLog("$time - Admin - Deleted resource $resourceDesc");
        sqlQuery("DELETE FROM resources WHERE resource_id={$resource}");
        $deleted = $resourceDesc;

        //delete requests that match deleted resource
        sqlQuery("DELETE FROM schedule WHERE schedule_resource_id={$resource}");
        break;

    case 'comment':
        sqlQuery("DELETE FROM comments WHERE comment_id={$comment_id}");
        writeLineToLog("$time - Admin - Deleted comment $comment_id");
        $deleted = $comment_id;
        break;

    //TODO: this should be moved over to PDO
    case 'rType':
        $STH = sqlSelect("SELECT * FROM resources WHERE resource_type={$type_id}");

        while($row = $STH->fetch()) {
            $resourceDesc = getResourceDesc($row['resource_id']);
            writeLineToLog("$time - Admin - Deleted resource $resourceDesc");
            sqlQuery("DELETE FROM resources WHERE resource_id={$row['resource_id']}");

            sqlQuery("DELETE FROM schedule WHERE schedule_resource_id={$row['resource_id']}");
        }
        $type_name = getTypeName($type_id);
        sqlQuery("DELETE FROM types WHERE type_id={$type_id}");

        writeLineToLog("$time - Admin - Deleted type $type_name");
        $deleted = $type_name;
        break;
    }
}
$_SESSION['tab'] = $type;
$cap_type = ucfirst($type);
redirect("./?action=redirect&type=$type&$page_string=$page", "$cap_type: $deleted deleted successfully");
?>
