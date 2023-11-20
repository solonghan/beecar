const fromURL = document.referrer;
const NEW_FROM_URL = new URL(fromURL)
const { searchParams } = NEW_FROM_URL;
let START_ADDR = JSON.parse(searchParams.get('start_addr'))
let END_ADDR = JSON.parse(searchParams.get('end_addr'))
// console.log(START_DATE);
function renderFilter() {
    const START_DATE = JSON.parse(searchParams.get('start_date'))
    const END_DATE = JSON.parse(searchParams.get('end_date'))
    const START_TIME = JSON.parse(searchParams.get('start_time'))
    const END_TIME = JSON.parse(searchParams.get('end_time'))
    const CAR_MODAL = JSON.parse(searchParams.get('car_model'))
    const STATUS = JSON.parse(searchParams.get('status'))
    $('input[name="from"]').val(`${START_DATE || ''}`);
    $('input[name="to"]').val(`${END_DATE || ''}`);
    $('input[name="startTime"]').val(`${START_TIME || ''}`)
    $('input[name="endTime"]').val(`${END_TIME || ''}`)
    // 狀態
    console.log(STATUS);
    if (STATUS) {
        let statusStr = `<input type="text" name="statusResult" class="form-control" id="cash2" value="${STATUS.join('、')}" disabled>`
        $('.status_result').html(statusStr)
        STATUS.forEach((item) => {
            $(`input[data-status="${item}"]`).prop('checked',true)
        })
    }
    // 車型
    let modalStr = ''
    if (CAR_MODAL) {
        CAR_MODAL.forEach((item,idx) => {
            modalStr +=
            `
            <input type="text" name="modalfilter" class="form-control" id="modal_${idx + 1}" value="${item}" disabled>
            `
            $(`input[value="${item}"]`).prop('checked',true)
        })
        $('.modal_result').html(modalStr)
    }
    // 起點
    console.log(START_ADDR);
    let start_val = '';
    if (START_ADDR && START_ADDR != '') {
        START_ADDR.forEach((item) => {
            console.log(item);
            start_val +=
            `
                <input type="text" class="form-control" id="${item.city + ' ' + item.area}" value="${item.city + ' ' + item.area}" disabled>
            `
        })
        $('.start_city').html(start_val)
    }

    // 終點
    if (END_ADDR && END_ADDR != '') {
        let end_val = '';
        END_ADDR.forEach((item) => {
            console.log(item);
            end_val +=
            `
                <input type="text" class="form-control" data-addrtype="end" id="${item.city + ' ' + item.area}" value="${item.city + ' ' + item.area}" disabled>
            `
        })
        $('.end_city').html(end_val)
    }
}
renderFilter()
for (let [key, value] of searchParams.entries()) {
    console.log(key, value);
}
let modal_filter; 
let status_filter;
let start_addr = [];
let end_addr = [];
$('#statusFilter').on('hide.bs.modal',function(e) {
    let str = '';
    const status_val = $('input[name="status[]"]:checked').map(function() {
        return $(this).val()
    }).get()
    status_filter = $('input[name="status[]"]:checked').map(function() {
        return $(this).data('status')
    }).get()
    console.log(status_val);
    if (status_val.length != 0) {
        str = `<input type="text" name="statusResult" class="form-control" id="cash2" value="${status_val.join('、')}" disabled>`
    } else if (status_val.length == 0) {
        str = '';
    }
    $('.status_result').html(str)
})

$('#modalFilter').on('hide.bs.modal',function(e) {
    modal_filter = $('input[name="modal[]"]:checked').map(function() {
        return $(this).attr('id')
    }).get()
    let str = '';
    modal_filter.forEach((item,idx) => {
        console.log(item);
        str +=
        `
        <input type="text" name="modalfilter" class="form-control" id="modal_${idx + 1}" value="${item}" disabled>
        `
    })
    $('.modal_result').html(str)
})


