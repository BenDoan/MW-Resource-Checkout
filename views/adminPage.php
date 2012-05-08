<!--TODO:
email notifications
edit email in user settings
    might need a confirmation email?
change admin request add type to the request_id
edit resources
 -->

<?php
if ($_SESSION['user']['user_username'] != ADMIN_USERNAME) {
    redirect('./');
}
?>
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
$comment = "";
$info = "";

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

    case 'comment':
        $comment= "active";
        break;

    case 'info':
        $info = "active";
        break;

    default:
        $info = "active";
        break;
    }
}else{
    $info = "active";
}

if (isset($type)) {
    $_SESSION['tab'] = $type;
}
?>
<div class="span10 columns">
    <h1>Admin Panel</h1>
    <ul class="nav nav-tabs">
      <li class="<?php print $info ?>"><a href="#info" data-toggle="tab">Info</a></li>
      <li class="<?php print $user ?>"><a href="#users" data-toggle="tab">Users</a></li>
      <li class="<?php print $request ?>"><a href="#requests" data-toggle="tab">Requests</a></li>
      <li class="<?php print $resource ?>"><a href="#resources" data-toggle="tab">Resources</a></li>
      <li class="<?php print $comment?>"><a href="#comments" data-toggle="tab">Comments</a></li>
      <li class="<?php print $settings ?>"><a href="#settings" data-toggle="tab">Settings</a></li>
      <li class="<?php print $log ?>"><a href="#log" data-toggle="tab">Admin Log</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane <?php print $info ?>" id="info"><?php include('admin/info.php');?></div>
        <div class="tab-pane <?php print $user ?>" id="users"><?php include('admin/users.php');?></div>
        <div class="tab-pane <?php print $request ?>" id="requests"><?php include('admin/requests.php');?></div>
        <div class="tab-pane <?php print $resource ?>" id="resources"><?php include('admin/resources.php');?></div>
        <div class="tab-pane <?php print $comment?>" id="comments"><?php include('admin/comments.php');?></div>
        <div class="tab-pane <?php print $settings ?>" id="settings"><?php include('admin/settings.php');?></div>
        <div class="tab-pane <?php print $log ?>" id="log"><?php include('admin/log.php');?></div>
</div>
</div>
<?php
unset($_SESSION['type']);
unset($_SESSION['tab']);
?>
