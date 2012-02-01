<h1>Add a <?php print $_GET['type']; ?></h1>
<form method="post" action="./?action=add">
    <input type="hidden" name="type" value="<?php print $_GET['type'] ?>" />
    <table>
        <tr>
            <td>Type</td>
            <td><input type="text" name="type" /></td>
        </tr>
        <tr>
            <td>Details (eg: 25 computers)</td>
            <td><input type="text" name="details" /></td>
        </tr>
        <tr>
            <td>Identifier (eg: room 123)</td>
            <td><input type="text" name="identifier" /></td>
        </tr>
        <tr>
            <td>Block Type</td>
            <td>
                <select name="blocktype">
                  <option value="full">Full</option>
                  <option value="half">Half</option>
                </select>
            </td>
        </tr>
    </table>
    <input type="submit" />
    <input type="button" onclick="history.go(-1);" value="Cancel" />
</form>
