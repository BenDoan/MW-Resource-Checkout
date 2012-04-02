<?php
if ($_SESSION['user']['user_username'] != ADMIN_USERNAME) {
    redirect('./');
}
extract($_POST);
$conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
$sql = "UPDATE users SET user_firstname='$firstname' WHERE user_id='$userid'";
$results = $conn->query($sql);

$sql = "UPDATE users SET user_lastname='$lastname' WHERE user_id='$userid";
$results = $conn->query($sql);

if ($newpass != '' || $newpass2 != '') {
    if ($newpass == $newpass2) {
        $md5Pass = md5($newpass);
        $sql = "UPDATE users SET user_password='$md5Pass' WHERE user_id='$userid'";
        $results = $conn->query($sql);
        redirect('./', 'Settings saved');
    }else{
        redirect("./?$urlstring", 'The two passwords you have entered do not match', 'alert-error');
    }
}else{
    redirect('./', 'Settings saved');
}
?>
