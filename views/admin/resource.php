<?php
if (isset($_GET['currentresourcepage'])) {
    $page = $_GET['currentresourcepage'];
}else{
    $page = 1;
}
$type = 'resource';
$conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);

$sql = "SELECT COUNT(*) FROM resources";
$results = $conn->query($sql);
$row = $results->fetch_assoc();
$num_rows = $row['COUNT(*)'];

$rows_per_page = 10;
$total_pages = ceil($num_rows / $rows_per_page); //ceil rounds up

if(isset($_GET['currentresourcepage']) && is_numeric($_GET['currentresourcepage'])){
    $currentresourcepage = (int) $_GET['currentresourcepage'];
}else{
    $currentresourcepage = 1;
}

if($currentresourcepage > $total_pages){
    $currentresourcepage = $total_pages;
}

if($currentresourcepage < 1){
    $currentresourcepage = 1;
}

$offset = ($currentresourcepage - 1) * $rows_per_page;

$sql = "SELECT * FROM resources LIMIT $offset, $rows_per_page";
$results = $conn->query($sql);

print "<table class=\"admintable table table-striped table-condensed responsive\">
       <thead>
            <tr>
                <th>Type</th>
                <th>Details</th>
                <th>Identifier</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
    ";
while($row = $results->fetch_assoc()){
    extract($row);
    $type_name = getResourceTypeName($resource_type);
    $department_name = getDepartmentName($resource_department);
    print "
        <tr>
            <td>$type_name</td>
            <td>$resource_details</td>
            <td>$resource_identifier</td>
            <td>$department_name</td>
            <td>
            <a href=\"./?p=confirm&user=$user_id&confirmAction=delete&type=resource&resource=$resource_id&page=$page\" class=\" btn btn-small btn-danger admindelete\">
                <i class=\"icon-trash icon-white\"></i>
                delete
            </a>
            <a href=\"./?p=edit&resource=$resource_id&type=resource\" class=\" btn btn-small admindelete\">
                <i class=\"icon-edit icon-black\"></i>
                edit
            </a>
        </tr>
    ";
}
print "</tbody></table>
        <div class=\"pagination\">
        <ul>
    ";

if($currentresourcepage > 1){
    print "<li><a href=\"./?action=redirect&currentresourcepage=1&type=$type\">&laquo;</a></li>";
    $prev_page = $currentresourcepage - 1;
    print "<li><a href=\"./?action=redirect&currentresourcepage=$prev_page&type=$type\">&lsaquo;</a></li>";
}else{
    print "<li class=\"disabled\"><a href=\"\">&laquo;</a></li>";
    print "<li class=\"disabled\"><a href=\"\">&lsaquo;</a></li>";
}

$range = 3;

for($x = ($currentresourcepage - $range); $x < (($currentresourcepage + $range) + 1); $x++){
    if(($x > 0) && ($x <= $total_pages)){
        if($x == $currentresourcepage){
            print "<li class=\"active\"><a>$x</a></li>";
        }else{
            print "<li><a href=\"./?action=redirect&currentresourcepage=$x&type=$type\">$x</a></li>";
        }
    }
}

if($currentresourcepage != $total_pages){
    $next_page = $currentresourcepage + 1;
    print "<li><a href=\"./?action=redirect&currentresourcepage=$next_page&type=$type\">&rsaquo;</a></li>";
    print "<li><a href=\"./?action=redirect&currentresourcepage=$total_pages&type=$type\">&raquo;</a></li>";
}else{
    print "<li class=\"disabled\"><a href=\"\">&rsaquo;</a></li>";
    print "<li class=\"disabled\"><a href=\"\">&raquo;</a></li>";
}
print "</ul></div><a class=\"btn add\" href=\"./?p=add&type=resource\">Add resource</a>";

$conn->close();
?>
