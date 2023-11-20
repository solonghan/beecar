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
        <div class="pageTitle">紀錄篩選</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <div id="appCapsule">
        <?php include_once (dirname(dirname(__FILE__)) . "/quote/filter/nostatus.php"); ?>
    </div>
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

    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/car.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/datepicker.php"); ?>
    <script>
        sessionStorage.setItem('page','member');
    </script>
    <script src="<?=base_url()?>assets/custom/js/cityfilter.js"></script>
    <script src="<?=base_url()?>assets/custom/APIJs/filter.js"></script>

</body>

</html>