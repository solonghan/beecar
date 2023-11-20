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
        <div class="pageTitle">加入群組</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="add-friend">
            <div class="section full">
                <div class="bg-gray">
                    <div class="section-title">請輸入群組碼以加入群組</div>
                    <div class="wide-block pb-2">
                        <form class="search-form">
                            <div class="form-group searchbox">
                                <input type="text" id="input" class="form-control search_bar" placeholder="請輸入群組碼">
                                <i class="input-icon search">
                                    <ion-icon name="search-outline"></ion-icon>
                                </i>
                                <a href="javascript:;" id="reset" class="ml-1 close toggle-searchbox">
                                    <ion-icon name="close-circle"></ion-icon>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="driver-list section">
                    <div class="needs-validation group_list">
                    </div>
                </div>
                <div class="form-button-group bottomMenu-button" style="bottom:100px;">
                    <input type="button" class="btn btn-primary btn-block search_group_code" value="搜尋群組碼"></input>
                </div>
                <div class="form-button-group bottomMenu-button">
                    <input type="submit" class="btn btn-primary btn-lg btn-block" value="加入群組" disabled></button>
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

    <div class="modal fade dialogbox" id="memberAddGroup" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">已加入群組</h5>
                </div>
                <div class="modal-footer">
                    <div class="btn-list">
                        <a href="#" class="btn btn-text-secondary btn-block" data-dismiss="modal">關閉</a>
                        <!-- <?=base_url()?>driver/member#drivers -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/driver.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
        sessionStorage.setItem('page','member');
    </script>
    <script src="<?=base_url()?>assets/custom/js/search.js"></script>
    <script src="<?=base_url()?>assets/custom/APIJs/join-group.js?v=001"></script>
    <!-- <script>
        let token = localStorage.getItem('token');
        $('.search_bar').on('keyup',function(e) {
            let searchVal = $(this).val().trim();
            if (searchVal == '') {
                $('input[type="submit"]').attr('disabled',true)
                return
            }
            $.ajax({
                url: baseUrl + 'api/search_group',
                type: 'POST',
                dataType: 'json',
                data: {
                    token: token,
                    search: searchVal
                },
                success: function(res) {
                    console.log(res);
                    if (res.status) {
                        search(searchVal, res.data);
                    }
                }
            })
        })
        function search(searchVal, data) {
            let str = '';
            if (data.length == 0) {
                str = '查無此群組'
                $('input[type="submit"]').attr('disabled',true)
            } else {
                data.forEach(item => {
                if (searchVal == item.code) {
                        localStorage.setItem('groud_id',item.id)
                        str += 
                        `
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="group_${item.id}">群組名稱</label>
                                <input type="text" class="form-control" id="group_${item.id}" value="${item.title}" disabled>
                            </div>
                        </div>
                        `
                    }
                })
                $('input[type="submit"]').attr('disabled',false)
            }
            $('.group_list').html(str)
        }
        $('input[type="submit"]').on('click',function(e) {
            e.preventDefault();
            let groupId = localStorage.getItem('groud_id');
            $.ajax({
                url: baseUrl + 'api/join_group',
                type: 'POST',
                dataType: 'json',
                data: {
                    token: token,
                    group_id: groupId
                },
                success: function(res) {
                    if (res.status) {
                        console.log(res);
                        $('#memberAddGroup').modal('show')
                        localStorage.removeItem('groud_id')
                    } else {
                        alert(res.msg)
                        return
                    }
                }
            })
        })

    </script> -->
</body>

</html>