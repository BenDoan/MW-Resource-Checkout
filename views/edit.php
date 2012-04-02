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
    if ($_GET['type'] == 'user') {
        include('edit/user.php');
    }elseif (($_GET['type'] == 'resource')){
        include('edit/resource.php');
    }elseif (($_GET['type'] == 'request')){
        include('edit/request.php');
    }
}
?>

