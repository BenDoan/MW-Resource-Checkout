<form class="well" method="post" action="./?action=add">
    <input type="hidden" name="type" value="<?php print $_GET['type'] ?>" />
    First Name<br />
    <input type="text" class="input-xlarge" name="firstname"><br/>
    Last Name<br />
    <input type="text" class="input-xlarge" name="lastname"><br/>
    Username<br />
    <input type="text" class="input-xlarge" name="username"><br/>
    Email<br />
    <input type="text" class="input-xlarge" name="email"><br/>
    Password<br />
    <input type="password" class="input-xlarge" name="password"><br/>

    <button type="submit" class="btn btn-success">Save</button>
    <button type="reset" class="btn" onclick="history.go(-1);">Cancel</button>
</form>
