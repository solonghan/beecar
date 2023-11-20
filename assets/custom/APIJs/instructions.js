let token = localStorage.getItem('token')
let notice;
$.ajax({
    url: baseUrl + 'api/instructions',
    // url: 'https://www.anbon.vip/beecar/api/instructions',
    type: 'POST',
    dataType: 'json',
    data: {
        token: token
    },
    success: function(res) {
        if (res.status){
            notice = res.data;
            rendor(notice);
        }   else {
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
// console.log(res);
function rendor(notice) {
    let str = ''
    // if (notice.length == 0) {
    //     str = 
    //     `
    //     <div class="no_list">
    //         無通知
    //     </div>
    //     `
    // }
   
    str=`<p>${notice.content}</p>`
    console.log(str);
    $('.noticeList').html(str)
}
$(document).on('click','ul > li',function(e){
    let noticeId = $(this).data('notification')
    let list = $(this)
    $.ajax({
        url: baseUrl + 'api/notification_read',
        type: 'POST',
        dataType: 'json',
        data: {
            token: token,
            notification_id: noticeId
        },
        success: function(res) {
            if (res.status) {
                if (res.msg == "通知已標為已讀") {
                    list.removeClass('unread')
                    list.addClass('read')
                }
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
})