<?php
//TODO: get rid of old dates

$conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
$sql = "SELECT * FROM schedule";
$results = $conn->query($sql);


print "<table class=\"table table-striped table-condensed\">
       <thead>
            <tr>
                <th>Resource</th>
                <th>User</th>
                <th>Date</th>
                <th>Block</th>
            </tr>
        </thead>
        <tbody>
    ";
while($row = $results->fetch_assoc()){
    extract($row);
    $schedule_resource = getResourceDesc($schedule_resource_id);
    $user_id = getUsername($schedule_user_id);

    //if(time() <= strtotime($schedule_date)){
        print "
            <tr>
                <td>$schedule_resource</td>
                <td>$user_id</td>
                <td>$schedule_date</td>
                <td>$schedule_block</td>
                <td>
                <a href=\"./?action=delete&user=$user_id&type=request&request=$schedule_id\"class=\" btn btn-small btn-danger\">
                    <i class=\"icon-trash icon-white\"></i>
                    delete
                </a>
            </tr>
            ";
    //}
}
print "</tbody></table>";
print "<a class=\"btn add\" href=\"./?p=add&type=request\">Add request</a>";
$conn->close();

?>
