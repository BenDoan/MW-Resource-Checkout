<?php
if ($_SESSION['user']['user_username'] != ADMIN_USERNAME) {
    redirect('./');
}

extract($_POST);

switch ($type) {
    case 'user':
        makeUser($firstname, $lastname, $username, $password);
        break;

    case 'resource':
        makeResource($rType, $details, $identifier, $blocktype);
        break;

    case 'request':
        makeRequest($rType, $username, $date, $block);
        break;

    case 'type':
        makeType($rType);
        break;

    default:
        // code...
        break;
}
$cap_type = ucfirst($type);
$_SESSION['tab'] = $type;
redirect("./", "$cap_type successfully added");
?>
