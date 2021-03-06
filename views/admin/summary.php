<link media="print" rel="stylesheet" type="text/css" href="print.css"/>
<form action="./?p=adminPage" class="form-inline summary-search-form">
<?php
if (isset($_GET['date'])) {
    print '<input style="margin-right:5px;" type="text" name="date" value="'.$_GET['date'].'" />';
    print '<input type="submit" class="btn btn-primary" />';
    print '</form>';
    print "<h1>Resources checked out for: {$_GET['date']}</h1>";
}else {
    $today = date("m/d/Y");
    print '<input style="margin-right:5px;" type="text" name="date" value="'.$today.'" />';
    print '<input type="submit" class="btn btn-primary" />';
    print '</form>';
    print "<h1>Resources checked out for: $today</h1>";
}
?>
<table class="table table-condensed table-striped responsive">
<tr>
    <th>Resource Type</th>
    <th>Resource</th>
    <th>Name</th>
    <th>Block</th>
</tr>
<?php
if (isset($_GET['date'])) {
    $today = date("Y-m-d", strtotime($_GET['date']));
}else{
    $today = date("Y-m-d");
}
$STH = sqlSelect("SELECT * FROM schedule WHERE schedule_date='$today' ORDER BY schedule_block ASC");
while($row = $STH->fetch()) {
    print "<tr>";
    print "<td>" . getResourceTypeName(getResourceTypeIdFromResource($row['schedule_resource_id'])) . "</td>";
    print "<td>" . getResourceDesc($row['schedule_resource_id']) . "</td>";
    print "<td>" . getFullName($row['schedule_user_id']) . "</td>";
    print "<td>" . blockToHuman($row['schedule_block']) . "</td>";
    print "</tr>";
}
?>
</table>
