let token = localStorage.getItem('token');
let allData = function() {
    $.ajax({
        url: baseUrl + 'api/friend_list',
        type: 'POST',
        dataType: 'json',
        data: {
            token: token
        },
        success: function(res) {
            if (res.status) {
                rendor(res.data)
            }else {
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
allData();
$('.search_bar').on('keyup',function() {
    let searchVal = $(this).val().trim();
    if (searchVal != '') {
        $.ajax({
            url: baseUrl + 'api/friend_list',
            type: 'POST',
            dataType: 'json',
            data: {
                token: token,
                search: searchVal
            },
            success: function(res) {
                if (res.status) {
                    let driverData = res.data;
                    if (driverData.length != 0) {
                        rendor(driverData)
                    }
                }else {
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
    } else {
        allData();
    }
})
function rendor(data) {
    let str = '';
    if (data == []) {
        str = ''
    } else {
            data.forEach(item => {
            str +=
            `
            <div class="custom-control custom-checkbox">
                <input type="checkbox" id="driver_id${item.id}" name="driver[]" class="custom-control-input" value="${item.id}">
                <label class="custom-control-label" for="driver_id${item.id}">${item.showname}</label>
            </div>
            ` 
        })
    }
    $('.driver_list').html(str)
}
$('input[type="submit"]').on('click',function(e) {
    e.preventDefault();
    let title = localStorage.getItem('group_name');
    let code = localStorage.getItem('group_code');
    let driverid = $("input[name='driver[]']:checked").map(function(){
    return $(this).val();
    }).get();
    $.ajax({
        url: baseUrl + 'api/create_group',
        type: 'POST',
        dataType: 'json',
        data: {
            token: token,
            title: title,
            code: code,
            drivers: driverid
        },
        success: function(res) {
            if (res.status) {
               alert(res.msg)
               localStorage.removeItem('group_name');
               localStorage.removeItem('group_code');
               location.href = 'member';
            }else {
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
})