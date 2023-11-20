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
        <div class="pageTitle">建立行程</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">


        <div class="set-search section full mt-2">
            <div class="section-title">聯絡人電話</div>
            <div class="pl-2 pr-2">
                <form class="search-form" onsubmit="return false">
                    <div class="form-group searchbox">
                        <input type="text" class="form-control order_contact_person" placeholder="請輸入聯絡人電話">
                        <!-- <ion-icon name="search-outline" class="search-icon"></ion-icon> -->
                    </div>
                </form>
            </div>
        </div>

        <div class="create_order mb-2 mt-2" id="sliderCard">
            <!-- <div class="carousel-single carousel-custom owl-carousel owl-theme carousel_order_card">
                <div class="item">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">2019/12/11</h5>
                            <div class="card-text">
                                <p>起點 : 台北市中山北路一段59號</p>
                                <p>目的地 : 台北市太原路二段72號</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">2019/10/16</h5>
                            <div class="card-text">
                                <p>起點 : 台北市中山北路一段59號</p>
                                <p>目的地 : 台北市太原路二段72號</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

        </div>

        <div class="section mb-3 detail_card">
            <!-- <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        2020/12/10
                    </h5>
                    <p class="card-subtitle">10:30</p>
                    <div class="card-text">
                        <p>起點 : 台北市中山北路一段59號</p>
                        <p>目的地 : 台北市太原路二段72號</p>
                    </div>
                    <div class="card-bottom">
                        <div class="remark">
                            <p>航班編號 : FQV1316</p>
                            <p>車型 : 五人座</p>
                            <p>行李數 : 2件 / 乘客數 : 3人</p>
                            <p>備註 : 有寵物狗，行李很重</p>
                            <p>支付方式 : 現金</p>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>

        <div class="section full mt-2">
            <div class="wide-block pt-2 pb-2">
                <form class="needs-validation" novalidate>
                    <h2 class="fw-bold mb-2">建立行程</h2>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="">聯絡人名稱</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="請輸入聯絡人名稱" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                            <div class="invalid-feedback">請輸入聯絡人名稱</div>
                        </div>
                    </div>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="">預約日期</label>
                            <input type="text" class="form-control" id="appointment" name="date" placeholder="請選擇" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                            <div class="invalid-feedback">請選擇預約日期</div>
                        </div>
                    </div>

                    <div class="form-group boxed form-multiple">
                        <div class="input-wrapper">
                            <label class="label" for="">預約時間(小時)</label>
                            <select class="form-control custom-select" id="reservationHR" name="hour" required>
                                <option selected value="">請選擇</option>
                            </select>
                            <div class="invalid-feedback">請選擇時間</div>
                        </div>
                        <div class="input-wrapper">
                            <label class="label" for="">預約時間(分鐘)</label>
                            <select class="form-control custom-select" id="reservationMn" name="minute" required>
                                <option selected value="">請選擇</option>
                            </select>
                            <div class="invalid-feedback">請選擇時間</div>
                        </div>
                    </div>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="">航班編號</label>
                            <input type="text" class="form-control" id="flight" name="flight" placeholder="請輸入航班編號">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                            <div class="invalid-feedback">請輸入航班編號</div>
                        </div>
                    </div>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="">預約車型</label>
                            <select class="form-control custom-select" id="carModel" name="car_model" required>
                                <option selected disabled value="">請選擇</option>
                                <optgroup label="小客車">
                                    <option value="轎車/休旅車(5人座)">轎車/休旅車(5人座)</option>
                                    <option value="休旅車(7人座)">休旅車(7人座)</option>
                                    <option value="商務車(9人座)">商務車(9人座)</option>
                                </optgroup>
                                <optgroup label="大客車">
                                    <option value="小巴(09~15人座)">小巴(09~15人座)</option>
                                    <option value="中巴(20~28人座)">中巴(20~28人座)</option>
                                    <option value="大巴(32~43人座)">大巴(32~43人座)</option>
                                </optgroup>
                            </select>
                            <div class="invalid-feedback">請選擇車型</div>
                        </div>
                    </div>
                    <div class="location">
                        <div class="form-group boxed form-multiple end_form">
                            <div class="input-wrapper">
                                <label class="label" for="">起點城市</label>
                                <select class="form-control custom-select city_select" id="startCity" name="outset_city" required>
                                    <option selected disabled value="">請選擇</option>
                                </select>
                                <div class="invalid-feedback">請選擇起點城市</div>
                            </div>
                            <div class="input-wrapper">
                                <label class="label" for="">起點區域</label>
                                <select class="form-control custom-select area_select" id="startDist" name="outset_area" required>
                                    <option selected disabled value="">請選擇</option>
                                </select>
                                <div class="invalid-feedback">請選擇起點區域.</div>
                            </div>

                            <div class="input-textarea">
                                <label class="label d-flex justify-content-between" for="">
                                    起點詳細地址
                                    <span>
                                        <a href="javascript:;" class="text-primary commonly_county">選擇常用地點</a>
                                    </span>
                                </label>
                                <textarea class="form-control address" id="startAddress" cols="30" rows="10" name="outset_address" placeholder="請輸入詳細地址" required></textarea>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                                <div class="invalid-feedback">請填寫起點詳細地址.</div>
                            </div>
                        </div>
                        <div class="end_List_form">
                            <div class="form-group boxed form-multiple end_form areaList" data-destination="1">
                                <a href="#" class="delete" data-toggle="modal">
                                    <ion-icon name="remove-circle-outline"></ion-icon>
                                    <span>刪除</span>
                                </a>
                                <div class="input-wrapper">
                                    <label class="label" for="">目的地城市</label>
                                    <select class="form-control custom-select city_select" id="endCity1" name="city1" required>
                                        <option disabled value="">請選擇</option>
                                    </select>
                                    <div class="invalid-feedback">請選擇目的地城市1.</div>
                                    
                                </div>
                                <div class="input-wrapper">
                                    <label class="label" for="">目的地區域</label>
                                    <select class="form-control custom-select area_select" id="endDist1" name="area1" required>
                                        <option selected disabled value="">請選擇</option>
                                    </select>
                                    <div class="invalid-feedback">請選擇目的地區域</div>
                                </div>
                                <div class="input-textarea">
                                    <label class="label d-flex justify-content-between" for="">
                                        目的地詳細地址
                                        <span>
                                            <a href="javascript:;" class="text-primary commonly_county">選擇常用地點</a>
                                        </span>
                                    </label>
                                    <textarea class="form-control address" id="endAddress1" cols="30" rows="10" name="address1" placeholder="請填寫起點詳細地址" required></textarea>
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                    <div class="invalid-feedback">請填寫起點詳細地址</div>
                                </div>
                            </div>


                            <!-- <div class="form-group boxed form-multiple end_form areaList" data-destination="2">
                                <a href="#" data-toggle="modal">
                                    <div class="delete">
                                        <ion-icon name="remove-circle-outline"></ion-icon>
                                        <span>刪除</span>
                                    </div>
                                </a>
                                <div class="input-wrapper">
                                    <label class="label" for="city2">目的地城市</label>
                                    <select class="form-control custom-select city_select" id="city2" name="city2" required>
                                        <option selected disabled value="">請選擇</option>
                                    </select>
                                    <div class="invalid-feedback">請選擇目的地城市1.</div>
                                    
                                </div>
                                <div class="input-wrapper">
                                    <label class="label" for="dist2">目的地區域</label>
                                    <select class="form-control custom-select area_select" id="dist2" name="area2" required>
                                        <option selected disabled value="">請選擇</option>
                                    </select>
                                    <div class="invalid-feedback">請選擇目的地區域</div>
                                </div>
                                <div class="input-textarea">
                                    <label class="label d-flex justify-content-between" for="address2">
                                        目的地詳細地址
                                        <span>
                                            <a href="<?=base_url()?>driver/frequently-used-locations" class="text-primary">選擇常用地點</a>
                                        </span>
                                    </label>
                                    <textarea class="form-control address" id="address1" cols="30" rows="10" name="address1" placeholder="請填寫起點詳細地址" required></textarea>
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                    <div class="invalid-feedback">請填寫起點詳細地址</div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="add col-12 p-0">
                        <a href="javascript: ;" class="fs-6 text-primary d-flex align-items-center justify-content-end add">
                            <ion-icon name="add-circle-outline"></ion-icon>
                            <span>新增目的地</span>
                        </a>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="">乘車人數</label>
                            <input type="text" class="form-control" id="people" name="number" placeholder="請輸入乘車人數" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                            <div class="invalid-feedback">請輸入乘車人數.</div>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="">行李件數</label>
                            <input type="text" class="form-control" id="baggage" name="baggage" placeholder="請輸入行李件數" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                            <div class="invalid-feedback">請輸入行李件數.</div>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="">備註</label>
                            <textarea class="form-control" id="remark" cols="30" rows="10" name="remark"></textarea>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="">車資</label>
                            <input type="text" class="form-control" id="cash1" name="price" placeholder="請輸入車資">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                            <div class="invalid-feedback">請輸入車資.</div>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <div class="custom-control custom-radio d-inline">
                                <input type="radio" id="Rebate" name="customRadioInline" class="custom-control-input" value="0" checked>
                                <label class="custom-control-label p-0 mr-1" for="Rebate">回金</label>
                            </div>
                            <div class="custom-control custom-radio d-inline">
                                <input type="radio" id="subsidy" name="customRadioInline" class="custom-control-input" value="1">
                                <label class="custom-control-label p-0" for="subsidy">補貼</label>
                            </div>
                            <input type="text" class="form-control mt-1" id="cash" name="final_payment" placeholder="請輸入金額">
                        </div>
                    </div>

                    <!-- <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="payment">支付方式</label>
                            <select class="form-control" aria-label="Default select example" id="payment">
                                <option disabled selected>請選擇</option>
                                <option value="1">信用卡</option>
                                <option value="2">現金</option>
                            </select>
                            <div class="valid-feedback">Looks good!</div>
                            <div class="invalid-feedback">請選擇支付方式.</div>
                        </div>
                    </div> -->
                    <div class="mt-2">
                        <input class="btn btn-primary btn-block" type="submit" value="建立"></input>
                        <!-- dispach.html -->
                    </div>

                </form>


            </div>
        </div>



    </div>
    <!-- * App Capsule -->

    <div class="modal fade dialogbox" id="deleteDialog" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">是否刪除此地點?</h5>
                </div>
                <div class="modal-footer">
                    <div class="btn-inline">
                        <a href="#" class="btn btn-text-secondary delete_N" data-dismiss="modal">否</a>
                        <a href="#" class="btn btn-text-primary delete_Y" data-dismiss="modal">是</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade dialogbox" id="countyModal" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content commonly_modal">
                <div class="modal-header">
                    <h5 class="modal-title">常用地點</h5>
                </div>
                <form>
                    <div class="modal-body text-left mb-2">
                        <div class="form-group basic">
                            <div class="input-wrapper">
                            <ul class="listview simple-listview commonly_modal_county">
                            </ul>
                            <a href="javascript:;" class="d-flex align-items-center text-primary add_county">
                                <ion-icon name="add-circle-outline"></ion-icon>
                                <p class="ml-1">新增常用地點</p>
                            </a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <button type="button" class="btn btn-text-secondary" data-dismiss="modal">關閉</button>
                            <button type="button" class="btn btn-text-primary commonly_city_confirm" data-dismiss="modal">確認</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade dialogbox" id="DialogBasic" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="custom-modal-header modal-header">
                    <h5 class="modal-title">是否刪除此常用地點?</h5>
                </div>
                <div class="modal-footer">
                    <div class="btn-inline">
                        <a href="#" class="btn btn-text-secondary" data-dismiss="modal">否</a>
                        <a href="#" class="btn btn-text-primary delete_county_Y">是</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade dialogbox" id="addCounty" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content commonly_modal">
                <div class="modal-header">
                    <h5 class="modal-title">新增常用地點</h5>
                </div>
                <form>
                    <div class="modal-body text-left mb-2">
                        <div class="form-group boxed form-multiple">
                            <div class="input-wrapper">
                                <label class="label" for="modalCity">城市</label>
                                <select class="form-control custom-select city_select" id="modalCity" required>
                                    <option selected disabled value="">請選擇</option>
                                </select>
                                <div class="invalid-feedback">請選擇城市.</div>
                            </div>
                            <div class="input-wrapper">
                                <label class="label" for="modalDist">區域</label>
                                <select class="form-control custom-select area_select" id="modalDist" required>
                                    <option selected disabled value="">請選擇</option>
                                </select>
                                <div class="invalid-feedback">請選擇區域.</div>
                            </div>
                            <div class="input-textarea">
                                <label class="label d-flex justify-content-between" for="address">
                                    詳細地址
                                </label>
                                <textarea class="form-control address" name="address" id="modalAddress" cols="30" rows="10" placeholder="請填寫起點詳細地址" required></textarea>
                                <div class="invalid-feedback">請輸入地址.</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <button type="button" class="btn btn-text-secondary" data-dismiss="modal">關閉</button>
                            <button type="button" class="btn btn-text-primary add_county_Y">儲存</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="toast-4" class="toast-box toast-top">
        <div class="in">
            <div class="text">
                已建立訂單
            </div>
        </div>
    </div>
    <div id="copyorder" class="toast-box toast-top">
        <div class="in">
            <div class="text">
                已複製行程
            </div>
        </div>
    </div>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/car.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
        sessionStorage.setItem('page','create-itinerary');
    </script>
    <script src="<?=base_url()?>assets/js/plugins/owl-carousel/carousel-custom.js"></script>
    <script src="<?=base_url()?>assets/custom/js/county-drop-down.js"></script>
    <script src="<?=base_url()?>assets/custom/js/create-itinerary.js"></script>
    <script src="<?=base_url()?>assets/js/plugins/jquery-ui-datepick.custom/jquery-ui.min.js" ></script>
    <script src="<?=base_url()?>assets/custom/APIJs/create-itinerary.js"></script>
    <script src="<?=base_url()?>assets/custom/js/validation-form.js"></script>
</body>

</html>