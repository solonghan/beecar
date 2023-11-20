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
                            <li><a href="<?=base_url()?>car/basic-Information">基本資料</a></li>
                            <li>
                                <a href="<?=base_url()?>car/notification">
                                    通知中心
                                    <span class="badge badge-primary notice_num"></span>
                                </a>
                            </li>
                            <li><a href="<?=base_url()?>car/trip-record">行程紀錄</a></li>
                            <li><a href="#">分享功能</a></li>
                            <li><a href="<?=base_url()?>car/Instructions-for-use">使用說明</a></li>
                        </ul>
                        <ul class="listview">
                            <li class="d-flex signOut"><a href="#" class="info">登出</a></li>
                        </ul>
                    </div>

                </div>
                <!-- * set tab -->
                <!-- drivers tab -->
                <div class="tab-pane fade" id="drivers" role="tabpanel">

                    <div class="section full mt-1">
                        <div class="section full mt-2">
                            <div class="wide-block pb-2">
                                <form class="search-form">
                                    <div class="form-group searchbox">
                                        <input type="text" id="input" class="form-control search_bar" placeholder="請輸入關鍵字">
                                        <i class="input-icon search_icon">
                                            <ion-icon name="search-outline"></ion-icon>
                                        </i>
                                        <a href="javascript:;" id="reset" class="ml-1 close toggle-searchbox" style="display: none;">
                                            <ion-icon name="close-circle"></ion-icon>
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
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
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/car.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
        sessionStorage.setItem('page','member');
    </script>
    <script src="<?=base_url()?>assets/custom/js/search.js"></script>
    <script src="<?=base_url()?>assets/custom/APIJs/member.js"></script>
</body>

</html>