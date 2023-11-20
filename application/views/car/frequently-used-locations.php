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
        <div class="pageTitle">常用地點</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">


        <div class="section full group-list">
            <div class="title bg-light p-2 ">
                <a href="<?=base_url()?>car/add-frequently-used-locations" class="d-flex align-items-center text-primary">
                    <ion-icon name="add-circle-outline"></ion-icon>
                    <p class="ml-1">新增常用地點</p>
                </a>
            </div>
            <ul class="listview simple-listview">
                <li>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio11" name="customRadioList" class="custom-control-input">
                        <label class="custom-control-label" for="customRadio11">台北市中山區中山北路一段59號</label>
                    </div>
                    <div class="delete-icon">
                        <a href="" data-toggle="modal" data-target="#DialogBasic">
                            <ion-icon name="remove-circle-outline"></ion-icon>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio12" name="customRadioList" class="custom-control-input">
                        <label class="custom-control-label" for="customRadio12">台北市大同區太原路二段72號</label>
                    </div>
                    <div class="delete-icon">
                        <a href="" data-toggle="modal" data-target="#DialogBasic">
                            <ion-icon name="remove-circle-outline"></ion-icon>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio13" name="customRadioList" class="custom-control-input">
                        <label class="custom-control-label" for="customRadio13">台北市大安區仁愛路四段22號</label>
                    </div>
                    <div class="delete-icon">
                        <a href="" data-toggle="modal" data-target="#DialogBasic">
                            <ion-icon name="remove-circle-outline"></ion-icon>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio14" name="customRadioList" class="custom-control-input">
                        <label class="custom-control-label" for="customRadio14">台北市大同區太原路一段6號</label>
                    </div>
                    <div class="delete-icon">
                        <a href="" data-toggle="modal" data-target="#DialogBasic">
                            <ion-icon name="remove-circle-outline"></ion-icon>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="section">
            <input type="button" class="btn btn-primary btn-block" value="確認" onclick="window.location='<?=base_url()?>car/create-itinerary';"></input>
        </div>

        <!-- Dialog Basic -->
        <div class="modal fade dialogbox" id="DialogBasic" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="custom-modal-header modal-header">
                        <h5 class="modal-title">是否刪除此常用地點?</h5>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <a href="#" class="btn btn-text-secondary" data-dismiss="modal">否</a>
                            <a href="#" class="btn btn-text-primary" data-dismiss="modal">是</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Dialog Basic -->



    </div>
    <!-- * App Capsule -->
    
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/car.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>


</body>

</html>