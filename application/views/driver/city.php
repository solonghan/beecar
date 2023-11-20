<?php include_once (dirname(dirname(__FILE__)) . "/quote/header.php"); ?>
<body>
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">城市篩選</div>
        <div class="right"></div>
    </div>
    <div id="appCapsule">
        <?php include_once (dirname(dirname(__FILE__)) . "/quote/cityfilter.php"); ?>
        <div class="section">
            <input type="submit" class="btn btn-primary btn-lg btn-block" value="確認"></input>
        </div>
    </div>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/driver.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
</body>

</html>