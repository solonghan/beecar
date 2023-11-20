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
        <div class="pageTitle">基本資料</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">

        <div class="member">
            <div class="section full mt-2 mb-2">
                <div class="wide-block pb-3 information">

                    <form class="needs-validation" novalidate>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="name1">顯示名稱</label>
                                <input type="text" class="form-control" id="name1" placeholder="請輸入名稱" required>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="lastname1">手機</label>
                                <input type="phone" class="form-control" id="phone1" value="09123456789" disabled>
                                <span class="bind">已綁定</span>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="name1">Line帳號</label>
                                <input type="text" class="form-control" id="name1" placeholder="請輸入名稱" value="carcar123" required>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="Email">Email</label>
                                <input type="email" class="form-control" id="Email" name="Email" placeholder="請輸入e-mail" value="carcar123@mail.com" required>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-links mt-2">
                            <div class="fs-6">
                                <a href="<?=base_url()?>car/change-password" class="text-primary">變更密碼</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="form-button-group mb-6 fs-5">
                    <input type="submit" class="btn btn-primary btn-block" value="儲存"></input>
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
    <script src="<?=base_url()?>assets/custom/APIJs/basic-information.js?v=001"></script>

</body>

</html>