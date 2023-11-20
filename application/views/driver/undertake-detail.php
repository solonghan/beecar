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
        <div class="pageTitle">可接行程詳情</div>
        <div class="right">
            <a href="<?=base_url()?>driver/driver-index" class="headerButton">
                <ion-icon name="albums-outline"></ion-icon>
            </a>
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">


        <div class="detail-page">
            <div class="section mt-2 mb-2">
            <div class="undertake-detail-card">
            </div>
                <!-- <div class="card undertake-detail-card">
                    <div class="card-body">
                        <h5 class="card-title">
                            2020/12/10
                        </h5>
                        <p class="card-subtitle">10:30</p>
                        <div class="card-text">
                            <p>起點 : 台北市中山區中山北路一段</p>
                            <p>目的地 : 台北市大同區太原路二段</p>
                        </div>
                        <div class="card-bottom">
                            <div class="remark">
                                <p>車型 : 四人座</p>
                                <p>行李數 : 2件 / 乘客數 : 3人</p>
                                <p>備註 : 有寵物狗，行李很重</p>
                                <p>支付方式 : 現金</p>
                                <a href="<?=base_url()?>driver/undertack-drive-information"><p>派遣人 : 林小美</p></a>
                            </div>
                            <span class="price">實收 : $400</span>
                        </div>
                    </div>
                </div> -->
                <input type="submit" class="btn btn-primary btn-lg btn-block" value="我要承接">
            </div>
        </div>



    </div>
    <!-- * App Capsule -->


        <div class="modal fade dialogbox" id="undertake" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">已承接</h5>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-list">
                            <a href="#" class="btn btn-block close" data-dismiss="modal">關閉</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/driver.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
        sessionStorage.setItem('page','undertake');
    </script>
    <script src="<?=base_url()?>assets/custom/js/get-parameter.js"></script> <!-- 取得網址參數 -->
    <script>
        let token = localStorage.getItem('token');
        let orderId = $.urlParam('order_id');
        $.ajax({
            url: baseUrl + 'api/get_order_detail',
            type: 'POST',
            dataType: 'json',
            data: {
                token: token,
                order_no: orderId
            },
            success: function(res) {
                if(res.status) {
                    render(res)
                } else {
                    if(res.token_status == false){
                        alert(res.msg);
                        localStorage.clear();
                        location.href = '../home/login'
                    } else {
                        alert('取得訂單資訊失敗')
                    }
                }
            }
        })

        function render(data) {
            console.log(data.order_middle,data.order_owner)
            data.friend_id = (data.order_middle == 0 ? data.order_owner : data.order_middle)
            console.log(data.friend_id)
            let str = 
            `
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        ${data.date}
                    </h5>
                    <p class="card-subtitle">${data.time}</p>
                    <div class="card-text">
                        <p>起點 : ${data['start_addr']}</p>
                        ${AllTarget(data['end_addr'])}
                    </div>
                    <div class="card-bottom">
                        <div class="remark">
                            <p>車型 : ${data['car_model']}</p>
                            <p>行李數 : ${data['baggage']}件</p>
                            <p>乘客數 : ${data['number']}人</p>
                            <div style="display:flex;">
                                <div>備註 :&nbsp;</div>
                                <div style="white-space:pre-wrap;">${data['remark']}</div>
                            </div>
                            <a href="undertack-drive-information?friend_id=${data["friend_id"]}"><p>派遣人 : ${data['sender_name']}</p></a>
                        </div>
                        <span class="price">實收 : $${data['last_price']}</span>
                    </div>
                </div>
            </div>
            `
            $('.undertake-detail-card').html(str)
        }
        function AllTarget(address) {
            console.log(address);
            if (typeof address === 'string') {
                return
            }else {
                let target = ''
                if (address) {
                    if (address.length < 2) {
                        address.forEach(e => {
                            target += `
                            <p>目的地 : ${e}</p>
                            `
                        })
                    } else {
                        address.forEach((e, i) => {
                            target += `
                            <p>目的地${i+1} : ${e}</p>
                            `
                        })
                    }
                    return target
                }else {
                    return '<p>目的地: </p>'
                }
            }
        }
        $(document).on('click','input[type="submit"]',function(e) {
            e.preventDefault();
            $.ajax({
                url: baseUrl + 'api/get_order',
                type: 'POST',
                dataType: 'json',
                data: {
                    token: token,
                    order_no: orderId,
                },
                success: function(res) {
                    if (res.status) {
                        if(res.msg != "此行程不存在") {
                            $('#undertake').modal('show');
                        } else {
                            alert(res.msg)
                            location.href = "undertake"
                        }
                    } else {
                        if(res.token_status == false){
                            alert(res.msg);
                            localStorage.clear();
                            location.href = '../home/login'
                        }
                    }
                }
            })
        })
        $('.close').on('click',function(e) {
            location.href = "undertake"
        })
    </script>

</body>

</html>