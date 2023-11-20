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
        <div class="pageTitle">付款結果</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">


        <div class="section full flex-column d-flex justify-content-center align-items-center px-3">
            <div style="font-size: 26px;line-height:39px;color:#141515;margin-bottom:37px;margin-top:64px">付款成功</div>
            <ion-icon name="checkmark-circle" style="font-size:90px;color:#24A539;margin-bottom:99px"></ion-icon>
            <a href="<?=base_url()?>driver/consumption-record-detail-detail" class="btn btn-primary btn-lg btn-block">回消費紀錄</a>
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