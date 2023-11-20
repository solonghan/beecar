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
        <div class="pageTitle">狀態篩選</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <?php include_once (dirname(dirname(__FILE__)) . "/quote/statusfilter.php"); ?>
        <div class="section">
            <input type="submit" class="btn btn-primary btn-lg btn-block" value="確認"></input>
        </div>
    </div>
    <!-- * App Capsule -->

    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/driver.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
        const urlcity = location.href; // 現在網頁
        const url1 = new URL(urlcity); // 解網址
        const filterType = url1.searchParams.get('type');
        // console.log(fromPageParam);
        // const searchCityParam = new URLSearchParams()
        $('input[type="submit"]').on('click',function(e) {
            e.preventDefault();
            const statusVal = $('input[name="status[]"]:checked').map(function() {
                return $(this).val();
            }).get();
            console.log(statusVal);
            // let fromPage = document.referrer // 從哪裡來?
            // let fromPageURL = new URL(fromPage); //解網址
            // let params = new URLSearchParams(fromPageURL.search)
            // fromPageURL.search = params
            // window.location.href = `${fromPageURL.href}`
        })
    </script>
</body>

</html>