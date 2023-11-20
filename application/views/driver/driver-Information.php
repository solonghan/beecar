<?php include_once (dirname(dirname(__FILE__)) . "/quote/header.php"); ?>
<script src="<?=base_url()?>assets/custom/js/tab.js"></script>
<body class="bg-light">
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle"></div>
        <div class="right">
            <a href="#" class="headerButton" data-toggle="modal" data-target="#DialogBlockButton">
                <ion-icon name="ellipsis-horizontal-outline"></ion-icon>
            </a>
        </div>
    </div>
    <div id="appCapsule">
        <div class="add-friend mt-2 mb-5">
            <div class="section full">
                <div class="driver-list">
                    <form id="" class="section needs-validation driverInfo" novalidate>
                    </form>
                </div>
                <textarea name="" id="copytest" class="copytest" style="opacity: 0; height: 0px !important;width: 0px"></textarea>
                <!-- opacity: 0; height: 0px !important;width: 0px -->
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

    <!-- Dialog Block Button -->
    <div class="modal fade dialogbox" id="DialogBlockButton" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">請選擇動作</h5>
                </div>
                <div class="modal-footer">
                    <div class="btn-list">
                        <a href="#" class="btn btn-text-primary btn-block copy" data-dismiss="modal" data-clipboard-target=".copytest">複製駕駛資料</a>
                        <a href="<?=base_url()?>driver/add-group" id="add_group" class="btn btn-text-primary btn-block">新增至群組</a>
                        <a href="#" id="addFriend" class="btn btn-text-primary btn-block" data-dismiss="modal">加為好友</a>
                        <a href="#" id="blockadeFriend" class="btn btn-text-primary btn-block" data-dismiss="modal">封鎖</a>
                        <a href="#" id="delFriend" class="btn btn-text-primary btn-block" data-dismiss="modal">刪除好友</a>
                        <a href="#" class="btn btn-text-secondary btn-block" data-dismiss="modal">取消</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade dialogbox" id="addfriendDialog" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                </div>
                <div class="modal-footer">
                    <div class="btn-list">
                    <div class="btn-inline">
                        <a href="#" class="btn btn-text-secondary" data-dismiss="modal">否</a>
                        <a href="#" class="btn btn-text-primary add_Y" data-dismiss="modal">是</a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade dialogbox" id="blockadeFriendDialog" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                </div>
                <div class="modal-footer">
                    <div class="btn-inline">
                        <a href="#" class="btn btn-text-secondary" data-dismiss="modal">否</a>
                        <a href="#" class="btn btn-text-primary black_Y" data-dismiss="modal">是</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade dialogbox" id="delFriendDialog" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                </div>
                <div class="modal-footer">
                    <div class="btn-inline">
                        <a href="#" class="btn btn-text-secondary" data-dismiss="modal">否</a>
                        <a href="#" class="btn btn-text-primary del_Y" data-dismiss="modal">是</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="copyorder" class="toast-box toast-top">
        <div class="in">
            <div class="text">
                已複製駕駛資料
            </div>
        </div>
    </div>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/driver.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
        sessionStorage.setItem('page','member');
    </script>
    <script src="<?=base_url()?>assets/custom/js/dialog.js"></script>
    <script src="<?=base_url()?>assets/custom/js/get-parameter.js"></script> <!-- 取得網址參數 -->
    <script src="<?=base_url()?>assets/custom/APIJs/dirver-information.js?v=003"></script>
</body>

</html>