<form class="form-search" method="post" action="./?action=grepLog">
    <input type="text" name="pattern" class="input-medium search-query">
    <button type="submit" class="btn">Search</button>
    <p class="help-block">Uses <a href="http://en.wikipedia.org/wiki/Grep">grep</a></p>
</form>
<div class="well">
<?php
$type = 'log';
$log = array_slice(array_reverse(readLog()), 1);

$num_rows = sizeof($log);
$rows_per_page = 13;
$total_pages = ceil($num_rows / $rows_per_page); //ceil rounds up

if(isset($_GET['currentlogpage']) && is_numeric($_GET['currentlogpage'])){
    $currentlogpage = (int) $_GET['currentlogpage'];
}else{
    $currentlogpage = 1;
}

if($currentlogpage > $total_pages){
    $currentlogpage = $total_pages;
}

if($currentlogpage < 1){
    $currentlogpage = 1;
}

$offset = ($currentlogpage - 1) * $rows_per_page;
$sliced_log = array_slice($log, $offset, $rows_per_page);
foreach($sliced_log as $x){
    print $x;
    print "<br />";
}
print "</div>";

print "<div class=\"pagination\">";

if($currentlogpage > 1){
    print "<li><a href=\"./?action=redirect&currentlogpage=1&type=$type\">&laquo;</a></li>";
    $prev_page = $currentlogpage - 1;
    print "<li><a href=\"./?action=redirect&currentlogpage=$prev_page&type=$type\">&lsaquo;</a></li>";
}else{
    print "<li class=\"disabled\"><a href=\"\">&laquo;</a></li>";
    print "<li class=\"disabled\"><a href=\"\">&lsaquo;</a></li>";
}

$range = 3;

for($x = ($currentlogpage - $range); $x < (($currentlogpage + $range) + 1); $x++){
    if(($x > 0) && ($x <= $total_pages)){
        if($x == $currentlogpage){
            print "<li class=\"active\"><a>$x</a></li>";
        }else{
            print "<li><a href=\"./?action=redirect&currentlogpage=$x&type=$type\">$x</a></li>";
        }
    }
}

if($currentlogpage != $total_pages){
    $next_page = $currentlogpage + 1;
    print "<li><a href=\"./?action=redirect&currentlogpage=$next_page&type=log\">&rsaquo;</a></li>";
    print "<li><a href=\"./?action=redirect&currentlogpage=$total_pages&type=log\">&raquo;</a></li>";
}else{
    print "<li class=\"disabled\"><a href=\"\">&rsaquo;</a></li>";
    print "<li class=\"disabled\"><a href=\"\">&raquo;</a></li>";
}

print "</div>";
?>
