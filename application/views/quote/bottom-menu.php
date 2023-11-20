<div id="appBottomMenu" class="appBottomMenu">
        <a href="<?=base_url()?>driver/driver-index" class="item stroked">
            <div class="col">
                <ion-icon name="car-outline"></ion-icon>
                <span>已接行程</span>
            </div>
        </a>
        <a href="<?=base_url()?>driver/undertake" class="item canStroked">
            <div class="col">
                <ion-icon name="document-text-outline"></ion-icon>
                <span>可接行程</span>
            </div>
        </a>
        <a href="<?=base_url()?>driver/create-itinerary" class="item createStroke">
            <div class="col">
                <ion-icon name="add-circle-outline"></ion-icon>
                <span>建立行程</span>
            </div>
        </a>
        <a href="<?=base_url()?>driver/dispach" class="item orderList">
            <div class="col">
                <ion-icon name="file-tray-full-outline"></ion-icon>
                <span>管理列表</span>
            </div>
        </a>
        <a href="<?=base_url()?>driver/member" class="item member">
            <div class="col">
                <ion-icon name="happy-outline"></ion-icon>
                <span>會員中心</span>
            </div>
        </a>
</div>

<script>
    $(window).bind('beforeunload',function() {
        $('#appBottomMenu').find('active').removeClass('active')
    })
    $('#appBottomMenu a').on('click',function(e) {
        let bottomClass = $(this).attr('class').split(/\s+/)
        $.each(bottomClass, (index,item) => {
            localStorage.setItem('page',item)
        })
    })
</script>