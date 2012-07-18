<?php
$STH = sqlSelect("SELECT * FROM users WHERE user_id={$_SESSION['user']['user_id']}");
$firstname = "";
$lastname = "";
$email = "";
while($row = $STH->fetch()) {
    $firstname = $row['user_firstname'];
    $lastname = $row['user_lastname'];
    $email = $row['user_email'];
}
?>
<form class="well" method="post" action="./?action=editUserSettings">
    Current Password (required)<br />
    <input type="password" class="span3" name="curpass" value=""><br/><br/>

    First Name<br />
    <input type="text" class="span3" name="firstname" value="<?php print $firstname; ?>"><br/>

    Last Name<br />
    <input type="text" class="span3" name="lastname" value="<?php print $lastname; ?>"><br/>

    Email<br />
    <input type="text" class="span3" name="email" value="<?php print $email; ?>"><br/>

    New Password<br />
    <input type="password" class="span3" name="newpass" name="newpass" value=""><br/>

    Verify Password<br />
    <input type="password" class="span3" name="newpass2" value=""><br/>

    <button type="submit" class="btn btn-success">Save</button>
</form>
<div class="clear"></div>
