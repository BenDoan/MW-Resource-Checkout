<?php
extract($_GET);

if (isset($date)&& isset($id) && $date !="" && $id!=""){
	// Get the resource who's id matches the id in the url
	$sql="SELECT * FROM resources WHERE resource_id='$id'";
	$conn= new mysqli('localhost', DB_USERNAME, DB_PASSWORD, DB_NAME);
	$result=$conn->query($sql);
	$row=$result->fetch_assoc();
	extract($row);

	// Get all scheduling events for that resource on the selected date, ordered by the block
	$sql="SELECT * FROM schedule
	LEFT JOIN resources ON schedule.schedule_resource_id=resources.resource_id
	LEFT JOIN users ON schedule.schedule_user_id=users.user_id
	WHERE schedule_date='$date' AND resource_id='$id'
	ORDER BY schedule_block";

	// Transform the date for display purposes
	$displayDate = date("m/d/Y", strtotime($date));

	// If the date fails and goes to default
	if ($displayDate == '01/01/1970'){
		redirect('./?p=404');
	}
	// Display the resource's information and schedule
	?>
<h1>Resource Details</h1>
<table class="details">
	<tr>
		<th>Type</th>
		<td><?php echo $resource_type;?></td>
	</tr>
</table>
<table class="details">
	<tr>
		<th rowspan =2>Details</th>
		<td><?php echo $resource_identifier;?></td>
	</tr>
	<tr>
		<td><?php echo $resource_details;?></td>
	</tr>
</table>
<table class="details">
	<tr>
		<th>Availability</th>
		<td><?php echo $resource_blocktype;?> Blocks</td>
	</tr>
	<tr>
		<th></th>
		<td><a class="btn" href="./?p=formAddComment&id=<?php echo $id;?>">Add
		Comments</a></td>
	</tr>
</table>
<h1>Schedule for <?php echo $displayDate;?></h2>
<table class="full">
	<tr>
		<th>Block</th>
		<th>Availablity</th>

	</tr>
	<?php
	$class="";
	// Generate the rows for every block (i is the block number)
	for ($i=1;$i<5;$i++){
		$class=getRows($class, $resource_type, $resource_identifier, $resource_id, $date, $i, $resource_blocktype);
	}
	?>
</table>
	<?php
}else{
	redirect('./?p=404');
}
// Check for the availablity of a resource at a given time
// Returns the the availibility as a td
function getAvailability($id, $date, $block){

	$sql="SELECT * FROM schedule
	LEFT JOIN resources ON schedule.schedule_resource_id=resources.resource_id
	LEFT JOIN users ON schedule.schedule_user_id=users.user_id
	WHERE schedule_date='$date' AND schedule_block='$block' AND resource_id='$id'
	ORDER BY schedule_block";
	$conn= new mysqli('localhost', DB_USERNAME, DB_PASSWORD, DB_NAME);
	$result=$conn->query($sql);
	$row=$result->fetch_assoc();

	// If a scheduling event already exists, echo by the name of the user who reserved it
	if ($row != null){
		extract($row);
		return '<td>Reserved by '.$user_firstname.' '.$user_lastname.'</td>';
	}else{ // Otherwise, display a link to make a reservation
		return '<td><a href="./?p=confirm&confirmAction=reserve&schedule_resource_id='.$id.'&schedule_block='.$block.'&schedule_date='.$date.'">reserve</a></td>';
	}
}

// Display the row(s)
// Changes the type of styling for the next row and returns this value
function getRows($class, $resource_type, $resource_identifier, $resource_id, $date, $block, $resource_blocktype){
	// Display two rows per resource per block if the resource is only available for half blocks
	if ($resource_blocktype == "Half"){
		echo '<tr class="'.$class.'">';
		echo '<td>'.$block.' (First Half)</td>';
		echo getAvailability($resource_id, $date, ($block*10 + 1));
		echo '</tr>';
		// Change styling of row
		$class = ($class=="") ? "colored": "";
		echo '<tr class="'.$class.'">';
		echo '<td>'.$block.' (Second Half)</td>';
		echo getAvailability($resource_id, $date, ($block*10 + 2));
		echo '</tr>';
		return $class = ($class=="") ? "colored": "";
	}else{ // Otherwise, show only one row
		echo '<tr class="'.$class.'">';
		echo '<td>'.$block.'</td>';
		echo getAvailability($resource_id, $date, $block);
		echo '</tr>';
		return $class = ($class=="") ? "colored": "";
	}
}
$conn->close();
?>
