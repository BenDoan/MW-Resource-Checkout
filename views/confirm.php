<link rel="stylesheet" type="text/css"
	href="bootstrap/css/bootstrap.css" />
<link
	rel="stylesheet" type="text/css" href="resource.css" />



	<?php
	extract($_GET);
	$user_id=$_SESSION['user']['user_id'];
	
	//If the user is trying to cancel a request
	if (isset($cancel)){
		//And if all necessary information exists
		if(isset($schedule_id) && $schedule_id!="") {
			//Display a delete form
			?>
<div class="confirm">
	<h3>Confirm Delete</h3>
	<p>
		Are you sure you want to permanently delete <strong>this request</strong>?
	</p>
	<form action="./?action=cancel" method="post">
		<input type="hidden" name="schedule_id"
			value="<?php echo $schedule_id;?>" /> <input type="submit"
			value="Yes" /> <input type="button" onclick="history.go(-1);"
			value="No" />
	</form>
</div>



<?php
		} else {
			redirect('./?p=404', 'You have reached this page due to an error. Please use the provided navigation.');
		}

		//If the user is trying to cancel a request
	}elseif(isset($reserve)){
		//And if all necessary information exists
		if (isset($schedule_date) && $schedule_date!="" && isset($schedule_block) && 
				$schedule_block!="" && isset($schedule_resource_id) && $schedule_resource_id!=""
				 && isAllowed($schedule_resource_id, $schedule_block, $schedule_date, $user_id)){
			//Transform date and block information for display purposes
			$half = (fmod($schedule_block,10)==1) ? "first half": "second half";
			$block = ($schedule_block > 10) ? floor($schedule_block/10): $schedule_block;
			$date = date("m/d/Y", strtotime($schedule_date));
			//Display reserve form
			?>
<div class="confirm">
	<h3>Confirm Reserve</h3>
	<p>
		Are you sure you want to reserve this resource for the <strong><?php echo $half ?>
			of block <?php echo $block ?> on <?php echo $date;?> </strong>?
	</p>
	<form action="./?action=reserve" method="post">
		<input type="hidden" name="schedule_block"
			value="<?php echo $schedule_block;?>" /> <input type="hidden"
			name="schedule_resource_id"
			value="<?php echo $schedule_resource_id;?>" /> <input type="hidden"
			name="schedule_date" value="<?php echo $schedule_date;?>" /> <input
			type="submit" value="Yes" /> <input type="button"
			onclick="history.go(-1);" value="No" />
	</form>
</div>



<?php
		}
	}elseif(isset($delete_db) && isset($type) && (isset($user) || isset($request) || isset($resource))){
		$args = "";
		switch ($type) {
			case 'user':
				$args = "type=user&user=$user";
				break;

			case 'request':
				$args = "type=request&request=$request";
				break;

			case 'resource':
				$args = "type=resource&resource=$resource&user=$user";
				break;

			default:
				//$args = "./?p=adminPage";
				break;
		}
		?>
<div class="confirm">
	<h3>Confirm Delete</h3>
	<p>
		Are you sure you want to delete this <strong><?php print $type ?> </strong>
	</p>
	<a class="btn" href="./?action=delete&<?php print $args?>">Yes</a> <a
		class="btn" type="button" onclick="history.go(-1);" value="No">No</a>
</div>


		<?php

	} else {
		redirect('./?p=404', 'You have reached this page due to an error. Please use the provided navigation.');
	}


	function isAllowed($schedule_resource_id, $schedule_block, $schedule_date, $schedule_user_id){
		
		$sql = "SELECT * FROM settings";
		$conn= new mysqli('localhost', DB_USERNAME, DB_PASSWORD, DB_NAME);
		$results = $conn->query($sql);
		
		while(($row = $results->fetch_assoc()) != null){
			extract($row);
			if($setting_type == "Number of Days Per Week"){
				$dayLimit = $setting_value;
			}else if($setting_type == "Number of Days in a Row"){
				$daysInRow = $setting_value;
			}
		}
		$conn->close();
		if (!(numReservations($schedule_date, $schedule_resource_id, $schedule_user_id) < $dayLimit)){		
			redirect('./?p=calendar', 'You are not permitted to check out more than '.$dayLimit.' times per week.');
		}elseif(!(numDaysInRow($schedule_date, $schedule_resource_id, $schedule_user_id,$daysInRow) == 0)){
			redirect('./?p=calendar', 'You may not check out more than one resource within '.($daysInRow +1).' days.');
		}
		return true;
	}

	function numReservations($schedule_date, $schedule_resource_id, $schedule_user_id){
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
		
		
		$sql = "SELECT Count(*) FROM schedule WHERE schedule_date IN ($ids) AND schedule_user_id='$schedule_user_id'"; 
// 						AND schedule_resource_id='$schedule_resource_id'";
		
		$conn= new mysqli('localhost', DB_USERNAME, DB_PASSWORD, DB_NAME);
		$result=$conn->query($sql);

		$counter = 0;
		while(($row = $result->fetch_assoc()) != null){
			foreach ($row as $value) {
				$counter =$value;
			}
		}
		$conn->close();
		return $counter;
	}
	
	function numDaysInRow($schedule_date, $schedule_resource_id, $schedule_user_id,$daysInRow){
		$timestamp = strtotime($schedule_date);
		
		$newDate = date('Y-m-d', $timestamp);
		$dates[$j++]= "'".$newDate."'";
		
		$j =0;
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
		$conn= new mysqli('localhost', DB_USERNAME, DB_PASSWORD, DB_NAME);
		$result=$conn->query($sql);
		
		echo $sql;
		$counter = 0;
		while(($row = $result->fetch_assoc()) != null){
			echo "<pre>";
			print_r($row);
			echo "</pre>";
			foreach ($row as $value) {
				$counter =$value;
			}
		}
		$conn->close();
		echo $counter;
		return $counter;
	}