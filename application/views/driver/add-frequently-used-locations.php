<?php include_once (dirname(dirname(__FILE__)) . "/quote/header.php"); ?>

<body>

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
        <div class="pageTitle">新增常用地點</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">


        <div class="section mt-1">
            <form class="needs-validation" novalidate>
                <div class="form-group boxed form-multiple">
                    <div class="input-wrapper">
                        <label class="label" for="city2">城市</label>
                        <select class="form-control custom-select city_select" id="city" required>
                            <option selected disabled value="">請選擇</option>
                        </select>
                        <div class="invalid-feedback">請選擇城市.</div>
                    </div>
                    <div class="input-wrapper">
                        <label class="label" for="dist2">區域</label>
                        <select class="form-control custom-select area_select" id="dist" required>
                            <option selected disabled value="">請選擇</option>
                        </select>
                        <div class="invalid-feedback">請選擇區域.</div>
                    </div>
                    <div class="input-textarea">
                        <label class="label d-flex justify-content-between" for="address">
                            詳細地址
                        </label>
                        <textarea class="form-control address" name="address" id="" cols="30" rows="10" placeholder="請填寫起點詳細地址" required></textarea>
                        <div class="invalid-feedback">請輸入地址.</div>
                    </div>
                </div>
                <div class="form-button-group bottomMenu-button">
                    <input type="submit" class="btn btn-primary btn-block" value="儲存"></input>
                    <!-- frequently-used-locations.html -->
                </div>
            </form>    
        </div>



    </div>
    <!-- * App Capsule -->

    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/driver.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script src="<?=base_url()?>assets/custom/js/county-drop-down.js"></script>
    <script src="<?=base_url()?>assets/custom/js/validation-form.js"></script>
    <script src="<?=base_url()?>assets/custom/APIJs/add-location.js"></script>
</body>

</html>