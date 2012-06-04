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

// to add a page to the admin panel, put the php file into
// views/admin and put the name of the file in this array
$pages = array(
    "info",
    "user",
    "request",
    "resource",
    "resourceType",
    "comment",
    "settings",
    "log");

?>
<div class="span10 columns">
    <h1>Admin Panel</h1>
    <ul class="nav nav-tabs">
    <?php
    foreach ($pages as $key) {
        if (isset($_SESSION['tab'])) {
            if ($_SESSION['tab'] == $key) {
                print "<li class=\"active\"><a href=\"#rkey\" data-toggle=\"tab\">". ucfirst($key) . "</a></li>\n";
            }else {
                print "<li><a href=\"#$key\" data-toggle=\"tab\">" . ucfirst($key) . "</a></li>\n";
            }
        }else{
            if (DEFAULT_ADMIN_PANEL_ITEM == $key) {
                print "<li class=\"active\"><a href=\"#$key\" data-toggle=\"tab\">" . ucfirst($key) . "</a></li>\n";
            }else {
                print "<li><a href=\"#$key\" data-toggle=\"tab\">". ucfirst($key) . "</a></li>\n";
            }
        }
    }
    ?>
    </ul>

    <div class="tab-content">
        <?php
        foreach ($pages as $key) {
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
</div>
<?php
unset($_SESSION['type']);
unset($_SESSION['tab']);
?>
