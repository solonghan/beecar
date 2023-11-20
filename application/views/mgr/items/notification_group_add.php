<!DOCTYPE html>
<html>

<head>
    <? include("header.php"); ?>

    <link href="vendors/clockface/css/clockface.css" rel="stylesheet" type="text/css"/>
    <link href="vendors/colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet" type="text/css"/>
    <link href="vendors/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
    <link href="vendors/bootstrap-touchspin/css/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css"/>
    <link href="vendors/bootstrap-multiselect/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css"/>
    <link href="vendors/clockpicker/css/bootstrap-clockpicker.min.css" rel="stylesheet" type="text/css"/>
    <link href="vendors/bootstrap-switch/css/bootstrap-switch.css" rel="stylesheet" type="text/css"/>
    

    <link rel="stylesheet" type="text/css" href="css/pickers.css">
    <link rel="stylesheet" href="crop/cropper.css">


    <link rel="stylesheet" type="text/css" href="vendors/datatables/css/dataTables.bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="vendors/datatablesmark.js/css/datatables.mark.min.css"/>

    <link href="vendors/select2/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="vendors/select2/css/select2-bootstrap.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" media="screen" type="text/css" href="vendors/summernote/summernote.css">

    <!--end of page level css-->

</head>
<? include("nav+menu.php"); ?>
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?=$title?>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?=base_url() ?>mgr/">
                        <i class="fa fa-fw ti-home"></i> 主控板
                    </a>
                </li>
                <li ><a href="<?=base_url() ?>mgr/priv">
                        <i class="fa fa-fw ti-comment-alt"></i> <?=$title?>管理
                    </a>
                </li>
                <li class="active"><?=$title?></li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="panel filterable">
                        <div class="panel-heading clearfix">
                            <h3 class="panel-title pull-left m-t-6">
                                <i class="ti-view-list"></i> 新增<?=$title?>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="<?=base_url() ?>mgr/notification_group/add" id="notification_group_form" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">種類</label>
                                    <div class="col-sm-10">
                                        <select class="form-control select2" name="type" id="type">
                                            <option value="text">文字</option>
                                            <option value="coupon">優惠券</option>
                                            <option value="activity">活動</option>
                                            <option value="url">網址</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">種類項目</label>
                                    <div class="col-sm-10">
                                        <select class="form-control select2" name="relation_id" id="relation_id">
                                            <option value="text">0(種類為文字或網址，不需選擇)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label">對象</label>
                                    <div class="col-sm-10">
                                        <select class="form-control select2" name="target">
                                            <option value="1">吳俊宏</option>
                                            <option value="6">施燕汝</option>
                                            <option value="8">張蓉蓉</option>
                                            <option value="14">朱璇</option>
                                            <option value="1610">林俊傑</option>
                                            <option value="1612">楊曉青</option>
                                            <option value="1608">李嘉誠</option>
                                            <option value="test">測試員</option>
                                            <option value="all_1">全部(上)</option>
                                            <option value="all_2">全部(下)</option>
                                            <option value="new_1">新客戶(上)</option>
                                            <option value="new_2">新客戶(下)</option>
                                            <option value="old_1">舊客戶(上)</option>
                                            <option value="old_2">舊客戶(下)</option>
                                            <option value="designer">設計師</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="t_and_c" style="display: block;">
                                    <div class="form-group">
                                        <label for="input-text" class="col-sm-2 control-label">標題</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="title" value="">
                                        </div>
                                    </div>
                                    <div class="form-group" id="only_cont">
                                        <label for="input-text" class="col-sm-2 control-label">內容</label>
                                        <div class="col-sm-10">
                                            <textarea name="content" class="form-control" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>                                
                                <div id="u" style="display: none;">
                                    <div class="form-group">
                                        <label for="input-text" class="col-sm-2 control-label">網址</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="url" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-block btn-primary submit_btn">發送給會員</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="background-overlay"></div>
        </section>
        <!-- /.content -->
    </aside>
</div>
<!-- Cover Modal -->
<div class="modal fade" id="coverModal" role="dialog" aria-labelledby="modalLabel" tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">照片</h5>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
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
<!-- Cover Modal -->
<!-- global js -->
<script src="js/app.js" type="text/javascript"></script>

