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
        <div class="pageTitle">新增至群組</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="section full group-list">
            <div class="pt-2">
                <div class="wide-block pb-2">
                    <form class="search-form">
                        <div class="form-group searchbox">
                            <input type="text" id="input" class="form-control" placeholder="請輸入關鍵字">
                            <i class="input-icon search">
                                <ion-icon name="search-outline"></ion-icon>
                            </i>
                            <a href="javascript:;" id="reset" class="ml-1 close toggle-searchbox">
                                <ion-icon name="close-circle"></ion-icon>
                            </a>
                        </div>
                    </form>
                </div>
                <div class="wide-block p-0">   
                    <div class="input-list group_list">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="groupName1" name="groupName1" class="custom-control-input">
                            <label class="custom-control-label" for="groupName1">快樂車車聯盟</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="groupName2" name="groupName2" class="custom-control-input">
                            <label class="custom-control-label" for="groupName2">專業夜車群</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="groupName3" name="groupName3" class="custom-control-input">
                            <label class="custom-control-label" for="groupName3">跑跑卡丁車</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="groupName4" name="groupName4" class="custom-control-input">
                            <label class="custom-control-label" for="groupName4">手排車聯盟</label>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
        <div class="section">
            <input type="submit" class="btn btn-primary btn-lg btn-block" value="新增" data-toggle="modal" data-target="#addGroup">
        </div>
    </div>
    <!-- * App Capsule -->
    <div class="modal fade dialogbox" id="addGroup" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">已新增至群組</h5>
                </div>
                <div class="modal-footer">
                    <div class="btn-list">
                        <a href="javascript:history.back()" class="btn btn-text-secondary btn-block">關閉</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/driver.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script src="<?=base_url()?>assets/custom/js/search.js"></script>
    <script src="<?=base_url()?>assets/custom/js/get-parameter.js"></script> <!-- 取得網址參數 -->
    <script src="<?=base_url()?>assets/custom/APIJs/add-group.js"></script>
    <script>
        sessionStorage.setItem('page','member');
    </script>
    <!-- <script>
        let token = localStorage.getItem('token');
        let friendId = $.urlParam('friend_id');
        $.ajax({
            url: baseUrl + 'api/my_groups',
            type:'POST',
            dataType: 'json',
            data: {
                token: token
            },
            success: function(res) {
                if(res.status) {
                    rendor(res.data)
                }
            }
        })
        function rendor(data) {
            let str = '';
            if (data == []) {
                str = ''
            } else {
                data.forEach(item => {
                str += 
                `
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" id="group_id${item.id}" name="group[]" class="custom-control-input" value="${item.id}">
                    <label class="custom-control-label" for="group_id${item.id}">${item.title}</label>
                </div>
                    `
                })
            }
            $('.group_list').html(str)
        }
        $('input[type="text"]').on('keyup',function(e) {
            let searchVal = $(this).val().trim();
            if (searchVal !== '') {
                $.ajax({
                    url: baseUrl + 'api/my_groups',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        token: token,
                        search: searchVal
                    },
                    success: function(res) {
                        if (res.status) {
                            rendor(res.data)
                        }
                    }
                })
            } else {
                allData();
            }
        })
        function allData() {
            $.ajax({
                url: baseUrl + 'api/my_groups',
                type:'POST',
                dataType: 'json',
                data: {
                    token: token
                },
                success: function(res) {
                    if(res.status) {
                        rendor(res.data)
                    }
                }
            })
        }
        $('input[type="submit"]').on('click',function(e) {
            e.preventDefault();
            let searchIDs = $("input[name='group[]']:checked").map(function(){
            return $(this).val();
            }).get();
            $.ajax({
                url: baseUrl + 'api/add_friend_join_groups',
                type: 'POST',
                dataType: 'json',
                data: {
                    token: token,
                    driver_id: friendId,
                    group_id: searchIDs
                },
                success: function(res) {
                    console.log(res);
                }
            })
        })
    </script> -->


</body>

</html>