<?php
//TODO: deal with blocks and half blocks

$date=(isset($_SESSION['GET']['date'])) ? $_SESSION['GET']['date'] : "";
?>
<div class="span8">
      <form class="form-horizontal" method="post" action="./?action=add">
        <input type="hidden" name="type" value="<?php print $_GET['type'] ?>" />
        <fieldset>
          <legend>Add a request</legend>

          <div class="control-group">
            <label class="control-label" for="rtype">Type</label>
            <div class="controls">
              <input type="text" class="input-xlarge" name="rtype">
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="user">User</label>
            <div class="controls">
              <input type="text" class="input-xlarge" name="user">
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
                <input type="radio" name="optionsRadios" value="1" checked="checked" >
                1
                </label>
              <label class="radio">
                <input type="radio" name="optionsRadios" value="2" >
                2
              </label>
              <label class="radio">
                <input type="radio" name="optionsRadios" value="3" >
                3
              </label>
              <label class="radio">
                <input type="radio" name="optionsRadios" value="4" >
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
