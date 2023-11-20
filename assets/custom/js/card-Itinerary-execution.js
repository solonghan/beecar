$('.card-Itinerary-execution').click(function(e){
    let val = e.target.nodeName;
    if (val !== 'SPAN') {
        window.location.href = 'Itinerary-execution';
    }
})