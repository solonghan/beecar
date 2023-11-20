<html lang="en">
<?php include_once (dirname(dirname(__FILE__)) . "/quote/header.php"); ?>
<body class="bg-white">
    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>

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
    <div id="appCapsule">
        <div class="login-form">
            <div class="section">
                <h1 class="fs-5 fw-light">設置密碼</h1>
            </div>
            <div class="section mt-2 mb-5">
                <form>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label for="password">密碼</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="請輸入密碼">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label for="confirm_password">確認密碼</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="請再次輸入密碼">
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
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script src="<?=base_url()?>assets/custom/APIJs/set-password.js"></script>
</body>

</html>