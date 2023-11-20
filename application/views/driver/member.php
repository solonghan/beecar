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
        <div class="pageTitle">會員中心</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- Extra Header -->
    <div class="extraHeader p-0">
        <ul class="nav nav-tabs lined" role="tablist">
            <li class="nav-item">
                <a class="nav-link active fs-6" id="setTab" data-toggle="tab" href="#set" role="tab">
                    <ion-icon name="settings-outline"></ion-icon>
                    設定
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fs-6" id="driversTab" data-toggle="tab" href="#drivers" role="tab">
                    <ion-icon name="people-outline"></ion-icon>
                    司機名單
                </a>
            </li>
        </ul>
    </div>
    <!-- * Extra Header -->

    <!-- App Capsule -->
    <div id="appCapsule" class="extra-header-active">

        <div class="member fs-6">
            <div class="tab-content mt-1">
                <!-- set tab -->
                <div class="tab-pane fade show active" id="set" role="tabpanel">

                    <div class="section full mt-1">
                        <ul class="listview link-listview">
                            <li><a href="<?=base_url()?>driver/basic-Information">基本資料</a></li>
                            <li>
                                <a href="<?=base_url()?>driver/driver-data-verification">
                                    駕駛驗證
                                    <!-- <span class="text-brown">審核中</span> -->
                                </a>
                            </li>
                            <li>
                                <a href="<?=base_url()?>driver/notification">
                                    通知中心
                                    <span class="badge badge-primary notice_num"></span>
                                </a>
                            </li>
                            <li><a href="<?=base_url()?>driver/undertakerecord">行程紀錄</a></li>
										<!-- 先隱藏消費紀錄 -->
                           <!--  <li><a href="<?=base_url()?>driver/consumption-record">消費紀錄</a></li> -->
                            <!-- <li><a href="<?=base_url()?>driver/value-add">加值服務</a></li> -->
                            <li><a href="#">分享功能</a></li>
                            <li><a href="<?=base_url()?>driver/Instructions-for-use">使用說明</a></li>
                        </ul>
                        <ul class="listview">
                            <li class="d-flex signOut"><a href="javascript:;" class="info">登出</a></li>
                        </ul>
                    </div>

                </div>
                <!-- * set tab -->
                <!-- drivers tab -->
                <div class="tab-pane fade" id="drivers" role="tabpanel">
                    <div class="section full">
                        <ul class="listview link-listview mb-2 bg-info-secondary">
                            <li class="multi-level">
                                <a href="#" class="item">群組名單</a>
                                <!-- sub menu -->
                                <ul class="listview link-listview groupList">
                                </ul>
                                <!-- * sub menu-->
                            </li>
                            <li class="multi-level">
                                <a href="#" class="item">好友名單</a>
                                <!-- sub menu -->
                                <ul class="listview link-listview friendList">
                                </ul>
                                <!-- * sub menu-->
                            </li>

                            <li class="multi-level">
                                <a href="#" class="item">封鎖名單</a>
                                <!-- sub menu -->
                                <ul class="listview simple-listview blackList">
                                </ul>
                                <!-- * sub menu-->
                            </li>               
                        </ul>
                    </div>

                </div>
                <!-- * drivers tab -->
            </div>
        </div>
    </div>
    <!-- * App Capsule -->
    <div class="modal fade dialogbox" id="dismiss" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">是否對阿明解除封鎖?</h5>
                </div>
                <div class="modal-footer">
                    <div class="btn-inline">
                        <a href="#" class="btn btn-text-secondary" data-dismiss="modal">否</a>
                        <a href="#" class="btn btn-text-primary dismiss_Y" data-dismiss="modal">是</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/driver.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
        sessionStorage.setItem('page','member');
    </script>
    <script src="<?=base_url()?>assets/custom/js/search.js"></script>
    <script src="<?=base_url()?>assets/custom/APIJs/member.js"></script>
    <!-- <script>
        //連到tab
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
                $('.notice_num').text(res.data.length)
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
                    friend(res['friend_list'])
                    group(res['group_list'])
                    blackList(res['black_list'])
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
                        friend(res['friend_list'])
                        group(res['group_list'])
                        blackList(res['black_list'])
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
                <a href="<?=base_url()?>driver/add-friends" class="item">
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
                        <a href="<?=base_url()?>driver/driver-Information?friend_id=${data[i].id}" class="item">
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
                    <a href="<?=base_url()?>driver/build-group" class="item">
                        建立群組
                    </a>
                </li>
                <li>
                    <a href="<?=base_url()?>driver/join-group" class="item">
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
                        href = 'driver/group-set-creator'
                    } else {
                        href = 'driver/group-set-notcreator'
                    }
                    str += 
                    `
                    <li>
                        <a href="<?=base_url()?>${href}?group_id=${data[i].id}" class="item justify-content-start">
                            <div class="icon-box list-icon-style d-flex align-items-center mr-1 primary">
                                <ion-icon name="person-circle-sharp"></ion-icon>
                            </div>
                            <div class="in">
                                <p>${data[i].title}(${data[i].cnt})</p>
                            </div>
                        </a>
                    </li>
                    `
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
                        <div>${data[i].username}</div>
                        <div class="dismiss">
                            <a href="#" class= "dismiss" data-toggle="modal" data-target="#dismiss" data-friend=${data[i].id}>
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
        $(document).on('click','.dismiss',function(e){
            e.stopPropagation();
            let friendId = $(this).data('friend');
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
                            location.reload()
                        }
                    }
                })
            })
        })
    </script> -->


</body>

</html>