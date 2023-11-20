<?php include_once (dirname(dirname(__FILE__)) . "/quote/header.php"); ?>
<link rel="stylesheet" href="<?=base_url()?>assets/custom/cropper/cropper.css">
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
        <div class="pageTitle fs-6">行照驗證</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="section-title bg-gray fs-6 text-info p-2">行照驗證</div>
        <div class="section full mb-2">
            <div class="wide-block pt-2 border-bottom-0">
                <form class="mb-2">
                    <h5 class="fs-6">請上傳行照正面照</h5>
                    <div class="custom-file-upload">
                        <input type="file" id="fileuploadInput" class="js-photo-upload" accept=".png, .jpg, .jpeg">
                        <img src="" alt="" class="showImg1">
                        <label for="fileuploadInput">
                            <span class="js_upload_icon1">
                                <strong>
                                    <ion-icon name="cloud-upload-outline"></ion-icon>
                                    <i>點擊上傳</i>
                                </strong>
                            </span>
                        </label>
                    </div>
                </form>
            </div>
        </div>
        <div class="section full mb-2">
            <div class="wide-block border-bottom-0">
                <form>
                    <h5 class="fs-6">請上傳行照背面照</h5>
                    <div class="custom-file-upload">
                        <input type="file" id="fileuploadInput2" class="js-photo-upload2" accept=".png, .jpg, .jpeg">
                        <img src="" alt="" class="showImg2">
                        <label for="fileuploadInput2">
                            <span class="js_upload_icon2">
                                <strong>
                                    <ion-icon name="cloud-upload-outline"></ion-icon>
                                    <i>點擊上傳</i>
                                </strong>
                            </span>
                        </label>
                    </div>
                </form>
            </div>
        </div>
        <div class="section full mb-3">
            <div class="section-title bg-gray fs-6 text-info pt-2 pb-2">有效日期填寫</div>
            <div class="wide-block pt-2 border-bottom-0">
                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <label class="label fs-6" for="expiredDate">請填寫行照之有效期限</label>
                        <input type="text" class="form-control" id="expiredDate" name="expiredDate" placeholder="ex : 20210327" required>
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>
            </div>
        </div>
        <div class="section btn-bottom mb-2">
            <input type="submit" class="btn btn-primary btn-block btn-lg" value="儲存並送出">
        </div>
    </div>
    <!-- * App Capsule -->
    <div class="modal fade" id="coverModal" role="dialog" aria-labelledby="modalLabel" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">照片</h5>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <img id="coverImage" src="" alt="cover Image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">取消</button>
                    <button id="coverSave" type="button" class="btn btn-primary" data-dismiss="modal">儲存</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="coverModal2" role="dialog" aria-labelledby="modalLabel" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel2">照片</h5>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <img id="coverImage2" src="" alt="cover Image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">取消</button>
                    <button id="coverSave2" type="button" class="btn btn-primary" data-dismiss="modal">儲存</button>
                </div>
            </div>
        </div>
    </div>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/menu/driver.php"); ?>
    <?php include_once (dirname(dirname(__FILE__)) . "/quote/footer.php"); ?>
    <script>
        sessionStorage.setItem('page','member');
    </script>
    <script src="<?=base_url()?>assets/custom/cropper/cropper.js"></script>
    <script src="<?=base_url()?>assets/custom/APIJs/vehicle-license-verify.js"></script>
</body>

</html>