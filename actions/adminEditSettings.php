<?php
if (!isAdmin()) {
    redirect("./");
}
extract($_POST);
switch ($type) {
    case 'user':
        sqlQuery("UPDATE users SET user_firstname='$firstname', user_lastname='$lastname', user_username='$username', user_email='$email' WHERE user_id='$userid'");

        $user_name = getUsername($userid);
        writeLineToLog("$time - Admin - Edited user $user_name");

        if ($newpass != '' || $newpass2 != '') {
            if ($newpass == $newpass2) {
                $md5Pass = md5($newpass);
                sqlQuery("UPDATE users SET user_password='$md5Pass' WHERE user_id='$userid'");
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
        sqlQuery("UPDATE resources SET resource_type='$resourcetype', resource_details='$details', resource_identifier='$identifier', resource_blocktype='$blocktype' WHERE resource_id='$resource'");

        writeLineToLog("$time - Admin - Edited resource $resource");

        $_SESSION['tab'] = $type;
        redirect('./', 'Resource saved');
        break;

    case 'rType':
        sqlQuery("UPDATE types SET type_name='$name' WHERE type_id='$typeid'");

        writeLineToLog("$time - Admin - Edited type $typeid");

        $_SESSION['tab'] = 'rType';
        redirect('./', 'Type saved');
        break;

    default:
        redirect('./?p=404');
        break;
}
?>
