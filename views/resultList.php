<?php
$_SESSION['GET']=$_GET;

// Put the search bar at the top of the content block
include 'views/formSearch.php';

extract($_GET);

// Make sure date exists in the url
if (isset($date)){
	
	$timestamp = strtotime($date);
	// Use current date if no date was specified
	$date = ($date != "") ? date("Y-m-d", $timestamp) : date('Y-m-d');
	// Transform date for display
	$displayDate = date("l F jS, Y", strtotime($date));
	
	// Make sure that the date is today's date or later
	if (!($date < date('Y-m-d'))){
		// Search for resources of specified type, or all if type was not specified
		$sql="SELECT * FROM resources";
		if(isset($type) && $type!=""){
			$sql= $sql." WHERE resource_type='$type'";
		}
		$conn= new mysqli('localhost', DB_USERNAME, DB_PASSWORD, DB_NAME);
		$results=$conn->query($sql);
	
		// Put the resources into an array
		while($row = $results->fetch_assoc()){
			$resources[]=$row;
		}
		
		// If the date is valid and resources exist
		if ($date != "0000-00-00" && isset($resources)){
			// Use all blocks if no block was specified
			$noBlock = (!isset($block_1) && !isset($block_2) && !isset($block_3) && !isset($block_4)) ? true: false;
			
			echo "<h1>Results for ".$displayDate."</h1>";
			
			echo '<table class="full">';
				echo '<tr class="head">';
					echo '<td><div>Resource Type</div></td>';
					echo '<td><div>Identification</div></td>';
					echo '<td><div>Time</div></td>';
					echo '<td><div>Availability</div></td>';
				echo '</tr>';
			for ($b=1;$b<5;$b++){
				if ($noBlock || ($b==1 && isset($block_1)) || ($b==2 && isset($block_2)) || ($b==3 && isset($block_3)) || ($b==4 && isset($block_4))){
					$i=0;
					// Display the block divider
					echo '<tr><td><h3>Block '.$b.'</h3></td></tr>';
					$class="";
					// Loop through resources, generating the rows
					while (isset($resources[$i])){
						extract($resources[$i++]);
						$class = getRows($class, $resource_type, $resource_identifier, $resource_id, $date, $b, $resource_blocktype);
					}
				}
			}
			echo '</table>';
		}else{
			redirect('./?p=formSearch', 'You have entered invalid search parameter(s). Please try again.');
		}
	}else{
		redirect('./?p=formSearch', 'You have selected an invalid date. Please select a valid date no earlier than '.date('Y-m-d').'.');
	}
}else{
	redirect('./?p=404', 'An error has occured. Please use the provided navigation.');
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
	}else{	// Otherwise, display a link to make a reservation
		return '<td><a href="./?p=confirm&reserve=&schedule_resource_id='.$id.'&schedule_block='.$block.'&schedule_date='.$date.'">reserve</a></td>';
	}		
}

// Display the row(s)
// Changes the type of styling for the next row and returns this value
function getRows($class, $resource_type, $resource_identifier, $resource_id, $date, $block, $resource_blocktype){	
	// Display two rows per resource per block if the resource is only available for half blocks
	if ($resource_blocktype == "Half"){
		echo '<tr class="'.$class.'">';
			echo '<td><a href="./?p=resource&id='.$resource_id.'&date='.$date.'">'.$resource_type.'</a></td>';
			echo '<td>'.$resource_identifier.'</td>';
			echo '<td>First Half</td>';
			echo getAvailability($resource_id, $date, ($block*10 + 1));
		echo '</tr>';
		// Change styling of row
		$class = ($class=="") ? "colored": "";
		echo '<tr class="'.$class.'">';
			echo '<td><a href="./?p=resource&id='.$resource_id.'&date='.$date.'">'.$resource_type.'</a></td>';
			echo '<td>'.$resource_identifier.'</td>';
			echo '<td>Second Half</td>';
			echo getAvailability($resource_id, $date, ($block*10 + 2));
		echo '</tr>';	
		return $class = ($class=="") ? "colored": "";
	}else{	// Otherwise, show only one row
		echo '<tr class="'.$class.'">';
			echo '<td><a href="./?p=resource&id='.$resource_id.'&date='.$date.'">'.$resource_type.'</a></td>';
			echo '<td>'.$resource_identifier.'</td>';
			echo '<td>Full Block</td>';
			echo getAvailability($resource_id, $date, $block);
		echo '</tr>';	
		return $class = ($class=="") ? "colored": "";
	}
}

?>

