let token = localStorage.getItem('token');
$.ajax({
    url: baseUrl + 'api/get_friend_list',
    type: 'POST',
    dataType: 'json',
    data: {
        token: token
    },
    success: function(res) {
        if (res.status) {
            render(res['friend_list'])
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
})

function render(data) {
    console.log(data);
    let str= '';
    data.forEach((item) => {
        str += 
        `
        <div class="custom-control custom-radio" data-driver="${item['friend_id']}">
            <input type="radio" id="friend_${item['friend_id']}" name="customRadioList" class="custom-control-input" value="${item['showname']}">
            <label class="custom-control-label" for="friend_${item['friend_id']}">${item['showname']}</label>
        </div>
        `
    })
    $('.friend_list').html(str)
}

// let pagetitle = $('.pageTitle').text();
// let active = '';
// if(pagetitle == '行程轉單') {
//     active = 'transfer';
// } else if (pagetitle == '指定駕駛') {
//     active = 'assign';
// }
// console.log(active); 
// $('input[type="submit"]').on('click',function(e) {
//     e.preventDefault();
//     let driverId = $('input[name="customRadioList"]:checked').parent().data('driver');
//     console.log(driverId);
// })