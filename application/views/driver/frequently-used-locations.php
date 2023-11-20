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
        <div class="pageTitle">常用地點</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">


        <div class="section full group-list">
            <div class="title bg-light p-2 ">
                <a href="<?=base_url()?>driver/add-frequently-used-locations" class="d-flex align-items-center text-primary">
                    <ion-icon name="add-circle-outline"></ion-icon>
                    <p class="ml-1">新增常用地點</p>
                </a>
            </div>
            <ul class="listview simple-listview commonly_county">
            </ul>
        </div>
        <div class="section">
            <input type="submit" class="btn btn-primary btn-block" value="確認"></input>
        </div>

        <!-- Dialog Basic -->
        <div class="modal fade dialogbox" id="DialogBasic" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="custom-modal-header modal-header">
                        <h5 class="modal-title">是否刪除此常用地點?</h5>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <a href="#" class="btn btn-text-secondary" data-dismiss="modal">否</a>
                            <a href="#" class="btn btn-text-primary delete_Y" data-dismiss="modal">是</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Dialog Basic -->



    </div>
    <!-- * App Capsule -->
    
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/driver.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
        let token = localStorage.getItem('token');
        $.ajax({
            url: baseUrl + 'api/address_list',
            type: 'POST',
            dataType: 'json',
            data: {
                token: token,
            },
            success: function(res) {
                if(res.status) {
                    render(res['addr_list'])
                } else {
                    if(res.token_status == false){
                        alert(res.msg);
                        localStorage.clear();
                        location.href = '../home/login'
                    } else {
                        alert(res.msg);
                    }
                }
            }
        })
        function render(data) {
            let str = '';
            data.forEach((item) => {
                str +=
                `
                <li data-end="${item.id}">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="${item.id}" name="customRadioList" class="custom-control-input">
                        <label class="custom-control-label" for="${item.id}">${item['city_str'] + item['dist_str'] + item['address']}</label>
                    </div>
                    <div class="delete-icon delete_county">
                        <a href="javascript:;" data-toggle="modal" data-target="#DialogBasic">
                            <ion-icon name="remove-circle-outline"></ion-icon>
                        </a>
                    </div>
                </li>
                `
            })
            $('.commonly_county').html(str)
        }
        $(document).on('click','.delete_county',function(e) {
            console.log(e);
            let address_id = $(this).parent().data('end');
            $('.delete_Y').on('click',function(e) {
                console.log(e);
                $.ajax({
                    url: baseUrl + 'api/del_address',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        token: token,
                        address_id: address_id,
                    },
                    success: function(res) {
                        if(res.status) {
                            location.reload();
                        } else {
                            if(res.token_status == false){
                                alert(res.msg);
                                localStorage.clear();
                                location.href = '../home/login'
                            } else {
                                alert(res.msg);
                            }
                        }
                    }
                })
            })
        })

        $('input[type="submit"]').on('click',function(e) {
            e.preventDefault();
            let a_id = localStorage.getItem('a_id')
            let addr_id = $('input[type="radio"]:checked').attr('id')
            if (addr_id == undefined) {
                alert('請選擇常用地點');
                return
            }
            console.log(addr_id);
            $.ajax({
                url: baseUrl + 'api/addr_add_to_order',
                type: 'POST',
                dataType: 'json',
                data: {
                    token: token,
                    a_id: a_id,
                    addr_id: addr_id,
                },
                success: function(res) {
                    if(res.status) {
                        commonly(res['address_data'])
                    } else {
                        if(res.token_status == false){
                            alert(res.msg);
                            localStorage.clear();
                            location.href = '../home/login'
                        } else {
                            alert(res.msg);
                        }
                    }
                }
            })
        })
        function commonly(addr) {
            localStorage.setItem('commonly_info',JSON.stringify(addr));
            history.go(-1);
        }
    </script>
</body>

</html>