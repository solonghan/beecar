<!doctype html>
<html lang="en">

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
        <div class="pageTitle"></div>
        <div class="right">
            <a href="#" class="headerButton" data-toggle="modal" data-target="#DialogBlockButton">
                <ion-icon name="ellipsis-horizontal-outline"></ion-icon>
            </a>
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">


        <div class="add-friend mt-2">
            <div class="section full">
                <div class="driver-list">
                    <form class="section needs-validation driverInfo" novalidate>
                        <!-- 
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="name1">駕駛名稱</label>
                                <input type="text" class="form-control" id="name1" value="" disabled>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="phone">電話</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="" disabled>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="lineAccount">Line帳號</label>
                                <input type="text" class="form-control" id="lineAccount" value="" disabled>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="licensePlateNumber">車牌號碼</label>
                                <input type="text" class="form-control" id="licensePlateNumber" name="licensePlateNumber" value="" disabled>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div> -->
                    </form>
                </div>
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
                        <a href="<?=base_url()?>driver/add-group" id="add_group" class="btn btn-text-primary btn-block">新增至群組</a>
                        <a href="#" id="addFriend" class="btn btn-text-primary btn-block" data-dismiss="modal">加為好友</a>
                        <a href="#" id="blockadeFriend" class="btn btn-text-primary btn-block" data-dismiss="modal">封鎖</a>
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
                    <h5 class="modal-title"></h5>
                </div>
                <div class="modal-footer">
                    <div class="btn-inline">
                        <a href="#" class="btn btn-text-secondary" data-dismiss="modal">否</a>
                        <a href="#" class="btn btn-text-primary block_Y" data-dismiss="modal">是</a>
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
    <script src="<?=base_url()?>assets/custom/js/dialog.js"></script>
    <script src="<?=base_url()?>assets/custom/js/get-parameter.js"></script> <!-- 取得網址參數 -->
    <script src="<?=base_url()?>assets/custom/APIJs/undertack-drive-information.js?v=001"></script>
</body>

</html>