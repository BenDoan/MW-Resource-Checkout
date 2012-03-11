<!--TODO:
    add limits to carts
        <= 3/week
        <= 2 consecutive
    fix add for requests and resources
    delete requests along with user -> foreign keys mysql
    authentication on all admin pages
    look into creating users
        stop duplicate users from being created
        stop admin user from being created
    make the site look more visually consistant
 -->


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
        <div class="tab-pane <?php print $log ?>" id="log"><?php include('admin/log.php');?></div>
</div>
</div>
<?php
unset($_SESSION['type']);
unset($_SESSION['tab']);
?>
