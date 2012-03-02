<?php
$conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);

$sql = "SELECT COUNT(*) FROM users";
$results = $conn->query($sql);
$row = $results->fetch_assoc();
$num_rows = $row['COUNT(*)'] - 1; //'-1' to account for admin not being counted

$rows_per_page = 10;
$total_pages = ceil($num_rows / $rows_per_page); //ceil rounds up

if(isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])){
    $currentpage = (int) $_GET['currentpage'];
}else{
    $currentpage = 1;
}

if($currentpage > $total_pages){
    $currentpage = $total_pages;
}

if($currentpage < 1){
    $currentpage = 1;
}

$offset = ($currentpage - 1) * $rows_per_page;

$sql = "SELECT * FROM users WHERE user_username != \"admin\" LIMIT $offset, $rows_per_page";
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
            <a href=\"./?p=confirm&user=$user_id&delete_db=1&type=user\"class=\" btn btn-small btn-danger\">
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

if($currentpage > 1){
    print "<li><a href=\"./?currentpage=1\">«</a></li>";
    $prev_page = $currentpage - 1;
    print "<li><a href=\"./?currentpage=$prev_page\">‹</a></li>";
}else{
    print "<li class=\"disabled\"><a href=\"\">«</a></li>";
    print "<li class=\"disabled\"><a href=\"\">‹</a></li>";
}

$range = 3;

for($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++){
    if(($x > 0) && ($x <= $total_pages)){
        if($x == $currentpage){
            print "<li class=\"active\"><a>$x</a></li>";
        }else{
            print "<li><a href=\"./?currentpage=$x\">$x</a></li>";
        }
    }
}

if($currentpage != $total_pages){
    $next_page = $currentpage + 1;
    print "<li><a href=\"./?currentpage=$next_page\">›</a></li>";
    print "<li><a href=\"./?currentpage=$total_pages\">»</a></li>";
}else{
    print "<li class=\"disabled\"><a href=\"\">›</a></li>";
    print "<li class=\"disabled\"><a href=\"\">»</a></li>";
}


print "</div><a class=\"btn add\" href=\"./?p=add&type=user\">Add user</a>";

$conn->close();
?>
