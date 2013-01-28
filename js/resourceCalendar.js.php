<?php
session_start();

require_once('../config/db.php');
require_once('../functions.php');

extract($_GET);
$today=date('Y-m-d');

$currentUser = $_SESSION['user']['user_id'];

$conn= new mysqli('localhost', DB_USERNAME, DB_PASSWORD, DB_NAME);
$sql="SELECT * FROM schedule
         LEFT JOIN users ON schedule.schedule_user_id=users.user_id
         WHERE schedule_resource_id='$resource'
         ORDER BY schedule_date, schedule_block";
$results = $conn->query($sql);

$numRows = $conn->affected_rows;

//returns the next event from the sql query above
function getNextEvent($results){
    $day = date('d');
    $month = date('m');
    $year = date('y');

	$row = $results->fetch_assoc();
	extract($row);

	$half = (fmod($schedule_block,10)==1) ? "1st half": "2nd half";
	$block = ($schedule_block > 10) ? floor($schedule_block/10): $schedule_block;

    $resource_name = getResourceTypeName($schedule_resource_id);
    $resource_blocktype = getBlockType($schedule_resource_id);
    $resource_user = getFullName($schedule_user_id);
    if ($resource_blocktype == 'full') {
        $event = array(
            'title'  =>	"$resource_user - Block $block",
            'start'	=>	$schedule_date,
        );
    }else{
        $event = array(
            'title'  =>	"$resource_user - $half of Block $block",
            'start'	=>	$schedule_date,
        );
    }
	return $event;
}
//
$events = array();
for ($i = 0; $i < $numRows; $i++){
    $events[] = getNextEvent($results);
}

$conn->close();
?>
var EVENTS = <?php echo json_encode($events) ?>;
$(function() {
	initCalendar();
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


            var today = new Date();
            if (date >= today) {
                window.location = './?p=checkout&date=' + m + '/' + d + '/' + y;
            }
	    }
	});
}
