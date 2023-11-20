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
        rendor(res.data)
    },
    error: function(err) {
        console.log(err);
    }
})
function rendor(data) {
    str =
    `
    <div class="form-group boxed">
        <div class="input-wrapper">
            <label class="label fs-6" for="editGroupNum">群組碼</label>
            <input type="text" class="form-control" id="editGroupNum" name="editGroupNum" value="${data.code}" required>
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>
    `
    $('.edit_group_num').html(str)
}
$('input[type="submit"]').on('click',function(e) {
    e.preventDefault();
    let edit = $('input[name="editGroupNum"]').val().trim();
    if (edit == '') {
        alert('欄位不可為空')
        return
    }
    $.ajax({
        url: baseUrl + 'api/edit_group_code',
        type: 'POST',
        dataType: 'json',
        data: {
            token: token,
            group_id: id,
            code: edit
        },
        success: function(res) {
            if (res.status) {
                alert(res.msg)
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
        error: function(err) {
            console.log(err);
        }
    })
})