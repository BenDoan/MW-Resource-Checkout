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
    $department = $row['resource_department'];
}
?>
<form class="well" method="post" action="./?action=edit">
    <input type="hidden" name="resource" value="<?php print $_GET['resource']; ?>">
    <input type="hidden" name="type" value="resource">
    Type<br />
    <select name="resourcetype">
        <?php
            $typesArray = getRTypesArray();
            foreach ($typesArray as $x) {
                if ($type == $x['type_id']) {
                    print '<option selected="selected" value="' . $x['type_id'] . '">' . $x['type_name'] . '</option>';
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

    Department<br />
    <select name="department">
        <?php
            $departmentsArray = getDepartmentsArray();
            foreach ($departmentsArray as $department) {
                if ($department == $department['department_id']) {
                    print '<option selected="selected" value="' . $department['department_id'] . '">' . $department['department_name'] . '</option>';
                }else{
                    print '<option value="' .$department['department_id'] . '">' . $department['department_name'] . '</option>';
                }
            }
        ?>
    </select><br />

    <button type="submit" class="btn btn-success">Save</button>
    <button type="reset" class="btn" onclick="history.go(-1);">Cancel</button>
</form>
<div class="clear"></div>
