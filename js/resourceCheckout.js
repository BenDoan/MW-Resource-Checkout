$(function() {
    $(".alert").alert();
    $('input[name=date]').datepicker({dateFormat: 'mm/dd/yy', beforeShowDay:$.datepicker.noWeekends});
    $('input[name=checkoutdate]').datepicker({
        dateFormat: 'mm/dd/yy',
        beforeShowDay:$.datepicker.noWeekends,
        minDate:0
    });
});
$('.disabled').live("click", function(e){
    e.preventDefault();
});

$('input, textarea').placeholder();