<script src="crop/cropper.js"></script>
<!-- end of global js -->
<script type="text/javascript" src="vendors/summernote/summernote.min.js"></script>
<script src="vendors/moment/js/moment.min.js" type="text/javascript"></script>
<script src="vendors/colorpicker/js/bootstrap-colorpicker.min.js" type="text/javascript"></script>
<script src="vendors/clockpicker/js/bootstrap-clockpicker.min.js" type="text/javascript"></script>
<script src="vendors/datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="vendors/datetimepicker/js/zh-tw.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        $(".select2").select2();
        $(".summernote").summernote({
            height: 350,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['Insert', ['picture', 'link', 'table', 'hr']],
                ['view', ['codeview']],
            ],
            callbacks: {
                onImageUpload: function(image) {
                    var file = image[0];

                    data = new FormData();
                    data.append("pic", file);
                    $.ajax({
                        data: data,
                        type: "POST",
                        url: "<?=base_url()?>mgr/Upload_pic",
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(url) {
                            var image = $('<img>').attr('src', url).css("width", '100%');
                            $('.summernote').summernote("insertNode", image[0]);
                        }   
                    });
                }
            }
        });

        function readURL(input,id_str) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#'+id_str).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#img").change(function() {
            readURL(this,"img_show");
        });


        $(".submit_btn").on('click', function(event) {
            $("#notification_group_form").submit();
        });
        $(".submit_single_btn").on('click', function(event) {
            $("#content").html($('#content_sn').summernote('code'));
            $("#given_type").val('single');
            $("#new_form").submit();
        });

        $('.bootstrapSwitch').bootstrapSwitch('onText', "是");
        $('.bootstrapSwitch').bootstrapSwitch('offText', "否");

        
        var dateNow = new Date();
        $(".datetimepicker").datetimepicker({
            format: 'YYYY/MM/DD HH:mm:ss',
            locale:"zh-tw",
            defaultDate:dateNow
        }).parent().css("position :relative");

        $(".datetimepicker_end").datetimepicker({
            format: 'YYYY/MM/DD HH:mm:ss',
            locale:"zh-tw",
            defaultDate:dateNow.setFullYear(2050)
        }).parent().css("position :relative");

        $(".datetimepicker_empty").datetimepicker({
            format: 'YYYY/MM/DD HH:mm:ss',
            locale:"zh-tw",
        }).parent().css("position :relative");

        $("#type").on('change',function(event){
            if($(this).val()=="activity"){
                $("#relation_id").html('<?=$activity_select_html?>');
            }else if($(this).val()=="coupon"){
                $("#relation_id").html('<?=$coupon_select_html?>');
            }else if($(this).val()=="text" || $(this).val()=="url"){
                $("#relation_id").html('<option value="text">0(種類為文字，不需選擇)</option>');
            }

            if($(this).val()=="url"){
                $("#only_cont").hide();
                $("#u").show();
            }else{
                $("#t_and_c").show();
                $("#u").hide();
            }
        });

    });  

    window.addEventListener('DOMContentLoaded', function () {
        /* crop */
        var coverImage = document.getElementById("coverImage");
        var cropper;

        $("#inputCover").on("change", function(){
            var input = this;
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $("#coverImage").attr('src', e.target.result);
                    $("#coverImage").width("100%");
                }

                reader.readAsDataURL(input.files[0]);

                $("#coverModal").modal({'backdrop':'static'});
                $("#coverModal").modal("show");
            }
            $(this).val("");
        });

        $('#coverModal').on('shown.bs.modal', function () {
            cropper = new Cropper(coverImage, {
                aspectRatio: 16 / 9
            });

                // $(".modal-backdrop").css({
                //     'z-index': '1049'
                // });
                // $(".modal-backdrop").on('click', function(event) {
                //     return false;
                // });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
        });

        $("#coverSave").on('click', function(event) {
            var result = cropper.getCroppedCanvas();
            $('#getCroppedCanvasModal').modal().find('.modal-body').html(result);

            $.ajax({
                url: "<?=base_url() ?>mgr/dashboard/img_upload",
                data: {
                    imageData: result.toDataURL("image/jpeg")
                },
                type:"POST",
                dataType:'text',
                success: function(msg){
                    // $("#coverArea img").attr("src", msg);
                    // $("#coverArea").css({
                    //     'background': '#FFF',
                    //     'border': '0.5px solid #EEE',
                    //     'padding': '2px',
                    //     'border-radius': '2px'
                    // }).show();
                    // $("#coverurl").val(msg);
                    
                    $("#coverArea").html("<div class='col-lg-3 col-md-4 col-sm-6 col-xs-6' style='border: 1px solid #DDD; background-color:#FFF; padding: 0;'><img src='<?=base_url() ?>"+msg+"' style='width:94%; margin:3%;'></div>");
                    $("#coverurls").val($("#coverurls").val()+msg);
                },
                error:function(xhr, ajaxOptions, thrownError){ 
                    alert("照片上傳發生錯誤"); 
                }
            });

            cropper.destroy();
        });

        /* crop end */
    });  
</script>
</body>

</html>
