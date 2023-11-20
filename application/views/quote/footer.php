    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
    <script src="<?=base_url()?>assets/js/lib/jquery-3.4.1.min.js"></script>
    <!-- Bootstrap-->
    <script src="<?=base_url()?>assets/js/lib/popper.min.js"></script>
    <script src="<?=base_url()?>assets/js/lib/bootstrap.min.js"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.js"></script>
    <!-- Owl Carousel -->
    <script src="<?=base_url()?>assets/js/plugins/owl-carousel/owl.carousel.min.js"></script>
    <!-- jQuery Circle Progress -->
    <script src="<?=base_url()?>assets/js/plugins/jquery-circle-progress/circle-progress.min.js"></script>
    <script src="<?=base_url()?>assets/custom/js/bottom-menu.js"></script>
    <!-- Base Js File -->
    
    <script src="<?=base_url()?>assets/js/base.js"></script>
    <script src="<?=base_url()?>assets/custom/js/card-Itinerary-execution.js?v=001"></script>
    <!-- APIURL -->
    <script src="<?=base_url()?>assets/custom/js/envs.js"></script>
    <script src="<?=base_url()?>assets/custom/APIJs/getUserInfo.js"></script>
    <script>
    if('serviceWorker' in navigator) {
        navigator.serviceWorker.register('../service-worker.js')
        .then(registration => {
            console.log('成功', registration);
        }).catch(() => {
            console.log('unable to get permission to notify');
        })
    }

    const is_verify = localStorage.getItem('is_verify') || '';
    if (is_verify == 'false') {
        console.log($('#appBottomMenu .hide'));
        $('#appBottomMenu .hide').remove();
    };
    </script>

