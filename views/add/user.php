<div class="alert alert-info">
    <a class="close" data-dismiss="alert">&times;</a>
    <h4>This form will create a new user and email them their login information.</h4>
</div>

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
    read only
    <input type="checkbox" name="readonly" /><br />

    <button type="submit" class="btn btn-success">Save</button>
    <button type="reset" class="btn" onclick="history.go(-1);">Cancel</button>
</form>
