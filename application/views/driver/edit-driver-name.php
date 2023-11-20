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
        <div class="pageTitle">編輯駕駛名稱</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="add-friend">
            <div class="section full mt-2">
                <div class="driver-list">
                    <form class="section needs-validation" novalidate>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="name1">駕駛名稱</label>
                                <input type="text" class="form-control edit_name" id="name1" value="">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>
                    </form>
                    <div class="form-button-group fix-btn">
                        <input type="submit" class="btn btn-primary btn-block btn-lg" value="儲存">
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
    <script src="<?=base_url()?>assets/custom/js/get-parameter.js"></script> <!-- 取得網址參數 -->
    <script src="<?=base_url()?>assets/custom/APIJs/edit-driver-name.js"></script>
    <!-- <script>
        let token = localStorage.getItem('token');
        let id = $.urlParam('friend_id');
        function presetName() {
            let showname = JSON.parse(localStorage.getItem('showname'))
            $(".edit_name").val(showname)
            localStorage.removeItem('showname');
        }
        presetName();
        $('input[type="submit"]').on('click',function(e) {
            e.preventDefault();
            let editName = $('.edit_name').val().trim();
            if (editName !== '') {
                $.ajax({
                    url: baseUrl + 'api/edit_friend_driver',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        token: token,
                        driver_id: id,
                        nickname: editName
                    },
                    success: function(res) {
                        alert(res.msg)
                        history.back();
                    }
                })
            } else {
                alert('欄位不可為空') 
            }
        }) 
    </script> -->


</body>

</html>