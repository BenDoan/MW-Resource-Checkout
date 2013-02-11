<!DOCTYPE html>
<html>
	<head>
		<title>Resource Checkout</title>
        <meta charset="utf-8">

        <link rel="icon" type="image/ico" href="favicon.ico" />


        <link href='http://fonts.googleapis.com/css?family=Ropa+Sans' rel='stylesheet' type='text/css'>

 		<link rel='stylesheet' type='text/css' href='calendar/fullcalendar-1.5.2/fullcalendar/fullcalendar.css' />
		<link rel='stylesheet' type='text/css' href='calendar/fullcalendar-1.5.2/fullcalendar/fullcalendar.print.css' media='print' />
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="js/css/custom-theme/datepicker.css"/>
		<link rel="stylesheet" type="text/css" href="resource.css"/>

		<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.17.custom.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/jquery.placeholder.min.js"></script>
        <script type="text/javascript" src="js/resourceCheckout.js"></script>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Created by Tracy Moody, Destiny Osbourne and Ben Doan with assistance from the Omaha Bytes Club-->
	</head>
    <?php flush(); ?>
	<body>
        <?php if(isLoggedIn()): ?>
            <div id="header">
                    <?php //include('layout/header.php');?>
            </div>
			<div id="nav">
				<?php if (isLoggedIn()) include('layout/nav.php');?>
			</div>
		<div id="wrapper">
			<div id="content">
				<?php include('layout/content.php');?>
			</div>
		</div>
		<div id="footer">
			<?php include('layout/footer.php');?>
		</div>
        <?php else: ?>
            <?php include('layout/content.php') ?>
        <?php endif ?>
		<script type='text/javascript' src='calendar/fullcalendar-1.5.2/fullcalendar/fullcalendar.min.js'></script>
	</body>
</html>
