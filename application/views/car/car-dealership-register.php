<html lang="en">
<?php include_once (dirname(dirname(__FILE__)) . "/quote/header.php"); ?>
<body class="bg-light">
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
            <a href="<?=base_url()?>home/login" class="headerButton">
                登入
            </a>
        </div>
    </div>
    <div id="appCapsule">
        <div class="login-form">
            <div class="section-custom">
                <h1>車行註冊</h1>
            </div>
            <div class="section mt-2 mb-5">
                <form>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label for="mobile">手機</label>
                            <input type="phone" class="form-control" id="mobile" name="mobile" placeholder="請輸入手機">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label for="mobile">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="請輸入Email">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                </form>
                <div class="mt-1 text-left">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="term">
                        <label class="custom-control-label text-muted fs-6" for="term">我同意 <a
                                href="javascript:;" class="text-primary">政策及條款</a></label>
                    </div>
                </div>
                <div class="form-button-group">
                    <input type="submit" class="registered btn btn-primary btn-block btn-lg" value="註冊">
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script src="<?=base_url()?>assets/custom/APIJs/register.js?v=001"></script>
</body>
</html>