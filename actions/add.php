<?php
extract($_POST);

switch ($type) {
    case 'user':
        if ($readonly === 'on') {
            $readonly = 1;
        }else {
            $readonly = 0;
        }
        makeUser($firstname, $lastname, $username, $email, $readonly);
        break;

    case 'resource':
        makeResource($rType, $details, $identifier, $blocktype);
        break;

    case 'request':
        makeRequest($rType, $username, $date, $block);
        break;

    case 'rType':
        makeType($rType);
        break;

    default:
        redirect("./?p=404");
        break;
}
$cap_type = ucfirst($type);
$_SESSION['tab'] = $type;
redirect("./", "$cap_type successfully added");
?>
