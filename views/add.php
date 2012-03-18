<style>
    #nav ul {
        display:none;
    }

    #userinfo {
        padding-top:14px;
    }
</style>
<?php
if ($_SESSION['user']['user_username'] != 'admin') {
    redirect('./');
}

if (isset($_GET['type'])) {
    if ($_GET['type'] == 'user') {
        include('add/user.php');
    }elseif (($_GET['type'] == 'resource')){
        include('add/resource.php');
    }elseif (($_GET['type'] == 'request')){
        include('add/request.php');
    }
}


?>
