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
        <div class="pageTitle">選擇司機</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="section full mt-2">
            <div class="wide-block pb-2">
                <form class="search-form">
                    <div class="form-group searchbox">
                        <input type="text" id="input" class="form-control search" placeholder="請輸入關鍵字">
                        <i class="input-icon">
                            <ion-icon name="search-outline"></ion-icon>
                        </i>
                        <a href="javascript:;" id="reset" class="ml-1 close toggle-searchbox">
                            <ion-icon name="close-circle"></ion-icon>
                        </a>
                    </div>
                </form>
            </div>
        </div>
        <div class="member-verification">
            <div class="section full mb-2">
                <div class="wide-block p-0 mb-8">   
                    <div class="input-list driverList">
                    </div>    
                </div>
                <div class="section">
                    <input type="submit" class="btn btn-primary btn-lg btn-block" value="確認">
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/driver.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script src="<?=base_url()?>assets/custom/js/search.js"></script>
    <script src="<?=base_url()?>assets/custom/js/get-parameter.js"></script> <!-- 取得網址參數 -->
    <script type="text/javascript">
        sessionStorage.setItem('page','member')
        let token = localStorage.getItem('token');
        let id = $.urlParam('group_id');
        let allData = function() {
            $.ajax({
                url: baseUrl + 'api/friend_list',
                type: 'POST',
                dataType: 'json',
                async: false,
                data: {
                    token: token,
                    exclude_group_id: id
                },
                success: function(res) {
                    if(res.status) {
                        rendor(res.data)
                    } else {
                        if(res.token_status == false){
                            alert(res.msg);
                            localStorage.clear();
                            location.href = '../home/login'
                        }
                    }
                }
            })
        }
        allData();
        $('.search').on('keyup',function(e) {
            let searchVal = $(this).val().trim();
            if (searchVal !== '') {
                $.ajax({
                    url: baseUrl + 'api/friend_list',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        token: token,
                        search: searchVal
                    },
                    success: function(res) {
                        if (res.status) {
                            rendor(res.data)
                        } else {
                            if(res.token_status == false){
                                alert(res.msg);
                                localStorage.clear();
                                location.href = '../home/login'
                            }
                        }
                    }
                })
            } else {
                allData();
            }
        })
        function rendor(data) {
            let str = '';
            if (data == '') {
                str = '';
            } else {
                data.forEach(item => {
                    str += 
                    `
                    <div class="custom-control custom-checkbox" data-driver=${item.id}>
                        <input type="checkbox" id="driver_${item.id}" name="driver[]" class="custom-control-input" value="${item.id}">
                        <label class="custom-control-label" for="driver_${item.id}">${item.username}</label>
                    </div>
                    `
                })
            }
            $('.driverList').html(str)
        }
        $('input[type="submit"]').on('click',function(e) {
            e.preventDefault();
            let addDriver = $('input[name="driver[]"]:checked').map(function(){
            return $(this).val()
            }).get()
            $.ajax({
                url: baseUrl + 'api/group_add_driver',
                type: 'POST',
                dataType: 'json',
                data: {
                    token: token,
                    group_id: id,
                    driver_id: addDriver
                },
                success: function(res) {
                    if(res.status) {
                        location.href="<?=base_url()?>driver/member"
                    } else {
                        if(res.token_status == false){
                            alert(res.msg);
                            localStorage.clear();
                            location.href = '../home/login'
                        } else {
                            alert(res.msg)
                            return
                        }
                    }
                }
            })
        })
    </script>


</body>

</html>