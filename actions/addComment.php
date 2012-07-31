<?php
$date = date('m/d/Y');
$time = getTimestamp();
extract($_POST);
$user_id=$_SESSION['user']['user_id'];

if (isset($resource_id) && isset($comment_message)){
    sqlQuery("INSERT INTO comments (comment_resource_id, comment_user_id, comment_date, comment_message)
			VALUES ('$resource_id', '$user_id', CURDATE(), '$comment_message')");
    $username = $_SESSION['user']['user_username'];
    writeLineToLog("$time - $username - Added comment: $comment_message");
	redirect('./?p=resource&id='.$resource_id.'&date='.$date , 'Thank you for your comment!');
}else{
	redirect('./?p=404');
}
