$('#timepicker .time').timepicker({
    'showDuration': false,
    'step': 10,
    'timeFormat': 'G:i'
});
$('#timepicker').datepair({
    parseDate: function(input) {
        return $(input).datepicker('getDate');
    },
    updateDate: function(input, dateObj) {
        $(input).datepicker('setDate', dateObj);
    }
});



