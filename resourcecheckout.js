$(function() {
    initCalendar();
    $('input[name=date]').datepicker({dateFormat: 'mm/dd/yy'});
});

$(function() {
    $( "#accordion" ).accordion();
});

function initCalendar() {
    var date = new Date();

    // When a day on the calender is clicked, send the page to the search page with the date in the url
    $('#calendar').fullCalendar({
        editable: true,
        weekends: false,
        dayClick: function(dateClicked, allDay, jsEvent, view) {
            var date = new Date(dateClicked);
            var d = date.getDate();
            var m = date.getMonth() + 1;
            var y = date.getFullYear();

            window.location = './?p=resultList&date=' + m + '/' + d + '/' + y;		
        }
    });
}
