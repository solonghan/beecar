<?php include_once (dirname(dirname(__FILE__)) . "/quote/header.php"); ?>

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

                        <!-- <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="name1">駕駛名稱</label>
                                <input type="text" class="form-control" id="name1" value="阿弘" disabled>
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
                                <input type="text" class="form-control" id="brand" name="brand" value="Toyota" disabled>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="carmodel">車輛型號</label>
                                <input type="text" class="form-control" id="carModel" name="carmodel" value="RAV4" disabled>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="cartype">車型</label>
                                <input type="text" class="form-control" id="carType" name="cartype" value="七人座" disabled>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="manufacture">出廠年份</label>
                                <input type="text" class="form-control" id="manufacture" name="manufacture" value="2008" disabled>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="carcolor">顏色</label>
                                <input type="text" class="form-control" id="carColor" name="carcolor" value="黑" disabled>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div> -->
                    </form>
                    <!-- <div class="pt-2 pb-2">
                        <input type="button" class="btn btn-primary btn-lg btn-block" value="加入好友" data-toggle="modal" data-target="#memberAddFriend"></input>
                    </div> -->
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
                        <a href="<?=base_url()?>car/member#drivers" class="btn btn-text-secondary btn-block">關閉</a>
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
    <script src="<?=base_url()?>assets/custom/APIJs/add-friend.js?v=001"></script>
</body>

</html>