//filyer datepicker
$(function() {
    var dateFormat = "mm/dd/yy",
      from = $( "#from" ).datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 1
        })
        .on( "change", function() {
          $('#to').attr('value',$('#from').val());
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
  
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
  
      return date;
    }
});


// $('#timepicker,#timepicker1').timepicker({
//     timeFormat: 'HH:mm',
//     interval: 60,
//     minTime: '00',
//     maxTime: '23:00pm',
//     dynamic: false,
//     dropdown: true,
//     scrollbar: true
// });