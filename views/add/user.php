<div class="span8">
      <form class="form-horizontal" method="post" action="./?action=add">
        <input type="hidden" name="type" value="<?php print $_GET['type'] ?>" />
        <fieldset>
          <legend>Add a user</legend>

          <div class="control-group">
            <label class="control-label" for="firstname">First Name</label>
            <div class="controls">
              <input type="text" class="input-xlarge" name="firstname">
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="lastname">Last Name</label>
            <div class="controls">
              <input type="text" class="input-xlarge" name="lastname">
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="username">Username</label>
            <div class="controls">
              <input type="text" class="input-xlarge" name="username">
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="password">Password</label>
            <div class="controls">
              <input type="password" class="input-xlarge" name="password">
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
