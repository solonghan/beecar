let token = localStorage.getItem('token');

$.ajax({
    url: baseUrl + 'api/free_list',
    type: 'POST',
    dataType: 'json',
    data: {
        token: token,
    },
    success: function(res) {
        if(res.status) {
            rendor(res.list)
        } else {
            alert(res.msg)
        }
    }
})
function rendor(data) {
    let groupstr = '';
    let friendstr = '';
    let chengjieList = '';
    data.forEach((item) => {
        if (item.type == 'group') {
            groupstr +=
            `
            <div class="custom-control custom-checkbox">
                <input type="checkbox" id="group${item['group_id']}" name="group_list[]" class="custom-control-input" value="${item['group_id']}">
                <label class="custom-control-label" for="group${item['group_id']}">${item.title} (${item.cnt})</label>
            </div>
            `
        } else if (item.type == 'friend'){
            friendstr +=
            `
            <div class="custom-control custom-checkbox">
                <input type="checkbox" id="group${item['driver_id']}" name="friend_list[]" class="custom-control-input" value="${item['driver_id']}">
                <label class="custom-control-label" for="group${item['driver_id']}">${item.title}</label>
            </div>
            `
        }
    })
    chengjieList = groupstr + friendstr;
    $('.chengjie_list').html(chengjieList)
}

$(document).on('click','input[type="submit"]',function(e) {
    e.preventDefault();
    let orderId = JSON.parse(localStorage.getItem('orderId'));
    let groupList = $("input[name='group_list[]']:checked").map(function(){
        return $(this).val(); 
    }).get();
    let friendList = $("input[name='friend_list[]']:checked").map(function(){
        return $(this).val(); 
    }).get();
    console.log(groupList,friendList);
    $.ajax({
        url: baseUrl + 'api/free_send',
        type: 'POST',
        dataType: 'json',
        data: {
            token: token,
            order_list: orderId,
            group_list: groupList,
            friend_list: friendList,
        },
        success: function(res) {
            if (res.status) {
                $('#DialogIconedSuccess').modal('show');
                localStorage.removeItem('orderId')
            } else {
                if(res.token_status == false){
                    alert(res.msg);
                    localStorage.clear();
                    location.href = '../home/login'
                }
            }
        }
    })
})

$('.close').on('click',function() {
    window.history.back();
})