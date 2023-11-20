let token = localStorage.getItem('token');
$('.search_bar').on('keydown',function(e) {
    const keycode = e.keyCode;
    let searchVal = $(this).val().trim();
    if (searchVal == '') {
        $('input[type="submit"]').attr('disabled',true)
        return
    } else if (keycode == 13){
        e.preventDefault();
        $.ajax({
            url: baseUrl + 'api/search_group',
            type: 'POST',
            dataType: 'json',
            data: {
                token: token,
                search: searchVal
            },
            success: function(res) {
                console.log(res);
                if (res.status) {
                    search(searchVal, res.data);
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
})

$('.search_group_code').on('click',function(e) {
    let searchVal = $('.search_bar').val().trim();
    if (searchVal == '') {
        $('input[type="submit"]').attr('disabled',true)
        return
    } else {
        e.preventDefault();
        $.ajax({
            url: baseUrl + 'api/search_group',
            type: 'POST',
            dataType: 'json',
            data: {
                token: token,
                search: searchVal
            },
            success: function(res) {
                console.log(res);
                if (res.status) {
                    search(searchVal, res.data);
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
})
function search(searchVal, data) {
    let str = '';
    let hasSame = 0
    if (data.length == 0) {
        str = '查無此群組'
        $('input[type="submit"]').attr('disabled',true)
    } else {
        data.forEach(item => {
        console.log(searchVal, item.code);
            if (searchVal == item.code) {
                localStorage.setItem('groud_id',item.id)
                str += 
                `
                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="group_${item.id}">群組名稱</label>
                        <input type="text" class="form-control" id="group_${item.id}" value="${item.title}" disabled>
                    </div>
                </div>
                `
                $('input[type="submit"]').attr('disabled',false)
                hasSame = 1
            }
        }) 
    }
    if (hasSame == 0) {
        str = '查無此群組'
        $('input[type="submit"]').attr('disabled',true)
    }

    $('.group_list').html(str)
}
$('input[type="submit"]').on('click',function(e) {
    e.preventDefault();
    let groupId = localStorage.getItem('groud_id');
    $.ajax({
        url: baseUrl + 'api/join_group',
        type: 'POST',
        dataType: 'json',
        data: {
            token: token,
            group_id: groupId
        },
        success: function(res) {
            if (res.status) {
                console.log(res);
                $('#memberAddGroup').modal('show')
                localStorage.removeItem('groud_id')
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
})