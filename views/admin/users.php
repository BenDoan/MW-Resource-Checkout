<?php
$type = 'user';
if (isset($_GET['currentuserpage'])) {
    $page = $_GET['currentuserpage'];
}else{
    $page = 1;
}
$conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);

$sql = "SELECT COUNT(*) FROM users";
$results = $conn->query($sql);
$row = $results->fetch_assoc();
$num_rows = $row['COUNT(*)'] - 1; //'-1' to account for admin not being counted

$rows_per_page = 10;
$total_pages = ceil($num_rows / $rows_per_page); //ceil rounds up

if(isset($_GET['currentuserpage']) && is_numeric($_GET['currentuserpage'])){
    $currentuserpage = (int) $_GET['currentuserpage'];
}else{
    $currentuserpage = 1;
}

if($currentuserpage > $total_pages){
    $currentuserpage = $total_pages;
}

if($currentuserpage < 1){
    $currentuserpage = 1;
}

$offset = ($currentuserpage - 1) * $rows_per_page;

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
            <a href=\"./?p=confirm&user=$user_id&delete_db=1&type=user&page=$page\"class=\" btn btn-small btn-danger admindelete\">
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

if($currentuserpage > 1){
    print "<li><a href=\"./?action=redirect&currentuserpage=1&type=$type\">«</a></li>";
    $prev_page = $currentuserpage - 1;
    print "<li><a href=\"./?action=redirect&currentuserpage=$prev_page&type=$type\">‹</a></li>";
}else{
    print "<li class=\"disabled\"><a href=\"\">«</a></li>";
    print "<li class=\"disabled\"><a href=\"\">‹</a></li>";
}

$range = 3;

for($x = ($currentuserpage - $range); $x < (($currentuserpage + $range) + 1); $x++){
    if(($x > 0) && ($x <= $total_pages)){
        if($x == $currentuserpage){
            print "<li class=\"active\"><a>$x</a></li>";
        }else{
            print "<li><a href=\"./?action=redirect&currentuserpage=$x&type=$type\">$x</a></li>";
        }
    }
}

if($currentuserpage != $total_pages){
    $next_page = $currentuserpage + 1;
    print "<li><a href=\"./?action=redirect&currentuserpage=$next_page&type=$type\">›</a></li>";
    print "<li><a href=\"./?action=redirect&currentuserpage=$total_pages&type=$type\">»</a></li>";
}else{
    print "<li class=\"disabled\"><a href=\"\">›</a></li>";
    print "<li class=\"disabled\"><a href=\"\">»</a></li>";
}


print "</div><a class=\"btn add\" href=\"./?p=add&type=user\">Add user</a>";

$conn->close();
?>
