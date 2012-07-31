<?php
if (isset($_GET['type'])) {
    $type = $_GET['type'];
    include("edit/$type.php");
}else {
    redirect("./p=404");
}
