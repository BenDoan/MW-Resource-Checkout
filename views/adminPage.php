<style>
    #nav ul {
        display:none;
    }

    #userinfo {
        padding-top:14px;
    }
</style>
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
