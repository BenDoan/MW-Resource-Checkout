<?php
$conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);

$sql = "SELECT COUNT(*) FROM resources";
$results = $conn->query($sql);
$row = $results->fetch_assoc();
$num_rows = $row['COUNT(*)'];

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

$sql = "SELECT * FROM resources LIMIT $offset, $rows_per_page";
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
            <a href=\"./?p=confirm&user=$user_id&delete_db=1&type=resource&resource=$resource_id\" class=\" btn btn-small btn-danger\">
                <i class=\"icon-trash icon-white\"></i>
                delete
            </a>
        </tr>
    ";
}
print "</tbody></table>
        <div class=\"pagination\">
    ";

if($currentpage > 1){
    print "<li><a href=\"./?action=redirect&currentpage=1&type=$type\">«</a></li>";
    $prev_page = $currentpage - 1;
    print "<li><a href=\"./?action=redirect&currentpage=$prev_page&type=$type\">‹</a></li>";
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
            print "<li><a href=\"./?action=redirect&currentpage=$x&type=$type\">$x</a></li>";
        }
    }
}

if($currentpage != $total_pages){
    $next_page = $currentpage + 1;
    print "<li><a href=\"./?action=redirect&currentpage=$next_page&type=$type\">›</a></li>";
    print "<li><a href=\"./?action=redirect&currentpage=$total_pages&type=$type\">»</a></li>";
}else{
    print "<li class=\"disabled\"><a href=\"\">›</a></li>";
    print "<li class=\"disabled\"><a href=\"\">»</a></li>";
}
print "</div><a class=\"btn add\" href=\"./?p=add&type=resource\">Add resource</a>";

$conn->close();
?>
