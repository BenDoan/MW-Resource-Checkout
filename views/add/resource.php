<div class="span8">
      <form class="form-horizontal" method="post" action="./?action=add">
        <input type="hidden" name="type" value="<?php print $_GET['type'] ?>" />
        <fieldset>
          <legend>Add a resource</legend>

          <div class="control-group">
            <label class="control-label" for="rType">Type</label>
            <div class="controls">
                <select name="rType">
                	<?php 		
                	$sql = $sql = "SELECT * FROM types";
					$conn= new mysqli('localhost', DB_USERNAME, DB_PASSWORD, DB_NAME);
					$result = $conn->query($sql);
					while($row = $result->fetch_assoc()){
						extract($row);
						echo '<option value="'.$type_name.'">'.$type_name.'</option>';
					}
					?>
                </select>
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="details">Details</label>
            <div class="controls">
              <input type="text" class="input-xlarge" name="details">
              <p class="help-block">eg: 25 computers</p>
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="identifier">Identifier</label>
            <div class="controls">
              <input type="text" class="input-xlarge" name="identifier">
              <p class="help-block">eg: room 123</p>
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="blocktype">Block Type</label>
            <div class="controls">
              <label class="radio">
                <input type="radio" name="blocktype" value="Full" checked="checked" >
                Full Block
              </label>
              <label class="radio">
                <input type="radio" name="blocktype" value="Half" >
                Half Block
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
