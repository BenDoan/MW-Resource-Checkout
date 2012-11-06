<?php
// Pages to display in nav, in format ('Name' => 'QS param value')
$pages = array(
	'Home' => 'checkout',
);

// Display pages in <ul>
echo '<ul>';
if (isLoggedIn()) {
    foreach($pages as $name => $p) {
        $class = ($p == $CURR_PAGE) ? 'current' : '';
        echo "<li class=\"$class\"><a href=\"./?p=$p\">$name</a></li>";
    }

    if (!isReadOnly()) {
        $class = ('userSettings' == $CURR_PAGE) ? 'current' : '';
        echo "<li class=\"$class\"><a href=\"./?p=userSettings\">Settings</a></li>";
        $class = ('currentRequests' == $CURR_PAGE) ? 'current' : '';
        echo "<li class=\"$class\"><a href=\"./?p=currentRequests\">My Reservations</a></li>";
    }

    if (isAdmin()) {
        $class = ('adminPage' == $CURR_PAGE) ? 'current' : '';
        echo "<li class=\"$class\"><a href=\"./?p=adminPage\">Admin Panel</a></li>";
    }
}
echo '</ul>';
?>
<div id="userinfo">
	<?php
	// Check to see if user has logged in
	if(isLoggedIn()) {
			// Display user status and logout option
			echo '<p>Logged in as '.$_SESSION['user']['user_username'].' <a class="logout" href="./?action=authenticate&logout">logout</a></p>';
	}
	?>
</div>
