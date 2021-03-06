<?php
extract($_GET);
$conn = new mysqli('localhost', DB_USERNAME, DB_PASSWORD, DB_NAME);


switch ($confirmAction) {
    case 'cancel':
        if(isset($schedule_id) && $schedule_id!="") {
            print getCancelForm($schedule_id);
        }else{
            redirect('./?p=404');
        }
        break;

    case 'reserve':
        if (isReadOnly()) {
            redirect('./', 'You are not allowed to checkout resources', 'alert-error');
        }
        $user_id=$_SESSION['user']['user_id'];
        if (isset($schedule_date) &&
            $schedule_date!="" &&
            isset($schedule_block) &&
            $schedule_block!="" &&
            isset($schedule_resource_id) &&
            $schedule_resource_id!="" &&
            isAllowed($schedule_resource_id, $schedule_block, $schedule_date, $user_id)){
                $half = Array();
                $half[0] = 'full';
                $schedule_block .= '';
                if ($schedule_block.'length' == 2) {
                    $half[0] = 'half';
                    if ($schedule_block[0] == '1') {
                        $half[1] = 'first half';
                    }else{
                        $half[1] = 'second half';
                    }
                }
                $block = ($schedule_block > 10) ? floor($schedule_block/10): $schedule_block;
                $date = date("m/d/Y", strtotime($schedule_date));
                print getReserveForm($half, $block, $date, $schedule_block,$schedule_resource_id, $schedule_date);
        }// the isAllowed function redirects if it fails
        break;

    case 'delete':
        if (isset($type) &&
            isset($page) &&
                (isset($user) ||
                isset($request) ||
                isset($resource) ||
                isset($comment) ||
                isset($department) ||
            isset($rType) )) {
            $args = "";
            $page = $_GET['page'];
            switch ($type) {
                case 'user':
                    $args = "type=user&user=$user&page=$page";
                    break;

                case 'request':
                    $args = "type=request&request=$request&page=$page";
                    break;

                case 'resource':
                    $args = "type=resource&resource=$resource&user=$user&page=$page";
                    break;

                case 'comment':
                    $args = "type=comment&comment_id=$comment&page=$page";
                    break;

                case 'rType':
                    $args = "type=rType&type_id=$rType&page=$page";
                    break;

                case 'department':
                    $args = "type=department&department=$department&page=$page";
                    break;
            }
            print getDeleteForm($args, $type);
        }
        break;

    default:
        redirect('./?p=404');
        break;
}

function getCancelForm($schedule_id){
    $cancelForm = '
    <div class="confirm">
        <h3>Confirm Delete</h3>
        <p>Are you sure you want to permanently delete this request?</p>
        <form action="./?action=cancel" method="post">
            <input type="hidden" name="schedule_id" value="' . $schedule_id . '"/>
            <input class="btn" type="submit" value="Yes"/>
            <input class="btn" type="button" onclick="history.go(-1);" value="No" />
        </form>
    </div>
    ';
    return $cancelForm;
}

function getReserveForm($half, $block, $date, $schedule_block,$schedule_resource_id, $schedule_date){
    $reserveForm = '
    <div class="confirm">
        <h3>Confirm Reserve</h3>
        <p>';

    if ($half[0] == 'half') {
        $reserveForm .=
            'Are you sure you want to reserve this resource for the <strong>' . $half[1] .
                ' of block ' . $block . ' on ' . $date . '</strong>?';
    }else {
        $reserveForm .=
            'Are you sure you want to reserve this resource for <strong>block '
                . $block . ' on ' . $date . '</strong>?';
    }
        $reserveForm .= '</p>
        <form action="./?action=reserve" method="post">
            <input type="hidden" name="schedule_block" value="' . $schedule_block . '" />
            <input type="hidden" name="schedule_resource_id" value="' . $schedule_resource_id . '" />
            <input type="hidden" name="schedule_date" value="' . $schedule_date . '" />

            <input class="btn" type="submit" value="Yes" />
            <input class="btn" type="button" onclick="history.go(-1);" value="No" />
        </form>
    </div>
    ';
    return $reserveForm;
}

function getDeleteForm($args, $type){
    $deleteForm = '
    <div class="confirm">
        <h3>Confirm Delete</h3>
        <p>Are you sure you want to delete this ' . $type . '</p>
        <a class="btn" href="./?action=delete&' . $args . '">Yes</a>
        <a class="btn" type="button" class="btn" onclick="history.go(-1);" value="No" >No</a>
    </div>
    ';
    return $deleteForm;
}

