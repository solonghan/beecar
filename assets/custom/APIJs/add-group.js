let token = localStorage.getItem('token');
let friendId = $.urlParam('friend_id');
$.ajax({
    url: baseUrl + 'api/my_groups',
    type:'POST',
    dataType: 'json',
    data: {
        token: token
    },
    success: function(res) {
        if(res.status) {
            rendor(res.data)
        }
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
            <input type="checkbox" id="group_id${item.id}" name="group[]" class="custom-control-input" value="${item.id}">
            <label class="custom-control-label" for="group_id${item.id}">${item.title}</label>
        </div>
            `
        })
    }
    $('.group_list').html(str)
}
$('input[type="text"]').on('keyup',function(e) {
    let searchVal = $(this).val().trim();
    if (searchVal !== '') {
        $.ajax({
            url: baseUrl + 'api/my_groups',
            type: 'POST',
            dataType: 'json',
            data: {
                token: token,
                search: searchVal
            },
            success: function(res) {
                if (res.status) {
                    rendor(res.data)
                }else {
                    if(res.token_status == false){
                        alert(res.msg);
                        localStorage.clear();
                        location.href = '../home/login'
                    }
                }
            }
        })
    } else {
        allData();
    }
})
function allData() {
    $.ajax({
        url: baseUrl + 'api/my_groups',
        type:'POST',
        dataType: 'json',
        data: {
            token: token
        },
        success: function(res) {
            if(res.status) {
                rendor(res.data)
            }
        }
    })
}
$('input[type="submit"]').on('click',function(e) {
    e.preventDefault();
    let searchIDs = $("input[name='group[]']:checked").map(function(){
    return $(this).val();
    }).get();
    $.ajax({
        url: baseUrl + 'api/add_friend_join_groups',
        type: 'POST',
        dataType: 'json',
        data: {
            token: token,
            driver_id: friendId,
            group_id: searchIDs
        },
        success: function(res) {
            console.log(res);
            $('#addGroup').modal('show')
        },
        error: function(err) {
            $('#addGroup .modal-title').text(`${err.message}`)
            $('#addGroup').modal('show')
        }
    })
})