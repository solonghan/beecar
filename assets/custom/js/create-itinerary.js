$(function() {
    $('#appointment').datepicker({
        dateFormat: "yy-mm-dd"
    });
});

$(function() {
    for(let i = 0; i < 24; i++) {
        if (i < 10) {
            hrSelect = `<option value ='${i}'>0${i}</option>`;
        } else {
            hrSelect = `<option value ='${i}'>${i}</option>`;
        }
        // hrSelect = `<option value ='${i}'>${i}</option>`;
        $('#reservationHR').append(hrSelect);
    };
    for(let i = 0; i < 60; i++) {
        if (i % 5 === 0) {
            if(i < 10) {
                mnSelect = `<option value ='${i}'>0${i}</option>`;
                $('#reservationMn').append(mnSelect);
            } else {
                mnSelect = `<option value ='${i}'>${i}</option>`;
                $('#reservationMn').append(mnSelect);
            }
        }
    }
});