<?php include_once(dirname(dirname(__FILE__)) . "/quote/header.php"); ?>

<body>

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="#" class="headerButton goBack">
            </a>
        </div>
        <div class="pageTitle">管理列表</div>
        <div class="right">
            <a href="#" class="headerButton select_all_icon">
                <ion-icon name="checkmark-circle-outline"></ion-icon>
            </a>
            <a href="<?= base_url() ?>car/dispach-filter" class="headerButton">
                <ion-icon name="funnel-outline"></ion-icon>
            </a>
        </div>
    </div>
    <!-- * App Header -->

    <!-- Dialog Block Button -->
    <!-- <div class="modal fade dialogbox" id="DialogBlockButton" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">批次派遣</h5>
                </div>
                <div class="modal-body">
                    請選擇動作
                </div>
                <div class="modal-footer">
                    <div class="btn-list">
                        <a href="#" class="btn btn-text-primary btn-block" data-dismiss="modal">委託派遣</a>
                        <a href="#" class="btn btn-text-primary btn-block" data-dismiss="modal">指定駕駛</a>
                        <a href="#" class="btn btn-text-primary btn-block" data-dismiss="modal">自由承接</a>
                        <a href="#" class="btn btn-text-primary btn-block" data-dismiss="modal">重置派遣</a>
                        <a href="#" class="btn btn-text-primary btn-block" data-dismiss="modal">刪除派遣</a>
                        <a href="#" class="btn btn-text-secondary btn-block" data-dismiss="modal">取消</a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- * Dialog Block Button -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="dispach mt-2">
            <div class="dispach-status section">
                <ul>
                    <a href="#" class="zhuan_dan">
                        <li>行程轉單</li>
                    </a>
                    <a href="#" class="zhiding">
                        <li>指定駕駛</li>
                    </a>
                    <a href="#" class="chengjie">
                        <li>自由承接</li>
                    </a>
                    <a href="#" class="reset">
                        <li>重置派遣</li>
                    </a>
                    <a href="#" class="delete_itinerary">
                        <li>刪除行程</li>
                    </a>
                </ul>
            </div>
            <div class="section mb-3 manage_list">
                <!-- <div class="no_list">
                目前還沒有訂單資訊
            </div> -->
                <!-- <div class="card-dispach-detail">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheckb1">
                                <label class="custom-control-label" for="customCheckb1">2020/12/10</label>
                                <a href="#" data-toggle="modal" data-target="#lightdialog">
                                    <span class="status undertaken">
                                        待承接
                                    </span>
                                </a>
                            </div>
                            <p class="card-subtitle">10:30</p>
                            <div class="card-text">
                                <p>起點 : 台北市中山區中山北路一段59號</p>
                                <p>目的地 : 台北市大同區太原路二段72號</p>
                            </div>
                            <div class="card-bottom">
                                <div class="remark">
                                    <p>車型 : 七人座</p>
                                    <p>備註 : 有寵物狗，行李很重</p>
                                </div>
                                <div class="price">
                                    <p>回金 : $200</p>
                                    <p>車資 : $800</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-dispach-detail">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheckb2">
                                <label class="custom-control-label" for="customCheckb2">2020/12/10</label>
                                <a href="#" data-toggle="modal" data-target="#lightdialog">
                                    <span class="status dispatched">
                                        已派遣
                                    </span>
                                </a>
                            </div>
                            <p class="card-subtitle">6:30</p>
                            <div class="card-text">
                                <p>起點 : 台北市中山區中山北路一段59號</p>
                                <p>目的地 : 台北市大同區太原路二段72號</p>
                            </div>
                            <div class="card-bottom">
                                <div class="remark">
                                    <p>車型 : 五人座</p>
                                    <p>備註 : 有易碎品，要小心搬運</p>
                                    <p>駕駛名稱 : 王大明</p>
                                </div>
                                <div class="price">
                                    <p>回金 : $100</p>
                                    <p>車資 : $600</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-dispach-detail">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheckb3">
                                <label class="custom-control-label" for="customCheckb3">2020/12/10</label>
                                <a href="#" data-toggle="modal" data-target="#lightdialog">
                                    <span class="status processing">
                                        抵達起點
                                    </span>
                                </a>
                            </div>
                            <p class="card-subtitle">6:30</p>
                            <div class="card-text">
                                <p>起點 : 台北市中山區中山北路一段59號</p>
                                <p>目的地 : 台北市大同區太原路二段72號</p>
                            </div>
                            <div class="card-bottom">
                                <div class="remark">
                                    <p>車型 : 五人座</p>
                                    <p>備註 : 有寵物狗，行李很重</p>
                                </div>
                                <div class="price">
                                    <p>回金 : $100</p>
                                    <p>車資 : $600</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>


        </div>



    </div>
    <!-- * App Capsule -->
    <div class="modal fade dialogbox" id="lightdialog" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="light-dialog modal-body fs-6">
                    <p class="text-left">2020/12/10</p>
                    <ul>
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

    <!-- 彈出行程細節 -->
    <div class="modal fade dialogbox order_log_modal" id="lightdialog" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="light-dialog modal-body fs-6">
                </div>
                <div class="modal-footer">
                    <div class="btn-list">
                        <a href="#" class="btn btn-block" data-dismiss="modal">關閉</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once(dirname(dirname(__FILE__)) . "/quote/menu/car.php"); ?>
    <?php include_once(dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
        sessionStorage.setItem('page', 'dispach');
    </script>
    <script src="<?= base_url() ?>assets/custom/APIJs/dispach.js?v=001"></script>
</body>

</html>