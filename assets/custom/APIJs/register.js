const role = localStorage.getItem('role')
$('input[type="submit"]').on('click',function(e) {
    e.preventDefault();
    const phone = $('input[name="mobile"]').val().trim();
    const email = $('input[name="email"]').val().trim();
    emailRule = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;
    let terms = $('#term').is(':checked');
    if (phone == '' || email == ''){
        alert('資料不可為空')
        return
    } else if (email.search(emailRule) == -1) {
        alert('email格式不正確');
        return
    }
    if(terms == false) {
        alert('請同意政策條款')
        return
    }
    const registerData = {
        mobile : phone,
        email: email,
        role: role
    };
    $.ajax({
        url: baseUrl + 'api/register',
        type: 'POST',
        dataType: 'json',
        data: registerData,
        success:function(res){
            let mobile = res['debug_post']['mobile']
            if (res.status == true) {
                localStorage.setItem('token', JSON.stringify(res.token))
                localStorage.setItem('mobile',JSON.stringify(mobile))
                location.href = "sms-verification"
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

$.ajax({
    url: baseUrl + 'api/statement',
    type: 'GET',
    dataType: 'json',
    success:function(res){
        console.log(res);
        $('#terms').html(res.data.content)
    },
})