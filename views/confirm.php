<?php
extract($_GET);
// If the user is trying to cancel a request
if (isset($cancel)){
	// And if all necessary information exists
	if(isset($schedule_id) && $schedule_id!="") {
		// Display a delete form
	?>
		<div class="confirm">
			<h3>Confirm Delete</h3>
			<p>Are you sure you want to permanently delete <strong>this request</strong>?</p>
			<form action="./?action=cancel" method="post">
				<input type="hidden" name="schedule_id" value="<?php echo $schedule_id;?>" />
				<input type="button" onclick="history.go(-1);" value="No" /> <input type="submit" value="Yes" />
			</form>
		</div>
	<?php
	} else {
		redirect('./?p=404', 'You have reached this page due to an error. Please use the provided navigation.');
	}

// If the user is trying to cancel a request
}elseif(isset($reserve)){
	// And if all necessary information exists
	if (isset($schedule_date) && $schedule_date!="" && isset($schedule_block) && $schedule_block!="" && isset($schedule_resource_id) && $schedule_resource_id!=""){
		// Transform date and block information for display purposes
		$half = (fmod($schedule_block,10)==1) ? "first half": "second half";
		$block = ($schedule_block > 10) ? floor($schedule_block/10): $schedule_block;
		$date = date("m/d/Y", strtotime($schedule_date));
		// Display reserve form
		?>
			<div class="confirm">
				<h3>Confirm Reserve</h3>
				<p>Are you sure you want to reserve this resource for the <strong><?php echo $half ?> of block <?php echo $block ?> on <?php echo $date;?></strong>?</p>
				<form action="./?action=reserve" method="post">
					<input type="hidden" name="schedule_block" value="<?php echo $schedule_block;?>"/>
					<input type="hidden" name="schedule_resource_id" value="<?php echo $schedule_resource_id;?>" />
					<input type="hidden" name="schedule_date" value="<?php echo $schedule_date;?>" />
					<input type="button" onclick="history.go(-1);" value="No" /> <input type="submit" value="Yes" />
				</form>
			</div>
		<?php
	} else {
		redirect('./?p=404', 'You have reached this page due to an error. Please use the provided navigation.');
	}
	
}else{
	redirect('./?p=404', 'You have reached this page due to an error. Please use the provided navigation.');
}


?>