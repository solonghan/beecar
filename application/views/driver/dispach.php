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
        <div class="pageTitle">管理列表</div>
        <div class="right">
        <!-- data-toggle="modal" data-target="#selectAllModal" -->
            <a href="#" class="headerButton select_all_icon">
                <ion-icon name="checkmark-circle-outline"></ion-icon>
            </a>
            <a href="<?=base_url()?>driver/dispach-filter" class="headerButton filterBtn">
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
                        <a href="#" class="btn btn-text-primary btn-block" data-dismiss="modal">委任派遣</a>
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
            </div>
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
    <!-- 全選modal -->
    <!-- <div class="modal fade dialogbox" id="selectAllModal" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">請選擇動作</h5>
                </div>
                <div class="modal-footer">
                    <div class="btn-list">
                        <a href="#" class="btn btn-text-primary btn-block select_all" data-dismiss="modal">全選</a>
                        <a href="#" class="btn btn-text-secondary btn-block cancel_select_all" data-dismiss="modal">取消全選</a>
                        <a href="#" class="btn btn-text-secondary btn-block close" data-dismiss="modal">關閉</a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/driver.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
        sessionStorage.setItem('page','dispach');
    </script>
    <script src="<?=base_url()?>assets/custom/APIJs/dispach.js?v=001"></script>
</body>
<script>
</script>

</html>