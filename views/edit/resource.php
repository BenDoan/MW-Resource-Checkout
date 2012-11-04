<?php
$STH = sqlSelect("SELECT * FROM resources WHERE resource_id={$_GET['resource']}");
$type = "";
$details = "";
$identifier = "";
$blocktype = "";
while($row = $STH->fetch()) {
    $type = $row['resource_type'];
    $details = $row['resource_details'];
    $identifier = $row['resource_identifier'];
    $blocktype = $row['resource_blocktype'];

    $fullBlock = "";
    $halfBlock = "";
    if ($blocktype == "Full") {
        $fullBlock = 'selected="selected"';
    }else{
        $halfBlock = 'selected="selected"';
    }

}
?>
<form class="well" method="post" action="./?action=edit">
    <input type="hidden" name="resource" value="<?php print $_GET['resource']; ?>">
    <input type="hidden" name="type" value="resource">
    Type<br />
    <select name="resourcetype">
        <?php
            $typesArray = getRTypesArray();
            print $type;
            foreach ($typesArray as $x) {
                if ($type == $x['type_id']) {
                    print '<option selected="selected" value="' .$x['type_id'] . '">' . $x['type_name'] . '</option>';
                }else{
                    print '<option value="' .$x['type_id'] . '">' . $x['type_name'] . '</option>';
                }
            }
        ?>
    </select><br />

    Details<br />
    <input type="text" class="span3" name="details" value="<?php print $details ?>"><br/>

    Identifier<br />
    <input type="text" class="span3" name="identifier" value="<?php print $identifier ?>"><br/>

    Block Type<br />


    <select name="blocktype">
        <option <?php print $fullBlock; ?> value="Full">Full Block</option>
    	<option <?php print $halfBlock; ?> value="Half">Half Block</option>
    </select><br />

    <button type="submit" class="btn btn-success">Save</button>
    <button type="reset" class="btn" onclick="history.go(-1);">Cancel</button>
</form>
<div class="clear"></div>
