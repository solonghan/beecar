let token = localStorage.getItem('token');
let id = $.urlParam('friend_id');
function presetName() {
    let showname = JSON.parse(localStorage.getItem('showname'))
    $(".edit_name").val(showname)
    localStorage.removeItem('showname');
}
presetName();
$('input[type="submit"]').on('click',function(e) {
    e.preventDefault();
    let editName = $('.edit_name').val().trim();
    if (editName !== '') {
        $.ajax({
            url: baseUrl + 'api/edit_friend_driver',
            type: 'POST',
            dataType: 'json',
            data: {
                token: token,
                driver_id: id,
                nickname: editName
            },
            success: function(res) {
                if(res.token_status == false){
                    alert(res.msg);
                    localStorage.clear();
                    location.href = '../home/login'
                } else {
                    alert(res.msg);
                    history.back();
                }

            }
        })
    } else {
        alert('欄位不可為空') 
    }
})