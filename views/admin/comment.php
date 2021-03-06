<?php
if (isset($_GET['currentcommentpage'])) {
    $page = $_GET['currentcommentpage'];
}else{
    $page = 1;
}
$type = 'comment';
$conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);

$sql = "SELECT COUNT(*) FROM comments";
$results = $conn->query($sql);
$row = $results->fetch_assoc();
$num_rows = $row['COUNT(*)'];

$rows_per_page = 10;
$total_pages = ceil($num_rows / $rows_per_page); //ceil rounds up

if(isset($_GET['currentcommentpage']) && is_numeric($_GET['currentcommentpage'])){
    $currentcommentpage = (int) $_GET['currentcommentpage'];
}else{
    $currentcommentpage = 1;
}

if($currentcommentpage > $total_pages){
    $currentcommentpage = $total_pages;
}

if($currentcommentpage < 1){
    $currentcommentpage = 1;
}

$offset = ($currentcommentpage - 1) * $rows_per_page;

$sql = "SELECT * FROM comments ORDER BY comment_id DESC LIMIT $offset, $rows_per_page";
$results = $conn->query($sql);

print "<table class=\"admintable table table-striped table-condensed responsive\">
       <thead>
            <tr>
                <th>Resource</th>
                <th>User</th>
                <th>Date</th>
                <th>Comment</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
    ";
while($row = $results->fetch_assoc()){
    extract($row);
    $user = getUsername($comment_user_id);
    print "
        <tr>
            <td>" . getResourceDesc($comment_resource_id) . "</td>
            <td>$user</td>
            <td>$comment_date</td>
            <td>$comment_message</td>
            <td>
            <a href=\"./?p=confirm&user=$user_id&confirmAction=delete&type=comment&comment=$comment_id&page=$page\" class=\" btn btn-small btn-danger admindelete\">
                <i class=\"icon-trash icon-white\"></i>
                delete
            </a>
        </tr>
    ";
}
print "</tbody></table>
        <div class=\"pagination\">
        <ul>
    ";

if($currentcommentpage > 1){
    print "<li><a href=\"./?action=redirect&currentcommentpage=1&type=$type\">&laquo;</a></li>";
    $prev_page = $currentcommentpage - 1;
    print "<li><a href=\"./?action=redirect&currentcommentpage=$prev_page&type=$type\">&lsaquo;</a></li>";
}else{
    print "<li class=\"disabled\"><a href=\"\">&laquo;</a></li>";
    print "<li class=\"disabled\"><a href=\"\">&lsaquo;</a></li>";
}

$range = 3;

for($x = ($currentcommentpage - $range); $x < (($currentcommentpage + $range) + 1); $x++){
    if(($x > 0) && ($x <= $total_pages)){
        if($x == $currentcommentpage){
            print "<li class=\"active\"><a>$x</a></li>";
        }else{
            print "<li><a href=\"./?action=redirect&currentcommentpage=$x&type=$type\">$x</a></li>";
        }
    }
}

if($currentcommentpage != $total_pages){
    $next_page = $currentcommentpage + 1;
    print "<li><a href=\"./?action=redirect&currentcommentpage=$next_page&type=$type\">&rsaquo;</a></li>";
    print "<li><a href=\"./?action=redirect&currentcommentpage=$total_pages&type=$type\">&raquo;</a></li>";
}else{
    print "<li class=\"disabled\"><a href=\"\">&rsaquo;</a></li>";
    print "<li class=\"disabled\"><a href=\"\">&raquo;</a></li>";
}
print "</ul></div>";

$conn->close();
?>

