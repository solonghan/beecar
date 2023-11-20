$('input[type="submit"]').on('click',function(e) {
    e.preventDefault();
    let token = localStorage.getItem('token')
    let oldPassword = $('input[name="oldPassword"]').val().trim();
    let newPassword = $('input[name="newPassword"]').val().trim();
    let newPassword1 = $('input[name="newPassword1"]').val().trim();
    let data = {};
    data.token = token;
    data['old_password'] = oldPassword;
    if (newPassword !== newPassword1) {
        alert('新密碼與確認密碼不一致')
        return
    } else {
        data.password = newPassword;
        data['password_confirm'] = newPassword1;
    }
    $.ajax({
        url: baseUrl + 'api/edit_password',
        type: 'POST',
        dataType: 'json',
        data: data,
        success: function(res) {
            if(res.status) {
                window.history.go(-1)
            } else {
                if(res.token_status == false){
                    alert(res.msg);
                    localStorage.clear();
                    location.href = '../home/login'
                }   else {
                    alert(res.msg);
                }
            }
        },
        error: function(err) {
            console.log(err);
        }
    })
})