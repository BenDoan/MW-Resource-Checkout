<?php
extract($_POST);
extract($_SESSION['user']);

$curpass = addslashes($curpass);
$firstname = addslashes($firstname);
$email = addslashes($email);
$user_id = addslashes($user_id);
$newpass = addslashes($newpass);
$newpass2 = addslashes($newpass2);



if (md5($curpass) == $_SESSION['user']['user_password']) {
    sqlQuery("UPDATE users SET user_firstname='$firstname', user_lastname='$lastname', user_email='$email' WHERE user_id='$user_id'");
    updateSessionUser();

    if ($newpass != '' || $newpass2 != '') {
        if ($newpass == $newpass2) {
            $md5Pass = md5($newpass);
            sqlQuery("UPDATE users SET user_password='$md5Pass' WHERE user_id='$user_id'");
            alog("Updated password");
            updateSessionUser();
            redirect('./?p=userSettings', 'Settings saved');
        }else{
            redirect('./?p=userSettings', 'The two passwords you have entered do not match', 'alert-error');
        }
    }else{
        alog("Updated user information");
        redirect('./?p=userSettings', 'Settings saved');
    }
}else{
    redirect('./?p=userSettings', 'You did not enter the correct password', 'alert-error');
}

?>
