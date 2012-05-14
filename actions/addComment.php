<?php
$date = date('m/d/Y');
$time = date('m/d/Y G:h');
extract($_POST);
$user_id=$_SESSION['user']['user_id'];

if (isset($resource_id) && isset($comment_message)){
	$sql = $sql = "INSERT INTO comments (comment_resource_id, comment_user_id, comment_date, comment_message)
			VALUES ('$resource_id', '$user_id', CURDATE(), '$comment_message')";
	$conn= new mysqli('localhost', DB_USERNAME, DB_PASSWORD, DB_NAME);
	$result = $conn->query($sql);
	$conn->close();
    $username = $_SESSION['user']['user_username'];
    writeLineToLog("$time - $username - Added comment: $comment_message");
	redirect('./?p=resource&id='.$resource_id.'&date='.$date , 'Thank you for your comment!');
}else{
	redirect('./?p=404');
}
