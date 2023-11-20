(function() {
    let tabTxt = localStorage.getItem('tab')
    if (tabTxt !== null) {
        tabFn(tabTxt)
    }
})();
function tabFn(tabTxt) {
    var tab = $('.nav-tabs li a');
    var con = $('.tab-content .tab-pane');
    if (tabTxt == 'drivers') {
        $('#setTab').removeClass('active');
        $('#driversTab').addClass('active');
        $('#set').removeClass('show active');
        $('#drivers').addClass('show active');
    } else {
        $('#driversTab').removeClass('active');
        $('#set').addClass('active');
        $('#drivers').removeClass('show active');
        $('#set').addClass('show active');
    }
}
$('#setTab').on('click',function() {
    localStorage.removeItem('tab')
})
$(window).bind('beforeunload',function(){
    localStorage.removeItem('tab')
})
// API
let token = localStorage.getItem('token');
// 設定 -> 通知中心數量
$.ajax({
    url: baseUrl + 'api/notification',
    type: 'POST',
    dataType: 'json',
    data: {
        token: token
    },
    success: function(res) {
        if (res.status) {
            let num = 0
            res.data.forEach(item => {
                if (item.is_read == 'false') {
                    num = num + 1;
                }
            });
            if (num) {
                $('.notice_num').text(num)
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
// 司機名單
let allData = function () {
    $.ajax({
        url: baseUrl + 'api/driver_list',
        type: 'POST',
        dataType: 'json',
        data: {
            token: token
        },
        success: function(res) {
            if (res.status) {
                friend(res['friend_list'])
                group(res['group_list'])
                blackList(res['black_list'])
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
}
allData();
// 搜尋
$('.search_bar').on('keyup',function(e) {
    let searchVal = $(this).val().trim();
    if(searchVal !== '') {
        $('#reset').css('display','flex')
        $.ajax({
            url: baseUrl + 'api/driver_list',
            type: 'POST',
            dataType: 'json',
            data: {
                token: token,
                search: searchVal
            },
            success: function(res) {
                if (res.status) {
                    friend(res['friend_list'])
                    group(res['group_list'])
                    blackList(res['black_list'])
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
    } else {
        $('#reset').css('display','none')
        allData();
    }
})
// 好友列表
function friend(data) {
    let str = 
    `
    <li>
        <a href="add-friends" class="item">
        新增好友
        </a>
    </li>
    `
    if (data.length == 0) {
        str = str;
    } else {
        for (let i = 0; i < data.length; i++) {
            str +=
            `
            <li>
                <a href="driver-Information?friend_id=${data[i].id}" class="item">
                    ${data[i].showname}
                </a>
            </li>
            `
        }
    }
    $('.friendList').html(str)
}
// 群組列表
function group(data) {
    let str = 
    `
        <li>
            <a href="build-group" class="item">
                建立群組
            </a>
        </li>
        <li>
            <a href="join-group" class="item">
                加入群組
            </a>
        </li>
    `
    let href = '';
    if (data.length == 0) {
        str = str
    } else {
        for(let i = 0; i < data.length; i++) {
            if (data[i].mine) {
                href = 'group-set-creator'
                str += 
                `
                <li>
                    <a href="${href}?group_id=${data[i].id}" class="item justify-content-start">
                        <div class="icon-box list-icon-style d-flex align-items-center mr-1 primary">
                            <ion-icon name="person-circle-sharp"></ion-icon>
                        </div>
                        <div class="in">
                            <p>${data[i].title}(${data[i].cnt})</p>
                        </div>
                    </a>
                </li>
                `
            } else {
                href = 'group-set-notcreator'
                str += 
                `
                <li>
                    <a href="${href}?group_id=${data[i].id}" class="item justify-content-start">
                        <div class="icon-box list-icon-style d-flex align-items-center mr-3 primary">
                        </div>
                        <div class="in">
                            <p>${data[i].title}(${data[i].cnt})</p>
                        </div>
                    </a>
                </li>
                `
            }
        }
    }
    $('.groupList').html(str)
}
// 黑名單
function blackList(data) {
    let str = '';
    if (data.length == 0) {
        str = '';
    } else {
        for (let i = 0; i < data.length; i++) {
            str += 
            `
            <li>
                <div class="driverName">${data[i].username}</div>
                <div class="dismiss">
                    <a href="#" class= "dismiss" data-toggle="modal" data-target="#dismiss" data-friend=${data[i].id} data-name="${data[i].username}">
                        <ion-icon name="remove-circle-outline"></ion-icon>
                        <span>解除</span>
                    </a>
                </div>
            </li>
            `
        }
    }
    $('.blackList').html(str)
}
// 解除封鎖
let friendId = '';
let friendName = '';
$(document).on('click','.dismiss',function(e){
    e.stopPropagation();
    friendId = $(this).data('friend');
    friendName = $(this).data('name');
    $('#dismiss .modal-title').text(`是否對${friendName}解除封鎖?`);
})
$('.dismiss_Y').on('click',function(e){
    $.ajax({
        url: baseUrl + 'api/black_to_friend',
        type: 'POST',
        dataType: 'json',
        data: {
            token: token,
            driver_id: friendId
        },
        success: function(res) {
            if(res.status) {
                alert(`已對${friendName}解除封鎖`)
                location.reload()
            } else {
                if(res.token_status == false){
                    alert(res.msg);
                    localStorage.clear();
                    location.href = '../home/login'
                } else {
                    alert('解除封鎖失敗')
                }
            }
        }
    })
})

$(document).on('click','.signOut',function(e){
    // e.preventDefault();
    localStorage.clear();
    location.href = '../home/login'
})