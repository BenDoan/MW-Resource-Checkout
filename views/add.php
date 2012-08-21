<?php
if (isset($_GET['type'])) {
    $type = $_GET['type'];
    include("add/$type.php");
}else {
    redirect("./p=404");
}
?>
