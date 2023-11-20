<?php include_once(dirname(dirname(__FILE__)) . "/quote/header.php"); ?>

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
        <div class="pageTitle">已接行程</div>
        <div class="right">
            <!-- 超級通知位置 -->
            <a href="<?=base_url()?>driver/notification-filter" class="headerButton">
                <ion-icon name="flash-outline"></ion-icon>
            </a>
            <!-- <a href="<?=base_url()?>driver/undertack-filter" class="headerButton">
                <ion-icon name="funnel-outline"></ion-icon>
            </a> -->
        </div>
    </div>
    <!-- * App Header -->
    <!-- App Capsule -->
    <div id="appCapsule-no-header">

        <div class="header-large-title">
            <div class="title">
                <h1>
                    <!-- 林正義，早安! -->
                    <a href="<?= base_url() ?>driver/notification-filter">
                        <ion-icon name="flash-outline"></ion-icon>
                    </a>
                </h1>
                <h4 class="subtitle fs-6 mb-3">累積趟數:52</h4>
            </div>
        </div>

        <h2 class="section fs-5 mb-1">執行行程</h2>
        <div class="section js_section">
            <!-- <div class="card-Itinerary-execution">
                <div class="card">
                    <div class="card-body">
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
                            <p>起點 : 台北市中山區中山北路一段59號</p>
                            <p>目的地 : 台北市大同區太原路二段72號</p>
                        </div>
                        <div class="card-bottom">
                            <div class="remark">
                                <p>支付方式 : 現金</p>
                                <p>派遣人 : 林小美</p>
                            </div>
                            <div class="price">
                                <p>回金 : $200</p>
                                <p>車資 : $600</p>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
            <div class="card-Itinerary-execution">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            2020/12/10
                            <a href="#" data-toggle="modal" data-target="#lightdialog">
                                <span class="status dispatched">
                                    未執行
                                </span>
                            </a>
                        </h5>
                        <p class="card-subtitle">11:30</p>
                        <div class="card-text">
                            <p>起點 : 台北市中山區大同區承德路三段83號</p>
                            <p>目的地 : 台北市萬華區和平西路三段182號</p>
                        </div>
                        <div class="card-bottom">
                            <div class="remark">
                                <p>支付方式 : 現金</p>
                                <p>派遣人 : 王小恩</p>
                            </div>
                            <div class="price">
                                <p>回金 : $200</p>
                                <p>車資 : $600</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>

        <!-- <div class="section">
            <div class="card-Itinerary-execution">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            2020/12/11
                        </h5>
                        <p class="card-subtitle">10:50</p>
                        <div class="card-text">
                            <p>起點 : 台北市中山區大同區承德路三段83號</p>
                            <p>目的地 : 台北市萬華區和平西路三段182號</p>
                        </div>
                        <div class="card-bottom">
                            <div class="remark">
                                <p>支付方式 : 現金</p>
                                <p>派遣人 : 周花花</p>
                            </div>
                            <div class="price">
                                <p>回金 : $200</p>
                                <p>車資 : $600</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

    </div>
    <!-- * App Capsule -->
    <!-- lightdialog -->
    <div class="modal fade dialogbox order_log_modal" id="lightdialog" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="light-dialog modal-body fs-6">
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
                    </ul>
                    <div class="divider bg-primary mt-2 mb-2"></div>
                    <p class="text-left">2020/12/11</p>
                    <ul class="">
                        <li>
                            <div class="dialog-content">13 : 30</div>
                            <div class="dialog-content">指定駕駛</div>
                            <div class="dialog-content">
                                <p>阿明</p>
                            </div>
                        </li>
                    </ul> -->

                </div>
                <div class="modal-footer">
                    <div class="btn-list">
                        <a href="#" class="btn btn-block" data-dismiss="modal">關閉</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once(dirname(dirname(__FILE__)) . "/quote/menu/driver.php"); ?>

    <!-- welcome notification  -->
    <!-- <div id="notification-welcome" class="notification-box">
        <div class="notification-dialog android-style">
            <div class="notification-header">
                <div class="in">
                    <strong>蜜蜂派車</strong>
                    <span>現在</span>
                </div>
                <a href="#" class="close-button">
                    <ion-icon name="close"></ion-icon>
                </a>
            </div>
            <div class="notification-content">
                <div class="in">
                    <h3 class="subtitle">超級通知</h3>
                    <div class="text">
                        有一個行程符合您的通知，點擊前往查看。
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <?php include_once(dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script src="<?= base_url() ?>assets/custom/APIJs/driver-index.js?v=001"></script>
</body>

</html>