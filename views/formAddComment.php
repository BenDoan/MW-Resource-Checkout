<?php extract($_GET);?>

<div class="well">
<p>Please inform us of any issues, damages, etc. with this resource.</p>
<p>Include details such as identification numbers (e.g. specific laptop
	number).</p>
<form action="./?action=addComment" method="post">
	<fieldset>
		<div class="control-group">
            <p class="help-block">Enter your comments here</p>
			<textarea name="comment_message" cols="40" rows="5"></textarea>
			<br>
		</div>
		<input type="hidden" name="resource_id" value="<?php echo $id; ?>"/>
		<button class="btn btn-primary" type="submit">Add Comment</button>
	</fieldset>
</form>
</div>
