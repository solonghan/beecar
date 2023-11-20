// let allData;
let citySelect = `<option selected disabled value="">請選擇</option>`;
let areaSelect = `<option selected disabled value="">請選擇</option>`;
(function() {
    $.ajax({
        url: baseUrl + 'api/get_citydata',
        type: 'GET',
        dataType: 'json',
        async: false,
        success: function(res) {
            if (res.status) {
                counties(res.data);
                // area(res.data)
                // allData = res.data
            }
        }
    })
})();
function sendCityRequest() {
    let allCity = '';
    $.ajax({
        url: baseUrl + 'api/get_citydata',
        type: 'GET',
        dataType: 'json',
        async: false,
        success: function(res) {
            if (res.status) {
                // area(res.data)
                allCity = res.data
            }
        }
    })
    console.log(allCity);
    return allCity
}
function counties(data) {
    console.log(data);
    let city = [];
    let area;
    let cityActive = '';
    data.forEach((item) => {
        city.push(item.name)
        citySelect += `<option value="${item.name}">${item.name}</option>`
    })
    $('.city_select').html(citySelect)
    $(document).on('change','.city_select', function() {
        let areaSelect = `<option selected disabled value="">請選擇</option>`;
        cityActive = $(this).val();
        let dist = data.filter(data => cityActive === data.name);
        area = dist[0].dist;
        area.forEach((item) => {
            areaSelect += `<option value="${item.name}">${item.name}</option>`
        })
        $(this).closest('.input-wrapper').next().children('.area_select').html(areaSelect)
    })
    // var osel= document.getElementById("startCity"); 
    // var opts= osel.getElementsByTagName("option");
    // console.log(opts[4]);
}

function area(val,location) {
    let allData = sendCityRequest();
    let cityActive = val;
    let endForm = location;
    let area;
    let areaSelect = `<option selected disabled value="">請選擇</option>`;
    let dist = allData.filter(allData => cityActive == allData.name);
    area = dist[0].dist;
    area.forEach((item) => {
        areaSelect += `<option value="${item.name}">${item.name}</option>`
    })
    endForm.parents('.end_form').find('.area_select').html(areaSelect);
}