<h2>Checkout a resource</h2>
<div class="modules">
    <div class="resourcediv attention" style="display:inline-block;">
        <p>Choose a resource</p>
        <select name="resource" class="resource">
            <option></option>
            <?php
                $typesArray = getRTypesArray();
                foreach ($typesArray as $x) {
                    print '<option value="' .$x['type_id'] . '">' . $x['type_name'] . '</option>';
                }
            ?>
        </select>
    </div>
    <div class="datediv attention" style="display:none;">
        <p>Select a date</p>
        <input type="text" name="checkoutdate" class="date" />
    </div>
    <div class="fullblocks attention" style="display:none;">
        <p>Choose the periods</p>
        <a href="./?action=reserve" class="btn">1</a>
        <a href="./?action=reserve" class="btn">2</a>
        <a href="./?action=reserve" class="btn">3</a>
        <a href="./?action=reserve" class="btn">4</a>
    </div>
    <div class="halfblocks attention" style="display:none;">
        <p>Choose the periods</p>
        <table style="display:block;">
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
    $('.datediv').css('display', 'inline-block');
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
            $('.fullblocks').css('display', 'inline-block');
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
            $('.halfblocks').css('display', 'inline-block');
        }
    });
});
</script>
