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
        <div class="pageTitle">群組碼</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="group-edit">
            <div class="section mt-2">
                <div class="driver-list">
                    <form class="needs-validation edit_group_num" novalidate>
                    </form>
                    <div class="form-button-group bottomMenu-button">
                        <input type="submit" class="btn btn-primary btn-block btn-lg" value="儲存">
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
    <script src="<?=base_url()?>assets/custom/js/get-parameter.js"></script> <!-- API-取得網址參數 -->
    <script src="<?=base_url()?>assets/custom/APIJs/edit-groupnumber.js"></script>
</body>

</html>