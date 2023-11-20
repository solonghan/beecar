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
        <div class="pageTitle">行程交易紀錄</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">


        <div class="transaction section full">
            <ul class="listview simple-listview">
                <li>目前應扣總額 : 380</li>
                <li class="d-flex bg-gray">
                    <p>日期與摘要</p>
                    <p>應扣金額</p>
                </li>
            </ul>
            <ul class="listview link-listview p-0">
                <li>
                    <a href="<?=base_url()?>driver/transaction-record-detail" class="item">
                        <div class="in">
                            <div>
                                2020/09/16
                                <footer>抽成</footer>
                            </div>
                            <span class="text-muted">18</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?=base_url()?>driver/transaction-record-detail" class="item">
                        <div class="in">
                            <div>
                                2020/09/26
                                <footer>抽成</footer>
                            </div>
                            <span class="text-muted">100</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?=base_url()?>driver/transaction-record-detail" class="item">
                        <div class="in">
                            <div>
                                2020/10/02
                                <footer>抽成</footer>
                            </div>
                            <span class="text-muted">60</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?=base_url()?>driver/transaction-record-detail" class="item">
                        <div class="in">
                            <div>
                                2020/10/03
                                <footer>抽成</footer>
                            </div>
                            <span class="text-muted">80</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?=base_url()?>driver/transaction-record-detail" class="item">
                        <div class="in">
                            <div>
                                2020/10/04
                                <footer>抽成</footer>
                            </div>
                            <span class="text-muted">18</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?=base_url()?>driver/transaction-record-detail" class="item">
                        <div class="in">
                            <div>
                                2020/10/05
                                <footer>抽成</footer>
                            </div>
                            <span class="text-muted">60</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>

        <div class="transaction-description section mb-2">
            <p>
                說明 : <br>
                交易金額達1000元，或是繳款後第一筆交易後30天（視何者先到）作一次扣款，
                統一使用信用卡扣款，並發送電子發票，收費金額為該執行車資的3%，最低5元，
                執行行程結束後才列入費用計算，扣款時若有小數點去掉小數點取整數（例：862.89元，
                計算為862元。
            </p>
        </div>
    </div>
    <!-- * App Capsule -->

    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/driver.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
        sessionStorage.setItem('page','member');
    </script>


</body>

</html>