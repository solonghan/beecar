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
        <div class="pageTitle">選擇司機</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">


        <div class="section full mt-2">
            <div class="wide-block pb-2">
                <form class="search-form">
                    <div class="form-group searchbox">
                        <input type="text" id="input" class="form-control" placeholder="請輸入關鍵字">
                        <i class="input-icon">
                            <ion-icon name="search-outline"></ion-icon>
                        </i>
                        <a href="javascript:;" id="reset" class="ml-1 close toggle-searchbox">
                            <ion-icon name="close-circle"></ion-icon>
                        </a>
                    </div>
                </form>
            </div>
        </div>
        <div class="member-verification">
            <div class="section full mb-2">
                <div class="wide-block p-0 mb-8">   
                    <div class="input-list driver_list">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="customRadio11" name="customRadioList" class="custom-control-input">
                            <label class="custom-control-label" for="customRadio11">簡志恩</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="customRadio12" name="customRadioList" class="custom-control-input">
                            <label class="custom-control-label" for="customRadio12">林明洪</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="customRadio13" name="customRadioList" class="custom-control-input">
                            <label class="custom-control-label" for="customRadio13">莊銘成</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="customRadio14" name="customRadioList" class="custom-control-input">
                            <label class="custom-control-label" for="customRadio14">王華華</label>
                        </div>
                    </div>    
                </div>
                <div class="section">
                    <input type="submit" class="btn btn-primary btn-lg btn-block" value="建立">
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/car.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
        sessionStorage.setItem('page','dispach');
    </script>
    <script src="<?=base_url()?>assets/custom/APIJs/group-driver-choose.js"></script>

</body>

</html>