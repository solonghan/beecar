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
        <div class="pageTitle">
            <!-- 2020年8月 -->
        </div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">


        <div class="transaction section full">
            <ul class="listview simple-listview">
                <!-- <li>當月總金額 : 826</li> -->
                <li class="border-bottom">
                    <div class="total_price">當月未繳總金額 : 826</div>
                    <button class="btn btn-warning btn-xs toPay">前往付款</button></li>
                <li class="d-grid bg-gray" style="padding-right: 60px;">
                    <p>日期與摘要</p>
                    <p>金額</p>
                </li>
            </ul>
            <ul class="listview link-listview p-0 border-0 record">
                <li class="border-bottom">
                    <a href="<?=base_url()?>driver/consumption-record-detail-detail" class="item" style="padding-right: 60px;">
                        <div class="in">
                            <div>
                                2020/09/03
                                <footer>抽成</footer>
                            </div>
                            <span class="text-muted">30</span>
                        </div>
                    </a>
                </li>
                <li class="border-bottom">
                    <a href="<?=base_url()?>driver/consumption-record-detail-detail" class="item" style="padding-right: 60px;">
                        <div class="in">
                            <div>
                                2020/09/04
                                <footer>啟用超級通知</footer>
                            </div>
                            <span class="text-muted">100</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- * App Capsule -->

    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/driver.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
        sessionStorage.setItem('page','member');
    </script>
    <script src="<?=base_url()?>assets/custom/js/get-parameter.js"></script> <!-- 取得網址參數 -->
    <script src="<?=base_url()?>assets/custom/APIJs/consumption-record-detail.js"></script>
</body>

</html>