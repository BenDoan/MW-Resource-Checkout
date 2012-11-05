<h2>Checkout a resource</h2>
<br />Choose a resource<br />
<select name="resource" class="resource">
    <option></option>
    <?php
        $typesArray = getRTypesArray();
        foreach ($typesArray as $x) {
            print '<option value="' .$x['type_id'] . '">' . $x['type_name'] . '</option>';
        }
    ?>
</select><br />
<div class="datediv" style="display:none;">
    <br />Select a date<br />
    <input type="text" name="date" class="date" /><br />
</div>
<div class="blockdiv" style="display:none;">
    <br />Choose the periods<br />
    <div class="btn-group fullblocks" style="display:none;">
        <a href="./?action=reserve" class="btn">1</a>
        <a href="./?action=reserve" class="btn">2</a>
        <a href="./?action=reserve" class="btn">3</a>
        <a href="./?action=reserve" class="btn">4</a>
    </div>
    <div class="btn-group halfblocks" style="display:none;">
        <a href="./?action=reserve" class="btn">1 1<sup>st</sup> half</a>
        <a href="./?action=reserve" class="btn">1 2<sup>nd</sup> half</a>
        <a href="./?action=reserve" class="btn">2 1<sup>st</sup> half</a>
        <a href="./?action=reserve" class="btn">2 2<sup>nd</sup> half</a>
        <a href="./?action=reserve" class="btn">3 1<sup>st</sup> half</a>
        <a href="./?action=reserve" class="btn">3 2<sup>nd</sup> half</a>
        <a href="./?action=reserve" class="btn">4 1<sup>st</sup> half</a>
        <a href="./?action=reserve" class="btn">4 2<sup>nd</sup> half</a>
    </div>
</div>
<script type="text/javascript">
var date = "";
var type = "";
function genReserverUrl(rType, block, date) {
    return "./?action=reserve&rType=" + rType + "&block=" + block + "&date=" + date;
}

$('.resource').change(function() {
    $('.datediv').css('display', 'block');
    type = $('.resource :selected').val();
});

$('.date').change(function() {
    date = $('.datediv :input').val();
    date = $.datepicker.formatDate('yy-mm-dd', new Date(date));
    $.ajax({
        url: "./?action=checkAvailability&date=" + date + "&type=" + type,
        cache: false
    }).done(function(html) {
        var blockArray = $.parseJSON(html);
        if (blockArray[0] == 'full') {
            for ($i = 0; $i < blockArray[1].length; $i++) {
                $('.fullblocks').children('a').each(function (){
                    if ($(this).text() == ($i + 1) && blockArray[1][$i] == false) {
                        $(this).addClass('disabled');
                    }
                });
            }
            $('.fullblocks').children('a').each(function (){
                if ($(this).hasClass('disabled')) {
                    $(this).attr('href', "");
                }else {
                    $(this).attr('href', genReserverUrl(type, $(this).text(), date));
                }
            });
        }else {
            for ($i = 0; $i < blockArray[1].length; $i++) {
                $('.blocks').children('a').each(function (){
                    if ($(this).text() == ($i + 1) && blockArray[1][$i] == false) {
                        $(this).addClass('disabled');
                    }
                });
            }
            $('.blocks').children('a').each(function (){
                if ($(this).hasClass('disabled')) {
                    $(this).attr('href', "");
                }else {
                    $(this).attr('href', genReserverUrl(type, $(this).text(), date));
                }
            });

        }
    });
    $('.blockdiv').css('display', 'block');
});
</script>
