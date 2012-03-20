<?php
// If no message is in session, display a not found message
if (!isset($_SESSION['message'])){
    print "<div class=\"alert alert-error\">
                <a class=\"close\" data-dismiss=\"alert\">&times;</a>
                Page not found
            </div>
    ";
}

?>
