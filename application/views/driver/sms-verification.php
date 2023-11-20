<html lang="en">
<?php include_once (dirname(dirname(__FILE__)) . "/quote/header.php"); ?>
<body class="bg-light">

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
                <h1 class="fs-5 fw-light">請輸入手機驗證碼</h1>
            </div>
            <div class="section mt-2 mb-5">
                <form>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="text" class="form-control verify-input" id="smscode" name="smscode" placeholder="••••••" maxlength="6">
                        </div>
                    </div>
                </form>
                <div class="resend-verification">
                    <input type="button" class="btn btn-block btn-outline-primary" value='重發驗證碼'>
                </div>
                <div class="form-button-group">
                    <input type="submit" class="btn btn-primary btn-block btn-lg" value="下一步">
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script src="<?=base_url()?>assets/custom/APIJs/sms-verification.js"></script>
</body>

</html>