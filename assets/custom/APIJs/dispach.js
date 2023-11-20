const nowPageURL = location.href
const NEW_PAGE_URL = new URL(nowPageURL)
const URL_Params = NEW_PAGE_URL.searchParams
var checkFilterData = new Array()
let token = localStorage.getItem('token')
let datalength = ''
let timer = setInterval(() => {
    filterData()
}, 10000)
$(window).bind('beforeunload', function () {
    clearInterval(timer)
})
function filterData() {
    const data = {}
    const { href, protocol, hostname, pathname, search, searchParams } = NEW_PAGE_URL
    if (NEW_PAGE_URL.search != '' && NEW_PAGE_URL.search != undefined) {
        for (let [key, value] of searchParams.entries()) {
            data[`${key}`] = JSON.parse(value)
            data['token'] = token
        }
        sendFilterRequest(data)
    } else {
        getManageList()
    }
}
filterData()
// filterData(data)
function sendFilterRequest(filterdata) {
    console.log(filterdata)
    $.ajax({
        url: baseUrl + 'api/manager_list_search',
        type: 'POST',
        dataType: 'json',
        data: filterdata,
        success: function (res) {
            if (res.status) {
                const c = JSON.stringify(checkFilterData)
                const r = JSON.stringify(res.data)
                if (c !== r) {
                    datalength = res.data.length
                    render(res.data)
                    checkFilterData = res.data
                }
                return
            }else {
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
            console.log(err)
        },
    })
}
function getManageList() {
    $.ajax({
        url: baseUrl + 'api/get_manage_list',
        type: 'POST',
        dataType: 'json',
        data: {
            token: token,
        },
        success: function (res) {
            console.log(res)
            if (res.status) {
                const c = JSON.stringify(checkFilterData)
                const r = JSON.stringify(res.get_manage_list)
                if (c !== r) {
                    datalength = res['get_manage_list'].length
                    render(res['get_manage_list'])
                    checkFilterData = res.get_manage_list
                }
                return
            } else {
                if(res.token_status == false){
                    alert(res.msg)
                    localStorage.clear();
                    location.href = '../home/login'
                } else {
                    alert(res.msg);
                    location.href = `${res.url}`
                }
            }
        },
    })
}
function render(data) {
    let manageList = ''
    if (data.length == 0) {
        manageList = `
        <div class="no_list">
            目前還沒有訂單資訊
        </div>
        `
    }
    data.forEach((item) => {
        let status = orderStatus(item['final_status'])
        let statusLight = orderStatusLight(item['status_str'])
        manageList += `
        <div class="card-dispach-detail card-list order_card" data-order="${item['order_no']}">
            <div class="card">
                <div class="card-body">
                    <div class="card-title custom-control custom-checkbox">
                        <input type="checkbox" class="test custom-control-input" id="${
                            item['order_no']
                        }" name="orderId[]">
                        <label class="custom-control-label" for="${item['order_no']}">${item['date']}</label>
                        <a href="javascript:;" class="order_log">
                            <span id="test" class="test status ${statusLight}">
                                ${item['status_str']}
                            </span>
                        </a>
                    </div>
                    <p class="card-subtitle">${item['time']}</p>
                    <div class="card-text">
                        <p>起點 : ${item['address_start']}</p>
                        ${AllTarget(item['address_end'])}
                    </div>
                    <div class="card-bottom">
                        <div class="remark">
                            <p>車型 : ${item['car_model']}</p>
                            ${HaveDispatchName(item['owner_name'])}
                        </div>
                        <div class="price">
                            <p>${status} : $${item['final_payment']}</p>
                            <p>車資 : $${item['price']}</p>
                            <div style="display:flex;">
                                <div>備註 :&nbsp;</div>
                                <div style="white-space:pre-wrap;">${item['remark'] == ' ' ? '無' : item['remark']}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `
    })
    $('.manage_list').html(manageList)
}
function AllTarget(address) {
    if (typeof address === 'string') {
        return
    }else {
        let target = ''
        if (address) {
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
        }else {
            return '<p>目的地: </p>'
        }
    }
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
// 判斷訂單回金還是補貼
function orderStatus(status) {
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
// 判斷燈號顏色
function orderStatusLight(statuslight) {
    let statusLightClassName = ''
    switch (statuslight) {
        case '未派遣':
            statusLightClassName = 'notdispatched'
            break
        case '已接到轉單':
            statusLightClassName = 'notdispatched'
            break
        case '待承接':
            statusLightClassName = 'undertaken'
            break
        case '已轉單':
            statusLightClassName = 'dispatched'
            break
        case '已有駕駛承接':
            statusLightClassName = 'dispatched'
            break
        case '已指定駕駛':
            statusLightClassName = 'dispatched'
            break
        case "前往起點":
        case "抵達起點":
        case "開始行程":
            statusLightClassName = "processing";
            break;
    }
    return statusLightClassName
}
// 全選
$(document).on('click', '.select_all_icon', function (e) {
    const checkboxChecked = $('input[name="orderId[]"]:checked')
        .map(function () {
            return $(this).val()
        })
        .get()
    if (checkboxChecked.length != datalength) {
        $('input[name="orderId[]"]').prop('checked', true)
    } else if (checkboxChecked.length == datalength) {
        $('input[name="orderId[]"]').prop('checked', false)
    }
})
$(document).on('click', '.card-dispach-detail', function (e) {
    let val = e.target.nodeName
    let orderId = $(this).data('order')
    if (val !== 'SPAN' && val !== 'INPUT' && val !== 'LABEL') {
        window.location.href = `dispach-detail?order_id=${orderId}`
    }
})
// 操作判斷
let orderId
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
$('.zhuan_dan').on('click', function (e) {
    let option = 'transfer'
    orderId = $("input[name='orderId[]']:checked")
        .map(function () {
            return $(this).attr('id')
        })
        .get()
    if (orderId.length == 0) {
        alert('至少選一個行程')
        return
    }
    let checkResult = check(option, orderId)
    if (!checkResult) {
        alert('有筆訂單無法被轉單')
        return
    } else {
        localStorage.setItem('orderId', JSON.stringify(orderId))
        window.location.href = 'appoint'
    }
})
$('.zhiding').on('click', function (e) {
    let option = 'assign'
    orderId = $("input[name='orderId[]']:checked")
        .map(function () {
            return $(this).attr('id')
        })
        .get()
    if (orderId.length == 0) {
        alert('至少選一個行程')
        return
    }
    let checkResult = check(option, orderId)
    if (!checkResult) {
        alert('有筆訂單無法被指定')
        return
    } else {
        localStorage.setItem('orderId', JSON.stringify(orderId))
        window.location.href = 'designated-driving'
    }
})
$('.chengjie').on('click', function (e) {
    orderId = $("input[name='orderId[]']:checked")
        .map(function () {
            return $(this).attr('id')
        })
        .get()
    if (orderId.length == 0) {
        alert('至少選一個行程')
        return
    }
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
})

$('.delete_itinerary').on('click', function (e) {
    let option = 'delete'
    orderId = $("input[name='orderId[]']:checked")
        .map(function () {
            return $(this).attr('id')
        })
        .get()
    if (orderId.length == 0) {
        alert('至少選一個行程')
        return
    }
    let checkResult = check(option, orderId)
    if (!checkResult) {
        alert('有筆訂單無法被刪除')
        return
    } else {
        deleteOrder(option, orderId)
    }
})
///
$('.reset').on('click', function (e) {
    let option = 'reset'
    orderId = $("input[name='orderId[]']:checked")
        .map(function () {
            return $(this).attr('id')
        })
        .get()
    console.log(orderId)
    if (orderId.length == 0) {
        alert('至少選一個行程')
        return
    }
    let checkResult = check(option, orderId)
    if (!checkResult) {
        alert('有筆訂單無法被重置')
        return
    } else {
        resetOrder(option, orderId)
    }
})

function resetOrder(option, orderId) {
    $.ajax({
        url: baseUrl + 'api/order_operation',
        type: 'POST',
        dataType: 'json',
        data: {
            token: token,
            action: option,
            order_list: orderId,
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
function deleteOrder(option, orderId) {
    $.ajax({
        url: baseUrl + 'api/order_operation',
        type: 'POST',
        dataType: 'json',
        data: {
            token: token,
            action: option,
            order_list: orderId,
        },
        success: function (res) {
            if (res.status) {
                alert('已刪除訂單')
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
            }else {
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
})
// <div class="divider bg-primary mt-2 mb-2"></div>
function rendorLog(data) {
    let str = ''
    console.log(data)
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
