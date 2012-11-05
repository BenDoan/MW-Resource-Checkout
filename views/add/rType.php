<form class="well" method="post" action="./?action=add">
    <input type="hidden" name="type" value="<?php print $_GET['type'] ?>" />
    Type Name<br />
    <input type="text" class="input-xlarge" name="rType"><br/>

    Type Blocktype<br />
    <select name="blocktype">
    	<option value="full">Full Blocks</option>
    	<option value="half">Half Blocks</option>
    </select><br />

    <button type="submit" class="btn btn-success">Save</button>
    <button type="reset" class="btn" onclick="history.go(-1);">Cancel</button>
</form>
