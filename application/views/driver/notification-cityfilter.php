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
        <div class="pageTitle">城市篩選</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">


        <?php include_once (dirname(dirname(__FILE__)) . "/quote/cityfilter.php"); ?>
        <div class="section">
            <input type="button" class="btn btn-primary btn-lg btn-block" value="確認" onclick="window.location='<?=base_url()?>driver/notification-addfilter';"></input>
        </div>



    </div>
    <!-- * App Capsule -->

    <?php include_once (dirname(dirname(__FILE__)) . "/quote/bottom-menu.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script src="<?=base_url()?>assets/custom/js/cityfilter.js"></script>


</body>

</html>