<?php include_once (dirname(dirname(__FILE__)) . "/quote/header.php"); ?>

<body class="bg-light">

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">跑跑卡丁車成員名單</div>
        <div class="right">
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">


        <div class="section full mt-2">
            <div class="wide-block pb-2">
                <form class="search-form">
                    <div class="form-group searchbox">
                        <input type="text" id="groupMemberSearch" class="form-control" placeholder="請輸入關鍵字">
                        <i class="input-icon">
                            <ion-icon name="search-outline"></ion-icon>
                        </i>
                        <a href="javascript:;" id="reset" class="ml-1 close toggle-searchbox">
                            <ion-icon name="close-circle"></ion-icon>
                        </a>
                    </div>
                </form>
            </div>
        </div>
        <div class="member-verification">
            <div class="section full mb-2">
                <div class="wide-block p-0">   
                    <ul class="listview simple-listview border-0 group_member">
                    </ul>        
                </div> 
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

    <!-- Dialog Basic -->
    <div class="modal fade dialogbox" id="Dialog" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">是否將王大明移除群組?</h5>
                </div>
                <div class="modal-footer">
                    <div class="btn-inline">
                        <a href="#" class="btn btn-text-secondary" data-dismiss="modal">否</a>
                        <a href="#" class="btn btn-text-primary remove" data-dismiss="modal">是</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * Dialog Basic -->

    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/driver.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
        sessionStorage.setItem('page','member');
    </script>
    <script src="<?=base_url()?>assets/custom/js/search.js"></script>
    <script src="<?=base_url()?>assets/custom/js/get-parameter.js"></script> <!-- 取得網址參數 -->
    <script>
        let token = localStorage.getItem('token');
        let id = $.urlParam('group_id');
        $.ajax({
            url: baseUrl + 'api/group_detail',
            type: 'POST',
            dataType: 'json',
            data: {
                token: token,
                group_id: id
            },
            success: function(res) {
                title(res.data.title)
            }
        })
        function title(title) {
            $('.pageTitle').text(title+'成員名單')
        }
        $.ajax({
            url: baseUrl + 'api/group_friends_list',
            type: 'POST',
            dataType: 'json',
            data: {
                token: token,
                group_id: id
            },
            success: function(res) {
                console.log(res);
                if (res.status) {
                    rendor(res.data)
                } else {
                    if(res.token_status == false){
                        alert(res.msg);
                        localStorage.clear();
                        location.href = '../home/login'
                    }
                }
            }
        })
        function rendor(data) {
            let str = '';
            let modelTitle = '';
            let addMember = 
            `
            <li>
                <div class="item">
                    <div class="in">
                        <a href="<?=base_url()?>driver/add-driver-choose?group_id=${id}" class="text-primary d-flex align-items-center">
                            <ion-icon name="add-circle-outline"></ion-icon>
                            <div class="ml-1">新增成員</div>
                        </a>
                    </div>
                </div>
            </li>
            `
            $('.group_member').html(addMember)
            if (data == '') {
                str = ''
            } else {
                for (let i = 0; i < data.length; i++) {
                    if (data[i].nickname) {
                        modelTitle = data[i].nickname
                    } else {
                        modelTitle = data[i].username
                    }
                    str +=
                    `
                    <li class="memberList" data-friend="${data[i].id}">
                        <a href="<?=base_url()?>driver/driver-Information?friend_id=${data[i].id}">
                            <div class="item">
                                <div class="in">
                                    <div>${modelTitle}</div>
                                    <a href="#" class="info d-flex align-items-center" data-toggle="modal" data-target="#Dialog">
                                        <ion-icon name="remove-circle-outline"></ion-icon>
                                        <span id="remove" class="text-muted ml-1">移除</span>
                                    </a>
                                </div>
                            </div>
                        </a>
                    </li>
                    `
                }
            }
            $('.group_member').append(str)
            $('.modal-title').text("是否將" + modelTitle + "移除群組?")
        }
        $(document).on('click', 'ul > li',function(e){
            let friendId = $(this).data('friend');
            if (friendId == undefined) {
                return
            }
            $('.remove').on('click',function(e) {
                $.ajax({
                    url: baseUrl + 'api/group_out',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        token: token,
                        group_id: id,
                        driver_id: friendId
                    },
                    success: function(res) {
                        if (res.status) {
                            window.location.reload();
                        } else {
                            if(res.token_status == false){
                                alert(res.msg);
                                localStorage.clear();
                                location.href = '../home/login'
                            }
                        }
                    }
                })
            })
        })
    </script>




</body>

</html>