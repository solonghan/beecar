const token = localStorage.getItem('token');
$('a[href="#pickUp"]').on('show.bs.tab',function() {
    postRecord();
})
$('a[href="#send"]').on('show.bs.tab',function() {
    manageRecord();
})
function postRecord() {
    $.ajax({
        url: baseUrl + 'api/get_record',
        type: 'POST',
        dataType: 'json',
        data: {
            token: token
        },
        success: function(res) {
            if (res.status){
                const list = res.list.data;
                record(list)
            } else {
                if(res.token_status == false){
                    alert(res.msg);
                    localStorage.clear();
                    location.href = '../home/login'
                } else {
                    alert(res.msg);
                }
            }
        }
    })
}

function manageRecord() {
    $.ajax({
        url: baseUrl + 'api/get_manage_record',
        type: 'POST',
        dataType: 'json',
        data: {
            token: token
        },
        success: function(res) {
            if (res.status) {
                const list = res.list.data;
                managerecord(list)
            } else {
                if(res.token_status == false){
                    alert(res.msg);
                    localStorage.clear();
                    location.href = '../home/login'
                } else {
                    alert(res.msg);
                }
            }
        }
    })
}
manageRecord();
postRecord();
function record(list) {
    // console.log(list);
    let str = '';
    if (list.length != 0) {
        list.forEach((item) => {
            let status = orderStatus(item['final_status'])
            str +=
            `
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        ${item.date}
                    </h5>
                    <p class="card-subtitle">${item.time}</p>
                    <div class="card-text">
                        <p>起點 : ${item['address_start']}</p>
                        <p>終點 : ${item['address_end']}</p>
                    </div>
                    <div class="card-bottom">
                        <div class="remark">
                            <p>行李數 : ${(item.baggage) ? item.baggage + '件' : '無'}</p>
                            <p>乘客數 : ${(item.number) ? item.number + '人' : '無'}</p>
                            <p>支付方式 : ${item.price}</p>
                            <p>車型 : ${item['car_model']}</p>
                            <a href="undertack-drive-information?friend_id=${item['sender_id']}"><p>派遣人 : ${item['sender_name']}</p></a>
                        </div>
                        <div class="price">
                            <p>${status} : $${item['final_payment']}</p>
                            <p>車資 : $${item['price']}</p>
                        </div>
                    </div>
                </div>
            </div>
            `
        })
    }
    $('#pickUp .section').html(str);
}
function managerecord(list) {
    // console.log(list);
    let str = '';
    list.forEach((item) => {
        console.log(item);
        let status = orderStatus(item['final_status'])
        str +=
        `
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    ${item.date}
                </h5>
                <p class="card-subtitle">${item.time}</p>
                <div class="card-text">
                    <p>起點 : ${item['address_start']}</p>
                    <p>終點 : ${item['address_end']}</p>
                </div>
                <div class="card-bottom">
                    <div class="remark">
                        <p>聯絡人名稱 : ${item.name}</p>
                        <p>聯絡人電話 : ${item.phone}</p>
                        <p>航班編號 : ${(item.flight) ? item.flight : '無'}</p>
                        <p>車型 : ${item['car_model']}</p>
                        <p>行李數 : 2件</p>
                        <p>乘客數 : ${item.number}</p>
                        <p>備註 : ${(item.remark) ? item.remark : '無'}</p>
                        <p>支付方式 : 現金</p>
                        <a href="driver-Information?friend_id=${item['driver_id']}"><p>駕駛名稱 : ${item['driver_name']}</p></a>
                    </div>
                    <div class="price">
                        <p>${status} : $${item['final_payment']}</p>
                        <p>車資 : $${item['price']}</p>
                    </div>
                </div>
            </div>
        </div>
        `
    })
    $('#send .section').html(str)
}
// 判斷訂單回金還是補貼
function orderStatus(status) {
    let final_status = '';
    switch (status) {
        case '0':
            final_status = '回金'
            break;
        case '1':
            final_status = '補貼';
            break;
    }
    return final_status
}