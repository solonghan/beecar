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
        <div class="pageTitle">自由承接</div>
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
        <div class="dispach-detail">
            <div class="section full mb-2">
                <div class="wide-block p-0">
                    <div class="input-list chengjie_list">
                    </div>    
                </div>
                <div class="section">
                    <input type="submit" class="btn btn-primary btn-lg btn-block" value="發送">
                </div>
            </div>
        </div>



    </div>
    <!-- * App Capsule -->

    <!-- DialogIconedSuccess -->
    <div class="modal fade dialogbox" id="DialogIconedSuccess" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-icon text-dispatched">
                    <ion-icon name="checkmark-circle"></ion-icon>
                </div>
                <div class="modal-header custom-icon-modal-header">
                    <h5 class="modal-title">已發送</h5>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <div class="btn-inline">
                        <a href="javascript:;" class="btn close">關閉</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * DialogIconedSuccess -->

    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/driver.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
        sessionStorage.setItem('page','dispach');
    </script>
    <script src="<?=base_url()?>assets/custom/js/search.js"></script>
    <script src="<?=base_url()?>assets/custom/APIJs/chengjie.js"></script>

</body>

</html>