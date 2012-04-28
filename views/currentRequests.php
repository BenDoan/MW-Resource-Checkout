<?php
echo '<h1>Current Requests for '.$_SESSION['user']['user_firstname'].' '.$_SESSION['user']['user_lastname'].'</h1>';

$currentUser = $_SESSION['user']['user_id'];
$today=date('Y-m-d');

// Get all scheduling events for the user logged in
// Do not select dates that have already passed
$conn= new mysqli('localhost', DB_USERNAME, DB_PASSWORD, DB_NAME);
$sql="SELECT * FROM schedule
		LEFT JOIN resources ON schedule.schedule_resource_id=resources.resource_id
		LEFT JOIN users ON schedule.schedule_user_id=users.user_id
		WHERE schedule_user_id='$currentUser' AND schedule_date >= '$today'
		ORDER BY schedule_date";
$results = $conn->query($sql);
$conn->close();
	?>
	<table class="table table-striped table-condensed">
		<tr>
			<th>Date</th>
			<th>Block</th>
			<th>Resource</th>
			<th>Identification</th>
			<th>Options</th>
		</tr>
	<?php
	// Loop through all scheduling events
	while ($row = $results->fetch_assoc()){
		extract($row);

		// If the resource is available for half blocks
		if ($resource_blocktype=="Half"){
			// Determine if the scheduling event is for the first or second half
			$half = (fmod($schedule_block,10)==1) ? "(First Half)": "(Second Half)";
			$schedule_block=floor($schedule_block/10)." ".$half;
		}
		// Display the row
		echo '<tr>';
			echo '<td>'.date('m/d/Y', strtotime($schedule_date)).'</td>';
			echo '<td>'.$schedule_block.'</td>';
			echo '<td><a href="./?p=resource&id='.$resource_id.'&date='.$schedule_date.'">'.$resource_type.'</a></td>';
			echo '<td>'.$resource_identifier.'</td>';
			echo '<td><a href="./?p=confirm&confirmAction=cancel&cancel=&schedule_id='.$schedule_id.'">cancel</a></td>';
		echo '</tr>';
		// Switch the styling of the next row
	}
	?>
	</table>
