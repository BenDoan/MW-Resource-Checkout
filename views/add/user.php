<h1>Add a <?php print $_GET['type']; ?></h1>
<form method="post" action="./?action=add">
    <input type="hidden" name="type" value="<?php print $_GET['type'] ?>" />
    <table>
        <tr>
            <td>First Name</td>
            <td><input type="text" name="firstname" /></td>
        </tr>
        <tr>
            <td>Last Name</td>
            <td><input type="text" name="lastname" /></td>
        </tr>
        <tr>
            <td>Username</td>
            <td><input type="text" name="username" /></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" name="password" /></td>
        </tr>
    </table>
    <input type="submit" />
    <input type="button" onclick="history.go(-1);" value="Cancel" />
</form>
