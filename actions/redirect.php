<?php
    $_SESSION['tab'] = $_GET['type'];
    $pagetype = 'current' . $_GET['type'] . 'page';
    $cur_page = $_GET[$pagetype];
    redirect("./?$pagetype=$cur_page");
?>
