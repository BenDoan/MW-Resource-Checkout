<?php

    $_SESSION['tab'] = $_GET['type'];
    $pagetype = 'current' . $_GET['type'] . 'page';
    $cur_page = $_GET[$pagetype];
    printArray($_SESSION);
    printArray($_GET);
    redirect("./?$pagetype=$cur_page");
?>
