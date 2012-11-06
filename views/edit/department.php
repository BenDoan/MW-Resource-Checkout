<?php
$STH = sqlSelect("SELECT * FROM departments WHERE department_id={$_GET['department']}");
while($row = $STH->fetch()) {
    extract($row);
}
?>
<form class="well" method="post" action="./?action=edit">
    <input type="hidden" name="departmentid" value="<?php print $department_id ?>">
    <input type="hidden" name="type" value="department">
    Department Name<br />
    <input type="text" class="span3" name="name" value="<?php print $department_name ; ?>"><br/>
    <button type="submit" class="btn btn-success">Save</button>
    <button type="reset" class="btn" onclick="history.go(-1);">Cancel</button>
</form>
<div class="clear"></div>

