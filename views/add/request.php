<?php
//TODO: deal with blocks and half blocks

$date=(isset($_SESSION['GET']['date'])) ? $_SESSION['GET']['date'] : "";
?>

<h1>Add a <?php print $_GET['type']; ?></h1>
<form method="post" action="./?action=add">
    <input type="hidden" name="type" value="<?php print $_GET['type'] ?>" />
    <table>
        <tr>
            <td>Type</td>
            <td><input type="text" name="type" /></td>
        </tr>
        <tr>
            <td>Username</td>
            <td><input type="text" name="username" /></td>
        </tr>
        <tr>
            <td>Date</td>
			<td><input name="date" type="text" value="<?php echo $date;?>" /></td>
        </tr>
        <tr>
            <td>Block</td>
            <td>
                <select name="block">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                </select>
            </td>
        </tr>
    </table>
    <input type="submit" />
    <input type="button" onclick="history.go(-1);" value="Cancel" />
</form>
