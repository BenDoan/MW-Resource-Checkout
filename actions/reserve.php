<?php
extract($_GET);
$user_department = $_SESSION['user']['user_department'];
$rType = mysql_real_escape_string($rType);
$block = mysql_real_escape_string($block);
$date = mysql_real_escape_string($date)

$resourceList = array();
if (isAdmin()) {
    $STH = sqlSelect("SELECT * FROM resources WHERE resource_type='$rType'");
} else {
    $STH = sqlSelect("SELECT * FROM resources WHERE resource_type='$rType' AND (resource_department='$user_department' OR resource_department=0)");
}
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

$final_resource = '';
foreach ($resourceList as $resource) {
    if ($resource != null) {
        $final_resource = $resource;
    }
}
$resource_name = getResourceDesc($final_resource);
$user = $_SESSION['user']['user_id'];
sqlQuery("INSERT INTO schedule SET schedule_resource_id='$final_resource', schedule_user_id='$user', schedule_date='$date', schedule_block='$block'");

$humanBlock = blockToHuman($block);
$request_id = sqlSelectOne("SELECT * FROM schedule WHERE schedule_resource_id='$final_resource' AND schedule_user_id='$user' AND schedule_date='$date' AND schedule_block='$block'", 'schedule_id');

alog("Checked out $resource_name on $date $humanBlock");
print json_encode(array($request_id, "You have successfully checkout out $resource_name for $date $humanBlock"));
