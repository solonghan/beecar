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
        <div class="pageTitle">加值服務</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">


        <div class="section full">
            <ul class="listview link-listview">
                <li><a href="<?=base_url()?>driver/value-add-notice">超級通知功能</a></li>
                <!-- <li><a href="<?=base_url()?>driver/set-credit">信用卡設定</a></li>
                <li><a href="<?=base_url()?>driver/transaction-record">行程交易紀錄</a></li> -->
                <li><a href="<?=base_url()?>driver/consumption-record">消費紀錄</a></li>
            </ul>
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