<?php
extract($_GET);
$user_department = $_SESSION['user']['user_department'];
$rType = mysql_real_escape_string($rType);
$block = mysql_real_escape_string($block);
$date = mysql_real_escape_string($date);
$resourceId = mysql_real_escape_string($resource);
$cancelId = mysql_real_escape_string($cancelId);

//validate that the user owns the request they are changing
$requestUser = sqlSelectOne("SELECT * FROM schedule WHERE schedule_id='$cancelId'", 'schedule_user_id');
if ($requestUser != $_SESSION['user']['user_id']) {
    return;
}
sqlQuery("DELETE FROM schedule WHERE schedule_id='$cancelId'"); // cancels previous request

if (isAdmin()) {
    $STH = sqlSelect("SELECT * FROM resources WHERE resource_type='$rType'");
} else {
    $STH = sqlSelect("SELECT * FROM resources WHERE resource_type='$rType' AND (resource_department='$user_department' OR resource_department=0)");
}

$resourceList = array();
while($row = $STH->fetch()) {
    $resourceList[] = $row['resource_id'];
}

$sqlResourceList = "(";
for ($i = 0; $i < sizeof($resourceList); $i++) {
    $sqlResourceList .= $resourceList[$i];
    if ($i != sizeof($resourceList) - 1) {
        $sqlResourceList .= ', ';
    }
}
$sqlResourceList .= ')';

for ($i = 0; $i < sizeof($resourceList); $i++) {
    $STH = sqlSelect("SELECT * FROM schedule WHERE schedule_date='$date' AND schedule_resource_id in $sqlResourceList AND schedule_block='$block'");
    while($row = $STH->fetch()) {
        if ($resourceList[$i] == $row['schedule_resource_id']) {
            $resourceList[$i] = false;
        }
    }
}

$final_resources = array();
foreach ($resourceList as $resource) {
    if ($resource && $resource != $resourceId) {
        $final_resources[] = $resource;
    }
}

$resources_complete = array();
foreach ($final_resources as $resource) {
    $resources_complete[] = array(getResourceDesc($resource), $resource);
}

$resource_name = getResourceDesc($resourceId);

$user = $_SESSION['user']['user_id'];
$id = sqlQuery("INSERT INTO schedule SET schedule_resource_id='$resourceId', schedule_user_id='$user', schedule_date='$date', schedule_block='$block'");

$humanBlock = blockToHuman($block);

alog("Checked out $resource_name on $date $humanBlock");
print json_encode(array($id, "You have successfully checkout out <strong>{$resource_name}</strong> for <strong>{$date}</strong> <strong>{$humanBlock}</strong>", $resources_complete, $block, $cancelId));