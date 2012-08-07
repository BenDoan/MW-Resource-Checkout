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
<select name="rType" id="rType" onChange="updateBlocks()">
    <?php
        //prints out resource types
        $STH = sqlSelect("SELECT * FROM resources");

        while($row = $STH->fetch()) {
            extract($row);
            $blocktype = getResourceBlockType($resource_id);
            print "<option value=\"$resource_id\" class=\"$resource_blocktype\">$resource_identifier</option>";
        }
    ?>
</select><br />
User<br />
<input id="user" name="username" data-provide="typeahead" />
<p class="help-block">Start typing for suggestions</p>
Date<br />
<input type="text" name="date"><br />
Block<br />
<div id="blocks"></div>

<button type="submit" class="btn btn-success">Save</button>
<button type="reset" class="btn" onclick="history.go(-1);">Cancel</button>
</form>
<script type="text/javascript">
$half =
    ['<label class="radio">',
    '<input type="radio" name="block" value="11" checked="checked" >',
    'Block 1 first half',
    '</label>',

    '<label class="radio">',
    '<input type="radio" name="block" value="12" checked="checked" >',
    'Block 1 second half',
    '</label>',

    '<label class="radio">',
    '<input type="radio" name="block" value="21" checked="checked" >',
    'Block 2 first half',
    '</label>',

    '<label class="radio">',
    '<input type="radio" name="block" value="22" checked="checked" >',
    'Block 2 second half',
    '</label>',

    '<label class="radio">',
    '<input type="radio" name="block" value="31" checked="checked" >',
    'Block 3 first half',
    '</label>',

    '<label class="radio">',
    '<input type="radio" name="block" value="32" checked="checked" >',
    'Block 3 second half',
    '</label>',

    '<label class="radio">',
    '<input type="radio" name="block" value="41" checked="checked" >',
    'Block 4 first half',
    '</label>',

    '<label class="radio">',
    '<input type="radio" name="block" value="42" checked="checked" >',
    'Block 4 second half',
    '</label>'].join('\n');

$full =
    ['<label class="radio">',
    '<input type="radio" name="block" value="1" checked="checked" >',
    'Block 1',
    '</label>',

    '<label class="radio">',
    '<input type="radio" name="block" value="2" checked="checked" >',
    'Block 2',
    '</label>',

    '<label class="radio">',
    '<input type="radio" name="block" value="3" checked="checked" >',
    'Block 3',
    '</label>',

    '<label class="radio">',
    '<input type="radio" name="block" value="4" checked="checked" >',
    'Block 4',
    '</label>'].join('\n');

function updateBlocks(){
    if (document.getElementById("rType").options[document.getElementById("rType").selectedIndex].className === "Half" ) {
        $('#blocks').html($half);
    }else{
        $('#blocks').html($full);
    }
}
updateBlocks();
</script>
