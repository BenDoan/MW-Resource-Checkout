<?php
if (!isAdmin()) {
    redirect('./');
}
?>
<h1>Results</h1>
<div class="well">
<?php
    if (!isset($_SESSION['matches'])) {
        redirect('./');
    }
    $matches = explode("\n", $_SESSION['matches']);
    unset($_SESSION['matches']);
    foreach ($matches as $x) {
        print $x;
        print "<br />";
    }
?>
</div>
<a href="./" class="btn">Back</a>
