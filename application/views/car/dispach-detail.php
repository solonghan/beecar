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
        <div class="pageTitle">管理行程詳情</div>
        <div class="right">
            <a href="#" class="headerButton" data-toggle="modal" data-target="#operating">
                <ion-icon name="ellipsis-horizontal-outline"></ion-icon>
            </a>
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="dispach-detail">
            <div class="section mb-3 mt-2">
                <div class="card order_detail">
                    <div class="card-body">
                        <h5 class="card-title">
                            2020/12/11
                            <a href="#" data-toggle="modal" data-target="#lightdialog">
                                <span class="status dispatched">
                                    已派遣
                                </span>
                            </a>
                            <span class="transferred">
                                建單人 : 已轉單
                            </span>
                        </h5>
                        <p class="card-subtitle">10:30</p>
                        <div class="card-text">
                            <p>起點 : 台北市中山區中山北路一段59號</p>
                            <p>目的地 : 台北市大同區太原路二段72號</p>
                        </div>
                        <div class="card-bottom">
                            <div class="remark">
                                <p>聯絡人名稱 : 王曉華</p>
                                <p>聯絡人電話 : 0912345678</p>
                                <p>航班編號 : FQV1316</p>
                                <p>車型 : 四人座</p>
                                <p>行李數 : 2件 / 乘客數 : 3人</p>
                                <p>備註 : 有寵物狗，行李很重</p>
                                <p>支付方式 : 現金</p>
                                <a href="<?=base_url()?>driver/driver-Information"><p>駕駛名稱 : 王大明</p></a>
                            </div>
                            <div class="price">
                                <p>回金 : $200</p>
                                <p>車資 : $800</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="botton d-flex justify-content-between mb-8">
                    <button type="button" class="btn btn-text-black shadowed transfer">行程轉單</button>
                    <button type="button" class="btn btn-text-black shadowed cancel_transfer">取消轉單</button>
                    <button type="button" class="btn btn-text-black shadowed assign">指定駕駛</button>
                    <button type="button" class="btn btn-text-black shadowed cancel_assign">取消指定</button>
                    <button type="button" class="btn btn-text-black shadowed free">自由承接</button>
                    <button type="button" class="btn btn-text-black shadowed cancel_free">取消承接</button>
                </div>
                <div class="botton">
                    <button type="button" class="btn btn-outline-primary btn-lg btn-block btn-active edit_btn">編輯</button>
                </div>
            </div>
            <div class="modal fade dialogbox" id="operating" data-backdrop="static" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">請選擇動作</h5>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-list">
                                <a href="#" class="btn btn-text-primary btn-block operating modal_delete">刪除行程</a>
                                <a href="#" class="btn btn-text-primary  btn-block operating2 modal_reset">重置派遣</a>
                                <a href="#" class="btn btn-text-primary btn-blockd modal_cancel">取消行程</a>
                                <a href="#" class="btn btn-text-secondary btn-block" data-dismiss="modal">取消</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- 刪除行程 -->
            <div class="modal fade dialogbox" id="deleteItinerary" data-backdrop="static" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">是否刪除此行程?</h5>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-inline">
                                <a href="#" class="btn btn-text-secondary" data-dismiss="modal">否</a>
                                <a href="#" class="btn btn-text-primary delete_y">是</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 重置派遣 -->
            <div class="modal fade dialogbox" id="Dialogreset" data-backdrop="static" tabindex="-1" role="dialog"> 
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">是否重置此派遣?</h5>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-inline">
                                <a href="#" class="btn btn-text-secondary" data-dismiss="modal">否</a>
                                <a href="#" class="btn btn-text-primary reset">是</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 確認編輯 -->
            <div class="modal fade dialogbox" id="confirmEditModal" data-backdrop="static" tabindex="-1" role="dialog"> 
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">編輯會使行程回到未派遣狀態，是否確定進入編輯?</h5>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-inline">
                                <a href="#" class="btn btn-text-secondary" data-dismiss="modal">否</a>
                                <a href="#" class="btn btn-text-primary confirm_edit_btn">是</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dialog box -->
        <div class="modal fade dialogbox order_log_modal" id="lightdialog" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="light-dialog modal-body fs-6">
                        <div class="orderRecord">
                            <p class="text-left">2020/12/10</p>
                            <ul class="orderRecordList">
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
                        </div>
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
    <!-- * App Capsule -->

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

    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/car.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
        sessionStorage.setItem('page','dispach');
    </script>
    <script src="<?=base_url()?>assets/custom/js/dialog.js"></script>
    <script src="<?=base_url()?>assets/custom/js/get-parameter.js"></script> <!-- 取得網址參數 -->
    <script src="<?=base_url()?>assets/custom/APIJs/dispach-detail.js?v=001"></script>

</body>

</html>