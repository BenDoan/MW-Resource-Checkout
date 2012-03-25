<?php
extract($_POST);
extract($_SESSION['user']);

$conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);

if (md5($curpass) == $_SESSION['user']['user_password']) {
    if ($firstname != $user_firstname) {
        $sql = "UPDATE users SET user_firstname='$firstname' WHERE user_id={$_SESSION['user']['user_id']}";
        $results = $conn->query($sql);
    }

    if ($lastname != $user_lastname) {
        $sql = "UPDATE users SET user_lastname='$lastname' WHERE user_id={$_SESSION['user']['user_id']}";
        $results = $conn->query($sql);
    }

    if ($newpass != '' && $newpass2 != '' && $newpass == $newpass2) {
        $md5Pass = md5($newpass);
        $sql = "UPDATE users SET user_password='$md5Pass' WHERE user_id='{$_SESSION['user']['user_id']}'";
        $results = $conn->query($sql);
    }else{
        redirect('./?p=userSettings', 'The two passwords you have entered do not match', 'alert-error');
    }
    updateSessionUser();
    redirect('./', 'Settings saved');
}else{
    redirect('./?p=userSettings', 'You did not enter the correct password', 'alert-error');
}
?>
