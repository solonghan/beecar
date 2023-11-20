let token = localStorage.getItem('token');
let id = $.urlParam('group_id');
$.ajax({
    url: baseUrl + 'api/group_detail',
    type: 'POST',
    dataType: 'json',
    data: {
        token: token,
        group_id: id
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
function rendor(data) {
    $('.group_title').text(data.title)
    $('.group_code').text(data.code)
    $('.group_creater').text(data.creater)
}
$('.drop_out').on('click',function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'api/group_out',
        type: 'POST',
        dataType: 'json',
        data: {
            token: token,
            group_id: id
        },
        success: function(res) {
            if (res.status) {
                alert(res.msg)
                location.href= "member"
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