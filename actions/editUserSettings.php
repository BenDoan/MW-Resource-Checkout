<?php
extract($_POST);
extract($_SESSION['user']);


if (isAdmin()) {
    redirect("./?p=userSettings", "Sorry, you can't edit an admin's settings", 'alert-error');
}else {
    if (md5($curpass) == $_SESSION['user']['user_password']) {
        sqlQuery("UPDATE users SET user_firstname='$firstname', user_lastname='$lastname', user_email='$email' WHERE user_id={$_SESSION['user']['user_id']}");
        updateSessionUser();

        if ($newpass != '' || $newpass2 != '') {
            if ($newpass == $newpass2) {
                $md5Pass = md5($newpass);
                sqlQuery("UPDATE users SET user_password='$md5Pass' WHERE user_id='{$_SESSION['user']['user_id']}'");
                redirect('./?p=userSettings', 'Settings saved');
            }else{
                redirect('./?p=userSettings', 'The two passwords you have entered do not match', 'alert-error');
            }
        }else{
            redirect('./?p=userSettings', 'Settings saved');
        }
    }else{
        redirect('./?p=userSettings', 'You did not enter the correct password', 'alert-error');
    }
}

?>
