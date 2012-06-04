<?php
extract($_POST);

switch ($type) {
    case 'user':
        makeUser($firstname, $lastname, $username, $email, $password);
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
        // code...
        break;
}
$cap_type = ucfirst($type);
$_SESSION['tab'] = $type;
redirect("./", "$cap_type successfully added");
?>
