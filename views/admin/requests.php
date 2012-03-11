<?php
if (isset($_GET['currentrequestpage'])) {
    $page = $_GET['currentrequestpage'];
}else{
    $page = 1;
}
$type = 'request';
$today=date('Y-m-d');
$conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);

$sql = "SELECT COUNT(*) FROM schedule WHERE schedule_date >= '$today'" ;
$results = $conn->query($sql);
$row = $results->fetch_assoc();
$num_rows = $row['COUNT(*)'];

$rows_per_page = 10;
$total_pages = ceil($num_rows / $rows_per_page); //ceil rounds up

if(isset($_GET['currentrequestpage']) && is_numeric($_GET['currentrequestpage'])){
    $currentrequestpage = (int) $_GET['currentrequestpage'];
}else{
    $currentrequestpage = 1;
}

if($currentrequestpage > $total_pages){
    $currentrequestpage = $total_pages;
}

if($currentrequestpage < 1){
    $currentrequestpage = 1;
}

$offset = ($currentrequestpage - 1) * $rows_per_page;

$sql = "SELECT * FROM schedule WHERE schedule_date >= '$today' LIMIT $offset, $rows_per_page";
$results = $conn->query($sql);

print "<table class=\"admintable table table-striped table-condensed\">
    <thead>
    <tr>
    <th>Resource</th>
    <th>User</th>
    <th>Date</th>
    <th>Block</th>
    <th>Delete</th>
    </tr>
    </thead>
    <tbody>
    ";
while($row = $results->fetch_assoc()){
    extract($row);
    $schedule_resource = getResourceDesc($schedule_resource_id);
    $user_id = getUsername($schedule_user_id);

    if(time() <= strtotime($schedule_date)){
        print "
            <tr>
            <td>$schedule_resource</td>
            <td>$user_id</td>
            <td>$schedule_date</td>
            <td>$schedule_block</td>
            <td>
            <a href=\"./?p=confirm&user=$user_id&delete_db=1&type=request&request=$schedule_id&page=$page\"class=\" btn btn-small btn-danger admindelete\">
            <i class=\"icon-trash icon-white\"></i>
            delete
            </a>
            </tr>
            ";
    }
}
print "</tbody></table>
        <div class=\"pagination\">
    ";

if($currentrequestpage > 1){
    print "<li><a href=\"./?action=redirect&currentrequestpage=1&type=$type\">«</a></li>";
    $prev_page = $currentrequestpage - 1;
    print "<li><a href=\"./?action=redirect&currentrequestpage=$prev_page&type=$type\">‹</a></li>";
}else{
    print "<li class=\"disabled\"><a href=\"\">«</a></li>";
    print "<li class=\"disabled\"><a href=\"\">‹</a></li>";
}

$range = 3;

for($x = ($currentrequestpage - $range); $x < (($currentrequestpage + $range) + 1); $x++){
    if(($x > 0) && ($x <= $total_pages)){
        if($x == $currentrequestpage){
            print "<li class=\"active\"><a>$x</a></li>";
        }else{
            print "<li><a href=\"./?action=redirect&currentrequestpage=$x&type=$type\">$x</a></li>";
        }
    }
}

if($currentrequestpage != $total_pages){
    $next_page = $currentrequestpage + 1;
    print "<li><a href=\"./?action=redirect&currentrequestpage=$next_page&type=$type\">›</a></li>";
    print "<li><a href=\"./?action=redirect&currentrequestpage=$total_pages&type=$type\">»</a></li>";
}else{
    print "<li class=\"disabled\"><a href=\"\">›</a></li>";
    print "<li class=\"disabled\"><a href=\"\">»</a></li>";
}
print "</div><a class=\"btn add\" href=\"./?p=add&type=request\">Add request</a>";
$conn->close();

?>
