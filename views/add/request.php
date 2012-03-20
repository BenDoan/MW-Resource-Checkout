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
<?php
//TODO: deal with blocks and half blocks

$date = date('m-d-Y');
?>
<div class="span8">
      <form class="form-horizontal" method="post" action="./?action=add">
        <input type="hidden" name="type" value="<?php print $_GET['type'] ?>" />
        <fieldset>
          <legend>Add a request</legend>
          <div class="control-group">
            <label class="control-label" for="rtype">Resource</label>
            <div class="controls">
                <select name="rtype">
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
                </select>
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="user">User</label>
            <div class="controls">
            <input id="user" name="username" data-provide="typeahead" />
              <p class="help-block">Start typing for suggestions</p>

            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="date">Date</label>
            <div class="controls">
                <input type="text" class="input-xlarge" name="date" value="<?php echo $date;?>">
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="block">Block</label>
            <div class="controls">
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
            </div>
          </div>

          <div class="form-actions">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn" onclick="history.go(-1);">Cancel</button>
          </div>
        </fieldset>
      </form>
    </div>
<div class="clear"></div>
