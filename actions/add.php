<?php
extract($_POST);

switch ($type) {
    case 'user':
        if (isset($readonly) && $readonly === 'on') {
            $readonly = 1;
        }else {
            $readonly = 0;
        }
        makeUser($firstname, $lastname, $username, $email, $department, $readonly);
        break;

    case 'resource':
        makeResource($rType, $details, $identifier, $department);
        break;

    case 'request':
        makeRequest($resource, $username, $checkoutdate, $block);
        break;

    case 'rType':
        makeType($rType, $blocktype);
        break;

    case 'department':
        print $department;
        makeDepartment($department);
        break;

    default:
        redirect("./?p=404");
        break;
}
$cap_type = ucfirst($type);
$_SESSION['tab'] = $type;
redirect("./", "$cap_type successfully added");
?>
