<?php
    $time = date('m/d/Y G:h');
	extract($_POST);

    $username = $_SESSION['user']['user_username'];
    writeLineToLog("$time - $username - Canceled request $schedule_id");

	// Delete scheduling event that matches the id from the form
	$result = sqlQuery("DELETE FROM schedule WHERE schedule_id='$schedule_id'");

	// Check if query succeeded
	if ($result == 0){ // Query returned no results
		redirect('./?p=404', "You have reached this page due to an error, or this request has already been removed. Please use the provided navigation.");
	}else{
		// Redirect back to current requests
		redirect('./?p=currentRequests', 'Request deleted successfully!');
	}
