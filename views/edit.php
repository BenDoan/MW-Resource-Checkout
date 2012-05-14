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
    switch ($type) {
        case 'user':
            include('edit/user.php');
            break;

        case 'resource':
            include('edit/resource.php');
            break;

        case 'request':
            include('edit/request.php');
            break;

        default:
            redirect("./p=404");
            break;
    }
}
?>

