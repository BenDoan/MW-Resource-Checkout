<?php
$conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
$sql = "SELECT * FROM users WHERE user_username != 'admin'";
$results = $conn->query($sql);


print "<table class=\"table table-striped table-condensed\">
       <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
    ";
while($row = $results->fetch_assoc()){
    extract($row);
    print "
        <tr>
            <td>$user_firstname</td>
            <td>$user_lastname</td>
            <td>$user_username</td>
            <td>
            <a href=\"./?action=delete&user=$user_id&type=user\"class=\" btn btn-small btn-danger\">
                <i class=\"icon-trash icon-white\"></i>
                delete
            </a>
            </td>
        </tr>
    ";
}
print "</tbody></table>";
print "<a class=\"btn add\" href=\"./?p=add&type=user\">Add</a>";

$conn->close();
?>
