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
    <input type="text" name="checkoutdate" class="date" /><br />
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
        <table>
        <tr>
            <td><span style="padding-right:5px;">Block 1</span></td>
            <td style="padding-right:5px;"><a href="./?action=reserve" id="11" class="btn">1<sup>st</sup> half</a>
            <td><a href="./?action=reserve" id="12" class="btn">2<sup>nd</sup> half</a>
        </tr>
        <tr>
            <td><span style="padding-right:5px;">Block 2</span>
            <td style="padding-right:5px;"><a href="./?action=reserve" id="21" class="btn">1<sup>st</sup> half</a>
            <td><a href="./?action=reserve" id="22" class="btn">2<sup>nd</sup> half</a>
        </tr>
        <tr>
            <td><span style="padding-right:5px;">Block 3</span>
            <td style="padding-right:5px;"><a href="./?action=reserve" id="31" class="btn">1<sup>st</sup> half</a>
            <td><a href="./?action=reserve" id="32" class="btn">2<sup>nd</sup> half</a>
        </tr>
        <tr>
            <td><span style="padding-right:5px;">Block 4</span>
            <td style="padding-right:5px;"><a href="./?action=reserve" id="41" class="btn">1<sup>st</sup> half</a>
            <td><a href="./?action=reserve" id="42" class="btn">2<sup>nd</sup> half</a>
        </tr>
        </table>
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
            $('.halfblocks').css('display', 'none');
            $('.fullblocks').css('display', 'block');
        }else {
            for ($i = 0; $i < blockArray[1].length; $i++) {
                $('.halfblocks').find('a').each(function (index, value){
                    if (index == $i && blockArray[1][$i] == false) {
                        $(this).addClass('disabled');
                    }
                });
            }
            $('.halfblocks').find('a').each(function (){
                if ($(this).hasClass('disabled')) {
                    $(this).attr('href', "");
                }else {
                    console.log($(this).val());
                    $(this).attr('href', genReserverUrl(type, $(this).attr('id'), date));
                }
            });
            $('.fullblocks').css('display', 'none');
            $('.halfblocks').css('display', 'block');
        }
    });
    $('.blockdiv').css('display', 'block');
});
</script>
