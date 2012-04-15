<?php
    $log = implode('\n', array_slice(array_reverse(readLog()), 1));
    //$results = preg_grep(preg_quote($_POST['pattern'], '*'), $log);
    $pattern = $_POST['pattern'];
    $results = exec("grep /$log/ $pattern");

    print $results;
?>
