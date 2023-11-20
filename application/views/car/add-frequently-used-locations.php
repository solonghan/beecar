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
            <div class="form-group boxed form-multiple">
                <div class="input-wrapper">
                    <label class="label" for="city2">城市</label>
                    <select class="form-control custom-select" id="city2" required>
                        <option selected disabled value="">請選擇</option>
                        <option value="1">台北市</option>
                        <option value="2">台中市</option>
                        <option value="3">高雄市</option>
                    </select>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">請選擇目的地城市2.</div>
                </div>
                <div class="input-wrapper">
                    <label class="label" for="dist2">區域</label>
                    <select class="form-control custom-select" id="dist2" required>
                        <option selected disabled value="">請選擇</option>
                        <option value="1">文山區</option>
                        <option value="2">文山區</option>
                        <option value="3">文山區</option>
                    </select>
                </div>
                <div class="input-textarea">
                    <label class="label d-flex justify-content-between" for="address2">
                        詳細地址
                    </label>
                    <textarea class="form-control" name="address2" id="" cols="30" rows="10" placeholder="請填寫起點詳細地址"></textarea>
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
            </div>
            <div class="form-button-group bottomMenu-button">
                <input type="button" class="btn btn-primary btn-block" value="儲存" onclick="window.location='<?=base_url()?>car/frequently-used-locations';"></input>
            </div>
        </div>



    </div>
    <!-- * App Capsule -->

    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/car.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>


</body>

</html>