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
        <div class="pageTitle">車輛資料</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">

        <div class="member">
            <div class="section full mt-2">
                <div class="wide-block">

                    <form class="needs-validation mb-6" novalidate>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="carbrand">品牌</label>
                                <input type="text" class="form-control" id="carBrand" name="carbrand" placeholder="請輸入車輛品牌">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                                <div class="invalid-feedback">請輸入車輛品牌.</div>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="cartype">型號</label>
                                <input type="phone" class="form-control" id="carmodel" name="carmodel" placeholder="請選擇型號">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                                <div class="invalid-feedback">請選擇型號.</div>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="carType">車型</label>
                                <select class="form-control custom-select" id="carType">
                                    <option value="0" selected disabled>請選擇</option>
                                    <option value="轎車/休旅車(5人座)">轎車/休旅車(5人座)</option>
                                    <option value="休旅車(7人座)">休旅車(7人座)</option>
                                    <option value="商務車(9人座)">商務車(9人座)</option>
                                    <option value="小巴(09~15人座)">小巴(09~15人座)</option>
                                    <option value="中巴(20~28人座)">中巴(20~28人座)</option>
                                    <option value="大巴(32~43人座)">大巴(32~43人座)</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="manufacture">出廠年份</label>
                                <input type="text" class="form-control" id="manufacture" name="manufacture" placeholder="請輸入出廠年份">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                                <div class="invalid-feedback">請輸入出廠年份.</div>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="carColor">顏色</label>
                                <input type="text" class="form-control" id="carColor" name="carColor" placeholder="請輸入顏色">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                                <div class="invalid-feedback">請輸入顏色.</div>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="licensePlate">車牌號碼</label>
                                <input type="text" class="form-control" id="licensePlate" name="licensePlate" placeholder="請輸入車牌號碼" >
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                                <div class="invalid-feedback">請輸入顏色.</div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="section">
                <input type="submit" class="btn btn-primary btn-lg btn-block" value="儲存並送出">
            </div>
        </div>




    </div>
    <!-- * App Capsule -->

    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/driver.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
        sessionStorage.setItem('page','member');
    </script>
    <script>
        let token = localStorage.getItem('token');
        $.ajax({
            url: baseUrl + 'api/driver_info',
            type: 'POST',
            dataType: 'json',
            data: {
                token: token
            },
            success: function(res) {
                if (res.status) {
                    rendor(res['car_info'])
                } else {
                    if(res.token_status == false){
                        alert(res.msg);
                        localStorage.clear();
                        location.href = '../home/login'
                    } else {
                        alert(res.msg);
                    }
                }
            }
        })
        function rendor(data) {
            $('input[name="carbrand"]').val(data.brand)
            $('input[name="carmodel"]').val(data.model)
            $('#carType').val(data.type)
            $('input[name="manufacture"]').val(data.year)
            $('input[name="carColor"]').val(data.color)
            $('input[name="licensePlate"]').val(data.plate)
        }
        $('input[type="submit"]').on('click', function(e) {
            e.preventDefault();
            let brand = $('input[name="carbrand"]').val().trim();
            let model = $('input[name="carmodel"]').val().trim();
            let type = $('#carType').val();
            let year = $('input[name="manufacture"]').val().trim();
            let color = $('input[name="carColor"]').val().trim();
            let plate = $('input[name="licensePlate"]').val().trim();
            let data = {};
            data.token = token;
            data.brand = brand;
            data.model = model;
            data.type = type;
            data.year = year;
            data.color = color;
            data.plate = plate;
            $.ajax({
                url: baseUrl+'api/edit_car_info',
                type: 'POST',
                dataType: 'json',
                data: data,
                success: function(res) {
                    if(res.status) {
                        alert('資料已儲存')
                        location.href = "<?=base_url()?>driver/driver-data-verification"
                    } else {
                        if(res.token_status == false){
                            alert(res.msg);
                            localStorage.clear();
                            location.href = '../home/login'
                        } else {
                            alert(res.msg);
                        }
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            })
        })
    </script>

</body>

</html>