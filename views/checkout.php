<div class="checkout-alerts"></div>
<h2>Checkout a resource</h2>
<div class="modules well">
    <div class="resourcediv attention" style="display:inline-block;">
        <p><i class="icon-ok resource-ok" style="display:none;"></i>Choose a resource</p>
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
        <p><i class="icon-ok date-ok" style="display:none;"></i>Select a date</p>
        
        <input type="text" name="checkoutdate" class="date" />
    </div>
    <div class="fullblocks attention" style="display:none;">
        <p>Choose the periods</p>
        <a href="./?action=reserve" class="btn reserve-link">1</a>
        <a href="./?action=reserve" class="btn reserve-link">2</a>
        <a href="./?action=reserve" class="btn reserve-link">3</a>
        <a href="./?action=reserve" class="btn reserve-link">4</a>
    </div>
    <div class="halfblocks attention" style="display:none;">
        <p>Choose the periods</p>
        <input type="" style="visibility:hidden"/>
        <table>
            <tr>
                <td><span style="padding-right:5px;">Block 1</span></td>
                <td style="padding-right:5px;"><a href="./?action=reserve" id="11" class="btn reserve-link">1<sup>st</sup> half</a>
                <td><a href="./?action=reserve" id="12" class="btn reserve-link">2<sup>nd</sup> half</a>
            </tr>
            <tr>
                <td><span style="padding-right:5px;">Block 2</span>
                <td style="padding-right:5px;"><a href="./?action=reserve" id="21" class="btn reserve-link">1<sup>st</sup> half</a>
                <td><a href="./?action=reserve" id="22" class="btn reserve-link">2<sup>nd</sup> half</a>
            </tr>
            <tr>
                <td><span style="padding-right:5px;">Block 3</span>
                <td style="padding-right:5px;"><a href="./?action=reserve" id="31" class="btn reserve-link">1<sup>st</sup> half</a>
                <td><a href="./?action=reserve" id="32" class="btn reserve-link">2<sup>nd</sup> half</a>
            </tr>
            <tr>
                <td><span style="padding-right:5px;">Block 4</span>
                <td style="padding-right:5px;"><a href="./?action=reserve" id="41" class="btn reserve-link">1<sup>st</sup> half</a>
                <td><a href="./?action=reserve" id="42" class="btn reserve-link">2<sup>nd</sup> half</a>
            </tr>
        </table>
    </div>
</div>
<script type="text/javascript">
var date = "";
var type = "";
var resourceTriggered = false;
var dateTriggered = false;
function genReserveUrl(rType, block, date) {
    return "./?action=reserve&rType=" + rType + "&block=" + block + "&date=" + date;
}

function showBlocks(){
    if (!(resourceTriggered && dateTriggered)) {
        return 0;
    }
    $.ajax({
        url: "./?action=checkAvailability&date=" + date + "&type=" + type,
        cache: false
    }).done(function(html) {
        var blockArray = $.parseJSON(html);
        $('.halfblocks').find('a').each(function (){
            if ($(this).hasClass('disabled')){
                $(this).removeClass('disabled');
            }
        });
        $('.fullblocks').children('a').each(function (){
            if ($(this).hasClass('disabled')){
                $(this).removeClass('disabled');
            }
        });
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
                    $(this).attr('href', genReserveUrl(type, $(this).text(), date));
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
                    $(this).attr('href', genReserveUrl(type, $(this).attr('id'), date));
                }
            });
            $('.fullblocks').css('display', 'none');
            $('.halfblocks').css('display', 'inline-block');
        }
    });
}

$(function(){
    $('.cancel-link').live("click", function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
            url: url,
            cache: false
        }).done(function(html) {
            var resource = $.parseJSON(html);
            $('.' + resource).remove();
        });
    });
    $('.reserve-link').click(function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
            url: url,
            cache: false
        }).done(function(html) {
            var checkoutData = $.parseJSON(html);
            var alertText = '<div class="alert alert-success ' + checkoutData[0] + '"><a class="close" data-dismiss="alert">&times;</a>' + checkoutData[1] + '<a style="float:right;" class="btn btn-mini btn-danger cancel-link" href="./?action=cancelRequest&request=' + checkoutData[0] +'">Cancel</a></div>';
            $('.checkout-alerts').append(alertText);
        });
        $(this).addClass('disabled');
    });
});

$('.resource').change(function() {
    resourceTriggered = true;
    $('.resourcediv').removeClass('attention');
    $('.resource-ok').css('display', 'inline-block');
    $('.datediv').css('display', 'inline-block');
    type = $('.resource :selected').val();
    showBlocks();
});

$('.date').change(function() {
    dateTriggered = true;
    $('.datediv').removeClass('attention');
    $('.date-ok').css('display', 'inline-block');
    date = $('.datediv :input').val();
    date = $.datepicker.formatDate('yy-mm-dd', new Date(date));
    showBlocks();
});

function dateFilled(getDate){
    $('.date').val(getDate);
    $('.datediv').css('display', 'inline-block');
    $('.datediv').removeClass('attention');
    $('.date-ok').css('display', 'inline-block');
    date = getDate;
    date = $.datepicker.formatDate('yy-mm-dd', new Date(date));
    dateTriggered = true;
}
<?php
    if (isset($_GET['date'])) {
        $date = $_GET['date'];
        print "dateFilled('$date')";
    }
?>
</script>
