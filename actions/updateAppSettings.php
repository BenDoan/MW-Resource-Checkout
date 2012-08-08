<?php
    if (!isAdmin()) {
        redirect("./");
    }
    $time = getTimestamp();
    sqlQuery("UPDATE settings SET setting_value='{$_POST['1']}'WHERE setting_id=1");
    sqlQuery("UPDATE settings SET setting_value='{$_POST['2']}'WHERE setting_id=2");

    writeLineToLog("$time - Admin - Deleted user $user_name");

    redirect('./', 'Settings saved');
?>
