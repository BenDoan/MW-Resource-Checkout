<?php
extract($_GET);
$requestUser = sqlSelectOne("SELECT * FROM schedule WHERE schedule_id='$request'", 'schedule_user_id');
if ($requestUser == $_SESSION['user']['user_id']) {
    sqlQuery("DELETE FROM schedule WHERE schedule_id='$request'");
}
print $request;
alog("Canceled request $request");
