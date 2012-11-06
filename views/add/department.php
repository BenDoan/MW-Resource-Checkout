<form class="well" method="post" action="./?action=add">
    <input type="hidden" name="type" value="<?php print $_GET['type'] ?>" />
    Department Name<br />
    <input type="text" class="input-xlarge" name="department"><br/>

    <button type="submit" class="btn btn-success">Save</button>
    <button type="reset" class="btn" onclick="history.go(-1);">Cancel</button>
</form>

