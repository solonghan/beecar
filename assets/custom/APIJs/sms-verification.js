$('input[type="submit"]').on('click', function(e) {
    e.preventDefault();
    let smscode = $('input[name="smscode"]').val();
    let token = JSON.parse(localStorage.getItem('token'));
    let verifyMobile = {};
    verifyMobile.token = token;
    verifyMobile['verify_code'] = smscode;
    $.ajax({
        url: baseUrl+'api/verify_mobile',
        type: 'POST',
        dataType: 'json',
        data: verifyMobile,

        success:function(res){
            if (res.status) {
                alert(res.msg)
                localStorage.removeItem('mobile')
                location.href="set-password"
            } else {
                if(res.token_status == false){
                    alert(res.msg);
                    localStorage.clear();
                    location.href = '../home/login'
                } else {
                    alert("驗證碼輸入錯誤")
                }
            }
        }
    })
})
$('input[type="button"]').on('click',function(e) {
    let mobile = JSON.parse(localStorage.getItem('mobile'));
    $.ajax({
        url: baseUrl + 'api/resend_register_verify_code',
        type: 'POST',
        dataType: 'json',
        data: {
            mobile: mobile
        },
        success: function(res) {
            if(res.token_status == false){
                alert(res.msg);
                localStorage.clear();
                location.href = '../home/login'
            } else {
                alert(res.msg);
            }
        }
    })
    $(this).attr('disabled', true)
    let time = 60;
    let $this = $(this);
    let timer = setInterval(() => {
        time --;
        if (time == 0) {
            clearInterval(timer);
            $this.val('重發驗證碼')
            $this.removeAttr('disabled');
            return;
        }
        $this.val(time + '秒重發驗證碼')
    }, 1000);
})