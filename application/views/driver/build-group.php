<?php include_once (dirname(dirname(__FILE__)) . "/quote/header.php"); ?>
<script src="<?=base_url()?>assets/custom/js/tab.js"></script>
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
        <div class="pageTitle">建立群組</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
    <!-- App Capsule -->
    <div id="appCapsule">


        <div class="section mt-1 mb-2">
            <div class="formgroup">
                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <label class="label" for="groupName">群組名稱</label>
                        <input type="text" class="form-control" id="groupName" name="groupName" placeholder="請輸入群組名稱">
                    </div>
                </div>

                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <label class="label" for="groupCode">群組碼 (其他駕駛可輸入以加入群組)</label>
                        <input type="text" class="form-control" id="groupCode" name="groupCode" placeholder="請設定群組碼">
                    </div>
                    <div class="alertText check_code_msg">
                    </div>
                </div>
            </div>
            <div class="form-button-group bottomMenu-button">
                <input type="button" class="btn btn-primary btn-block" value="下一步">
            </div>
        </div>



    </div>
    <!-- * App Capsule -->
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/driver.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script src="<?=base_url()?>assets/custom/APIJs/build-group.js"></script>
    <script>
        sessionStorage.setItem('page','member');
    </script>
    <!-- <script>
        let token = localStorage.getItem('token');
        $('input[type="button"]').on('click',function(e) {
            e.preventDefault();
            let groupCode = $('input[name="groupCode"]').val().trim();
            let groupName = $('input[name="groupName"]').val().trim();
            if (groupName == '') {
                alert('群組名稱不可為空')
                return
            }
            if (groupCode !== '') {
                $.ajax({
                    url: baseUrl + 'api/group_code_check',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        token: token,
                        code: groupCode,
                    },
                    success: function(res) {
                        if(res.status) {
                            localStorage.setItem('group_code',groupCode)
                            localStorage.setItem('group_name',groupName)
                            location.href="<?=base_url()?>driver/group-driver-choose"
                        } else {
                            $('.check_code_msg').text(res.msg)
                        }
                    }
                })
            } else {
                alert('群組碼欄位不可為空')
                return
            }
            // $.ajax({
            //     url: baseUrl + 'api/group_code_check',
            //     type: 'POST',
            //     dataType: 'json',
            //     data: {
            //         token: token,
            //         code: groupCode
            //     },
            //     success: function(res) {
            //         if (res.status) {
            //             $('.alertText').text(res.msg).css('color','#00DB00')
            //             $('input[type="button"]').attr('disabled', false)
            //             localStorage.setItem('group_name',groupName);
            //             localStorage.setItem('group_code',groupCode);
            //         } else {
            //             $('.alertText').text(res.msg).css('color','red')
            //             $('input[type="submit"]').attr('disabled', true)
            //         }
            //     }
            // })
        })
        // $('input[type="submit"]').on('click',function(e) {
        //     e.preventDefault();
        //     let groupName = $('input[name="groupName"]').val().trim();
        //     let groupCode = $('input[name="groupCode"]').val().trim();
        //     let data = {};
        //     data.token = token;
        //     if (groupName == '' || groupCode == '') {
        //         alert('欄位不可為空')
        //         return
        //     } else {
        //         data.title = groupName
        //         data.code = groupCode
        //     }
        //     $.ajax({
        //         url: baseUrl + 'api/create_group',
        //         type: 'POST',
        //         dataType: 'json',
        //         data: data,
        //         success: function(res) {
        //             if(res.status) {
        //                 alert(res.msg)
        //                 localStorage.setItem('group_id',JSON.stringify(res.group_id))
        //                 // location.href = "<?=base_url()?>driver/group-driver-choose"
        //             } else {
        //                 $('.alertText').html('<p>此群組碼已被使用，請更換一個</p>')
        //                 return
        //             }
        //         },
        //     })
        // })
    </script> -->

</body>

</html>