//checks to see if the user is allowed to make a reservation
//uses the settings in the settings database table
function isAllowed($schedule_resource_id, $schedule_block, $schedule_date, $schedule_user_id){
    if (isAdmin()) {
        return true;
    }
    $STH = sqlSelect("SELECT * FROM settings");
    while($row = $STH->fetch()) {
        extract($row);
        if($setting_type == "Number of Days Per Week"){
            $dayLimit = $setting_value;
        }else if($setting_type == "Number of Days in a Row"){
            $daysInRow = $setting_value;
        }
    }
    if (numReservations($schedule_date, $schedule_resource_id, $schedule_user_id) > $dayLimit){
        redirect('./?p=calendar', "You are not allowed to check out for more than $dayLimit consecutive days.");
    }elseif(!withinConsecDays($schedule_date, $schedule_resource_id, $schedule_user_id, $dayLimit)){
        redirect('./?p=calendar', 'You may not check out more than one resource within '.($daysInRow +1).' days.');
    }
    return true;
}

function numReservations($schedule_date, $schedule_resource_id, $schedule_user_id){
    $conn = new mysqli('localhost', DB_USERNAME, DB_PASSWORD, DB_NAME);
    $timestamp = strtotime($schedule_date);
    $dayOfWeek = intval(date("N", $timestamp));
    $subDate=1-$dayOfWeek;
    $subDate*=-1;
    $beginningDate= "".date('Y-m-d', strtotime("-".$subDate." day", $timestamp));

    for($i=1; $i<6; $i++){
        if($i != $dayOfWeek){
            $dates[$i]= "'".$beginningDate."'";
        }
        $timestamp = strtotime($beginningDate);
        $beginningDate ="".date('Y-m-d', strtotime("+1 day", $timestamp));
    }

    $ids = join(',',$dates);

    $STH = sqlSelect("SELECT Count(*) FROM schedule WHERE schedule_date IN ($ids) AND schedule_user_id='$schedule_user_id'");
    $counter = 0;
    while($row = $STH->fetch()) {
        foreach ($row as $value) {
            $counter =$value;
        }
    }
    return $counter;
}

//returns true if the resource can be checked out
//within the consecutive bounds
//of the day limit
function withinConsecDays($schedule_date, $schedule_resource_id, $schedule_user_id, $dayLimit){
    $conn = new mysqli('localhost', DB_USERNAME, DB_PASSWORD, DB_NAME);
    // original events time
    $timestamp = strtotime($schedule_date);
    $dateToCheck = date('Y-m-d', $timestamp);

    $timestamp = strtotime($dateToCheck);
    $dateToCheck = date('Y-m-d', strtotime("+1 day", $timestamp));
    $counter = 1;

    $count = 1;
    while($count != 0){
        $sql = "SELECT COUNT(*) as 'num' FROM schedule WHERE schedule_user_id='$schedule_user_id' AND schedule_date='$dateToCheck'";
        $count = sqlSelectOne("SELECT COUNT(*) as 'num' FROM schedule WHERE schedule_user_id='$schedule_user_id' AND schedule_date='$dateToCheck'", 'num');
        $counter += $count;

        $timestamp = strtotime($dateToCheck);
        $dateToCheck = date('Y-m-d', strtotime("+1 day", $timestamp));
    }

    $timestamp = strtotime($schedule_date);
    $dateToCheck = date('Y-m-d', strtotime("-1 day", $timestamp));

    $count = 1;
    while($count != 0){
        $sql = "SELECT COUNT(*) as 'num' FROM schedule WHERE schedule_user_id='$schedule_user_id' AND schedule_date='$dateToCheck'";
        $results = $conn->query($sql);
        $row = $results->fetch_assoc();
        $count = $row['num'];
        $counter += $count;

        $timestamp = strtotime($dateToCheck);
        $dateToCheck = date('Y-m-d', strtotime("-1 day", $timestamp));
    }

    if ($counter > $dayLimit) {
        return false;
    }
    return true;
}

function numDaysInRow($schedule_date, $schedule_resource_id, $schedule_user_id,$daysInRow){
    $conn = new mysqli('localhost', DB_USERNAME, DB_PASSWORD, DB_NAME);
    $j =0;
    $timestamp = strtotime($schedule_date);

    $newDate = date('Y-m-d', $timestamp);
    $dates[$j++]= "'".$newDate."'";

    for ($i = 1; $i <= $daysInRow; $i++) {
        $newDate = date('Y-m-d', strtotime("+1 day", $timestamp));
        $timestamp = strtotime($newDate);
        $dates[$j++]= "'".$newDate."'";
    }
    $timestamp = strtotime($schedule_date);
    for ($i = 1; $i <= $daysInRow; $i++) {
        $newDate = date('Y-m-d', strtotime("-1 day", $timestamp));
        $timestamp = strtotime($newDate);
        $dates[$j++]= "'".$newDate."'";
    }

    $ids = join(',',$dates);

    $sql = "SELECT Count(*) FROM schedule WHERE schedule_date IN ($ids) AND schedule_user_id='$schedule_user_id'";
    $result=$conn->query($sql);

    $counter = 0;
    while(($row = $result->fetch_assoc()) != null){
        foreach ($row as $value) {
            $counter =$value;
        }
    }
    return $counter;
}
$conn->close();
