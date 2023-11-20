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


        <div class="section full">
            <ul class="transaction-list listview">
                <li><span class="list-title">交易日期</span>2020/10/05</li>
                <li><span class="list-title">應扣金額</span>18</li>
                <li><span class="list-title-mr60">詳情</span>抽成</li>
            </ul>
        </div>
        <div class="section mt-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        2020/12/10
                    </h5>
                    <p class="card-subtitle">7:30</p>
                    <div class="card-text">
                        <p>起點 : 台北市中山北路一段</p>
                        <p>終點 : 台北市太原路二段</p>
                    </div>
                    <div class="card-bottom">
                        <div class="remark">
                            <p>行李數 : 2件 / 乘客數 : 3人</p>
                            <p>支付方式 : 現金</p>
                            <p>車型 : 五人座</p>
                            <p>派遣人 : 毛毛</p>
                        </div>
                        <div class="price">
                            <p>回金 : $200</p>
                            <p>車資 : $600</p>
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


</body>

</html>