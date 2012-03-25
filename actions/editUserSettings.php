<?php
extract($_POST);
extract($_SESSION['user']);

$conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);

if (md5($curpass) == $_SESSION['user']['user_password']) {
    $sql = "UPDATE users SET user_firstname='$firstname' WHERE user_id={$_SESSION['user']['user_id']}";
    $results = $conn->query($sql);

    $sql = "UPDATE users SET user_lastname='$lastname' WHERE user_id={$_SESSION['user']['user_id']}";
    $results = $conn->query($sql);
    updateSessionUser();

    if ($newpass != '' || $newpass2 != '') {
        if ($newpass == $newpass2) {
            $md5Pass = md5($newpass);
            $sql = "UPDATE users SET user_password='$md5Pass' WHERE user_id='{$_SESSION['user']['user_id']}'";
            $results = $conn->query($sql);
            redirect('./', 'Settings saved');
        }else{
            redirect('./?p=userSettings', 'The two passwords you have entered do not match', 'alert-error');
        }
    }else{
        redirect('./', 'Settings saved');
    }
}else{
    redirect('./?p=userSettings', 'You did not enter the correct password', 'alert-error');
}
?>
