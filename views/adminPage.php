<!--TODO:
          paginate pages
 -->

<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="resource.css"/>
<script type="text/javascript" src="bootstrap/js/bootstrap-collapse.js"></script>

<script>
$(\".collapse\").collapse()
</script>

<style>
    #nav ul {
        display:none;
    }

    #userinfo {
        padding-top:14px;
    }
</style>


<?php
if (isset($_SESSION['type'])) {
    $user = '0px';
    $request = '0px';
    $resource = '0px';

    switch ($_SESSION['type']) {
        case 'user':
            $user = 'auto switching user';
            break;

        case 'request':
            $request = 'auto';
            break;

        case 'resource':
            $resource = 'auto';
            break;
        case 'log':
            $log = 'auto';
            break;
    }
    unset($_SESSION['type']);
}else{
    $user = 'auto';
    $request = '0px';
    $resource = '0px';
    $log = '0px;';
}
?>

<div class="span10 columns">
          <h1>Admin Panel</h1>
          <div class="accordion" id="accordion2">
            <div class="accordion-group">
              <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#users">
                    Users
                </a>
              </div>
              <div id="users" class="accordion-body in collapse" style="height: <?php print $user; ?>; ">
                <div class="accordion-inner">
                    <?php include('admin/users.php');?>
                </div>
              </div>
            </div>

            <div class="accordion-group">
              <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#requests">
                    Requests
                </a>
              </div>
              <div id="requests" class="accordion-body collapse" style="height: <?php print $request; ?>; ">
                <div class="accordion-inner">
                    <?php include('admin/requests.php');?>
                </div>
              </div>
            </div>

            <div class="accordion-group">
              <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#resources">
                    Resources
                </a>
              </div>
              <div id="resources" class="accordion-body collapse in" style="height: <?php print $resource; ?>; ">
                <div class="accordion-inner">
                    <?php include('admin/resources.php');?>
                </div>
              </div>
            </div>

            <div class="accordion-group">
              <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#log">
                    Log
                </a>
              </div>
              <div id="log" class="accordion-body collapse in" style="height: <?php print $resource; ?>; ">
                <div class="accordion-inner">
                    <?php include('admin/log.php');?>
                </div>
              </div>
            </div>
          </div>

