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
        <div class="pageTitle">加值服務</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">


        <div class="section mt-2">
            <div class="card">
                <div class="card-body value-add-card">
                    <h5 class="card-title">超級通知功能</h5>
                    <div class="icon-text">
                        <div class="icon-info">
                            <ion-icon name="list-outline" size='large'></ion-icon>
                            <h5>多筆篩選</h5>
                        </div>
                        <div class="icon-info">
                            <ion-icon name="flash-outline" size='large'></ion-icon>
                            <h5>極速通知</h5>
                        </div>
                        <div class="icon-info">
                            <ion-icon name="timer-outline" size='large'></ion-icon>
                            <h5>省時省力</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section mt-2">
            <div class="card">
                <div class="card-body value-add-card">
                    <h5 class="card-title">功能說明</h5>
                    <div class="card-text">
                        <p>
                            放置文案的地方放置文案的地方，使用超級
                            通知便能夠做的事。
                        </p>
                        <p>
                            服務功能 服務說明 服務說明 服務說明
                            服務功能，說明服務。說明服務說明說明
                            超級通知說明、功能等等......
                        </p>
                    </div>
                    <span class="text-info">(可使用官方發送之點數消費)</span>
                    <a href="javascript:;" class="btn btn-primary btn-block enable">立即啟用</a>
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
        $(document).on('click','.enable',function() {
            $.ajax({
                url: baseUrl + 'api/active_super_info',
                type: 'POST',
                dataType: 'json',
                data: {
                    token: token
                },
                success: function(res) {
                    if (res.status) {
                        console.log(res);
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
    </script>

</body>

</html>