<?php
$conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
$sql = "SELECT * FROM users WHERE user_username != 'admin'";
$results = $conn->query($sql);


print "<table class=\"full\">
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
            <td><a style=\"color:blue;font-size:12px;\" href=\"./?action=deleteUser.php?user=$user_id&type=user\">delete</a></td>
        </tr>
    ";
}
print "</tbody></table>";

$conn->close();
?>
