<?php
$conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
$sql = "SELECT * FROM resources";
$results = $conn->query($sql);


print "<table class=\"table table-striped table-condensed\">
       <thead>
            <tr>
                <th>Type</th>
                <th>Details</th>
                <th>Identifier</th>
                <th>Block Type</th>
            </tr>
        </thead>
        <tbody>
    ";
while($row = $results->fetch_assoc()){
    extract($row);
    print "
        <tr>
            <td>$resource_type</td>
            <td>$resource_details</td>
            <td>$resource_identifier</td>
            <td>$resource_blocktype</td>
            <td>
            <a href=\"./?action=delete&user=$user_id&type=resource\"class=\" btn btn-small btn-danger\">
                <i class=\"icon-trash icon-white\"></i>
                delete
            </a>
        </tr>
    ";
}
print "</tbody></table>";
print "<a class=\"btn add\" href=\"./?p=add&type=resources\">Add</a>";

$conn->close();
?>
