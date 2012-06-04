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
$data_source .= "\"\"]";
$conn->close();
?>

<script type="text/javascript">
jQuery(document).ready(function() {
    var users = <?php print $data_source?>.sort();
            $('#user').typeahead({source: users, items:5});
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
    <input type="radio" name="block" value="11" checked="checked" >
    1 (first half)
    </label>
    <label class="radio">
    <input type="radio" name="block" value="12" checked="checked" >
    1 (second half)
    </label>
    <label class="radio">
    <input type="radio" name="block" value="2" >
    2
    </label>
    <label class="radio">
    <input type="radio" name="block" value="21" >
    2 (first half)
    </label>
    <label class="radio">
    <input type="radio" name="block" value="22" >
    2 (second half)
    </label>
    <label class="radio">
    <input type="radio" name="block" value="3" >
    3
    </label>
    <label class="radio">
    <input type="radio" name="block" value="31" >
    3 (first half)
    </label>
    <label class="radio">
    <input type="radio" name="block" value="32" >
    3 (second half)
    </label>
    <label class="radio">
    <input type="radio" name="block" value="4" >
    4
    </label>
    <label class="radio">
    <input type="radio" name="block" value="41" >
    4 (first half)
    </label>
    <label class="radio">
    <input type="radio" name="block" value="42" >
    4 (second half)
    </label>

    <button type="submit" class="btn btn-success">Save</button>
    <button type="reset" class="btn" onclick="history.go(-1);">Cancel</button>
</form>
