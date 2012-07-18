<?php
$STH = sqlSelect("SELECT * FROM users WHERE user_id={$_GET['user']}");
while($row = $STH->fetch()) {
    $firstname = $row['user_firstname'];
    $lastname = $row['user_lastname'];
    $username = $row['user_username'];
    $email = $row['user_email'];
}
?>
<form class="well" method="post" action="./?action=adminEditSettings">
    <input type="hidden" name="userid" value="<?php print $_GET['user']; ?>">
    <input type="hidden" name="type" value="user">
    First Name<br />
    <input type="text" class="span3" name="firstname" value="<?php print $firstname; ?>"><br/>

    Last Name<br />
    <input type="text" class="span3" name="lastname" value="<?php print $lastname; ?>"><br/>

    Username<br />
    <input type="text" class="span3" name="username" value="<?php print $username; ?>"><br/>

    Email<br />
    <input type="text" class="span3" name="email" value="<?php print $email; ?>"><br/>

    New Password<br />
    <input type="password" class="span3" name="newpass" name="newpass" value=""><br/>

    Verify Password<br />
    <input type="password" class="span3" name="newpass2" value=""><br/>

    <button type="submit" class="btn btn-success">Save</button>
    <button type="reset" class="btn" onclick="history.go(-1);">Cancel</button>
</form>
<div class="clear"></div>
