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
        <div class="pageTitle">消費紀錄</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">


        <div class="section full">
            <ul class="listview simple-listview border-0">
                <!-- <li>當月總金額 : 826</li> -->
                <li class="border-bottom d-grid">
                    <div class="col-3 pl-0 text-nowrap">交易日期</div>
                    <div class="col-9 pr-0 text-nowrap transcation_date">
                        <!-- 2020/09/16 -->
                    </div>
                </li>
                <li class="border-bottom d-grid">
                    <div class="col-3 pl-0 text-nowrap">應扣金額</div>
                    <div class="col-9 pr-0 text-nowrap discount_price">
                        <!-- 18 -->
                    </div>
                </li>
                <li class="border-bottom d-grid">
                    <div class="col-3 pl-0 text-nowrap">詳情</div>
                    <div class="col-9 pr-0 text-nowrap month_content">
                        <!-- 抽成 -->
                    </div>
                </li>
            </ul>
        </div>
        <div class="section mb-3 mt-2">
            <div class="schedule-details card js-schedule-details">
                <div class="card-body">
                    <h5 class="card-title date">
                        2020/12/10
                    </h5>
                    <p class="card-subtitle time">10:30</p>
                    <div class="card-text">
                        <p>起點 : 
                            <span class="address_start">台北市中山區大同區承德路三段83號</span></p>
                        <p>目的地:
                            <span  class="address_end">
                                台北市萬華區和平西路三段182號
                            </span></p>
                    </div>
                    <div class="card-bottom">
                        <div class="remark">
                            <p>行李數 : 
                                <span class="baggage">
                                    <!-- 2 -->
                                </span>件 / 乘客數 : 
                                <span class="number">
                                    <!-- 3 -->
                                </span>人</p>
                            <p class="">
                                車型 : 
                                <span class="car_model">五人座</span>
                            </p>
                            <div class="d-flex justify-content-between">
                                <div>支付方式 : 
                                    <span class="price_type">
                                        <!-- 現金 -->
                                    </span>
                                </div>
                                <div class="price">
                                    <span class="final_status">
                                        <!-- 回金 :  -->
                                    </span>$
                                    <span class="final_payment">
                                        <!-- 200 -->
                                    </span></div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div><a href="<?=base_url()?>driver/undertack-drive-information"><p>派遣人 : 
                                    <span class="sender_name">
                                        <!-- 林小美 -->
                                    </span></p></a></div>
                                <div class="price">車資 : $
                                    <span class="carPrice">
                                        <!-- 600 -->
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/driver.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
        sessionStorage.setItem('page','member');
    </script>
    <script src="<?=base_url()?>assets/custom/js/get-parameter.js"></script> <!-- 取得網址參數 -->
    <script src="<?=base_url()?>assets/custom/APIJs/consumption-record-detail-detail.js"></script>
</body>

</html>