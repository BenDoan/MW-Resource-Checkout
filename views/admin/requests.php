<?php
//TODO: replace type/user with actual type/user name

$conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
$sql = "SELECT * FROM schedule";
$results = $conn->query($sql);


print "<table class=\"full\">
       <thead>
            <tr>
                <th>Type</th>
                <th>User</th>
                <th>Date</th>
                <th>Block</th>
            </tr>
        </thead>
        <tbody>
    ";
while($row = $results->fetch_assoc()){
    extract($row);
    print "
        <tr>
            <td>$schedule_resource_id</td>
            <td>$schedule_user_id</td>
            <td>$schedule_date</td>
            <td>$schedule_block</td>
        </tr>
    ";
}
print "</tbody></table>";
$conn->close();
?>
