let token = localStorage.getItem('token')
let notice;
$.ajax({
    url: baseUrl + 'api/notification',
    type: 'POST',
    dataType: 'json',
    data: {
        token: token
    },
    success: function(res) {
        // console.log(res);
        if (res.status) {
            notice = res.data;
            rendor(notice);
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
function rendor(notice) {

console.log(notice);

    let str = ''
    if (notice.length == 0) {
        str = 
        `
        <div class="no_list">
            無通知
        </div>
        `
    }
    // 這個寫法的 == false flase要是字串
    for (let i = 0; i < notice.length; i++) {
        str += 
        `
        <li data-notification="${notice[i].id}" data-content="${notice[i].content}" data-title="${notice[i].title}" class="${notice[i]['is_read'] == 'false' ? 'unread' : 'read'}">
            ${notice[i].title}
            <span class="time">${notice[i]['create_date']}</span>
        </li>
        `
    }
    $('.noticeList').html(str)
}
$(document).on('click','ul > li',function(e){
    $('#notificationModal').modal('show')
    $('#notificationModal .modal-body').text($(this).data('content'))
    $('#notificationModal .modal-title').text($(this).data('title'))
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