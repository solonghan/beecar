<?php include_once(dirname(dirname(__FILE__)) . "/quote/header.php"); ?>

<body class="bg-white">

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader no-border transparent position-absolute">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle"></div>
        <div class="right">
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="login-form">
            <div class="section">
                <h1 class="fs-5 fw-light">設定車輛資料</h1>
            </div>
            <div class="section mt-2 mb-5">
                <form>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="brand">品牌</label>
                            <input type="name" class="form-control" id="brand" name="brand" placeholder="請輸入品牌">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="model">型號</label>
                            <input type="text" class="form-control" id="model" name="model" placeholder="請輸入型號">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="type">車型</label>
                            <select class="form-control custom-select" id="type" >
                                <option value="" selected disabled>請選擇</option>
                                <option value="轎車/休旅車(5人座)">轎車/休旅車(5人座)</option>
                                <option value="休旅車(7人座)">休旅車(7人座)</option>
                                <option value="商務車(9人座)">商務車(9人座)</option>
                                <option value="小巴(09~15人座)">小巴(09~15人座)</option>
                                <option value="中巴(20~28人座)">中巴(20~28人座)</option>
                                <option value="大巴(32~43人座)">大巴(32~43人座)</option>
                            </select>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="year">出廠年份</label>
                            <input type="text" class="form-control" id="year" name="year" placeholder="出廠年份">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="color">顏色</label>
                            <input type="text" class="form-control" id="color" name="color" placeholder="顏色">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="plate">車牌號碼</label>
                            <input type="text" class="form-control" id="plate" name="plate" placeholder="車牌號碼">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                </form>
                <div class="form-button-group">
                    <input type="submit" class="btn btn-primary btn-block btn-lg" value="下一步">
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->
    <?php include_once(dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script src="<?= base_url() ?>assets/custom/APIJs/set-carinfo.js"></script>
</body>

</html>