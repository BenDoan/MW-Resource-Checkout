<?php
    printArray($_GET);
    $_SESSION['tab'] = $_GET['type'];
    $pagetype = 'current' . $_GET['type'] . 'page';
    $cur_page = $_GET[$pagetype];
    print $cur_page;
    //redirect("./?$pagetype=$cur_page");
?>
