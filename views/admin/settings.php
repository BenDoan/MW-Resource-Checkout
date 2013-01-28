<form class="well" method="post" action="./?action=updateAppSettings">
<h4>Checkout Controls</h4>
<?php
$STH = sqlSelect("SELECT * FROM settings");
while($row = $STH->fetch()) {
    print $row['setting_type'];
    print "<br />";
    print '<input type="text" class="span3" name="' . $row['setting_id'] . '" value="'. $row['setting_value'] . '"><br/>';
}
?>
<button type="submit" class="btn btn-success">Save</button>
</form>
