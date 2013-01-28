<h2>Select a resource to view its history</h2>
<form class="form-inline" action="./" method="get">
    <input type="hidden" value="resourceCalendar" name="p"  />
    <select name="resource">
    <?php
    $STH = sqlSelect('SELECT * FROM resources');
    while($row = $STH->fetch()){
        extract($row);
        if (isset($_GET['resource']) && $_GET['resource'] == $resource_id) {
            print "<option selected=\"selected\" value=\"$resource_id\">$resource_identifier</option>";
        }else {
            print "<option value=\"$resource_id\">$resource_identifier</option>";
        }
    }
    ?>
    </select>
    <button type="submit">Search</button>
</form>
<?php
if (isset($_GET['resource'])) {
    print '<a href="./?p=formAddComment&id=' . $_GET["resource"] . '" class="btn">Add comment</a>';
    $resource = $_GET['resource'];
    print '<script type="text/javascript" src="js/resourceCalendar.js.php?resource=' . $resource . '"></script>';
    print "<div id='calendar'></div>";
}
?>
