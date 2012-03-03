<!--TODO:
    add limits to carts
    <= 3/week
    <= 2 consecutive
    delete old requests
    fix add
    delete requests along with user -> foreign keys mysql
    github twitter hook
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

//$(document).ready(function(){
    //$(".admintable").hover(function() {
        //$(".admindelete").show("slide");
            //}, function() {
        //$(".admindelete").hide("slide");
    //});
//});
</script>

<?php
extract($_SESSION);
//printArray($_SESSION);

$user = "";
$request = "";
$resource = "";
$log = "";

if (isset($tab)) {
    switch ($tab) {
    case 'user':
        $user = "active";
        break;

    case 'request':
        $request = "active";
        break;

    case 'resource':
        $resource = "active";
        break;

    case 'log':
        $log = "active";
        break;

    default:
        $user = "active";
        break;
    }
}else{
    $user = "active";
}

if (isset($type)) {
    $_SESSION['tab'] = $type;
}
?>
<div class="span10 columns">
    <h1>Admin Panel</h1>
    <ul class="nav nav-tabs">
      <li class="<?php print $user ?>"><a href="#users" data-toggle="tab">Users</a></li>
      <li class="<?php print $request ?>"><a href="#requests" data-toggle="tab">Requests</a></li>
      <li class="<?php print $resource ?>"><a href="#resources" data-toggle="tab">Resources</a></li>
      <li class="<?php print $log ?>"><a href="#log" data-toggle="tab">Admin Log</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane <?php print $user ?>" id="users"><?php include('admin/users.php');?></div>
        <div class="tab-pane <?php print $request ?>" id="requests"><?php include('admin/requests.php');?></div>
        <div class="tab-pane <?php print $resource ?>" id="resources"><?php include('admin/resources.php');?></div>
    <div class="tab-pane" <?php print $log ?> id="log"><?php include('admin/log.php');?></div>
</div>
</div>
<?php
unset($_SESSION['type']);
unset($_SESSION['tab']);
?>
