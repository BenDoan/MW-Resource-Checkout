<?php
$STH = sqlSelect("SELECT * FROM types WHERE type_id={$_GET['type']}");
while($row = $STH->fetch()) {
    $type_name = $row['type_name'];
}
?>
<form class="well" method="post" action="./?action=edit">
    <input type="hidden" name="userid" value="<?php print $_GET['type']; ?>">
    <input type="hidden" name="type" value="type">
    First Name<br />
    <input type="text" class="span3" name="firstname" value="<?php print $firstname; ?>"><br/>

    Last Name<br />
    <input type="text" class="span3" name="lastname" value="<?php print $lastname; ?>"><br/>

    Username<br />
    <input type="text" class="span3" name="username" value="<?php print $username; ?>"><br/>

    New Password<br />
    <input type="password" class="span3" name="newpass" name="newpass" value=""><br/>

    Verify Password<br />
    <input type="password" class="span3" name="newpass2" value=""><br/>

    <button type="submit" class="btn btn-success">Save</button>
    <button type="reset" class="btn" onclick="history.go(-1);">Cancel</button>
</form>
<div class="clear"></div>
