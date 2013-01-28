<?php
if (!isAdmin()) {
    redirect('./');
}
?>
<script type="text/javascript">
$(document).ready(function(){
    //js for showing/hiding delete button in admin tables
    $(".admintable tr").hover(
        function() {
            $(this).addClass("hover");
        },
        function() {
            $(this).removeClass("hover");
        });
});
</script>

<?php
if (isset($_GET['date'])) {
    $_SESSION['tab'] = 'summary';
}

//to add a page to the admin panel, put the php file into
//views/admin/ and put the name of the file into this array
//filname then display name
$num_users = getTableLength('users');
$num_requests = getTableLength('schedule', "WHERE schedule_date > '" . date('Y-m-d') ."'");
$num_resources = getTableLength('resources');
$num_resource_types = getTableLength('types');
$num_departments = getTableLength('departments');
$num_comments = getTableLength('comments');
$pages = array(
    //array("info", "info"),
    array("user", "users <span class=\"badge badge-inverse\">$num_users</span>"),
    array("request", "requests <span class=\"badge badge-inverse\">$num_requests</span>"),
    array("resource", "resources <span class=\"badge badge-inverse\">$num_resources</span>"),
    array("rType", "Resource Types <span class=\"badge badge-inverse\">$num_resource_types</span>"),
    array("department", "Departments <span class=\"badge badge-inverse\">$num_departments</span>"),
    array("summary", "summary"),
    array("comment", "comments <span class=\"badge badge-inverse\">$num_comments</span>"),
    array("settings", "settings"),
    array("log", "log"));
?>
    <h1>Admin Panel</h1>
    <ul class="nav nav-tabs adminpage">
    <?php
    foreach ($pages as $key) {
        if (isset($_SESSION['tab'])) {
            if ($_SESSION['tab'] == $key[0]) {
                print "<li class=\"active\"><a href=\"#$key[0]\" data-toggle=\"tab\">". ucfirst($key[1]) . "</a></li>\n";
            }else {
                print "<li><a href=\"#$key[0]\" data-toggle=\"tab\">" . ucfirst($key[1]) . "</a></li>\n";
            }
        }else{
            if (DEFAULT_ADMIN_PANEL_ITEM == $key[0]) {
                print "<li class=\"active\"><a href=\"#$key[0]\" data-toggle=\"tab\">" . ucfirst($key[1]) . "</a></li>\n";
            }else {
                print "<li><a href=\"#$key[0]\" data-toggle=\"tab\">". ucfirst($key[1]) . "</a></li>\n";
            }
        }
    }
    ?>
    </ul>

    <div class="tab-content">
        <?php
        foreach ($pages as $key) {
            if (isset($_SESSION['tab'])) {
                if ($_SESSION['tab'] == $key[0]) {
                    print "<div class=\"tab-pane active\" id=\"$key[0]\">";
                    require_once("admin/$key[0].php" );
                    print "</div>";
                }else{
                    print "<div class=\"tab-pane\" id=\"$key[0]\">";
                    require_once("admin/$key[0].php" );
                    print "</div>";
                }
            }else {
                if ($key[0] == DEFAULT_ADMIN_PANEL_ITEM) {
                    print "<div class=\"tab-pane active\" id=\"$key[0]\">";
                    require_once("admin/$key[0].php" );
                    print "</div>";
                }else{
                    print "<div class=\"tab-pane\" id=\"$key[0]\">";
                    require_once("admin/$key[0].php" );
                    print "</div>";
                }
            }
        }
        ?>
</div>
<?php
unset($_SESSION['type']);
unset($_SESSION['tab']);
?>

