<?php
if (!isAdmin()) {
    redirect("./");
}
extract($_POST);
switch ($type) {
    case 'user':
        if ($readonly === 'on') {
            $readonly = 1;
        }else {
            $readonly = 0;
        }
        sqlQuery("UPDATE users SET user_firstname='$firstname', user_lastname='$lastname', user_username='$username', user_email='$email', user_isreadonly='$readonly', user_department='$department' WHERE user_id='$userid'");

        $user_name = getUsername($userid);
        alog("Edited user $user_name");

        if ($newpass != '' || $newpass2 != '') {
            if ($newpass == $newpass2) {
                $md5Pass = md5($newpass);
                sqlQuery("UPDATE users SET user_password='$md5Pass' WHERE user_id='$userid'");
                redirect('./', 'User saved');
            }else{
                redirect("./?p=edit&user=$userid&type=user", 'The two passwords you have entered do not match', 'alert-error');
            }
        }else{
            $_SESSION['tab'] = $type;
            redirect('./', 'User saved');
        }
        break;

    case 'resource':
        sqlQuery("UPDATE resources SET resource_type='$resourcetype', resource_details='$details', resource_identifier='$identifier', resource_department='$department' WHERE resource_id='$resource'");

        alog("Edited resource $resource");

        $_SESSION['tab'] = $type;
        redirect('./', 'Resource saved');
        break;

    case 'rType':
        sqlQuery("UPDATE types SET type_name='$name', type_blocktype='$blocktype' WHERE type_id='$typeid'");

        alog("Edited type $typeid");

        $_SESSION['tab'] = 'rType';
        redirect('./', 'Type saved');
        break;

    case 'department':
        sqlQuery("UPDATE departments SET department_name='$name' WHERE department_id='$departmentid'");

        alog("Edited department $departmentid");

        $_SESSION['tab'] = 'department';
        redirect('./', 'Department saved');
        break;

    default:
        redirect('./?p=404');
        break;
}
?>
