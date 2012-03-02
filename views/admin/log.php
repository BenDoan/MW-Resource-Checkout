<pre>
<?php
$log = readLog();

$num_rows = sizeof($log);
$rows_per_page = 20;
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
$sliced_log = array_slice($log, $offset, $rows_per_page);
foreach($sliced_log as $x){
    print $x;
    print "<br />";
}
print "</pre>";

print "<div class=\"pagination\">";

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
    print "<li><a href=\"./?action=redirect&currentpage=$next_page\">›</a></li>";
    print "<li><a href=\"./?action=redirect&currentpage=$total_pages\">»</a></li>";
}else{
    print "<li class=\"disabled\"><a href=\"\">›</a></li>";
    print "<li class=\"disabled\"><a href=\"\">»</a></li>";
}

print "</div>";
?>
