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
        <div class="pageTitle fs-5">已接行程詳情</div>
        <div class="right">
            <a href="#" class="headerButton" data-toggle="modal" data-target="#operating">
                <ion-icon name="ellipsis-horizontal-outline"></ion-icon>
            </a>
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="section mb-3 mt-2">
            <div class="schedule-details card js-schedule-details">
                <!-- <div class="card-body">
                    <h5 class="card-title">
                        2020/12/10
                        <a href="#" data-toggle="modal" data-target="#lightdialog">
                            <span class="status processing">
                                抵達起點
                            </span>
                        </a>
                    </h5>
                    <p class="card-subtitle">10:30</p>
                    <div class="card-text">
                        <p>起點 : 台北市中山區大同區承德路三段83號</p>
                        <p>目的地 : 台北市萬華區和平西路三段182號</p>
                    </div>
                    <div class="card-bottom">
                        <div class="remark">
                            <p>聯絡人名稱 : 王曉華</p>
                            <p>聯絡人電話 : 0912345678</p>
                            <p>航班編號 : FQV1316</p>
                            <p>車型 : 五人座</p>
                            <p>行李數 : 2件 / 乘客數 : 3人</p>
                            <p>備註 : 有寵物狗，行李很重</p>
                            <p>支付方式 : 現金</p>
                            <a href="<?=base_url()?>driver/undertack-drive-information"><p>派遣人 : 林小美</p></a>
                        </div>
                        <div class="price">
                            <p>回金 : $200</p>
                            <p>車資 : $600</p>
                        </div>
                    </div>
                </div> -->
            </div>
            <button type="button" class="btn btn-primary btn-lg btn-block js-status">前往起點</button>
            <!-- <button type="button" class="btn btn-outline-primary btn-lg btn-block" data-toggle="modal" data-target="#cancelTheTrip">取消行程</button> -->
        </div>


    </div>
    <!-- * App Capsule -->

            <!-- Dialog box -->
            <div class="modal fade dialogbox order_log_modal" id="lightdialog" data-backdrop="static" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="light-dialog modal-body fs-6">
                            <div class="order_log">
                                <!-- <p class="text-left">2020/12/10</p>
                                <ul class="">
                                    <li>
                                        <div class="dialog-content">13 : 30</div>
                                        <div class="dialog-content">自由承接</div>
                                        <div class="dialog-content">
                                            <p>台北安心群</p>
                                            <p>肯驛車隊</p>
                                            <p>王大頭</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dialog-content">13 : 45</div>
                                        <div class="dialog-content">指定駕駛</div>
                                        <div class="dialog-content">
                                            <p>陳老大</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dialog-content">13 : 30</div>
                                        <div class="dialog-content">取消駕駛</div>
                                        <div class="dialog-content"></div>
                                    </li>
                                </ul> -->
                            </div>                           
                        </div>
                        <div class="modal-footer">
                            <div class="btn-list">
                                <a href="#" class="btn btn-block" data-dismiss="modal">關閉</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


    <!-- Dialog Basic -->
    <div class="modal fade dialogbox" id="deleteItinerary" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">是否確定取消行程</h5>
                </div>
                <div class="modal-footer">
                    <div class="btn-inline">
                        <a href="#" class="btn btn-text-secondary" data-dismiss="modal">否</a>
                        <a href="#" class="btn btn-text-primary cancel_trip" data-dismiss="modal">是</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * Dialog Basic -->
    <div class="modal fade dialogbox" id="statusItinerary" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">是否開始行程</h5>
                </div>
                <div class="modal-footer">
                    <div class="btn-inline">
                        <a href="#" class="btn btn-text-secondary" data-dismiss="modal">否</a>
                        <a href="#" class="btn btn-text-primary yes" data-dismiss="modal">是</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade dialogbox" id="operating" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">請選擇動作</h5>
                </div>
                <div class="modal-footer">
                    <div class="btn-list">
                        <a href="#" class="btn btn-text-primary btn-block operating" data-dismiss="modal">取消行程</a>
                        <a href="#" class="btn btn-text-secondary btn-block" data-dismiss="modal">取消</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/driver.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
    </script>
    <script src="<?=base_url()?>assets/custom/js/dialog.js"></script>
    <script src="<?=base_url()?>assets/custom/js/get-parameter.js"></script> <!-- 取得網址參數 -->
    <script src="<?=base_url()?>assets/custom/APIJs/Itinerary-execution.js?v=001"></script>
</body>

</html>