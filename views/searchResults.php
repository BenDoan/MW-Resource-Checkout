<style>
#nav ul {
display:none;
    }

    #userinfo {
        padding-top:14px;
    }
</style>
<div class="well">
<?php
    if (!isset($_SESSION['matches'])) {
        redirect('./');
    }
    $matches = explode("\n", $_SESSION['matches']);
    unset($_SESSION['matches']);
    foreach ($matches as $x) {
        print $x;
        print "<br />";
    }
?>
</div>
<a href="./" class="btn">Back</a>
