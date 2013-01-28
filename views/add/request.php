<?php
//adds users to typeahead user list
$data_source = "[";
$STH = sqlSelect("SELECT * FROM users");
while($row = $STH->fetch()) {
extract($row);
$data_source .= "\"$user_username\",";
}
$data_source .= "\"\"]";
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
<select name="resource" id="resource" onChange="updateBlocks()">
    <?php
        //prints out resource types
        $STH = sqlSelect("SELECT * FROM resources");

        while($row = $STH->fetch()) {
            extract($row);
            $blocktype = getResourceBlockType($resource_id);
            print "<option value=\"$resource_id\" class=\"$blocktype\">$resource_identifier</option>";
        }
    ?>
</select><br />
User<br />
<input type="text" id="user" name="username" data-provide="typeahead" autocomplete="off" />
<p class="help-block">Start typing for suggestions</p>
Date<br />
<input type="text" name="checkoutdate"><br />
Block<br />
<div id="blocks"></div>

<button type="submit" class="btn btn-success">Save</button>
<button type="reset" class="btn" onclick="history.go(-1);">Cancel</button>
</form>
<script type="text/javascript">
var num_blocks = <?php print NUM_BLOCKS?>;
var half = "";
for (var i = 0; i < num_blocks; i++) {
    if (i == 0) {var checked = 'checked="checked"'} else {var checked = ''}
    half += '<label class="radio"><input type="radio" name="block" value="' + (i+1) + '1" ' + checked + ' >Block ' + (i+1) + ' first half</label>';
    half += '<label class="radio"><input type="radio" name="block" value="' + (i+1) + '2" >Block ' + (i+1) + ' second half</label>';
}
var full = "";
for (var i = 0; i < num_blocks; i++) {
    if (i == 0) {var checked = 'checked="checked"'} else {var checked = ''}
    full += '<label class="radio"><input type="radio" name="block" value="' + (i+2) + '" ' + checked + '">Block ' + (i+1) + '</label>';
}

function updateBlocks(){
    if (document.getElementById("resource").options[document.getElementById("resource").selectedIndex].className === "half" ) {
        $('#blocks').html(half);
    }else{
        $('#blocks').html(full);
    }
}
updateBlocks();
</script>
