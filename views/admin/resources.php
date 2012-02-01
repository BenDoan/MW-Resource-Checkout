<?php
$conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
$sql = "SELECT * FROM resources";
$results = $conn->query($sql);


print "<table class=\"full\">
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
            <td><a style=\"color:blue;font-size:12px;\" href=\"./?action=delete&resource=$resource_id&type=resource\">delete</a></td>
        </tr>
    ";
}
print "</tbody></table>";
print "<a class=\"add\" href=\"./?p=add&type=resource\">Add</a>";

$conn->close();
?>
