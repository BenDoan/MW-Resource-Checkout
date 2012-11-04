<?php
$STH = sqlSelect("SELECT * FROM users WHERE user_id={$_GET['user']}");
while($row = $STH->fetch()) {
    extract($row);
}
?>
<form class="well" method="post" action="./?action=edit">
    <input type="hidden" name="userid" value="<?php print $_GET['user']; ?>">
    <input type="hidden" name="type" value="user">
    First Name<br />
    <input type="text" class="span3" name="firstname" value="<?php print $user_firstname; ?>"><br/>

    Last Name<br />
    <input type="text" class="span3" name="lastname" value="<?php print $user_lastname; ?>"><br/>

    Username<br />
    <input type="text" class="span3" name="username" value="<?php print $user_username; ?>"><br/>

    Email<br />
    <input type="text" class="span3" name="email" value="<?php print $user_email; ?>"><br/>

    Department<br />
    <select name="department" id="department" >
        <?php
            //prints out resource types
            $STH = sqlSelect("SELECT * FROM departments");

            while($row = $STH->fetch()) {
                extract($row);
                if ($department_id == $user_department) {
                    print "<option selected=\"selected\"value=\"$department_id\">$department_name</option>";
                }else {
                    print "<option value=\"$department_id\">$department_name</option>";
                }
            }
        ?>
    </select><br />

    New Password<br />
    <input type="password" class="span3" name="newpass" name="newpass" value=""><br/>

    Verify Password<br />
    <input type="password" class="span3" name="newpass2" value=""><br/>


    Read only
    <?php
        if ($user_isreadonly) {
            print '<input type="checkbox" checked="checked" name="readonly" /><br />';
        }else{
            print '<input type="checkbox" name="readonly" /><br />';
        }
    ?>

    <button type="submit" class="btn btn-success">Save</button>
    <button type="reset" class="btn" onclick="history.go(-1);">Cancel</button>
</form>
<div class="clear"></div>
