<form class="well" method="post" action="./?action=updateAppSettings">
<h4>Checkout Controls</h4>
<?php
$conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
$sql = "SELECT * FROM settings";
$results = $conn->query($sql);
while($row = $results->fetch_assoc()){
    print $row['setting_type'];
    print "<br />";
    print '<input type="text" class="span3" name="' . $row['setting_id'] .
        '" value="'. $row['setting_value'] . '"><br/>';
}
?>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
