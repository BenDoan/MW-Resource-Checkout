<?php
// Check session data for message
if(isset($_SESSION['message'])) {
	// Display message
	//echo "<div class=\"message\">{$_SESSION['message']}</div>";
    print "<div class=\"alert {$_SESSION['messagetype']}\">
                <a class=\"close\" data-dismiss=\"alert\">&times;</a>
                {$_SESSION['message']}
            </div>
    ";
	// Remove message from session
	unset($_SESSION['message']);
	unset($_SESSION['messagetype']);
}

$file = "views/$CURR_PAGE.php";
// If page exist, load it
if(file_exists($file)) {
	include($file);
} else { // Page doesn't exist, display 404
	include('views/404.php');
}

?>
