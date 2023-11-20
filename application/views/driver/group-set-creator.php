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
        <div class="pageTitle">群組設定</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="group section full">
            <ul class="listview link-listview group_detail">
            </ul>
        </div>
    </div>
    <!-- * App Capsule -->

    <!-- Dialog Basic -->
    <div class="modal fade dialogbox" id="DialogBasic" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">是否刪除群組?</h5>
                </div>
                <div class="modal-footer">
                    <div class="btn-inline">
                        <a href="javascript:;" class="btn btn-text-secondary del_N" data-dismiss="modal">否</a>
                        <a href="javascript:;" class="btn btn-text-primary del_Y">是</a>
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
    <script src="<?=base_url()?>assets/custom/js/get-parameter.js"></script> <!-- 取得網址參數 -->
    <script src="<?=base_url()?>assets/custom/APIJs/group-set-creator.js"></script>
    <!-- <script>
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
                if (res.status) {
                    rendor(res.data)
                }
            },
        })
        function rendor(data) {
            str = 
            `
            <li>
                <a href="<?=base_url()?>driver/edit-group-name?group_id=${data.id}">
                    群組名稱
                    <span class="text-info">${data.title}</span>
                </a>
            </li>
            <li>
                <a href="<?=base_url()?>driver/edit-groupnumber?group_id=${data.id}">
                    群組碼
                    <span class="text-info">${data.code}</span>
                </a>
            </li>
            <li>
                <li class="simpleListview">
                    建立人
                    <span class="text-info">${data.creater}</span>
                </li>
            </li>
            <li>
                <a href="<?=base_url()?>driver/group-member?group_id=${data.id}">
                    成員名單
                </a>
            </li>
            <li>
                <a href="#DialogBasic" data-toggle="modal" data-target="#DialogBasic">
                    刪除群組
                </a>
            </li>
            `
            $('.group_detail').html(str)
        }
        $('.del_Y').on('click',function(e) {
            $.ajax({
                url: baseUrl + 'api/del_group',
                type: 'POST',
                dataType: 'json',
                data: {
                    token: token,
                    group_id: id
                },
                success: function(res) {
                    if (res.status) {
                        alert(res.msg)
                        history.back();
                    }
                }
            })
        })
    </script> -->


</body>

</html>