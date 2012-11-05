<?php
function convertHalfBlocks($block){
    switch ($block) {
        case 11:
            return 1;
            break;
        case 12:
            return 2;
            break;
        case 21:
            return 3;
            break;
        case 22:
            return 4;
            break;
        case 31:
            return 5;
            break;
        case 32:
            return 6;
            break;
        case 41:
            return 7;
            break;
        case 42:
            return 8;
            break;

        default:
            break;
    }
}
//./?action=checkAvailability&date=2012-31-10&type=1
extract($_GET);
$resourceList = array();
$STH = sqlSelect("SELECT * FROM resources WHERE resource_type=$type");
$blocktype = sqlSelectOne("SELECT * FROM types WHERE type_id='$type'", 'type_blocktype');
while($row = $STH->fetch()) {
    $resourceList[] = $row['resource_id'];
}

if ($blocktype == 'full') {
    $resourceBlocks = array();
    foreach ($resourceList as $x) {
        $resourceBlocks[$x] = array(true, true, true, true);
    }

    $sqlResourceList = "(";
    for ($i = 0; $i < sizeof($resourceList); $i++) {
        $sqlResourceList .= $resourceList[$i];
        if ($i != sizeof($resourceList) - 1) {
            $sqlResourceList .= ', ';
        }
    }
    $sqlResourceList .= ')';
    $STH = sqlSelect("SELECT * FROM schedule WHERE schedule_date='$date' AND schedule_resource_id in $sqlResourceList");
    while($row = $STH->fetch()) {
        $resourceBlocks[$row['schedule_resource_id']][$row['schedule_block'] - 1] = false;
    }

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
}else {
    //half blocktype

    $resourceBlocks = array();
    foreach ($resourceList as $x) {
        $resourceBlocks[$x] = array(true, true, true, true, true, true, true, true);
    }

    $sqlResourceList = "(";
    for ($i = 0; $i < sizeof($resourceList); $i++) {
        $sqlResourceList .= $resourceList[$i];
        if ($i != sizeof($resourceList) - 1) {
            $sqlResourceList .= ', ';
        }
    }
    $sqlResourceList .= ')';
    $STH = sqlSelect("SELECT * FROM schedule WHERE schedule_date='$date' AND schedule_resource_id in $sqlResourceList");
    while($row = $STH->fetch()) {
        $block = convertHalfBlocks($row['schedule_block']);
        $resourceBlocks[$row['schedule_resource_id']][$block - 1] = false;
    }
    $returnArray = array();
    for ($i = 0; $i < 8; $i++) {
        $countTaken = 0;
        foreach ($resourceBlocks as $resource) {
            if (!$resource[$i]) {
                $countTaken++;
            }
        }
        $returnArray[$i] = $countTaken != sizeof($resourceBlocks);
    }
}

$returnArray = array($blocktype, $returnArray);
print json_encode($returnArray);
