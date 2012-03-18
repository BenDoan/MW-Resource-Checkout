<?php
$date=(isset($_SESSION['GET']['date'])) ? $_SESSION['GET']['date'] : "";
?>

<form action="./?p=resultList" method="get">
	<input name="p" type="hidden" value="resultList" />
	<table class="full" id="search">
		<tr>
			<th>Date</th>
			<td><input name="date" type="text" value="<?php echo $date;?>" /></td>
			<th>Resource</th>
			<td>
				<select name="type">
					<option value=""></option>
					<?php
					echo generateResource('Computer Lab');
					echo generateResource('Laptop Cart');
					echo generateResource('Candy');
					?>
				</select>
			</td>
			<th>Block</th>
			<td>
				<?php echo generateBlock('1');?> <?php echo generateBlock('2');?> <?php echo generateBlock('3');?> <?php echo generateBlock('4');?>
			</td>
			<th></th>
			<td class="float"><input type="submit" class="btn" value="Search" /></td>
		</tr>
	</table>
</form>

<?php
function generateResource($value){
	if (isset($_SESSION['GET']['type']) && $_SESSION['GET']['type'] == $value){
		return '<option selected="selected" value="'.$value.'">'.$value.'</option>';
	}else{
		return '<option value="'.$value.'">'.$value.'</option>';
	}
}

function generateBlock($number){
	if (isset($_SESSION['GET']['block_'.$number]) && $_SESSION['GET']['block_'.$number] == $number){
		return $number.'<input type="checkbox" checked="checked" name="block_'.$number.'" value="'.$number.'" />';
	}else{
		return $number.'<input type="checkbox" name="block_'.$number.'" value="'.$number.'" />';
	}
}

?>
