<?php
session_start();
include 'config/db.php';
$today=date('Y-m-d');

$currentUser = $_SESSION['user']['user_id'];

$conn= new mysqli('localhost', DB_USERNAME, DB_PASSWORD, DB_NAME);
$sql="SELECT * FROM schedule
         LEFT JOIN resources ON schedule.schedule_resource_id=resources.resource_id
         LEFT JOIN users ON schedule.schedule_user_id=users.user_id
         WHERE schedule_user_id='$currentUser' AND schedule_date >= '$today'
         ORDER BY schedule_date";
$results = $conn->query($sql);

//if ($results == false){
	//echo "crap";
//}

$numRows = $conn->affected_rows;

//returns the next event from the sql query above
function getNextEvent($results){
    $day = date('d');
    $month = date('m');
    $year = date('y');

	$row = $results->fetch_assoc();
	extract($row);

	$half = (fmod($schedule_block,10)==1) ? "First half": "Second half";
	$block = ($schedule_block > 10) ? floor($schedule_block/10): $schedule_block;

	$event = array(
		'title'  =>	"$resource_type - $half of Block $block",
		'start'	=>	$schedule_date,
        'url' => './?p=currentRequests',

	);
	return $event;
}
//
$events = array();
for ($i = 0; $i < $numRows; $i++){
    $events[] = getNextEvent($results);
}

?>
var EVENTS = <?php echo json_encode($events) ?>;
$(function() {
	initCalendar();
	$('input[name=date]').datepicker({dateFormat: 'mm/dd/yy'});
});

function initCalendar() {
	var date = new Date();

	// When a day on the calender is clicked, send the page to the search page with the date in the url
	$('#calendar').fullCalendar({
		eventSources: [{
			events:EVENTS,
            color: '#204927',
            textColor: 'white',
        }],
		editable: false,
		weekends: false,
		dayClick: function(dateClicked, allDay, jsEvent, view) {
			var date = new Date(dateClicked);
			var d = date.getDate();
			var m = date.getMonth() + 1;
			var y = date.getFullYear();


	    	window.location = './?p=resultList&date=' + m + '/' + d + '/' + y;
	    }


	});
}
