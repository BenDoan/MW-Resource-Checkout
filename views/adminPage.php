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
$pages = array(
    //array("info", "info"),
    "user" => "Users",
    "request" => "Requests",
    "resource" => "Resources",
    "rType" => "Resource Types",
    "department" => "Departments",
    "summary" => "Summary",
    "comment" => "Comments",
    "settings" => "Settings",
    "log" => "Log"
);

if (DISP_BADGES) {
    $num_users = getTableLength('users');
    $num_requests = getTableLength('schedule', "WHERE schedule_date > '" . date('Y-m-d') ."'");
    $num_resources = getTableLength('resources');
    $num_resource_types = getTableLength('types');
    $num_departments = getTableLength('departments');
    $num_comments = getTableLength('comments');

    $pages["user"] = "users <span class=\"badge badge-inverse\">$num_users</span>";
    $pages["request"] = "requests <span class=\"badge badge-inverse\">$num_requests</span>";
    $pages["resource"] = "resources <span class=\"badge badge-inverse\">$num_resources</span>";
    $pages["rType"] = "Resource Types <span class=\"badge badge-inverse\">$num_resource_types</span>";
    $pages["department"] = "Departments <span class=\"badge badge-inverse\">$num_departments</span>";
    $pages["comment"] = "comments <span class=\"badge badge-inverse\">$num_comments</span>";
}
?>
    <h1>Admin Panel</h1>
    <ul class="nav nav-tabs adminpage">
    <?php
    foreach ($pages as $key => $val) {
        if (isset($_SESSION['tab'])) {
            if ($_SESSION['tab'] == $key) {
                print "<li class=\"active\"><a href=\"#$key\" data-toggle=\"tab\">". $val . "</a></li>\n";
            }else {
                print "<li><a href=\"#$key\" data-toggle=\"tab\">" . $val . "</a></li>\n";
            }
        }else{
            if (DEFAULT_ADMIN_PANEL_ITEM == $key) {
                print "<li class=\"active\"><a href=\"#$key\" data-toggle=\"tab\">" . $val . "</a></li>\n";
            }else {
                print "<li><a href=\"#$key\" data-toggle=\"tab\">". $val . "</a></li>\n";
            }
        }
    }
    ?>
    </ul>

    <div class="tab-content">
        <?php
        foreach ($pages as $key => $val) {
            if (isset($_SESSION['tab'])) {
                if ($_SESSION['tab'] == $key) {
                    print "<div class=\"tab-pane active\" id=\"$key\">";
                    require_once("admin/$key.php" );
                    print "</div>";
                }else{
                    print "<div class=\"tab-pane\" id=\"$key\">";
                    require_once("admin/$key.php" );
                    print "</div>";
                }
            }else {
                if ($key == DEFAULT_ADMIN_PANEL_ITEM) {
                    print "<div class=\"tab-pane active\" id=\"$key\">";
                    require_once("admin/$key.php" );
                    print "</div>";
                }else{
                    print "<div class=\"tab-pane\" id=\"$key\">";
                    require_once("admin/$key.php" );
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
