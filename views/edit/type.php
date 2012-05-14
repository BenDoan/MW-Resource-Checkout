<?php
$conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
$sql = "SELECT * FROM types WHERE type_id={$_GET['type']}";
$results = $conn->query($sql);

while($row = $results->fetch_assoc()){
    $type_name = $row['type_name'];
}
?>
<form class="well" method="post" action="./?action=adminEditSettings">
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
