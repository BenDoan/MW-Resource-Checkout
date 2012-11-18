<?php
// Pages to display in nav, in format ('Name' => 'QS param value')
$pages = array(
	'Home' => 'calendar',
    'Checkout' => 'checkout',
	'Resources' => 'resourceCalendar'
);
?>

<div class="navbar navbar-inverse"><div class="navbar-inner"><div class="container">
<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
</a>
<a class="brand" href="./">MW Checkout</a><div class="nav-collapse collapse">
<ul class="nav">
<?php
if (isLoggedIn()) {
    foreach($pages as $name => $p) {
        $class = ($p == $CURR_PAGE) ? 'active' : '';
        echo "<li class=\"$class\"><a href=\"./?p=$p\">$name</a></li>";
    }

    if (!isReadOnly()) {
        $class = ('userSettings' == $CURR_PAGE) ? 'active' : '';
        echo "<li class=\"$class\"><a href=\"./?p=userSettings\">Settings</a></li>";
        $class = ('currentRequests' == $CURR_PAGE) ? 'active' : '';
        echo "<li class=\"$class\"><a href=\"./?p=currentRequests\">My Reservations</a></li>";
    }

    if (isAdmin()) {
        $class = ('adminPage' == $CURR_PAGE) ? 'active' : '';
        echo "<li class=\"$class\"><a href=\"./?p=adminPage\">Admin Panel</a></li>";
    }
}
echo '</ul>';

if(isLoggedIn()) {
        // Display user status and logout option
        echo '<p class="navbar-text pull-right">'.$_SESSION['user']['user_username'].'|<a class="logout" href="./?action=authenticate&logout">logout</a></p>';
}
?>
</div>
</div>
</div>
</div>
