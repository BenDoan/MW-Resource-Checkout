<?php
// If no message is in session, display a not found message
if (!isset($_SESSION['message'])){
	echo '<p>Page not found. Please use the navigation provided.</p>';
}

?>