let accout = localStorage.getItem('accout');
let checkMember = localStorage.getItem('checkMember');
const token = localStorage.getItem('token') || '';
const role = localStorage.getItem('role') || '';
if (accout != null) {
    $('#accout').val(accout)
}
if(checkMember == 'true') {
    $('input[name="member"]').prop('checked',true);
} else {
    $('input[name="member"]').prop('checked',false);
}
;(function() {
    if (token != '') {
        if (role != '') {
            if (role == 'driver' && is_verify == 'true') {
                location.href="../driver/driver-index"
            } else if (role == 'dealer') {
                location.href="../car/dispach"
            }
        }
    }
})();

$('.register_btn').on('click',function() {
    const role = $(this).attr('id');
    localStorage.setItem('role',role)
})
$('#loginBtn').on('click', function(e) {
    e.preventDefault();
    let accout = $('#accout').val().trim();
    let password = $('#password').val().trim();
    let member = $('input[name="member"]').prop('checked');
    let data = {};
    data.mobile = accout;
    data.password = password;
    data['fcm_token'] = firebaseToken;
    $.ajax({
        url : baseUrl + 'api/login',
        type: 'POST',
        dataType: 'json',
        data: data,
        success:function(res){
            if (res.status) {
                memberMe(member,accout);
                console.log(res);
                login(res);
            } else {
                alert('帳號或密碼錯誤')
                return false
            }
        }
    })
})

function login(res) {
    localStorage.setItem("token",res.token);
    localStorage.setItem("page",'stroked');
    localStorage.setItem("user_id",res.data.id);
    localStorage.setItem("role",res.data.role);
    localStorage.setItem("is_verify",res.is_verify);
    // 這裡給我一個參數判斷條款有沒有更新，有的話我要往下call條款那隻api，show給用戶看，然後還要再開一隻讓我傳同意的申請0.0。
    if (!res.is_statement_read) {
        isReadUpdateTerm()
    } else {
        // 如果身分未被認證，導到會員中心
        if (res.is_verify == false && res.data.role == "driver") {
            location.href = "../driver/member";
        } else if (res.data.role == "driver") {
            location.href="../driver/driver-index";
        } else if (res.data.role == "dealer") {
            location.href="../car/dispach";
        }
    }
}

function isReadUpdateTerm(){
    $.ajax({
        url: baseUrl + 'api/statement',
        type: 'GET',
        dataType: 'json',
        success:function(res){
            console.log(res);
            $('#terms').html(res.data.content)
            $('#lightdialog').modal('show')
        },
    })
}

function memberMe(member,accout) {
    if (member) {
        localStorage.setItem('accout',accout);
        localStorage.setItem('checkMember',member);
    } else {
        localStorage.removeItem('accout');
        localStorage.setItem('checkMember',member);
    }
}

$('.submit_read').on('click', function(e) {
    e.preventDefault();

    $.ajax({
        url : baseUrl + 'api/statement_confirm',
        type: 'POST',
        dataType: 'json',
        data: {
			token: localStorage.getItem('token'),
		},
        success:function(res){
            if (res.status) {
                $('#lightdialog').modal('hide')
                // 如果身分未被認證，導到會員中心
                if (localStorage.getItem('is_verify') == false && localStorage.getItem('role') == "driver") {
                    location.href = "../driver/member";
                } else if (localStorage.getItem('role') == "driver") {
                    location.href="../driver/driver-index";
                } else if (localStorage.getItem('role') == "dealer") {
                    location.href="../car/dispach";
                }
            } else {
                alert(res.msg)
            }
        }
    })
})

$('.signOut').on('click', function(e) {
    // e.preventDefault();
    $('#lightdialog').modal('hide')
    localStorage.clear();
    location.href = '../home/login'
})