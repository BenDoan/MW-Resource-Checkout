<style type="text/css">
#nav ul {
    display:none;
}
</style>
<h3>Enter your user name to reset your password, a new password will be emailed to you</h3>
<form class="well" style="display:inline-block" action="./?action=resetPassword" method="post" >
    <input type="text" name="username" placeholder="username" />
    <input class="btn btn-primary" type="submit" />
    <input type="reset" value="Cancel" class="btn" onclick="history.go(-1);">
</form>
