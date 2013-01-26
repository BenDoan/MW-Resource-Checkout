// vim: ft=javascript

var date = "";
var type = "";
var resourceTriggered = false;
var dateTriggered = false;
function genReserveUrl(rType, block, date) {
    return "./?action=reserve&rType=" + rType + "&block=" + block + "&date=" + date;
}

function createCheckoutAlert(checkoutData, alert_type){
    var alertText = '<div class="alert alert-' + alert_type + ' ' + checkoutData[0] + '"><a class="close" data-dismiss="alert">&times;</a>' + checkoutData[1];
    alertText += '<a style="float:right;" class="btn btn-mini btn-danger cancel-link" href="./?action=cancelRequest&request=' + checkoutData[0] + '">Cancel</a>';
    if (checkoutData[2].length > 1) {
        alertText += '<span class="dropdown" style="float:right;margin-right:5px;"><a class="dropdown-toggle btn btn-mini btn-inverse" style="color:white;" data-toggle="dropdown" href="#">Change Resource<span class="caret"></span></a><ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">';
        checkoutData[2].forEach(function(resource, index){
                alertText += '<li><a tabindex="-1" href="./?action=changeReserve&resource=' + resource[1] + '&date=' + date + '&block=' + checkoutData[3] + '&rType=' + type + '&cancelId=' + checkoutData[0] + '" class="change-link" >' + resource[0] + '</a></li>';
        });
        alertText += '</ul></span>';
    }
    alertText += '</div>';
    $('#checkout-alerts').append(alertText);
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
            showBlocks();
        });
    });

    $('.change-link').live("click", function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
            url: url,
            cache: false
        }).done(function(html) {
            var checkoutData = $.parseJSON(html);
            createCheckoutAlert(checkoutData, 'info');
            $('.' + checkoutData[4]).remove();
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
            createCheckoutAlert(checkoutData, 'success');
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
