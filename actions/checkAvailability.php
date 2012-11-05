<?php
//./?action=checkAvailability&date=2012-31-10&type=1
extract($_GET);
$resourceList = array();
$STH = sqlSelect("SELECT * FROM resources WHERE resource_type=$type");
while($row = $STH->fetch()) {
    $resourceList[] = $row['resource_id'];
}
//print "<br /><br />Resource List<br />";
//printArray($resourceList);

$resourceBlocks = array();
foreach ($resourceList as $x) {
    $resourceBlocks[$x] = array(true, true, true, true);
}
//print "<br /><br />Resource Blocks<br />";
//printArray($resourceBlocks);

$sqlResourceList = "(";
for ($i = 0; $i < sizeof($resourceList); $i++) {
    $sqlResourceList .= $resourceList[$i];
    if ($i != sizeof($resourceList) - 1) {
        $sqlResourceList .= ', ';
    }
}
$sqlResourceList .= ')';
//print "<br /><br />sql resource list<br />";
//printArray($sqlResourceList);
$STH = sqlSelect("SELECT * FROM schedule WHERE schedule_date='$date' AND schedule_resource_id in $sqlResourceList");
while($row = $STH->fetch()) {
    $resourceBlocks[$row['schedule_resource_id']][$row['schedule_block'] - 1] = false;
    //print $row['schedule_block'];
}
//print "<br /><br />resource blocks new<br />";
//printArray($resourceBlocks);

$returnArray = array();
for ($i = 0; $i < 4; $i++) {
    $countTaken = 0;
    foreach ($resourceBlocks as $resource) {
        if (!$resource[$i]) {
            $countTaken++;
        }
    }
    $returnArray[$i] = $countTaken != sizeof($resourceBlocks);
}

//printArray($returnArray);
print json_encode($returnArray);
