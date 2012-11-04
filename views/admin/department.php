<?php
if (isset($_GET['currentdepartmentpage'])) {
    $page = $_GET['currentdepartmentpage'];
}else{
    $page = 1;
}
$type = 'department';
$conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);

$sql = "SELECT COUNT(*) FROM departments";
$results = $conn->query($sql);
$row = $results->fetch_assoc();
$num_rows = $row['COUNT(*)'];

$rows_per_page = 10;
$total_pages = ceil($num_rows / $rows_per_page); //ceil rounds up

if(isset($_GET['currentdepartmentpage']) && is_numeric($_GET['currentdepartmentpage'])){
    $currentdepartmentpage = (int) $_GET['currentdepartmentpage'];
}else{
    $currentdepartmentpage = 1;
}

if($currentdepartmentpage > $total_pages){
    $currentdepartmentpage = $total_pages;
}

if($currentdepartmentpage < 1){
    $currentdepartmentpage = 1;
}

$offset = ($currentdepartmentpage - 1) * $rows_per_page;

$sql = "SELECT * FROM departments LIMIT $offset, $rows_per_page";
$results = $conn->query($sql);

print "<table class=\"admintable table table-striped table-condensed\">
       <thead>
            <tr>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
    ";
while($row = $results->fetch_assoc()){
    extract($row);
    print "
        <tr>
            <td>$department_name</td>
            <td>
            <a href=\"./?p=confirm&user=$user_id&confirmAction=delete&type=department&department=$department_id&page=$page\" class=\" btn btn-small btn-danger admindelete\">
                <i class=\"icon-trash icon-white\"></i>
                delete
            </a>
            <a href=\"./?p=edit&department=$department_id&type=department\" class=\" btn btn-small admindelete\">
                <i class=\"icon-pencil icon-black\"></i>
                edit
            </a>
        </tr>
    ";
}
print "</tbody></table>
        <div class=\"pagination\">
    ";

if($currentdepartmentpage > 1){
    print "<li><a href=\"./?action=redirect&currentdepartmentpage=1&type=$type\">&laquo;</a></li>";
    $prev_page = $currentdepartmentpage - 1;
    print "<li><a href=\"./?action=redirect&currentdepartmentpage=$prev_page&type=$type\">&lsaquo;</a></li>";
}else{
    print "<li class=\"disabled\"><a href=\"\">&laquo;</a></li>";
    print "<li class=\"disabled\"><a href=\"\">&lsaquo;</a></li>";
}

$range = 3;

for($x = ($currentdepartmentpage - $range); $x < (($currentdepartmentpage + $range) + 1); $x++){
    if(($x > 0) && ($x <= $total_pages)){
        if($x == $currentdepartmentpage){
            print "<li class=\"active\"><a>$x</a></li>";
        }else{
            print "<li><a href=\"./?action=redirect&currentdepartmentpage=$x&type=$type\">$x</a></li>";
        }
    }
}

if($currentdepartmentpage != $total_pages){
    $next_page = $currentdepartmentpage + 1;
    print "<li><a href=\"./?action=redirect&currentdepartmentpage=$next_page&type=$type\">&rsaquo;</a></li>";
    print "<li><a href=\"./?action=redirect&currentdepartmentpage=$total_pages&type=$type\">&raquo;</a></li>";
}else{
    print "<li class=\"disabled\"><a href=\"\">&rsaquo;</a></li>";
    print "<li class=\"disabled\"><a href=\"\">&raquo;</a></li>";
}
print "</div><a class=\"btn add\" href=\"./?p=add&type=department\">Add department</a>";

$conn->close();
?>


