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
        <div class="pageTitle">駕駛資料</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="member fs-6">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="set" role="tabpanel">
                    <div class="section full">
                        <ul class="listview link-listview driver_info">
                        </ul>
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
                    console.log(res);
                    driverInfo(res)
                } else {
				if(res.token_status == false){
					alert(res.msg);
					localStorage.clear();
					location.href = '../home/login'
				}
			}
            },
        })
        function driverInfo(data) {
            let carinfo = data['car_info'];
            let driverinfo = data['driver_info'];
            driverinfo_li = 
            `
            <li>
                <a href="<?=base_url()?>driver/vehical-Information">
                    車輛資料
                    <span class="text-${classNameFn(carinfo.status)}">${statusTxt(carinfo.status)}</span>
                </a>
            </li>
            `
            $('.driver_info').html(driverinfo_li)

            // 先隱藏的內容
            // <li>
            //     <a href="<?=base_url()?>driver/photo-verify">
            //         照片驗證
            //         <span class="text-${classNameFn(driverinfo.photo.status)}">${statusTxt(driverinfo.photo.status)}</span>
            //     </a>
            // </li>
            // <li>
            //     <a href="<?=base_url()?>driver/ID-card">
            //         身分證驗證
            //         <span class="text-${classNameFn(driverinfo.idcard.status)}">${statusTxt(driverinfo.idcard.status)}</span>
            //     </a>
            // </li>
            // <li>
            //     <a href="<?=base_url()?>driver/vehicle-license-verify">
            //     行照驗證
            //     <span class="text-${classNameFn(driverinfo.vehiclelicense.status)}">${statusTxt(driverinfo.vehiclelicense.status)}</span>
            //     </a>
            // </li>
            // <li>
            //     <a href="<?=base_url()?>driver/drivers-license">
            //         駕照驗證
            //         <span class="text-${classNameFn(driverinfo.driverlicense.status)}">${statusTxt(driverinfo.driverlicense.status)}</span>
            //     </a>
            // </li>
            // <li>
            //     <a href="<?=base_url()?>driver/vehicle-verify">
            //         車輛驗證
            //         <span class="text-${classNameFn(driverinfo.car.status)}">${statusTxt(driverinfo.car.status)}</span>
            //     </a>
            // </li>
        }
        function classNameFn(status) {
            switch(status) {
                case 'pending' :
                return 'brown'
                break;
                case 'empty' :
                return 'info'
                break;
            }
        }
        function statusTxt(statustxt) {
            switch(statustxt) {
                case 'pending' :
                return '審核中'
                break;
                case 'empty' :
                return '未填寫'
                break;
                case 'verified' :
                return '已通過'
                break;
                case 'invalid' :
                return '未通過'
                break;
            }
        }
    </script>


</body>

</html>