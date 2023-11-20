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
        <div class="pageTitle">群組名稱</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="group-edit">
            <div class="section mt-2">
                <div class="driver-list">
                    <form class="needs-validation editTitle" novalidate>
                    </form>
                    <div class="form-button-group bottomMenu-button">
                        <input type="submit" class="btn btn-primary btn-block btn-lg" value="儲存"></input>
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
    <script src="<?=base_url()?>assets/custom/js/get-parameter.js"></script> <!-- API-取得網址參數 -->
    <script src="<?=base_url()?>assets/custom/APIJs/edit-group-name.js"></script>
    <!-- <script>
        let token = localStorage.getItem('token');
        let id = $.urlParam('group_id');
        $.ajax({
            url: baseUrl + 'api/group_detail',
            type: 'POST',
            dataType: 'json',
            data: {
                token: token,
                group_id:id
            },
            success: function(res) {
                if (res.status){
                    rendor(res.data)
                } else {
                    alert(res.msg)
                }
            }
        })
        function rendor(data) {
            str = 
            `
            <div class="form-group boxed">
                <div class="input-wrapper">
                    <label class="label fs-6" for="groupName">群組名稱</label>
                    <input type="text" class="form-control" id="groupName" name="groupName" value="${data.title}" required>
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
            </div>
            `
            $('.editTitle').html(str)
        }
        $('input[type="submit"]').on('click',function(e) {
            e.preventDefault();
            let editTitle = $('input[name="groupName"]').val().trim();
            if (editTitle == '') {
                alert('欄位不可為空')
                return
            }
            $.ajax({
                url: baseUrl + 'api/edit_group_title',
                type: 'POST',
                dataType: 'json',
                data: {
                    token: token,
                    group_id: id,
                    title: editTitle
                },
                success: function(res) {
                    if (res.status) {
                        alert(res.msg);
                        history.back();
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            })
        })
    </script> -->


</body>

</html>