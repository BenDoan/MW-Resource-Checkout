<?php
$time = getTimestamp();
extract($_POST);
$user_id=$_SESSION['user']['user_id'];
$conn= new mysqli('localhost', DB_USERNAME, DB_PASSWORD, DB_NAME);

// Get scheduling event that the user is attempting
$sql = "SELECT * FROM schedule WHERE schedule_date='$schedule_date' AND schedule_block='$schedule_block' AND
			schedule_resource_id='$schedule_resource_id'";
$result = $conn->query($sql);

// If an event already exists, display apology
if ($row = $result->fetch_assoc()){
	redirect('./?p=404', 'Unfortunately, this resource is no longer available. Please use the provided navigation.');
	// Else add the event under the user's id
}else{
	$sql = "INSERT INTO schedule (schedule_date, schedule_block, schedule_resource_id, schedule_user_id)
			VALUES ('$schedule_date', '$schedule_block', '$schedule_resource_id', '$user_id')";
    $username = $_SESSION['user']['user_username'];
    $rDesc = getResourceDesc($schedule_resource_id);
    writeLineToLog("$time - $username - Reserved $rDesc for block $schedule_block");
	$result = $conn->query($sql);

	// If failed...
	if ($result == null){
		// Display the error of the last executed query
		echo $conn->error.'<br/>'.$sql;
		// Otherwise, redirect to the resource's page
	}else{
        redirect("./?p=resource&id=$schedule_resource_id&date=$schedule_date", 'New request added successfully!');
	}
}
// Close Connection
$conn->close();
