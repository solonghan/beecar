<?php include_once (dirname(dirname(__FILE__)) . "/quote/header.php"); ?>

<body>
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <div class="appHeader bg-primary text-light" style="z-index: 1001;">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">派遣紀錄</div>
        <div class="right">
            <div class="dropdown">
                <a class="headerButton" href="#" data-toggle="dropdown" aria-expanded="false">
                    <ion-icon name="caret-down-circle-outline"></ion-icon>
                </a>

                <div class="dropdown-menu">
                    <a class="dropdown-item download-dispatch" href="#">下載派遣紀錄</a>
                    <a class="dropdown-item download-undertake" href="#">下載承接紀錄</a>
                </div>
            </div>
            <a href="<?=base_url()?>driver/trip-record-filter" class="headerButton">
                <ion-icon name="funnel-outline"></ion-icon>
            </a>
        </div>
    </div>
    <div class="extraHeader p-0">
        <ul class="nav nav-tabs lined" role="tablist">
            <li class="nav-item">
                <a class="nav-link" href="<?=base_url()?>driver/undertakerecord">
                    承接紀錄
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="<?=base_url()?>driver/managerecord">
                    派遣紀錄
                </a>
            </li>
        </ul>
    </div>
    <div id="appCapsule" class="extra-header-active">
        <div class="section mt-1 manage_record">
        </div>
    </div>
    <!-- * App Capsule -->
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
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/driver.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
        sessionStorage.setItem('page','member');
    </script>
    <script src="<?=base_url()?>assets/custom/APIJs/managerecord.js"></script>


</body>

</html>