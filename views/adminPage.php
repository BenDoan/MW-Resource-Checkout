<!--TODO:
    add limits to carts
    <= 3/week
    <= 2 consecutive
    delete old requests
 -->

<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="resource.css"/>
<script type="text/javascript" src="bootstrap/js/bootstrap-tab.js"></script>

<style>
#nav ul {
display:none;
    }

    #userinfo {
        padding-top:14px;
    }
</style>

    <script type="text/javascript">
$('#myTab').tab('show')
</script>

<?php
extract($_GET);

$users = "";
$requests = "";
$resources = "";
$log = "";

if (isset($tab)) {
    switch ($tab) {
    case 'users':
        $users = "active";
        break;

    case 'requests':
        $requests = "active";
        break;

    case 'resources':
        $resources = "active";
        break;

    case 'log':
        $log = "active";
        break;

    default:
        $users = "active";
        break;
    }
}else{
    $users = "active";
}
?>

<div class="span10 columns">
    <h1>Admin Panel</h1>
    <ul class="nav nav-tabs">
      <li class="<?php print $users ?>"><a href="#users" data-toggle="tab">Users</a></li>
      <li class="<?php print $requests ?>"><a href="#requests" data-toggle="tab">Requests</a></li>
      <li class="<?php print $resources ?>"><a href="#resources" data-toggle="tab">Resources</a></li>
      <li class="<?php print $log ?>"><a href="#log" data-toggle="tab">Admin Log</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane <?php print $users ?>" id="users"><?php include('admin/users.php');?></div>
        <div class="tab-pane <?php print $requests ?>" id="requests"><?php include('admin/requests.php');?></div>
        <div class="tab-pane <?php print $resources ?>" id="resources"><?php include('admin/resources.php');?></div>
    <div class="tab-pane" <?php print $log ?> id="log"><?php include('admin/log.php');?></div>
</div>
</div>

