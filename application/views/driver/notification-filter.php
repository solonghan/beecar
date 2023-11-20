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
        <div class="pageTitle">超級通知</div>
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
        <div class="notification-fifter">
            <div class="section full">
                <div class="section-title fs-5 pt-2 pb-2 border-bottom">
                    我的通知條件
                </div>
            </div>
            <div class="section full">
                <div class="section-title bg-light fs-5 text-info pt-2 pb-2 border-bottom">
                    <div class="custom-control custom-radio d-inline">
                        <input type="radio" id="superFifterNone" name="superFifter" class="custom-control-input" value="off">
                        <label class="custom-control-label" for="superFifterNone">不通知</label>
                    </div>
                </div>
            </div>
            <div class="section full">
                <div class="section-title bg-light fs-5 text-info pt-2 pb-2 border-bottom">
                    <div class="custom-control custom-radio d-inline">
                        <input type="radio" id="superFifterAll" name="superFifter" class="custom-control-input" value="on">
                        <label class="custom-control-label" for="superFifterAll">有新的可接行程通知我</label>
                    </div>
                </div>
            </div>
            <div class="section full">
                <div class="section-title bg-light fs-5 text-info pt-2 pb-2 border-bottom">
                    <div class="custom-control custom-radio d-flex w-100">
                        <input type="radio" id="superFifterCustom" name="superFifter" class="custom-control-input" value="customize">
                        <label class="custom-control-label" for="superFifterCustom">自訂通知條件</label>
                        <a href="<?=base_url()?>driver/notification-addfilter" class="ml-auto fs-6 text-primary d-flex align-items-center justify-content-end">
                            <ion-icon name="add-circle-outline"></ion-icon>
                            <span>新增條件</span>
                        </a>
                    </div>
                </div>
            </div>
    
    
    
            <div class="section">
                <div class="filter_list pt-2">
                    <!-- <div class="filter-results">
                        <div class="filter-results-header">
                            <h5 class="fs-5">篩選條件1</h5>
                            <a href="#" data-toggle="modal" data-target="#delete">
                                <div class="delete">
                                    <ion-icon name="remove-circle-outline"></ion-icon>
                                    <span>刪除</span>
                                </div>
                            </a>
                        </div>
                        <ul>
                            <li>
                                日期 : 2020/11/30
                            </li>
                            <li>
                                時間 : 8:00 ~ 14:00
                            </li>
                            <li>
                                起點地區 : 台北市 文山區、萬華區
                            </li>
                            <li>
                                目的地地區 : 新竹市 北區、東區
                            </li>
                        </ul>
                    </div>
                    <div class="filter-results">
                        <div class="filter-results-header">
                            <h5 class="fs-5">篩選條件2</h5>
                            <a href="#" data-toggle="modal" data-target="#delete">
                                <div class="delete">
                                    <ion-icon name="remove-circle-outline"></ion-icon>
                                    <span>刪除</span>
                                </div>
                            </a>
                        </div>
                        <ul>
                            <li>
                                日期 : 2020/11/30 ~ 2020/12/1
                            </li>
                            <li>
                                時間 : 8:00 ~ 16:00
                            </li>
                            <li>
                                起點地區 : 台北市 文山區、萬華區
                            </li>
                            <li>
                                目的地地區 : 新竹市 北區、東區
                            </li>
                        </ul>
                    </div> -->
                </div>
                <!-- <div class="add col-12 p-0">
                    <a href="<?=base_url()?>driver/notification-addfilter" class="fs-6 text-primary d-flex align-items-center justify-content-end">
                        <ion-icon name="add-circle-outline"></ion-icon>
                        <span>新增篩選</span>
                    </a>
                </div> -->
            </div>

            <!-- Dialog Basic -->
            <div class="modal fade dialogbox" id="delete" data-backdrop="static" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">是否確定刪除?
                            </h5>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-inline">
                                <a href="#" class="btn btn-text-secondary" data-dismiss="modal">否</a>
                                <a href="#" class="btn btn-text-primary delete_y" data-dismiss="modal">是</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade dialogbox" id="note" data-backdrop="static" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content" style="max-width: 100%">
                        <div class="modal-header">
                            <h5 class="modal-title py-4 superTitle">
                                <!-- 超級通知使用說明 -->
                            </h5>
                        </div>
                        <div class="px-4 superdContent">
                            <!-- <p>此功能為字說明功能文字說明功能文字。說明功能文字，說明功能文此功能為字說明功能文字說明功能。
                                文字說明功能文字說明功能文字說明字說明功能文字說明功能文字說明。<br><br>
                            </p>
                            <p>
                                說明功能文字說明功能。文字說明功能文字說明功能文字說明字說明功能文字說明功能文字說明
                                說明功能文字說明功能。文字說明功能文字說明功能文字說明字說明功能文字說明功能文字說明
                                說明功能文字說明功能。文字說明功能文字說明功能文字說明字說明功能文字說明功能文字說明
                                說明功能文字說明功能。文字說明功能文字說明功能文字說明字說明功能文字說明功能文字說明
                            </p> -->
                        </div>
                        <div class="px-4 py-4">
                            <div class="custom-control custom-checkbox noteCheckBox text-left">
                                <input type="checkbox" class="custom-control-input " id="customCheckb1" name="member">
                                <label class="custom-control-label" for="customCheckb1">不再顯示</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-inline">
                                <a href="#" class="btn btn-text-primary changeStatus" data-dismiss="modal">確定</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- * Dialog Basic -->
        </div>



    </div>
    <!-- * App Capsule -->

    <div id="toast-8" class="toast-box toast-bottom bg-secondary">
        <div class="in">
            <div class="text">
                Auto closing in 2 seconds.
            </div>
        </div>
    </div>

    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/driver.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
        sessionStorage.setItem('page','index');
    </script>
    <script src="<?=base_url()?>assets/custom/APIJs/notificationfilter.js"></script>
    <script>
        // const cityfilter = localStorage.getItem('start')
        // console.log('1');
    </script>
</body>

</html>