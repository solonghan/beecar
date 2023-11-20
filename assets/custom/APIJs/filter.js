const fromURL = document.referrer;
const NEW_FROM_URL = new URL(fromURL)
const { searchParams } = NEW_FROM_URL;
const filter_data = JSON.parse(localStorage.getItem('filter_data'))
let START_ADDR = JSON.parse(searchParams.get('start_addr'))
let END_ADDR = JSON.parse(searchParams.get('end_addr'))
function renderFilter() {
    const START_DATE = JSON.parse(searchParams.get('start_date'));
    const END_DATE = JSON.parse(searchParams.get('end_date'));
    let CURRENT_START_DATE = ''
    let CURRENT_END_DATE = ''
    console.log(START_DATE);
    console.log(END_DATE);
    if (START_DATE !== null && END_DATE !== null) {
        const start = START_DATE.split('-')
        const end = END_DATE.split('-')
        CURRENT_START_DATE = `${start[1]}/${start[2]}/${start[0]}`
        CURRENT_END_DATE = `${end[1]}/${end[2]}/${end[0]}`
        $('input[name="from"]').val(`${CURRENT_START_DATE}`);
        $('input[name="to"]').val(`${CURRENT_END_DATE}`);
    }else {
        $('input[name="from"]').val('');
        $('input[name="to"]').val('');
    }
    const START_TIME = JSON.parse(searchParams.get('start_time'))
    const END_TIME = JSON.parse(searchParams.get('end_time'))
    const CAR_MODAL = JSON.parse(searchParams.get('car_model'))
    const STATUS = JSON.parse(searchParams.get('status'))
    $('input[name="startTime"]').val(`${START_TIME || ''}`)
    $('input[name="endTime"]').val(`${END_TIME || ''}`)
    // 狀態
    console.log(STATUS);
    if (STATUS) {
        const statusArr = STATUS.map(item => {
            const newArr = item.replace('make', '未派遣').replace('transfer', '已轉單').replace('send_free', '已轉單').replace('free_get', '已有駕駛承接').replace('assign', '已指定駕駛').replace('catch', '已接到轉單')
            return newArr
        })
        let statusStr = `<input type="text" name="statusResult" class="form-control" id="cash2" value="${statusArr.join('、')}" disabled>`
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
// for (let [key, value] of searchParams.entries()) {
//     console.log(key, value);
// }
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
            if (item.area === '') {
                $(`#startFilter input[value="${item.city}"]`).prop('checked', true)
                // console.log($(".active .dist_list input[name='dist']"));
                $(".active .dist_list input[name='dist']").attr('disabled', true);
            } else {
                $(`#startFilter input[value="${item.city + ' ' + item.area}"]`).prop('checked', true)
            }
        })
    }
})
$('#startFilter').on('hide.bs.modal', function(){
    console.log($('#startFilter input[type=checkbox]:checked'));
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
    let originStartDate = $('input[name="from"]').val().trim()
    let originEndDate = $('input[name="to"]').val().trim()
    let startDate = ''
    let endDate = ''
    if (originStartDate !== '' && originEndDate !== '') {
        const start = originStartDate.split('/')
        const end = originEndDate.split('/')
        startDate = `${start[2]}-${start[0]}-${start[1]}`
        endDate = `${end[2]}-${end[0]}-${end[1]}`
    }
    const filter = {
        start_date: JSON.stringify(startDate),
        end_date: JSON.stringify(endDate),
        start_time: JSON.stringify($('input[name="startTime"]').val().trim()),
        end_time: JSON.stringify($('input[name="endTime"]').val().trim()),
        car_model: JSON.stringify(modal_filter),
        start_addr: JSON.stringify(start_addr),
        end_addr: JSON.stringify(end_addr),
        status: JSON.stringify(status_val),
    };
    const set_filter = {
        start_date: startDate,
        end_date: endDate,
        start_time: $('input[name="startTime"]').val().trim(),
        end_time: $('input[name="endTime"]').val().trim(),
        car_model: modal_filter,
        start_addr: start_addr,
        end_addr: end_addr,
        status: status_val,
    };
    const j_set_filter = JSON.stringify(set_filter)
    localStorage.setItem('filter_data', j_set_filter)
    Object.keys(filter).forEach((key) => {
        // console.log(key,filter[key]);
        if (filter[key] == '""' || filter[key] == "[]" || filter[key] == "{}") {
            delete filter[key]
        }
    })
    const filtersearchParams = new URLSearchParams(filter)
    NEW_FROM_URL.search = filtersearchParams
    if (Object.keys(filter).length !== 0) {
        location.href = `${NEW_FROM_URL.href}`
    }else {
        location.href = `${NEW_FROM_URL.href}`
    }
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