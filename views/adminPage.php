<!--TODO:
          'add user' page
          paginate pages
 -->

<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="resource.css"/>
<script type="text/javascript" src="bootstrap/js/bootstrap-collapse.js"></script>
<style>
    #nav ul {
        display:none;
    }

    #userinfo {
        padding-top:14px;
    }
</style>


<?php
if (isset($_GET['selection'])) {
    $selection = $_GET['selection'];
}
if (isset($selection)) {
    print "
        <script>
            $(\".collapse\").collapse()

            $('#myCollapsible').collapse({
              toggle: false
            })
        </script>
        ";
}else{
    print "
        <script>
            $(\".collapse\").collapse()

            $('#myCollapsible').collapse({
              toggle: false
            })
        </script>
        ";
}
?>
<div class="span9 columns">
          <h1>Admin Panel</h1>
          <div class="accordion" id="accordion2">
            <div class="accordion-group">
              <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                    Users
                </a>
              </div>
              <div id="collapseOne" class="accordion-body in collapse" style="height: auto; ">
                <div class="accordion-inner">
                    <?php include('admin/users.php');?>
                </div>
              </div>
            </div>
            <div class="accordion-group">
              <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                    Requests
                </a>
              </div>
              <div id="collapseTwo" class="accordion-body collapse" style="height: 0px; ">
                <div class="accordion-inner">
                    <?php include('admin/requests.php');?>
                </div>
              </div>
            </div>
            <div class="accordion-group">
              <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
                    Resources
                </a>
              </div>
              <div id="collapseThree" class="accordion-body collapse" style="height: 0px; ">
                <div class="accordion-inner">
                    <?php include('admin/resources.php');?>
                </div>
              </div>
            </div>
          </div>

