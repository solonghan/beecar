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
        <div class="pageTitle">通知中心</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="notice section full">
        <!-- <div class="no_list">
                無通知
            </div> -->
            <ul class="listview simple-listview noticeList">
                <!-- <li class="unread">
                    已成功承接 2020/12/10, 早上10:30 的行程
                    <span class="time">2小時前</span>
                </li>
                <li class="read">
                    已成功承接 2020/12/10, 早上11:30 的行程
                    <span class="time">5小時前</span>
                </li>
                <li class="unread">
                    可愛小車隊總指揮發布了新行程至群組
                    <span class="time">2020年12月9日 下午8:26</span>
                </li>
                <li class="unread">
                    已成功承接 2020/12/10, 早上10:30 的行程
                    <span class="time">2020年12月9日 下午8:26</span>
                </li>
                <li class="read">
                    已成功承接 2020/12/5, 早上10:30 的行程
                    <span class="time">2020年12月9日 下午8:26</span>
                </li>
                <li class="read">
                    可愛小車隊總指揮發布了新行程至群組
                    <span class="time">2020年12月9日 下午8:26</span>
                </li> -->
            </ul>
        </div>



    </div>
    <!-- * App Capsule -->

     <!-- modal -->
    <div class="modal fade dialogbox" id="notificationModal" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content commonly_modal">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                </div>
                <form>
                    <div class="modal-body text-left mb-2">
                    </div>
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <button type="button" class="btn btn-text-secondary" data-dismiss="modal">關閉</button>
                            <!-- <button type="button" class="btn btn-text-primary commonly_city_confirm" data-dismiss="modal">確認</button> -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- modal -->
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/driver.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
        sessionStorage.setItem('page','member');
    </script>
    <script src="<?=base_url()?>assets/custom/APIJs/notification.js"></script>
    <!-- <script>
        let token = localStorage.getItem('token')
        let notice;
        $.ajax({
            url: baseUrl + 'api/notification',
            type: 'POST',
            dataType: 'json',
            data: {
                token: token
            },
            success: function(res) {
                notice = res.data;
                rendor(notice);
            }
        })
        function rendor(notice) {
            let str = ''
            for (let i = 0; i < notice.length; i++) {
                str += 
                `
                <li data-notification=${notice[i].id} class="${notice[i]['is_read'] == true ? 'unread' : 'read'}">
                    ${notice[i].content}
                    <span class="time">${notice[i]['create_date']}</span>
                </li>
                `
            }
            $('.noticeList').html(str)
        }
        $(document).on('click','ul > li',function(e){
            let noticeId = $(this).data('notification')
            let list = $(this)
            $.ajax({
                url: baseUrl + 'api/notification_read',
                type: 'POST',
                dataType: 'json',
                data: {
                    token: token,
                    notification_id: noticeId
                },
                success: function(res) {
                    if (res.msg == "通知已標為已讀") {
                        list.removeClass('unread')
                        list.addClass('read')
                    }
                }
            })
        })
    </script> -->


</body>

</html>