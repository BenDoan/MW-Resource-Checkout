<?php
$type = 'user';
$conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);

$sql = "SELECT COUNT(*) FROM users";
$results = $conn->query($sql);
$row = $results->fetch_assoc();
$num_rows = $row['COUNT(*)'] - 1; //'-1' to account for admin not being counted

$rows_per_page = 10;
$total_pages = ceil($num_rows / $rows_per_page); //ceil rounds up

if(isset($_GET['currentuserepage']) && is_numeric($_GET['currentuserepage'])){
    $currentuserepage = (int) $_GET['currentuserepage'];
}else{
    $currentuserepage = 1;
}

if($currentuserepage > $total_pages){
    $currentuserepage = $total_pages;
}

if($currentuserepage < 1){
    $currentuserepage = 1;
}

$offset = ($currentuserepage - 1) * $rows_per_page;

$sql = "SELECT * FROM users WHERE user_username != \"admin\" LIMIT $offset, $rows_per_page";
$results = $conn->query($sql);

print "<table class=\"admintable table table-striped table-condensed\">
       <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Delete</th>
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
            <a href=\"./?p=confirm&user=$user_id&delete_db=1&type=user\"class=\" btn btn-small btn-danger admindelete\">
                <i class=\"icon-trash icon-white\"></i>
                delete
            </a>
            </td>
        </tr>
    ";
}
print "</tbody></table>
        <div class=\"pagination\">
    ";

if($currentuserepage > 1){
    print "<li><a href=\"./?action=redirect&currentuserepage=1&type=$type\">«</a></li>";
    $prev_page = $currentuserepage - 1;
    print "<li><a href=\"./?action=redirect&currentuserepage=$prev_page&type=$type\">‹</a></li>";
}else{
    print "<li class=\"disabled\"><a href=\"\">«</a></li>";
    print "<li class=\"disabled\"><a href=\"\">‹</a></li>";
}

$range = 3;

for($x = ($currentuserepage - $range); $x < (($currentuserepage + $range) + 1); $x++){
    if(($x > 0) && ($x <= $total_pages)){
        if($x == $currentuserepage){
            print "<li class=\"active\"><a>$x</a></li>";
        }else{
            print "<li><a href=\"./?action=redirect&currentuserepage=$x&type=$type\">$x</a></li>";
        }
    }
}

if($currentuserepage != $total_pages){
    $next_page = $currentuserepage + 1;
    print "<li><a href=\"./?action=redirect&currentuserepage=$next_page&type=$type\">›</a></li>";
    print "<li><a href=\"./?action=redirect&currentuserepage=$total_pages&type=$type\">»</a></li>";
}else{
    print "<li class=\"disabled\"><a href=\"\">›</a></li>";
    print "<li class=\"disabled\"><a href=\"\">»</a></li>";
}


print "</div><a class=\"btn add\" href=\"./?p=add&type=user\">Add user</a>";

$conn->close();
?>
