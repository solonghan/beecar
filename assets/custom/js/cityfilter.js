let url = 'https://beecar.anbon.vip/'
function sendRequest(modalType) {
    $.ajax({
        url: url + 'api/get_citydata',
        type: 'GET',
        async: false,
        dataType: 'json',
        success: function(res){
            if (res.status) {
                rendor(modalType,res.data)
            }
        },
    })
}
function rendor(modalType,data) {
    console.log(modalType);
    // console.log(data);
    let str = '';
    for (let i = 0; i < data.length; i++) {
        str += 
        `
        <li class="multi-level city_list">
            <a href="#" class="item checkBox_header" data-citydropdown="${data[i].name}">
                <div class="custom-control custom-checkbox checkBox">
                    <input type="checkbox" class="custom-control-input city-check" data-type="${modalType}" id="${ modalType  + 'city' + (i + 1)}" name="city" data-county="${i}" value="${data[i].name}">
                    <label class="custom-control-label" for="${modalType  + 'city' + (i + 1)}">${data[i].name}</label>
                </div>
            </a>
            <!-- sub menu -->
            <ul class="listview simple-listview dist_list">
                ${distList(data[i].name,data[i].dist,modalType)}
            </ul>
            <!-- * sub menu -->
        </li>
        `
    }
    $(`#${modalType} .city_filter`).append(str)
}
function distList(name,data,modalType) {
    // console.log(name,data);
    let str = '';
    for(let i = 0; i < data.length; i++) {
        str += 
        `
        <li class="distList">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input dist" data-type="${modalType}" data-city="${name}" data-dist="${data[i].name}" id="${modalType + data[i].c3}" name="dist" data-county="${data[i].c3}" value="${name} ${data[i].name}">
                <label class="custom-control-label" for="${modalType + data[i].c3}">${data[i].name}</label>
            </div>
        </li>
        `
    }
    return str
}
$(document).on('click','.checkBox_header',function(e) {
    if (e.target.nodeName == 'LABEL' || e.target.nodeName == 'INPUT') {return}
    e.preventDefault();
    if ($(this).parent(".multi-level").hasClass("active")) {
        $(this).next("ul").slideToggle(250);
        $(this).parent(".multi-level").removeClass("active");
    }
    else {
        $(this).parent(".multi-level").parent("ul").children("li").children("ul").slideUp(250)
        $(this).next("ul").slideToggle(250);
        $(this).parent(".multi-level").parent("ul").children(".multi-level").removeClass("active")
        $(this).parent(".multi-level").addClass("active");
    }
})
$(document).on('click','.checkBox_header',function() {
    $(this).toggleClass('bg-gray');
})
$(document).on('change','input[data-type="endFilter"]',function(e) {
    let max = 5;
    if ($('input[data-type="endFilter"]:checked').length == max) {
        $('input[data-type="endFilter"]').prop('disabled', true);
        $('input[data-type="endFilter"]:checked').removeAttr('disabled');
    } else {
        $("input[data-type='endFilter']").removeAttr('disabled');
    }
})
$(document).on('change','input[data-type="startFilter"]',function(e) {
    let max = 5;
    if ($('input[data-type="startFilter"]:checked').length == max) {
        $('input[data-type="startFilter"]').prop('disabled', true);
        $('input[data-type="startFilter"]:checked').removeAttr('disabled');
    } else {
        $("input[data-type='startFilter']").removeAttr('disabled');
    }
})
$(document).on('change','.city-check',function(e) {
    const city = $(this).val();
    if ($(this).prop('checked')) {
        $(this).closest('.city_list').find('.dist').prop('disabled',true)
        $(this).closest('.city_list').find('.dist').prop('checked',false)
    }
})