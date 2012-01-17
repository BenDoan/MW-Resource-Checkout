<?php 
// Pages to display in nav, in format ('Name' => 'QS param value')
$pages = array(
	'Homepage'  =>	'calendar',
	'Search'	=>	'formSearch',
	'Manage'	=>	'currentRequests'
);

// Display pages in <ul>
echo '<ul>';
foreach($pages as $name => $p) {
	$class = ($p == $CURR_PAGE) ? 'current' : '';
	echo "<li class=\"$class\"><a href=\"./?p=$p\">$name</a></li>";
}
echo '</ul>';
?>
<div id="userinfo">
	<?php 
	// Check to see if user has logged in
	if(isLoggedIn()) {
			// Display user status and logout option
			echo '<p>Logged in as '.$_SESSION['user']['user_firstname'].' '.$_SESSION['user']['user_lastname'].' <a class="logout" href="./?action=authenticate&logout">logout</a></p>';
	}
	?>
</div>