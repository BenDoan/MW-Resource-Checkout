<?php
    if (!isAdmin()) {
        redirect("./");
    }
    foreach ($_POST as $key => $val) {
        $key = addslashes($key);
        $val = addslashes($val);
        sqlQuery("UPDATE settings SET setting_value='$val' WHERE setting_id=$key");

        $setting_type = getSettingType($key);
        alog("updated setting $key to $val");
    }


    $_SESSION['tab'] = 'settings';
    redirect('./', 'Settings saved');
?>
