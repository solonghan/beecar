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
        <div class="pageTitle">編輯駕駛名稱</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="add-friend">
            <div class="section full mt-2">
                <div class="driver-list">
                    <form class="section needs-validation" novalidate>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="name1">駕駛名稱</label>
                                <input type="text" class="form-control edit_name" id="name1" value="" required>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                                <div class="invalid-feedback">請輸入駕駛名稱.</div>
                            </div>
                        </div>

                    </form>
                    <div class="form-button-group fix-btn">
                        <input type="submit" class="btn btn-primary btn-block btn-lg" value="儲存" onclick="window.location='<?=base_url()?>car/driver-Information';"></input>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/car.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
        sessionStorage.setItem('page','member');
    </script>
    <script src="<?=base_url()?>assets/custom/js/get-parameter.js"></script> <!-- 取得網址參數 -->
    <script src="<?=base_url()?>assets/custom/APIJs/edit-driver-name.js"></script>
</body>

</html>