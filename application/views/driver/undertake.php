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
        <div class="pageTitle">可接行程</div>
        <div class="right">
            <!-- 超級通知位置 -->
            <a href="<?=base_url()?>driver/notification-filter" class="headerButton">
                <ion-icon name="flash-outline"></ion-icon>
            </a>
					<!-- 先隱藏 -->
            <!--<a href="<?=base_url()?>driver/undertack-filter" class="headerButton">
                <ion-icon name="funnel-outline"></ion-icon>
            </a>-->
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">

        <div class="section mt-1 mb-1">
            <div class="undertake_list">
            
            </div>
            <!-- <div class="card">
                <a href="<?=base_url()?>driver/undertake-detail">
                    <div class="card-body">
                        <h5 class="card-title">
                            2020/12/10
                        </h5>
                        <p class="card-subtitle">10:30</p>
                        <div class="card-text">
                            <p>起點 : 台北市中山北路一段</p>
                            <p>終點 : 台北市太原路二段</p>
                        </div>
                        <div class="card-bottom">
                            <div class="remark">
                                <p>車型 : 六人座</p>
                                <p>派遣人 : 林小美</p>
                            </div>
                            <span class="price">實收 : $400</span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="card">
                <a href="<?=base_url()?>driver/undertake-detail">
                    <div class="card-body">
                        <h5 class="card-title">
                            2020/12/10
                        </h5>
                        <p class="card-subtitle">6:30</p>
                        <div class="card-text">
                            <p>起點 : 台北市中山北路一段</p>
                            <p>終點 : 台北市太原路二段</p>
                        </div>
                        <div class="card-bottom">
                            <div class="remark">
                                <p>車型 : 六人座</p>
                                <p>派遣人 : 王大華</p>
                            </div>
                            <span class="price">實收 : $500</span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="card">
                <a href="<?=base_url()?>driver/undertake-detail">
                    <div class="card-body">
                        <h5 class="card-title">
                            2020/12/06
                        </h5>
                        <p class="card-subtitle">6:30</p>
                        <div class="card-text">
                            <p>起點 : 台北市中山北路一段</p>
                            <p>終點 : 台北市太原路二段</p>
                        </div>
                        <div class="card-bottom">
                            <div class="remark">
                                <p>車型 : 六人座</p>
                                <p>派遣人 : 蕭明明</p>
                            </div>
                            <span class="price">實收 : $500</span>
                        </div>
                    </div>
                </a>
            </div> -->

        </div>



    </div>
    <!-- * App Capsule -->

    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/driver.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
        sessionStorage.setItem('page','undertake');
    </script>
    <script src="<?=base_url()?>assets/custom/APIJs/undertake.js"></script>
    <!-- <script>
        let token = localStorage.getItem('token');
        $.ajax({
            url: baseUrl + 'api/undertake_list',
            type: 'POST',
            dataType: 'json',
            data: {
                token: token,
            },
            success: function(res) {
                if(res.status) {
                    render(res.list)
                } else {
                    alert(res.msg);
                }
            }
        })
        function render(data) {
            let str = '';
            data.forEach((item) => {
                str += 
                `
                <div class="card undertake_order" data-order="${item['order_no']}">
                    <a href="undertake-detail?order_id=${item['order_no']}">
                        <div class="card-body">
                            <h5 class="card-title">
                                ${item.date}
                            </h5>
                            <p class="card-subtitle">${item.time}</p>
                            <div class="card-text">
                                <p>起點 : ${item['address_start']}</p>
                                <p>終點 : ${item['address_end']}</p>
                            </div>
                            <div class="card-bottom">
                                <div class="remark">
                                    <p>車型 : ${item['car_model']}</p>
                                    <p>派遣人 : ${item['sender_name']}</p>
                                </div>
                                <span class="price">實收 : $${item.price}</span>
                            </div>
                        </div>
                    </a>
                </div>
                `
            })
            $('.undertake_list').html(str);
        }
    </script> -->
</body>

</html>