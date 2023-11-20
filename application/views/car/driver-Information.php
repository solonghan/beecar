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
        <div class="pageTitle">阿弘</div>
        <div class="right">
            <a href="#" class="headerButton" data-toggle="modal" data-target="#DialogBlockButton">
                <ion-icon name="ellipsis-horizontal-outline"></ion-icon>
            </a>
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">


        <div class="add-friend mt-2 mb-5">
            <div class="section full">
                <div class="driver-list">
                    <form class="section needs-validation driverInfo" novalidate>

                        <!-- <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="name1">駕駛名稱</label>
                                <input type="text" class="form-control" id="name1" value="阿弘" disabled>
                                <a href="<?=base_url()?>car/edit-driver-name">
                                    <span class="icon-edit"><ion-icon name="open-outline"></ion-icon></span>
                                </a>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="driverPhone">Line帳號</label>
                                <input type="text" class="form-control" id="driverPhone" name="driverPhone" value="carcar123" disabled>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="lineAccount">Line帳號</label>
                                <input type="text" class="form-control" id="lineAccount" value="carcar123" disabled>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="brand">車輛品牌</label>
                                <input type="text" class="form-control" id="brand" value="Toyota" disabled>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="model">車輛型號</label>
                                <input type="text" class="form-control" id="model" value="RAV4" disabled>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="type">車型</label>
                                <input type="text" class="form-control" id="type" value="七人座" disabled>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="year">出廠年份</label>
                                <input type="text" class="form-control" id="year" value="2008" disabled>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="color">顏色</label>
                                <input type="text" class="form-control" id="color" value="黑" disabled>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="licensePlateNumber">車牌號碼</label>
                                <input type="text" class="form-control" id="licensePlateNumber" name="licensePlateNumber" value="ABC-1234" disabled>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div> -->
                    </form>
                </div>
                <textarea name="" id="" class="copytest" cols="30" rows="10" style="opacity: 0; height: 0px !important;width: 0px"></textarea>
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
                        <a href="add-group" id="add_group" class="btn btn-text-primary btn-block">新增至群組</a>
                        <a href="#" id="addFriend" class="btn btn-text-primary btn-block" data-dismiss="modal">加為好友</a>
                        <a href="#" id="blockadeFriend" class="btn btn-text-primary btn-block" data-dismiss="modal">封鎖</a>
                        <a href="#" id="delFriend" class="btn btn-text-primary btn-block" data-dismiss="modal">刪除好友</a>
                        <a href="#" class="btn btn-text-secondary btn-block" data-dismiss="modal">取消</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * Dialog Block Button -->

    <!-- addfriendDialog -->
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


    <!-- blockadeFriendDialog -->
    <div class="modal fade dialogbox" id="blockadeFriendDialog" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">是否封鎖阿弘?</h5>
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
                    <h5 class="modal-title">是否刪除阿弘?</h5>
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

    

    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/car.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
        sessionStorage.setItem('page','member');
    </script>
    <!-- dialogbox -->
    <script src="<?=base_url()?>assets/custom/js/dialog.js"></script>
    <script src="<?=base_url()?>assets/custom/js/get-parameter.js"></script> <!-- 取得網址參數 -->
    <script src="<?=base_url()?>assets/custom/APIJs/dirver-information.js?v=003"></script>
</body>

</html>