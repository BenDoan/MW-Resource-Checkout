<?php
$conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
$sql = "SELECT * FROM resources WHERE resource_id={$_GET['resource']}";
$results = $conn->query($sql);

$type = "";
$details = "";
$identifier = "";
$blocktype = "";
while($row = $results->fetch_assoc()){
    $type = $row['resource_type'];
    $details = $row['resource_details'];
    $identifier = $row['resource_identifier'];
    $blocktype = $row['resource_blocktype'];
}
?>
<form class="well" method="post" action="./?action=adminEditUserSettings">
    <input type="hidden" name="resource" value="<?php print $_GET['resource']; ?>">
    <input type="hidden" name="urlstring" value="p=edit&resource=<?php print $_GET['resource']; ?>&type=resource">
    Type<br />
    <select>
        <option value="Computer Lab">Computer Lab</option>
        <option value="Laptop Cart">Laptop Cart</option>
        <option value="Candy">Candy</option>
    </select><br />

    Details<br />
    <input type="text" class="span3" name="lastname" value="<?php print $lastname; ?>"><br/>

    Identifier<br />
    <input type="password" class="span3" name="newpass" name="newpass" value=""><br/>

    Block Type<br />
    <input type="password" class="span3" name="newpass2" value=""><br/>

    <button type="submit" class="btn btn-success">Save</button>
    <button type="reset" class="btn" onclick="history.go(-1);">Cancel</button>
</form>
<div class="clear"></div>
