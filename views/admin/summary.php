<h1>Today</h1>
<table class="table table-condensed table-striped">
<tr>
    <th>Resource</th>
    <th>User</th>
    <th>Block</th>
</tr>
<?php
$today = date("Y-m-d");
$STH = sqlSelect("SELECT * FROM schedule WHERE schedule_date='$today'");
while($row = $STH->fetch()) {
    print "<tr>";
    print "<td>" . getResourceDesc($row['schedule_resource_id']) . "</td>";
    print "<td>" . getUsername($row['schedule_user_id']) . "</td>";
    print "<td>" . blockToHuman($row['schedule_block']) . "</td>";
    print "</tr>";
}
?>
</table>
