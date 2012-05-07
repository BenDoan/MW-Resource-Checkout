<?php extract($_GET);?>

<p>Please inform us of any issues, damages, etc. with this resource.</p>
<p>Include details such as identification numbers (e.g. specific laptop
	number).</p>
<form action="./?action=addComment" method="post">
	<fieldset>
		<div class="control-group">
			<textarea name="comment_message" cols="40" rows="5">Enter your comments here...</textarea>
			<br>
		</div>
		<input type="hidden" name="resource_id" value="<?php echo $id; ?>"/>
		<button class="btn btn-primary" type="submit">Add Comment</button>
	</fieldset>
</form>
