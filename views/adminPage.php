<!--TODO:
          'add user' page
          paginate pages
 -->

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
            $(function() {
                $( \"#accordion\" ).accordion({autoHeight: false, collapsible: true, active: $selection});
            });
        </script>
        ";
}else{
    print "
        <script>
            $(function() {
                $( \"#accordion\" ).accordion({autoHeight: false, collapsible: true});
            });
        </script>
        ";
}
?>
<h1>Admin Panel</h1>
<div id="accordion">
	<h3><a href="#">Users</a></h3>
    <div>
        <?php include('admin/users.php');?>
    </div>
	<h3><a href="#">Requests</a></h3>
	<div>
        <?php include('admin/requests.php');?>
	</div>

	<h3><a href="#">Resources</a></h3>
	<div>
        <?php include('admin/resources.php');?>
	</div>
</div>
