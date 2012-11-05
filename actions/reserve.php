<!-- ./?action=reserve&date=10/10/10&resource=1&block=1&new=1 -->
<?php
extract($_GET);
$resourceList = array();
$STH = sqlSelect("SELECT * FROM resources WHERE resource_type=$rType");
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
redirect('./', "You have successfully checkout out $resource_name for $date block $block");