$('#startFilter').on('show.bs.modal',function() {
    sendRequest($(this).attr('id'))
    console.log(START_ADDR);
    if (START_ADDR && START_ADDR != '') {
        START_ADDR.forEach((item) => {
            const checkCity = item.city
            $(`#startFilter a[data-citydropdown="${checkCity}"]`).next('ul').css('display','block')
            $(`#startFilter a[data-citydropdown="${checkCity}"]`).closest('.city_list').addClass('active')
            $(`#startFilter input[value="${item.city + ' ' + item.area}"]`).prop('checked', true)
        })
    }
})
$('#startFilter').on('hide.bs.modal', function(){
    const startVal = $('#startFilter input[type=checkbox]:checked').map(function() {
        return $(this).val();
    }).get();
    let start_val = '';
    startVal.forEach((item) => {
        start_val +=
        `
            <input type="text" class="form-control" id="${item}" value="${item}" disabled>
        `
    })
    $('.start_city').html(start_val)
})


$('#endFilter').on('show.bs.modal',function() {
    sendRequest($(this).attr('id'))
    if (END_ADDR && END_ADDR != '') {
        END_ADDR.forEach((item) => {
            const checkCity = item.city
            $(`#endFilter a[data-citydropdown="${checkCity}"]`).next('ul').css('display','block')
            $(`#endFilter a[data-citydropdown="${checkCity}"]`).closest('.city_list').addClass('active')
            $(`#endFilter input[value="${item.city + ' ' + item.area}"]`).prop('checked', true)
        })
    }
})
$('#endFilter').on('hide.bs.modal', function(){
    const endtVal = $('#endFilter input[type=checkbox]:checked').map(function() {
        return $(this).val();
    }).get();
    let end_val = '';
    endtVal.forEach((item) => {
        end_val +=
        `
            <input type="text" class="form-control" data-addrtype="end" id="${item}" value="${item}" disabled>
        `
    })
    console.log(endtVal);
    $('.end_city').html(end_val)
})



$(document).on('click','input[name="filter"]',function(e){
    const modal_filter = $('input[name="modal[]"]:checked').map(function() {
        return $(this).attr('id')
    }).get()
    const status_val = $('input[name="status[]"]:checked').map(function() {
        return $(this).data('status')
    }).get()
    $('.end_city input').each((idx,ele) => {
        const endObj = $(ele).val().split(' ')
        const endaddr = {
            city: endObj[0],
            area: endObj[1] || ''
        }
        end_addr.push(endaddr)
    })

    $('.start_city input').each((idx,ele) => {
        const startObj = $(ele).val().split(' ')
        const startaddr = {
            city: startObj[0],
            area: startObj[1] || ''
        }
        start_addr.push(startaddr)
    })
    let sDate = ''
    let eDate = ''
    if ($('input[name="from"]').val() !== '' && $('input[name="to"]').val().substr(6,10) !== '') {
        sDate = `${$('input[name="from"]').val().substr(6,10)}-${$('input[name="from"]').val().substr(0,5).replace('/','-')}`
        eDate = `${$('input[name="to"]').val().substr(6,10)}-${$('input[name="to"]').val().substr(0,5).replace('/','-')}`
    }
    const filter = {
        start_date: JSON.stringify(sDate),
        end_date: JSON.stringify(eDate),
        start_time: JSON.stringify($('input[name="startTime"]').val().trim()),
        end_time: JSON.stringify($('input[name="endTime"]').val().trim()),
        car_model: JSON.stringify(modal_filter),
        start_addr: JSON.stringify(start_addr),
        end_addr: JSON.stringify(end_addr),
        status: JSON.stringify(status_val),
    };
    Object.keys(filter).forEach((key) => {
        console.log(key,filter[key]);
        if (filter[key] == '""' || filter[key] == "[]" || filter[key] == "{}") {
            delete filter[key]
        }
    })
    const filtersearchParams = new URLSearchParams(filter)
    NEW_FROM_URL.search = filtersearchParams
    location.href = `${NEW_FROM_URL.href}`
})

$(document).on('click','input[name="clearfilter"]',function(e) {
    NEW_FROM_URL.search = '';
    $('input[name="from"]').val('')
    $('input[name="to"]').val('')
    $('input[name="startTime"]').val('')
    $('input[name="endTime"]').val('')
    $('input[type="radio"], input[type="checkbox"]').prop('checked',false)
    START_ADDR = '';
    END_ADDR = '';
    modal_filter = ''; 
    status_filter = '';
    start_addr = [];
    end_addr = [];
    $('.start_city input').remove()
    $('.end_city input').remove()
    $('.modal_result input').remove()
    $('.status_result input').remove()
})