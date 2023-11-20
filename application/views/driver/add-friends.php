<?php include_once (dirname(dirname(__FILE__)) . "/quote/header.php"); ?>
<script src="<?=base_url()?>assets/custom/js/tab.js"></script>
<body>

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
        <div class="pageTitle">新增好友</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="add-friend">
            <div class="section full">
                <div class="section-title">使用手機號碼新增好友</div>
                <div class="wide-block pb-2">
                    <form class="search-form" onsubmit = "return false">
                        <div class="form-group searchbox">
                            <input type="text" id="input" class="form-control search_bar" placeholder="請輸入手機號碼">
                            <i class="input-icon search">
                                <ion-icon name="search-outline"></ion-icon>
                            </i>
                            <a href="javascript:;" id="reset" class="ml-1 close toggle-searchbox">
                                <ion-icon name="close-circle"></ion-icon>
                            </a>
                        </div>
                    </form>
                </div>
                <div class="driver-list section bg-light">
                    <form class="needs-validation driverInfo" novalidate>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

    <div class="modal fade dialogbox" id="memberAddFriend" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">已加為好友</h5>
                </div>
                <div class="modal-footer">
                    <div class="btn-list">
                        <a href="#" class="btn btn-text-secondary btn-block" data-dismiss="modal">關閉</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/driver.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script src="<?=base_url()?>assets/custom/js/search.js"></script>
    <script src="<?=base_url()?>assets/custom/APIJs/add-friend.js?v=001"></script>
    <script>
        sessionStorage.setItem('page','member');
    </script>
    <!-- <script>
        let token = localStorage.getItem('token');
        let userid = localStorage.getItem('user_id');
        (function() {
            localStorage.setItem('tab','drivers');
        })();
        $('.search').on('click',function(e) {
            let searchVal = $('.search_bar').val().trim();
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
                        $('.driverInfo').text(res.msg)
                    }
                }
            })
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
                        }
                    }
                })
            })
        }
    </script> -->


</body>

</html>