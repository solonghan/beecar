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
        <div class="pageTitle">建立群組</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">


        <div class="section mt-1 mb-2">
            <div class="formgroup">
                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <label class="label" for="groupName">群組名稱</label>
                        <input type="text" class="form-control" id="groupName" name="groupName" placeholder="請輸入群組名稱" required>
                    </div>
                </div>

                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <label class="label" for="groupCode">群組碼 (其他駕駛可輸入以加入群組)</label>
                        <input type="text" class="form-control" id="groupCode" name="groupCode" placeholder="請設定群組碼" required>
                    </div>
                    <div class="alertText check_code_msg">
                    </div>
                </div>
            </div>
            <div class="form-button-group bottomMenu-button">
                <input type="button" class="btn btn-primary btn-block" value="下一步"></input>
            </div>
        </div>



    </div>
    <!-- * App Capsule -->

    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/car.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
        sessionStorage.setItem('page','member');
    </script>
    <script src="<?=base_url()?>assets/custom/APIJs/build-group.js"></script>

</body>

</html>