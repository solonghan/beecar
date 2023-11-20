const token = localStorage.getItem('token')
$('input[type="submit"]').on('click',function(e) {
    const data = {
        token: token,
        brand: $('#brand').val().trim() || '',
        model: $('#model').val().trim() || '',
        type: $('#type').val().trim() || '',
        year: $('#year').val().trim() || '',
        color: $('#color').val().trim() || '',
        plate: $('#plate').val().trim() || ''
    }
    $.ajax({
        url: baseUrl + 'api/edit_car_info',
        type: 'POST',
        dataType: 'json',
        data: data,
        success: function(res) {
            if (res.status) {
                alert('註冊成功')
                location.href = "./../home/login"
            }else {
                if(res.token_status == false){
                    alert(res.msg);
                    localStorage.clear();
                    location.href = '../home/login'
                } else {
                    if(res.token_status == false){
                        alert(res.msg);
                        localStorage.clear();
                        location.href = '../home/login'
                    } else {
                        alert(res.msg);
                    }
                }
            }
        },
        error: function(err) {
            alert(err.msg)
        }
    })
})