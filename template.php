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
        <!-- Created by Tracy Moody, Destiny Osbourne and Ben Doan with assistance from the Omaha Bytes Club-->
	</head>
    <?php flush(); ?>
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
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
		<script type='text/javascript' src='calendar/fullcalendar-1.5.2/fullcalendar/fullcalendar.min.js'></script>
		<script type="text/javascript" src="resourcecheckout.js.php"></script>
        <script type="text/javascript">
            $(".alert").alert();
            $(function() {
                $('input[name=date]').datepicker({dateFormat: 'mm/dd/yy', beforeShowDay:$.datepicker.noWeekends});
                $('input[name=checkoutdate]').datepicker({
                    dateFormat: 'mm/dd/yy',
                    beforeShowDay:$.datepicker.noWeekends,
                    minDate:0
                });
            });
        </script>
	</body>
</html>
