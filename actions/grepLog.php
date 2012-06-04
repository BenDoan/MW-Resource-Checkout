<?php
    $log_array = array_slice(array_reverse(readLog()), 1);
    $pattern = $_POST['pattern'];
    $results = preg_grep("#" . $pattern . "#", $log_array);

    $resultsString = implode("\n", $results);
    if (count($results) != 0) {
        $_SESSION['matches'] = $resultsString;
        redirect('./?p=grepResults');
    }else {
        $_SESSION['tab'] = 'log';
        redirect('./', 'No results');
    }
?>
