<?php
//adds users to typeahead user list
$conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
$sql = "SELECT * FROM users";
$results = $conn->query($sql);

$data_source = "[";
while($row = $results->fetch_assoc()){
    extract($row);
    $data_source .= "\"$user_username\",";
}
$data_source .= "\"asda\"]";
?>

<script type="text/javascript">
jQuery(document).ready(function() {
    var alCities = <?php print $data_source?>.sort();
            $('#user').typeahead({source: alCities, items:5});
        });
</script>

<form class="well" method="post" action="./?action=add">
    <input type="hidden" name="type" value="<?php print $_GET['type'] ?>" />
    Resource<br />
    <select name="rType">
        <?php
            //prints out resource types
            $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
            $sql = "SELECT * FROM resources";
            $results = $conn->query($sql);

            while($row = $results->fetch_assoc()){
                extract($row);
                print "<option value=\"$resource_id\">$resource_identifier</option>";
            }
        ?>
    </select><br />
    User<br />
    <input id="user" name="username" data-provide="typeahead" />
    <p class="help-block">Start typing for suggestions</p>
    Date<br />
    <input type="text" name="date"><br />
    Block<br />
    <label class="radio">
    <input type="radio" name="block" value="1" checked="checked" >
    1
    </label>
    <label class="radio">
    <input type="radio" name="block" value="2" >
    2
    </label>
    <label class="radio">
    <input type="radio" name="block" value="3" >
    3
    </label>
    <label class="radio">
    <input type="radio" name="block" value="4" >
    4
    </label>

    <button type="submit" class="btn btn-success">Save</button>
    <button type="reset" class="btn" onclick="history.go(-1);">Cancel</button>
</form>
