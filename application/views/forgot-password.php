<?php include_once ("quote/header.php"); ?>

<body class="bg-light">

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader no-border transparent position-absolute">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle"></div>
        <div class="right">
            <a href="<?=base_url()?>home/login" class="headerButton">
                登入
            </a>
        </div>
    </div>
    <!-- * App Header -->
    <!-- App Capsule -->
    <div id="appCapsule">

        <div class="login-form">
            <div class="section">
                <h1>忘記密碼</h1>
                <h4>我們將發送重置密碼的連結至您的電子郵件</h4>
            </div>
            <div class="section mt-2 mb-5">
                <form action="app-pages.html">

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-button-group">
                        <input type="submit" class="btn btn-primary btn-block btn-lg" value="送出">
                    </div>

                </form>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->
    <?php include_once ("quote/footer.php"); ?>
    <script>
    $('input[type="submit"]').on('click',function(e) {
        e.preventDefault();
        alert('新密碼已寄至您的郵件信箱')
        let email = $('input[name="email"]').val().trim();
        $.ajax({
            url: baseUrl + 'api/forget_password',
            type: 'POST',
            dataType: 'json',
            data: {
                email: email
            },
            success: function(res) {
                if (res.status) {
                    // note: 需求是只要送出就直接回首頁，不等結果。
                } else{
                    alert(res.msg)
                }
            },
            error: function(err) {
                alert('請檢查網路連線')
            }
        })
        location.href = 'login'
    })
    </script>
</body>

</html>