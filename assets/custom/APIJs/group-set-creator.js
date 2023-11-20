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
    },
})
function rendor(data) {
    str = 
    `
    <li>
        <a href="edit-group-name?group_id=${data.id}">
            群組名稱
            <span class="text-info">${data.title}</span>
        </a>
    </li>
    <li>
        <a href="edit-groupnumber?group_id=${data.id}">
            群組碼
            <span class="text-info">${data.code}</span>
        </a>
    </li>
    <li>
        <li class="simpleListview">
            建立人
            <span class="text-info">${data.creater}</span>
        </li>
    </li>
    <li>
        <a href="group-member?group_id=${data.id}">
            成員名單
        </a>
    </li>
    <li>
        <a href="#DialogBasic" data-toggle="modal" data-target="#DialogBasic">
            刪除群組
        </a>
    </li>
    `
    $('.group_detail').html(str)
}
$('.del_Y').on('click',function(e) {
    $.ajax({
        url: baseUrl + 'api/del_group',
        type: 'POST',
        dataType: 'json',
        data: {
            token: token,
            group_id: id
        },
        success: function(res) {
            if (res.status) {
                alert(res.msg)
                history.back();
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