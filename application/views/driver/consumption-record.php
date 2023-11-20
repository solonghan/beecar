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
        <div class="pageTitle">消費紀錄</div>
        <div class="right">
            <a href="#" class="headerButton " data-toggle="modal" data-target="#note">
                說明
                <img src="<?=base_url()?>assets/custom/img/note.png" alt="image" class="ml-1">

            </a>
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">


        <div class="transaction section full">
            <ul class="listview simple-listview">
                <li class="d-grid bg-gray" >
                    <p class="col-4">月份</p>
                    <p class="col-4 text-center">付款狀態</p>
                    <p class="col-4 text-right text-nowrap" style="padding-right: 60px;">金額</p>
                </li>
            </ul>
            <ul class="listview link-listview p-0 border-0 record" >
                <!-- <li class="border-bottom">
                    <a href="<?=base_url()?>driver/consumption-record-detail" class="item" style="padding-right:16px">
                        <div class="in grid">
                            <div class="col-4">
                            2020年9月
                            </div>
                            <div class="col-4 text-center">
                            未付款
                            </div>
                            <div class="text-muted col-4 text-right" style="padding-right: 60px;">
                                1000
                            </div>
                        </div>
                    </a>
                </li>
                <li class="border-bottom">
                    <a href="<?=base_url()?>driver/consumption-record-detail" class="item" style="padding-right:16px">
                        <div class="in grid">
                            <div class="col-4">
                            2020年9月
                            </div>
                            <div class="col-4 text-center">
                            未付款
                            </div>
                            <div class="text-muted col-4 text-right" style="padding-right: 60px;">
                                1000
                            </div>
                        </div>
                    </a>
                </li>
                <li class="border-bottom">
                    <a href="<?=base_url()?>driver/consumption-record-detail" class="item" style="padding-right:16px">
                        <div class="in grid">
                            <div class="col-4">
                            2020年9月
                            </div>
                            <div class="col-4 text-center text-danger">
                            未付款
                            </div>
                            <div class="text-muted col-4 text-right" style="padding-right: 60px;">
                                1000
                            </div>
                        </div>
                    </a>
                </li> -->
            </ul>
        </div>

        <div class="modal fade dialogbox" id="note" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content" style="max-width: 100%">
                    <div class="modal-header py-4">
                        <h5 class="modal-title spendTitle">
                            <!-- 消費紀錄說明 -->
                        </h5>
                    </div>
                    <div class="px-4 pb-4 spendContent">
                        <!-- <p>說明說明未付款會被停用，說明說明未付款會被停用說明說明未付款會被停用。說明說明未未付款會被停用說明說明。<br><br>
                        </p>
                        <p>未付款會被停用說明說。明未付款會被停用說明，說明未付款會被停用，說明說明未付款會被停用說明說明未付款會被停用。</p> -->
                    </div>
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <a href="#" class="btn btn-text-primary" data-dismiss="modal">確定</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/driver.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
        sessionStorage.setItem('page','member');
    </script>
    <script src="<?=base_url()?>assets/custom/APIJs/consumption-record.js"></script>


</body>

</html>