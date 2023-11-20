let token = localStorage.getItem('token')
let orderNo = $.urlParam('order_id')
let sendStatus = ''
let timer = setInterval(() => {
    $.ajax({
        url: baseUrl + 'api/get_order_detail',
        type: 'POST',
        dataType: 'json',
        data: {
            token: token,
            order_no: orderNo,
        },
        success: function (res) {
            sendStatus = res.status_str
            if (res.status) {
                if (!res.status_str) {
                    alert('訂單已被取消')
                    location.href = 'dispach'
                }
                render(res)
                transfer(res['transfer_button'])
                assign(res['assign_button'])
                free(res['free_button'])
                edit(res['edit_button'])
                owner(res['is_owner'])
            } else {
                if(res.token_status == false){
                    alert(res.msg);
                    localStorage.clear();
                    location.href = '../home/login'
                } else {
                    alert('取得訂單失敗，請檢查連線')
                    location.href = 'dispach'
                }
            }
        },
    })
}, 10000)
$(window).bind('beforeunload', function () {
    clearInterval(timer)
})
$.ajax({
    url: baseUrl + 'api/get_order_detail',
    type: 'POST',
    dataType: 'json',
    data: {
        token: token,
        order_no: orderNo,
    },
    success: function (res) {
        sendStatus = res.status_str
        if (res.status) {
            if (!res.status_str) {
                alert('行程已取消')
                location.href = 'dispach'
            }
            render(res)
            transfer(res['transfer_button'])
            assign(res['assign_button'])
            free(res['free_button'])
            edit(res['edit_button'])
            owner(res['is_owner'])
        } else {
            if(res.token_status == false){
                alert(res.msg);
                localStorage.clear();
                location.href = '../home/login'
            } else {
                alert('取得訂單失敗，請檢查連線')
                location.href = 'dispach'
            }
        }
    },
})
function render(data) {
    console.log(data)
    let str = `
        <div class="card-body order_card" data-order="${data['order_no']}">
            <h5 class="card-title">
                ${data.date}
                <a href="javascript:;" class="order_log" data-toggle="modal" data-target="#lightdialog">
                    <span class="status ${orderStatusLight(data['status_str'])}">
                        ${data.status_str}
                    </span>
                </a>
                <span class="transferred">
                    建單人 : 已轉單
                </span>
            </h5>
            <p class="card-subtitle">${data.time}</p>
            <div class="card-text">
                <p>起點 : ${data['start_addr']}</p>
                ${AllTarget(data['end_addr'])}
            </div>
            <div class="card-bottom">
                <div class="remark">
                    <p>聯絡人名稱 : ${data.name}</p>
                    <p>聯絡人電話 : ${data.phone}</p>
                    <p>航班編號 : ${data.flight || ''}</p>
                    <p>車型 : ${data['car_model']}</p>
                    <p>行李數 : ${data.baggage} 件</p>
                    <p>乘車人數 : ${data.number} 位</p>
                    <div style="display:flex;">
                        <div>備註 :&nbsp;</div>
                        <div style="white-space:pre-wrap;">${data.remark != ' ' ? data.remark : '無'}</div>
                    </div>
                    <a href="${
                        data['driver_id'] != '0' ? `driver-Information?friend_id=${data['driver_id']}` : 'javascript:;'
                    }
                    ">
                        <p>駕駛名稱 : ${data['driver_name'] != '' ? data['driver_name'] : '未指定'}</p>
                    </a>
                    ${HaveDispatchName(data['owner_name'])}
                </div>
                <div class="price">
                    <p>${finalStatus(data['final_status'])} : $${data['final_payment']}</p>
                    <p>車資 : $${data.price}</p>
                </div>
            </div>
        </div>
    `
    $('.order_detail').html(str)
}
function AllTarget(address) {
    let target = ''
    if (address.length < 2) {
        address.forEach(e => {
            target += `
            <p>目的地 : ${e}</p>
            `
        })
    } else {
        address.forEach((e, i) => {
            target += `
            <p>目的地${i+1} : ${e}</p>
            `
        })
    }
    return target
}
function HaveDispatchName(name) {
    if (name !== undefined) {
        let ownerName = ''
        ownerName += `
            <p>派遣人 : ${name}</p>
        `
        return ownerName
    } else {
        return ''
    }
}
function finalStatus(status) {
    let final_status = ''
    switch (status) {
        case '0':
            final_status = '回金'
            break
        case '1':
            final_status = '補貼'
            break
    }
    return final_status
}
function orderStatusLight(statuslight) {
    let statusLightClassName = ''
    switch (statuslight) {
        case '未派遣':
        case '已接到轉單':
            statusLightClassName = 'notdispatched'
            break
        case '待承接':
            statusLightClassName = 'undertaken'
            break
        case '已轉單':
        case '已有駕駛承接':
        case '已指定駕駛':
            statusLightClassName = 'dispatched'
            break
        case '前往起點':
            statusLightClassName = 'processing'
            break
        case '抵達起點':
            statusLightClassName = 'processing'
            break
        case '開始行程':
            statusLightClassName = 'processing'
            break
    }
    return statusLightClassName
}
// 右上角行程modal
$(document).on('click', '.order_log', function () {
    $('.order_log_modal').modal('show')
    let orderNo = $(this).parents('.order_card').data('order')
    $.ajax({
        url: baseUrl + 'api/get_order_log',
        type: 'POST',
        dataType: 'json',
        data: {
            token: token,
            order_no: orderNo,
        },
        success: function (res) {
            if (res.status) {
                rendorLog(res.list)
            } else {
                if(res.token_status == false){
                    alert(res.msg);
                    localStorage.clear();
                    location.href = '../home/login'
                } else {
                    alert('無法取得資訊')
                }
            }
        },
    })
})
{
    /* <div class="divider bg-primary mt-2 mb-2"></div> */
}
function rendorLog(data) {
    let str = ''
    for (let item in data) {
        if (item !== 'status' && item !== 'msg' && item !== 'debug_post') {
            str += `
            <div class="orderRecord">
                <p class="text-left">${item}</p>
                <ul class="orderRecordList">
                    ${logContent(data[item])}
                </ul>
            </div>
            `
        }
    }
    $('.order_log_modal .modal-body').html(str)
}
function logContent(arr) {
    let logStr = ''
    arr.forEach((item) => {
        logStr += `
        <li class="${item['status'] ? '' : 'd-none'}">
            <div class="dialog-content">${item['time']}</div>
            <div class="dialog-content">${item['status']}</div>
            <div class="dialog-content">
                <p>${item['member']}</p>
            </div>
        </li>
        `
    })
    return logStr
}
// 判斷 button
function transfer(transfer) {
    //轉單按鈕判斷
    if (transfer == 'yes') {
        $('.transfer').css('display', 'block')
        $('.cancel_transfer').css('display', 'none')
        $('.transfer').attr('disabled', false)
    } else if (transfer == 'no') {
        $('.cancel_transfer').css('display', 'block')
        $('.transfer').css('display', 'none')
    } else if (transfer == 'disable') {
        $('.transfer').css('display', 'block')
        $('.cancel_transfer').css('display', 'none')
        $('.transfer').attr('disabled', true)
    } else if (transfer == 'none') {
        $('.transfer').css('display', 'none')
        $('.cancel_transfer').css('display', 'none')
    }
}
function assign(assign) {
    //指定駕駛按鈕判斷
    if (assign == 'yes') {
        $('.assign').css('display', 'block')
        $('.cancel_assign').css('display', 'none')
    } else if (assign == 'no') {
        $('.cancel_assign').css('display', 'block')
        $('.assign').css('display', 'none')
    } else if (assign == 'disable') {
        $('.assign').css('display', 'block')
        $('.cancel_assign').css('display', 'none')
        $('.assign').attr('disabled', true)
    } else if (assign == 'none') {
        $('.assign').css('display', 'none')
        $('.cancel_assign').css('display', 'none')
    }
}
function free(free) {
    //自由承接按鈕判斷
    if (free == 'yes') {
        $('.free').css('display', 'block')
        $('.free').attr('disabled', false)
        $('.cancel_free').css('display', 'none')
    } else if (free == 'no') {
        $('.cancel_free').css('display', 'block')
        $('.free').css('display', 'none')
    } else if (free == 'disable') {
        $('.free').css('display', 'block')
        $('.cancel_free').css('display', 'none')
        $('.free').attr('disabled', true)
    } else if (free == 'none') {
        $('.free').css('display', 'none')
        $('.cancel_free').css('display', 'none')
    }
}
function edit(edit) {
    // 編輯按鈕
    if (edit == 'yes') {
        $('.edit_btn').css('display', 'block')
    } else if (edit == 'disable') {
        $('.edit_btn').attr('disabled', true)
    } else if (edit == 'none') {
        $('.edit_btn').css('display', 'none')
    }
}
function owner(owner) {
    // 右上角modal判斷
    if (owner) {
        $('.modal_delete').css('display', 'flex')
        $('.modal_reset').css('display', 'flex')
        $('.modal_cancel').css('display', 'none')
    } else {
        $('.modal_delete').css('display', 'none')
        $('.modal_reset').css('display', 'none')
        $('.modal_cancel').css('display', 'flex')
    }
}
// 判斷操作
function check(option, orderId) {
    let status = ''
    $.ajax({
        url: baseUrl + 'api/order_operate_check',
        type: 'POST',
        dataType: 'json',
        async: false,
        data: {
            token: token,
            action: option,
            order_list: orderId,
        },
        success: function (res) {
            status = res.status
        },
    })
    return status
}
// 取消的操作
function cancel(option, orderId) {
    $.ajax({
        url: baseUrl + 'api/order_detail_operation',
        type: 'POST',
        dataType: 'json',
        async: false,
        data: {
            token: token,
            action: option,
            order_no: orderId,
        },
        success: function (res) {
            if (res.status) {
                alert('已取消')
                location.reload()
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
    })
}
// 刪除 or 取消行程
function deleteOrder(option, orderId) {
    $.ajax({
        url: baseUrl + 'api/order_detail_operation',
        type: 'POST',
        dataType: 'json',
        async: false,
        data: {
            token: token,
            action: option,
            order_no: orderId,
        },
        success: function (res) {
            if (res.status) {
                if (option == 'delete') {
                    alert('已刪除')
                } else if (option == 'cancel') {
                    alert('已取消')
                }
                location.href = 'dispach'
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
    })
}
//重置派遣
function resetOrder(option, orderId) {
    $.ajax({
        url: baseUrl + 'api/order_detail_operation',
        type: 'POST',
        dataType: 'json',
        async: false,
        data: {
            token: token,
            action: option,
            order_no: orderId,
        },
        success: function (res) {
            if (res.status) {
                alert('已重置訂單')
                location.reload()
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
    })
}
// 轉單操作
$(document).on('click', '.transfer', function () {
    let action = 'transfer'
    let orderId = [orderNo]
    let checkResult = check(action, orderId)
    if (checkResult) {
        localStorage.setItem('orderId', JSON.stringify(orderId))
        window.location.href = 'appoint'
    } else {
        alert('此筆訂單無法轉單')
        return
    }
})
$(document).on('click', '.cancel_transfer', function () {
    let action = 'transfer_cancel'
    let orderId = orderNo
    cancel(action, orderId)
})
// 指定操作
$(document).on('click', '.assign', function () {
    let action = 'assign'
    let orderId = [orderNo]
    let checkResult = check(action, orderId)
    if (checkResult) {
        localStorage.setItem('orderId', JSON.stringify(orderId))
        window.location.href = 'designated-driving'
    } else {
        alert('此筆訂單無法指定')
        location.href = 'dispach'
    }
})
$(document).on('click', '.cancel_assign', function () {
    let action = 'assign_cancel'
    let orderId = orderNo
    cancel(action, orderId)
})
// 自由承接
$(document).on('click', '.free', function () {
    let orderId = [orderNo]
    $.ajax({
        url: baseUrl + 'api/order_free_check',
        type: 'POST',
        dataType: 'json',
        async: false,
        data: {
            token: token,
            order_list: orderId,
        },
        success: function (res) {
            if (res.status) {
                localStorage.setItem('orderId', JSON.stringify(orderId))
                window.location.href = 'dispach-send'
            }else {
                if(res.token_status == false){
                    
                    localStorage.clear();
                    location.href = '../home/login'
                } else {
                    alert(res.msg);
                }
            }
        },
    })
})
$(document).on('click', '.cancel_free', function () {
    let action = 'free_cancel'
    let orderId = orderNo
    cancel(action, orderId)
})
// 刪除行程
$(document).on('click', '.delete_y', function () {
    let action = 'delete'
    let orderId = orderNo
    deleteOrder(action, orderId)
})
// 取消行程
$(document).on('click', '.modal_cancel', function () {
    let action = 'cancel'
    let orderId = orderNo
    deleteOrder(action, orderId)
})
// 編輯行程
$('.edit_btn').on('click', function () {
    console.log(sendStatus);
    if (sendStatus === '未派遣') {
        window.location.href = `modify-order?order_id=${orderNo}`
    } else {
        $('#confirmEditModal').modal('toggle')
    }
})
$(document).on('click', '.confirm_edit_btn', function () {
    let action = 'reset'
    let orderId = orderNo
    resetOrder(action, orderId)
    window.location.href = `modify-order?order_id=${orderNo}`
})
// 重置行程
$(document).on('click', '.reset', function () {
    let action = 'reset'
    let orderId = orderNo
    resetOrder(action, orderId)
})
