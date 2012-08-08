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

//to add a page to the admin panel, put the php file into
//views/admin/ and put the name of the file into this array
//filname then display name
$pages = array(
    array("info", "info"),
    array("user", "user"),
    array("request", "request"),
    array("resource", "resource"),
    array("rType", "Resource Type"),
    array("comment", "comment"),
    array("settings", "settings"),
    array("log", "log"));
?>
<div class="span10 columns">
    <h1>Admin Panel</h1>
    <ul class="nav nav-tabs">
    <?php
    foreach ($pages as $key) {
        if (isset($_SESSION['tab'])) {
            if ($_SESSION['tab'] == $key[0]) {
                print "<li class=\"active\"><a href=\"#$key[0]\" data-toggle=\"tab\">". ucfirst($key[1]) . "</a></li>\n";
            }else {
                print "<li><a href=\"#$key[0]\" data-toggle=\"tab\">" . ucfirst($key[0]) . "</a></li>\n";
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
</div>
<?php
unset($_SESSION['type']);
unset($_SESSION['tab']);
?>

