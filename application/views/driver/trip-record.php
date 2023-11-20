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
        <div class="pageTitle">行程紀錄</div>
        <div class="right">
            <a href="<?=base_url()?>driver/trip-record-filter" class="headerButton">
                <ion-icon name="funnel-outline"></ion-icon>
            </a>
        </div>
    </div>
    <!-- * App Header -->

    <!-- Extra Header -->
    <div class="extraHeader p-0">
        <ul class="nav nav-tabs lined" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#pickUp" role="tab">
                    承接紀錄
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#send" role="tab">
                    派遣紀錄
                </a>
            </li>
        </ul>
    </div>
    <!-- * Extra Header -->

    <!-- App Capsule -->
    <div id="appCapsule" class="extra-header-active">


        <div class="tab-content mt-2 mb-2">


            <!-- pickUp tab -->
            <div class="tab-pane fade show active" id="pickUp" role="tabpanel">

                <div class="section mt-1">
                    <!-- <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                2020/12/11
                                <a href="#" data-toggle="modal" data-target="#lightdialog">
                                    <span class="status dispatched">
                                        未執行
                                    </span>
                                </a>
                            </h5>
                            <p class="card-subtitle">8:30</p>
                            <div class="card-text">
                                <p>起點 : 台北市中山北路一段59號</p>
                                <p>終點 : 台北市太原路二段72號</p>
                            </div>
                            <div class="card-bottom">
                                <div class="remark">
                                    <p>行李數 : 2件 / 乘客數 : 3人</p>
                                    <p>支付方式 : 現金</p>
                                    <p>車型 : 四人座</p>
                                    <a href="<?=base_url()?>driver/undertack-drive-information"><p>派遣人 : 林小美</p></a>
                                </div>
                                <div class="price">
                                    <p>回金 : $200</p>
                                    <p>車資 : $600</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="divider bg-primary mt-2 mb-2"></div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                2020/11/8
                                <a href="#" data-toggle="modal" data-target="#lightdialog">
                                    <span class="status">
                                        行程結束
                                    </span>
                                </a>
                            </h5>
                            <p class="card-subtitle">8:30</p>
                            <div class="card-text">
                                <p>起點 : 台北市中山北路一段</p>
                                <p>終點 : 台北市太原路二段</p>
                            </div>
                            <div class="card-bottom">
                                <div class="remark">
                                    <p>行李數 : 2件 / 乘客數 : 3人</p>
                                    <p>支付方式 : 現金</p>
                                    <p>車型 : 五人座</p>
                                    <a href="<?=base_url()?>driver/undertack-drive-information"><p>派遣人 : 毛毛</p></a>
                                </div>
                                <div class="price">
                                    <p>回金 : $200</p>
                                    <p>車資 : $600</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="divider bg-primary mt-2 mb-2"></div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                2020/11/6
                                <a href="#" data-toggle="modal" data-target="#lightdialog">
                                    <span class="status">
                                        行程結束
                                    </span>
                                </a>
                            </h5>
                            <p class="card-subtitle">7:00</p>
                            <div class="card-text">
                                <p>起點 : 台北市中山北路一段</p>
                                <p>終點 : 台北市太原路二段</p>
                            </div>
                            <div class="card-bottom">
                                <div class="remark">
                                    <p>行李數 : 2件 / 乘客數 : 3人</p>
                                    <p>支付方式 : 現金</p>
                                    <p>車型 : 五人座</p>
                                    <a href="<?=base_url()?>driver/undertack-drive-information"><p>派遣人 : 阿明</p></a>
                                </div>
                                <div class="price">
                                    <p>回金 : $200</p>
                                    <p>車資 : $600</p>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
                

            </div>
            <!-- * pickUp tab -->



            <!-- send tab -->
            <div class="tab-pane fade" id="send" role="tabpanel">

                <div class="section mt-1">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                2020/12/16
                                <a href="#" data-toggle="modal" data-target="#lightdialog">
                                    <span class="status dispatched">
                                        已派遣
                                    </span>
                                </a>
                            </h5>
                            <p class="card-subtitle">8:30</p>
                            <div class="card-text">
                                <p>起點 : 台北市中山北路一段59號</p>
                                <p>終點 : 台北市太原路二段72號</p>
                            </div>
                            <div class="card-bottom">
                                <div class="remark">
                                    <p>聯絡人名稱 : 王曉華</p>
                                    <p>聯絡人電話 : 0912345678</p>
                                    <p>航班編號 : FQV1316</p>
                                    <p>車型 : 五人座</p>
                                    <p>行李數 : 2件 / 乘客數 : 3人</p>
                                    <p>備註 : 有寵物狗，行李很重</p>
                                    <p>支付方式 : 現金</p>
                                    <a href="<?=base_url()?>driver/driver-Information"><p>駕駛名稱 : 王小明</p></a>
                                </div>
                                <div class="price">
                                    <p>回金 : $200</p>
                                    <p>車資 : $800</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="divider bg-primary mt-2 mb-2"></div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                2020/12/10
                                <a href="#" data-toggle="modal" data-target="#lightdialog">
                                    <span class="status dispatched">
                                        已派遣
                                    </span>
                                </a>
                            </h5>
                            <p class="card-subtitle">10:30</p>
                            <div class="card-text">
                                <p>起點 : 台北市中山北路一段59號</p>
                                <p>終點 : 台北市太原路二段72號</p>
                            </div>
                            <div class="card-bottom">
                                <div class="remark">
                                    <p>聯絡人名稱 : 王曉華</p>
                                    <p>聯絡人電話 : 0912345678</p>
                                    <p>航班編號 : FQV1316</p>
                                    <p>車型 : 五人座</p>
                                    <p>行李數 : 2件 / 乘客數 : 3人</p>
                                    <p>備註 : 有寵物狗，行李很重</p>
                                    <p>支付方式 : 現金</p>
                                    <a href="<?=base_url()?>driver/driver-Information"><p>駕駛名稱 : 王小明</p></a>
                                </div>
                                <div class="price">
                                    <p>回金 : $200</p>
                                    <p>車資 : $800</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- * send tab -->


            <div class="modal fade dialogbox" id="lightdialog" data-backdrop="static" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="light-dialog modal-body fs-6">
                            <p class="text-left">2020/12/10</p>
                            <ul class="">
                                <li>
                                    <div class="dialog-content">13 : 30</div>
                                    <div class="dialog-content">自由承接</div>
                                    <div class="dialog-content">
                                        <p>台北安心群</p>
                                        <p>肯驛車隊</p>
                                        <p>王大頭</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="dialog-content">13 : 45</div>
                                    <div class="dialog-content">指定駕駛</div>
                                    <div class="dialog-content">
                                        <p>陳老大</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="dialog-content">13 : 30</div>
                                    <div class="dialog-content">取消駕駛</div>
                                    <div class="dialog-content"></div>
                                </li>
                            </ul>
                            <div class="divider bg-primary mt-2 mb-2"></div>
                            <p class="text-left">2020/12/11</p>
                            <ul class="">
                                <li>
                                    <div class="dialog-content">13 : 30</div>
                                    <div class="dialog-content">指定駕駛</div>
                                    <div class="dialog-content">
                                        <p>阿明</p>
                                    </div>
                                </li>
                            </ul>
                            
                        </div>
                        <div class="modal-footer">
                            <div class="btn-list">
                                <a href="#" class="btn btn-block" data-dismiss="modal">關閉</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




        </div>



    </div>
    <!-- * App Capsule -->

    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/driver.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script src="<?=base_url()?>assets/custom/APIJs/triprecord.js"></script>


</body>

</html>