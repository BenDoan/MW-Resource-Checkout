<?php
$STH = sqlSelect("SELECT * FROM types WHERE type_id={$_GET['rType']}");
while($row = $STH->fetch()) {
    extract($row);

    $fullBlock = "";
    $halfBlock = "";
    if ($type_blocktype == "full") {
        $fullBlock = 'selected="selected"';
    }else{
        $halfBlock = 'selected="selected"';
    }
}
?>
<form class="well" method="post" action="./?action=edit">
    <input type="hidden" name="typeid" value="<?php print $type_id ?>">
    <input type="hidden" name="type" value="rType">
    Type Name<br />
    <input type="text" class="span3" name="name" value="<?php print $type_name; ?>"><br/>

    Type Blocktype<br />
    <select name="blocktype">
        <option <?php print $fullBlock; ?> value="Full">Full Block</option>
        <option <?php print $halfBlock; ?> value="Half">Half Block</option>
    </select><br />
    <button type="submit" class="btn btn-success">Save</button>
    <button type="reset" class="btn" onclick="history.go(-1);">Cancel</button>
</form>
<div class="clear"></div>
