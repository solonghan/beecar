let token = localStorage.getItem('token');
let userid = localStorage.getItem('user_id');
(function() {
    localStorage.setItem('tab','drivers');
})();
// $('.search').on('click',function(e) {
//     let searchVal = $('.search_bar').val().trim();
//     $.ajax({
//         url: baseUrl + 'api/search_driver',
//         type: 'POST',
//         dataType: 'json',
//         data: {
//             token: token,
//             mobile: searchVal
//         },
//         success: function(res) {
//             if (res.status) {
//                 rendor(res.data)
//                 addFriend(res.data.id)
//             } else {
//                 $('.driverInfo').text(res.msg)
//             }
//         }
//     })
// })
$('.search_bar').on('keydown',function(e) {
    let searchVal = $('.search_bar').val().trim();
    const keycode = e.keyCode;
    console.log(keycode);
    if (keycode == 13) {
        $.ajax({
            url: baseUrl + 'api/search_driver',
            type: 'POST',
            dataType: 'json',
            data: {
                token: token,
                mobile: searchVal
            },
            success: function(res) {
                if (res.status) {
                    rendor(res.data)
                    addFriend(res.data.id)
                } else {
                    if(res.token_status == false){
                        alert(res.msg);
                        localStorage.clear();
                        location.href = '../home/login'
                    } else {
                        str = 
                        `
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <p>${res.msg}</p>
                            </div>
                        </div>
                        `
                        $('.driverInfo').html(str)
                    }
                }
            }
        })
    }
})
function rendor(data) {
    let addBtn = '';
    if (data.id == userid) {
        addBtn = 
        `
        <div class="pt-2 pb-2">
            <input type="submit" class="btn btn-primary btn-lg btn-block" value="無法將自己加入好友" disabled></button>
        </div>
        `
    } else {
        addBtn = 
        `
        <div class="pt-2 pb-2">
            <input type="submit" class="btn btn-primary btn-lg btn-block" value="加入好友" data-toggle="modal" data-target="#memberAddFriend"></button>
        </div>
        `
    }
    str = 
    `
        <div class="form-group basic">
            <div class="input-wrapper">
                <label class="label" for="name">駕駛名稱</label>
                <input type="text" class="form-control" id="name" value="${data.username}" disabled>
            </div>
        </div>
        <div class="form-group basic">
            <div class="input-wrapper">
                <label class="label" for="lineAccount">Line帳號</label>
                <input type="text" class="form-control" id="lineAccount" value="${data['line_id']}" disabled>
            </div>
        </div>
        <div class="form-group basic">
            <div class="input-wrapper">
                <label class="label" for="brand">車輛品牌</label>
                <input type="text" class="form-control" id="brand" name="brand" value="${data.brand}" disabled>
            </div>
        </div>
        <div class="form-group basic">
            <div class="input-wrapper">
                <label class="label" for="carmodel">車輛型號</label>
                <input type="text" class="form-control" id="carModel" name="carmodel" value="${data.model}" disabled>
            </div>
        </div>
        <div class="form-group basic">
            <div class="input-wrapper">
                <label class="label" for="cartype">車型</label>
                <input type="text" class="form-control" id="carType" name="cartype" value="${data.type}" disabled>
            </div>
        </div>
        <div class="form-group basic">
            <div class="input-wrapper">
                <label class="label" for="manufacture">出廠年份</label>
                <input type="text" class="form-control" id="manufacture" name="manufacture" value="${data.year}" disabled>
            </div>
        </div>
        <div class="form-group basic">
            <div class="input-wrapper">
                <label class="label" for="carcolor">顏色</label>
                <input type="text" class="form-control" id="carcolor" name="carcolor" value="${data.color}" disabled>
            </div>
        </div>
        ${addBtn}
    `
    $('.driverInfo').html(str)
}
function addFriend(driverid) {
    $(document).on('click','input[type="submit"]',function(e) {
        e.preventDefault();
        let id = driverid;
        $.ajax({
            url: baseUrl + 'api/add_friend',
            type: 'POST',
            dataType: 'json',
            data: {
                token: token,
                driver_id: id
            },
            success: function(res) {
                if (res.status) {
                    location.reload();
                } else {
                    if(res.token_status == false){
                        alert(res.msg);
                        localStorage.clear();
                        location.href = '../home/login'
                    } else {
                        $('#memberAddFriend .modal-title').text(res.msg)
                    }
                }
            }
        })
    })
}