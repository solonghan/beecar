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
        <div class="pageTitle">跑跑卡丁車成員名單</div>
        <div class="right">
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">


        <div class="section full mt-2">
            <div class="wide-block pb-2">
                <form class="search-form">
                    <div class="form-group searchbox">
                        <input type="text" id="groupMemberSearch" class="form-control" placeholder="請輸入關鍵字">
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
        <div class="member-verification">
            <div class="section full mb-2">
                <div class="wide-block p-0">   
                    <ul class="listview simple-listview">
                        <li>
                            <div class="item">
                                <div class="in">
                                    <a href="<?=base_url()?>car/add-driver-choose" class="text-primary d-flex align-items-center">
                                        <ion-icon name="add-circle-outline"></ion-icon>
                                        <div class="ml-1">新增成員</div>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a href="<?=base_url()?>car/driver-Information">
                                <div class="item">
                                    <div class="in">
                                        <div>高朋</div>
                                        <a href="#" class="info d-flex align-items-center" data-toggle="modal" data-target="#Dialog">
                                            <ion-icon name="remove-circle-outline"></ion-icon>
                                            <span class="text-muted ml-1">移除</span>
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="<?=base_url()?>car/driver-Information">
                                <div class="item">
                                    <div class="in">
                                        <div>簡志恩</div>
                                        <a href="#" class="info d-flex align-items-center" data-toggle="modal" data-target="#Dialog">
                                            <ion-icon name="remove-circle-outline"></ion-icon>
                                            <span class="text-muted ml-1">移除</span>
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="<?=base_url()?>car/driver-Information">
                                <div class="item">
                                    <div class="in">
                                        <div>林明洪</div>
                                        <a href="#" class="info d-flex align-items-center" data-toggle="modal" data-target="#Dialog">
                                            <ion-icon name="remove-circle-outline"></ion-icon>
                                            <span class="text-muted ml-1">移除</span>
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="<?=base_url()?>car/driver-Information">
                                <div class="item">
                                    <div class="in">
                                        <div>莊銘成</div>
                                        <a href="#" class="info d-flex align-items-center" data-toggle="modal" data-target="#Dialog">
                                            <ion-icon name="remove-circle-outline"></ion-icon>
                                            <span class="text-muted ml-1">移除</span>
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>        
                </div> 
            </div>
        </div>



    </div>
    <!-- * App Capsule -->

    <!-- Dialog Basic -->
    <div class="modal fade dialogbox" id="Dialog" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">是否將王大明移除群組?</h5>
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

    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/car.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
        sessionStorage.setItem('page','member');
    </script>



</body>

</html>