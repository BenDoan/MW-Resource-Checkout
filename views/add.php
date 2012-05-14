<style>
    #nav ul {
        display:none;
    }

    #userinfo {
        padding-top:14px;
    }
</style>
<?php
if ($_SESSION['user']['user_username'] != ADMIN_USERNAME) {
    redirect('./');
}
if (isset($_GET['type'])) {
    $type = $_GET['type'];
    include("add/$type.php");
}


?>
