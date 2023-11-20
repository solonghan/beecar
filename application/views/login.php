<?php include_once ("quote/header.php"); ?>

<body class="bg-white">

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->
    <!-- App Capsule -->
    <div id="appCapsule" class="pt-0">
        <div class="login login-form mt-1">
            <div class="section-custom">
                <img src="<?=base_url()?>assets/custom/img/loginimg.png" alt="image" class="form-image">
            </div>
            <div class="section-custom mt-1">
                <h1>登入</h1>
            </div>
            <div class="section mt-1 mb-5">
                <form>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="email" class="form-control" id="accout" placeholder="手機">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="password" class="form-control" id="password" placeholder="密碼">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                </form>    
                <div class="custom-control custom-checkbox text-left">
                    <input type="checkbox" class="custom-control-input remember" id="customCheckb1" name="member">
                    <label class="custom-control-label" for="customCheckb1">記住我</label>
                </div>
                <div class="form-links mt-1 register">
                    <div class="d-flex">
                        <a href="<?=base_url()?>driver/driver-register" id="driver" class="text-primary pr-1 border-right register_btn">駕駛註冊</a>
                        <a href="<?=base_url()?>car/car-dealership-register" id="dealer" class="text-primary pl-1 register_btn d-none">車行註冊</a>
                    </div>
                    <a href="<?=base_url()?>home/forgot-password" class="text-muted fs-6">忘記密碼?</a>
                </div>
                <div class="form-button-group">
                    <input type="submit" id='loginBtn' class="btn btn-primary btn-block btn-lg" value="登入">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade dialogbox order_log_modal" id="lightdialog" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content" style="max-width: 100%">
                <div class="modal-header">
                    <h5 class="modal-title">隱私權政策條款更新</h5>
                </div>
                <div class="light-dialog modal-body fs-6" id="terms">
                </div>
                <div class="modal-footer">
                    <div class="btn-list d-flex">
                        <a href="#" class="btn btn-block signOut" data-dismiss="modal">關閉</a>
                        <a href="javascript:;" class="btn btn-block submit_read">我同意</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->
    <?php include_once ("quote/footer.php"); ?>
    <script src="<?=base_url()?>assets/custom/APIJs/login.js?v=001"></script>
</body>

</html>