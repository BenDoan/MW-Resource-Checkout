<?php
if ($_SESSION['user']['user_username'] != ADMIN_USERNAME) {
    redirect('./');
}
$time = date('m/d/Y G:h');
extract($_POST);
printArray($_POST);
$conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);

switch ($type) {
    case 'user':
        $sql = "UPDATE users SET user_firstname='$firstname' WHERE user_id='$userid'";
        $conn->query($sql);

        $sql = "UPDATE users SET user_lastname='$lastname' WHERE user_id='$userid'";
        $conn->query($sql);

        $sql = "UPDATE users SET user_username='$username' WHERE user_id='$userid'";
        $conn->query($sql);

        $user_name = getUsername($userid);
        writeLineToLog("$time - Admin - Edited user $user_name");

        if ($newpass != '' || $newpass2 != '') {
            if ($newpass == $newpass2) {
                $md5Pass = md5($newpass);
                $sql = "UPDATE users SET user_password='$md5Pass' WHERE user_id='$userid'";
                $results = $conn->query($sql);
                redirect('./', 'Settings saved');
            }else{
                redirect("./?p=edit&user=$userid&type=user", 'The two passwords you have entered do not match', 'alert-error');
            }
        }else{
            $_SESSION['tab'] = $type;
            redirect('./', 'Settings saved');
        }
        break;

    case 'resource':
        $sql = "UPDATE resources SET resource_type='$resourcetype', resource_details='$details', resource_identifier='$identifier', resource_blocktype='$blocktype' WHERE resource_id='$resource'";
        $results = $conn->query($sql);

        $resource_name = getResourceDesc($resource);
        writeLineToLog("$time - Admin - Edited resource $resource_name");

        $_SESSION['tab'] = $type;
        redirect('./', 'Resource saved');
        break;

    default:
        // code...
        break;
}
$conn->close();
?>
