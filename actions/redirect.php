<?php
    $_SESSION['tab'] = $_GET['type'];
    $cur_page = $_GET['currentpage'];
    redirect("./?currentpage=$cur_page");
?>
