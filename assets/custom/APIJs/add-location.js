let submit = function() {
    let token = localStorage.getItem('token');
    let city = $('.city_select').val();
    let dist = $('.area_select').val();
    let address = $('.address').val().trim();
    let data = {};
    data.token = token;
    data.city = city;
    data.dist = dist;
    data.address = address;
    $.ajax({
        url: baseUrl + 'api/add_address',
        type: 'POST',
        dataType: 'json',
        data: data,
        success: function(res) {
            if(res.status) {
                location.href="frequently-used-locations"
            } else {
                if(res.token_status == false){
                    alert(res.msg);
                    localStorage.clear();
                    location.href = '../home/login'
                }
            }
        }
    })
}