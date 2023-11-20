<?php include_once (dirname(dirname(__FILE__)) . "/quote/header.php"); ?>

<body>
    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">派遣篩選</div>
        <div class="right"></div>
    </div>
    <div id="appCapsule">
        <?php include_once (dirname(dirname(__FILE__)) . "/quote/filter/status.php"); ?>
    </div>
    <!-- 狀態篩選 -->
    <div class="modal fade modalbox" id="statusFilter" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">狀態篩選</h5>
                    <a href="javascript:;" data-dismiss="modal">關閉</a>
                </div>
                <div class="modal-body p-0">
                    <div class="input-list">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="status1" name="status[]" class="custom-control-input" data-status="make" value="未派遣">
                            <label class="custom-control-label" for="status1">未派遣</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="status2" name="status[]" class="custom-control-input" data-status="transfer" value="已轉單">
                            <label class="custom-control-label" for="status2">已轉單</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="status3" name="status[]" class="custom-control-input" data-status="send_free" value="待承接">
                            <label class="custom-control-label" for="status3">待承接</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="status4" name="status[]" class="custom-control-input" data-status="free_get" value="已有駕駛承接">
                            <label class="custom-control-label" for="status4">已有駕駛承接</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="status5" name="status[]" class="custom-control-input" data-status="assign" value="已指定駕駛">
                            <label class="custom-control-label" for="status5">已指定駕駛</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="status6" name="status[]" class="custom-control-input" data-status="catch" value="已接到轉單">
                            <label class="custom-control-label" for="status6">已接到轉單</label>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    <!-- 車型篩選 -->
    <div class="modal fade modalbox" id="modalFilter" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">車型篩選</h5>
                    <a href="javascript:;" data-dismiss="modal">關閉</a>
                </div>
                <div class="modal-body p-0">
                    <div class="input-list">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="轎車/休旅車(5人座)" name="modal[]" class="custom-control-input" value="轎車/休旅車(5人座)">
                            <label class="custom-control-label" for="轎車/休旅車(5人座)">轎車/休旅車(5人座)</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="休旅車(7人座)" name="modal[]" class="custom-control-input" value="休旅車(7人座)">
                            <label class="custom-control-label" for="休旅車(7人座)">休旅車(7人座)</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="商務車(9人座)" name="modal[]" class="custom-control-input" value="商務車(9人座)">
                            <label class="custom-control-label" for="商務車(9人座)">商務車(9人座)</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="小巴(09~15人座)" name="modal[]" class="custom-control-input" value="小巴(09~15人座)">
                            <label class="custom-control-label" for="小巴(09~15人座)">小巴(09~15人座)</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="中巴(20~28人座)" name="modal[]" class="custom-control-input" value="中巴(20~28人座)">
                            <label class="custom-control-label" for="中巴(20~28人座)">中巴(20~28人座)</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="大巴(32~43人座)" name="modal[]" class="custom-control-input" value="大巴(32~43人座)">
                            <label class="custom-control-label" for="大巴(32~43人座)">大巴(32~43人座)</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modalbox city_modal" id="startFilter" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">起點篩選</h5>
                    <a href="javascript:;" data-dismiss="modal">關閉</a>
                </div>
                <div class="modal-body p-0">
                    <div class="input-list">
                        <ul class="listview link-listview mb-3 city_filter">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modalbox city_modal" id="endFilter" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">目的地篩選</h5>
                    <a href="javascript:;" data-dismiss="modal">關閉</a>
                </div>
                <div class="modal-body p-0">
                    <div class="input-list">
                        <ul class="listview link-listview mb-3 city_filter">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/driver.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/datepicker.php"); ?>
    <script>
        sessionStorage.setItem('page','dispach');
    </script>
    <script src="<?=base_url()?>assets/custom/js/cityfilter.js"></script>
    <script src="<?=base_url()?>assets/custom/APIJs/filter.js"></script>


</body>

</html>