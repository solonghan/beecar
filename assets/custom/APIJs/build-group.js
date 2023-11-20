let token = localStorage.getItem('token');
$('input[type="button"]').on('click',function(e) {
    e.preventDefault();
    let groupCode = $('input[name="groupCode"]').val().trim();
    let groupName = $('input[name="groupName"]').val().trim();
    if (groupName == '') {
        alert('群組名稱不可為空')
        return
    }
    if (groupCode !== '') {
        $.ajax({
            url: baseUrl + 'api/group_code_check',
            type: 'POST',
            dataType: 'json',
            data: {
                token: token,
                code: groupCode,
            },
            success: function(res) {
                if(res.status) {
                    localStorage.setItem('group_code',groupCode)
                    localStorage.setItem('group_name',groupName)
                    location.href="group-driver-choose"
                } else {
                    if(res.token_status == false){
                        alert(res.msg);
                        localStorage.clear();
                        location.href = '../home/login'
                    }   else {
                        $('.check_code_msg').text(res.msg)
                    }
                }
            }
        })
    } else {
        alert('群組碼欄位不可為空')
        return
    }
    // $.ajax({
    //     url: baseUrl + 'api/group_code_check',
    //     type: 'POST',
    //     dataType: 'json',
    //     data: {
    //         token: token,
    //         code: groupCode
    //     },
    //     success: function(res) {
    //         if (res.status) {
    //             $('.alertText').text(res.msg).css('color','#00DB00')
    //             $('input[type="button"]').attr('disabled', false)
    //             localStorage.setItem('group_name',groupName);
    //             localStorage.setItem('group_code',groupCode);
    //         } else {
    //             $('.alertText').text(res.msg).css('color','red')
    //             $('input[type="submit"]').attr('disabled', true)
    //         }
    //     }
    // })
})