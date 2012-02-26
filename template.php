<!DOCTYPE html>
<html>
	<head>
		<title>Resource Checkout</title>

        <link rel="icon" type="image/ico" href="favicon.ico?v=3" />

		<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.17.custom.min.js"></script>
		<script type='text/javascript' src='calendar/fullcalendar-1.5.2/fullcalendar/fullcalendar.min.js'></script>

		<script type="text/javascript" src="resourcecheckout.js.php"></script>

		<link rel='stylesheet' type='text/css' href='calendar/fullcalendar-1.5.2/fullcalendar/fullcalendar.css' />
		<link rel='stylesheet' type='text/css' href='calendar/fullcalendar-1.5.2/fullcalendar/fullcalendar.print.css' media='print' />
		<link rel="stylesheet" type="text/css" href="js/css/custom-theme/datepicker.css"/>
		<link rel="stylesheet" type="text/css" href="resource.css"/>
	</head>
	<body>
		<header>
			<?php include('layout/header.php');?>
		</header>
		<div id="wrapper">
			<div id="nav">
				<?php include('layout/nav.php');?>
			</div>
			<div id="content">
				<?php include('layout/content.php');?>
			</div>
		</div>
		<div id="footer">
			<?php include('layout/footer.php');?>
		</div>
	</body>
</html>
