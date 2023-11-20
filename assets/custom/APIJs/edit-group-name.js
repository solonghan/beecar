let token = localStorage.getItem('token');
let id = $.urlParam('group_id');
$.ajax({
    url: baseUrl + 'api/group_detail',
    type: 'POST',
    dataType: 'json',
    data: {
        token: token,
        group_id:id
    },
    success: function(res) {
        if (res.status){
            rendor(res.data)
        } else {
            alert(res.msg)
        }
    }
})
function rendor(data) {
    str = 
    `
    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="label fs-6" for="groupName">群組名稱</label>
            <input type="text" class="form-control" id="groupName" name="groupName" value="${data.title}" required>
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>
    `
    $('.editTitle').html(str)
}
$('input[type="submit"]').on('click',function(e) {
    e.preventDefault();
    let editTitle = $('input[name="groupName"]').val().trim();
    if (editTitle == '') {
        alert('欄位不可為空')
        return
    }
    $.ajax({
        url: baseUrl + 'api/edit_group_title',
        type: 'POST',
        dataType: 'json',
        data: {
            token: token,
            group_id: id,
            title: editTitle
        },
        success: function(res) {
            if (res.status) {
                alert(res.msg);
                history.back();
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