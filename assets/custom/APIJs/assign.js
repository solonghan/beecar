let orderId = JSON.parse(localStorage.getItem('orderId'));
$('input[type="submit"]').on('click',function(e) {
    e.preventDefault();
    let userId = $('input[type="radio"]:checked').parent().data('driver');
    let userName = $('input[type="radio"]:checked').val();
    let action = 'assign';
    $.ajax({
        url: baseUrl + 'api/order_operation',
        type: 'POST',
        dataType: 'json',
        data: {
            token : token,
            action: action,
            order_list: orderId,
            user_id : userId,
        },
        success: function(res) {
            if (res.status) {
                modalShow(userName);
            }else {
                if(res.token_status == false){
                    alert(res.msg);
                    localStorage.clear();
                    location.href = '../home/login'
                }
            }
        }
    })
})

function modalShow(userName) {
    $('.modal-body').text(`已指定給${userName}`)
    $('#assigned').modal('show');
    $('.close').on('click',function() {
        window.history.go(-1);
        location.replace(document.referrer)
        localStorage.removeItem('orderId');
    })
}