const token = localStorage.getItem('token')
let modal_filter; 
let start_addr = [];
let end_addr = [];
// $('#statusFilter').on('hide.bs.modal',function(e) {
//     let str = '';
//     const status_val = $('input[name="status[]"]:checked').map(function() {
//         return $(this).val()
//     }).get()
//     status_filter = $('input[name="status[]"]:checked').map(function() {
//         return $(this).data('status')
//     }).get()
//     if (status_val.length != 0) {
//         str = `<input type="text" name="statusResult" class="form-control" id="cash2" value="${status_val.join('、')}" disabled>`
//     } else if (status_val.length == 0) {
//         str = '';
//     }
//     $('.status_result').html(str)
// })

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
    // console.log(START_ADDR);
    // if (START_ADDR && START_ADDR != '') {
    //     START_ADDR.forEach((item) => {
    //         const checkCity = item.city
    //         $(`#startFilter a[data-citydropdown="${checkCity}"]`).next('ul').css('display','block')
    //         $(`#startFilter a[data-citydropdown="${checkCity}"]`).closest('.city_list').addClass('active')
    //         $(`#startFilter input[value="${item.city + ' ' + item.area}"]`).prop('checked', true)
    //     })
    // }
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
    // if (END_ADDR && END_ADDR != '') {
    //     END_ADDR.forEach((item) => {
    //         const checkCity = item.city
    //         $(`#endFilter a[data-citydropdown="${checkCity}"]`).next('ul').css('display','block')
    //         $(`#endFilter a[data-citydropdown="${checkCity}"]`).closest('.city_list').addClass('active')
    //         $(`#endFilter input[value="${item.city + ' ' + item.area}"]`).prop('checked', true)
    //     })
    // }
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
    const modalfilter = [];
    $('input[name="modalfilter"]').each((idx,ele) => {
        modalfilter.push($(ele).val())
    })
    console.log(modalfilter);
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
    const filter = {
        token: token,
        start_date: $('input[name="from"]').val().trim(),
        end_date: $('input[name="to"]').val().trim(),
        start_time: $('input[name="startTime"]').val().trim(),
        end_time: $('input[name="endTime"]').val().trim(),
        car_model: (modalfilter.length != 0 )? modalfilter : '',
        start_addr: start_addr,
        end_addr: end_addr,
    };
    postSuperFilter(filter)
})

// $('input[name="from"]').change(function(){
//     $('input[name="to"]').val('')
// })
// $('input[name="startTime"]').change(function(){
//     console.log('starttime');
//     console.log($('input[name="endTime"]').val());
//     $('input[name="endTime"]').val('')
// })
$(document).on('click','input[name="clearfilter"]',function(e) {
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

function postSuperFilter(data) {
    console.log(data);
	console.log('test',data);
    $.ajax({
        url: baseUrl + 'api/add_super_filter',
        type: 'POST',
        dataType: 'json',
        data: data,
        success: function (res) {
            if (res.status) {
                console.log(res);
				console.log('test_2',data);
                location.href = "notification-filter";
            } else {
                if(res.token_status == false){
                    alert(res.msg);
                    localStorage.clear();
                    location.href = '../home/login'
                } else {
                    alert(res.msg);
                }
            }
        },
        error: function (err) {
            console.log(err);
        }
    })
}