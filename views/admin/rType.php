<?php
if (isset($_GET['currenttypepage'])) {
    $page = $_GET['currenttypepage'];
}else{
    $page = 1;
}
$type = 'type';
$conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);

$sql = "SELECT COUNT(*) FROM types";
$results = $conn->query($sql);
$row = $results->fetch_assoc();
$num_rows = $row['COUNT(*)'];

$rows_per_page = 10;
$total_pages = ceil($num_rows / $rows_per_page); //ceil rounds up

if(isset($_GET['currenttypepage']) && is_numeric($_GET['currenttypepage'])){
    $currenttypepage = (int) $_GET['currenttypepage'];
}else{
    $currenttypepage = 1;
}

if($currenttypepage > $total_pages){
    $currenttypepage = $total_pages;
}

if($currenttypepage < 1){
    $currenttypepage = 1;
}

$offset = ($currenttypepage - 1) * $rows_per_page;

$sql = "SELECT * FROM types LIMIT $offset, $rows_per_page";
$results = $conn->query($sql);

print "<table class=\"admintable table table-striped table-condensed\">
       <thead>
            <tr>
                <th>Type</th>
                <th>Blocktype</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
    ";
while($row = $results->fetch_assoc()){
    extract($row);
    print "
        <tr>
            <td>$type_name</td>
            <td>$type_blocktype</td>
            <td>
            <a href=\"./?p=confirm&user=$user_id&confirmAction=delete&type=rType&rType=$type_id&page=$page\" class=\" btn btn-small btn-danger admindelete\">
                <i class=\"icon-trash icon-white\"></i>
                delete
            </a>
            <a href=\"./?p=edit&rType=$type_id&type=rType\" class=\" btn btn-small admindelete\">
                <i class=\"icon-pencil icon-black\"></i>
                edit
            </a>
        </tr>
    ";
}
print "</tbody></table>
        <div class=\"pagination\">
        <ul>
    ";

if($currenttypepage > 1){
    print "<li><a href=\"./?action=redirect&currenttypepage=1&type=$type\">&laquo;</a></li>";
    $prev_page = $currenttypepage - 1;
    print "<li><a href=\"./?action=redirect&currenttypepage=$prev_page&type=$type\">&lsaquo;</a></li>";
}else{
    print "<li class=\"disabled\"><a href=\"\">&laquo;</a></li>";
    print "<li class=\"disabled\"><a href=\"\">&lsaquo;</a></li>";
}

$range = 3;

for($x = ($currenttypepage - $range); $x < (($currenttypepage + $range) + 1); $x++){
    if(($x > 0) && ($x <= $total_pages)){
        if($x == $currenttypepage){
            print "<li class=\"active\"><a>$x</a></li>";
        }else{
            print "<li><a href=\"./?action=redirect&currenttypepage=$x&type=$type\">$x</a></li>";
        }
    }
}

if($currenttypepage != $total_pages){
    $next_page = $currenttypepage + 1;
    print "<li><a href=\"./?action=redirect&currenttypepage=$next_page&type=$type\">&rsaquo;</a></li>";
    print "<li><a href=\"./?action=redirect&currenttypepage=$total_pages&type=$type\">&raquo;</a></li>";
}else{
    print "<li class=\"disabled\"><a href=\"\">&rsaquo;</a></li>";
    print "<li class=\"disabled\"><a href=\"\">&raquo;</a></li>";
}
print "</ul></div><a class=\"btn add\" href=\"./?p=add&type=rType\">Add type</a>";

$conn->close();
?>

