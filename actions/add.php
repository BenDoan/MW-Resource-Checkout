<?php
if ($_SESSION['user']['user_username'] != ADMIN_USERNAME) {
    redirect('./');
}

extract($_POST);
printArray($_POST);

if ($type == 'user') {
    makeUser($firstname, $lastname, $username, $password);
}elseif ($type == 'resource'){
    makeResource($rType, $details, $identifier, $blocktype);
}elseif ($type == 'request'){
    makeRequest($rType, $username, $date, $block);
}
$cap_type = ucfirst($type);
$_SESSION['tab'] = $type;
redirect("./", "$cap_type successfully added");
?>
