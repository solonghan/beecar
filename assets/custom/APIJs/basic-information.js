let token = localStorage.getItem('token');
let userData = [];
$.ajax({
    url: baseUrl+'api/userinfo',
    type: 'POST',
    dataType: 'json',
    data: {
        token: token,
    },
    success: function(res) {
        if (res.status){
            userData.push(res.user)
            rendor();
        }else {
            if(res.token_status == false){
                alert(res.msg);
                localStorage.clear();
                location.href = '../home/login'
            }
        }
    },
    error: function(err) {
        console.log(err);
    }
})
// console.log(userData);
function rendor() {
    let str = '';
    userData.forEach(item => {
        str = 
        `
        <form class="needs-validation" novalidate>

                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="name1">顯示名稱</label>
                        <input type="text" class="form-control" id="name" name="name" value="${item.username}" placeholder="請輸入名稱" required>
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>

                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="lastname1">手機</label>
                        <input type="phone" class="form-control" id="phone" name="phone" value="${item.mobile}" disabled>
                        <span class="bind">已綁定</span>
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>

                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="name1">Line帳號</label>
                        <input type="text" class="form-control" id="line" name="line" placeholder="請輸入名稱" value="${item.line_id}" required>
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>

                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="Email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="請輸入e-mail" value="${item.email}" required>
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>
            </form>
            <div class="form-links mt-2">
                <div class="fs-6">
                    <a href="change-password" class="text-primary">變更密碼</a>
                </div>
            </div>
        `
    })
    $('.information').html(str)
}
$('input[type="submit"]').on('click',function(e) {
    e.preventDefault();
    let name = $('input[name="name"]').val().trim();
    let line = $('input[name="line"]').val().trim();
    let email = $('input[name="email"]').val().trim();
    let data = {};
    data.token = token;
    if(name == '') {
        alert('名稱不可為空')
        return
    } else {
        data.username = name;
    }
    if (line =='') {
        alert('Line帳號不可為空')
        return
    } else {
        data['line_id'] = line;
    }
    if (email == '') {
        alert('Email不可為空')
        return
    } else {
        data.email = email;
    }
    $.ajax({
        url: baseUrl+'api/edit_userinfo',
        type: 'POST',
        dataType: 'json',
        data: data,
        success: function(res) {
            alert(res.msg)
            if(res.status) {
                location.href=`../driver/member`
            }
        },
        error: function(err) {
            console.log(err);
        }
    })
})