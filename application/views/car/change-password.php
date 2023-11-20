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
        <div class="pageTitle">變更密碼</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">

        <div class="member">
            <div class="section full mt-2 mb-2">
                <div class="wide-block pb-3">
                    <form class="needs-validation" novalidate>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="name1">目前密碼</label>
                                <input type="password" class="form-control" id="password1" placeholder="請輸入目前密碼" required>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                                <div class="invalid-feedback">請輸入密碼</div>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="name1">新密碼</label>
                                <input type="password" class="form-control" id="NewPassword" placeholder="請輸入新密碼" required>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                                <div class="invalid-feedback">請輸入新密碼</div>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="name1">確認密碼</label>
                                <input type="password" class="form-control" id="NewPasswordAgain" placeholder="請輸入新密碼" required>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                                <div class="invalid-feedback">請輸入密碼</div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="form-button-group mb-6 fs-5">
                <input type="button" class="btn btn-primary btn-block" value="變更" data-toggle="modal" data-target="#changePassword"></input>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

    <div class="modal fade dialogbox" id="changePassword" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">已變更密碼</h5>
                </div>
                <div class="modal-footer">
                    <div class="btn-list">
                        <a href="<?=base_url()?>car/basic-Information" class="btn btn-text-secondary btn-block">關閉</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/car.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
        sessionStorage.setItem('page','member');
    </script>
    <script src="<?=base_url()?>assets/custom/APIJs/change-password.js?v=001"></script>


</body>

</html>