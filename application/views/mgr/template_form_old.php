<!DOCTYPE html>
<html>

<head>
    <? include("header.php"); ?>
    <link rel="stylesheet" href="vendors/datetime/css/jquery.datetimepicker.css">
    <link href="vendors/airdatepicker/css/datepicker.min.css" rel="stylesheet" type="text/css">
    <link href="vendors/select2/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="vendors/select2/css/select2-bootstrap.css" rel="stylesheet" type="text/css">
    
</head>
<? include("nav+menu.php"); ?>
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?=$title ?>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?=base_url() ?>mgr/">
                        <i class="fa fa-fw ti-home"></i> 主控板
                    </a>
                </li>
                <? if ($parent != ""): ?>
                <li ><a href="<?=$parent_link ?>">
                        <i class="fa fa-fw ti-folder"></i> <?=$parent ?>
                    </a>
                </li>
                <? endif; ?>
                <li class="active"><?=$title ?></li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="panel filterable">
                        <div class="panel-heading clearfix">
                            <h3 class="panel-title pull-left m-t-6">
                                <i class="ti-view-list"></i> <?=$title ?>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="<?=$action ?>" id="new_form" enctype='multipart/form-data'>
                                           <input type="hidden" name="coverDeleted" id="coverDeleted" value="">                            
                                <?
                                    
                                    foreach ($param as $item):
                                        
                                ?>
                                <div class="form-group">
                                    <label for="input-text" class="col-sm-2 control-label"><?=$item[0]?></label>
                                    <div class="col-sm-10">
                                        <? if ($item[2] == "text"): ?>
                                        <input type="text" class="form-control" name="<?=$item[1] ?>" value="<?=$item[3] ?>">
                                        
                                        <? elseif ($item[2] == "number"): ?>
                                        <input type="number" class="form-control" name="<?=$item[1] ?>" value="<?=$item[3] ?>">
                                        <? elseif ($item[2] == "plain"): ?>
                                        <div style="line-height: 40px; border-bottom: 1px solid #EEE;"><?=$item[3] ?></div>
                                        <? elseif($item[2] == "textarea"): ?>
                                        <textarea class="ckeditor" id="<?=$item[1] ?>" name="<?=$item[1] ?>"><?=$item[3] ?></textarea>
                                        
                                        <? elseif($item[2] == "textarea1"): ?>
                                        <textarea style="width: 100%;height: 200px;"  id="<?=$item[1] ?>" name="<?=$item[1] ?>"><?=$item[3] ?></textarea>   

                                        <? elseif($item[2] == "textarea_plain"): ?>
                                        <textarea class="form-control" id="<?=$item[1] ?>" name="<?=$item[1] ?>" style="height: 200px;"><?=$item[3] ?></textarea>
                                        <? elseif($item[2] == "checkbox"): ?>
                                        <input type="checkbox" class="form-control" name="<?=$item[1] ?>"<?=($item[3]!="" && $item[3]==1)?' checked':'' ?>>
                                        <? elseif($item[2] == "day"): ?>
                                        <input type="text" class="form-control daypicker" name="<?=$item[1] ?>" value="<?=$item[3] ?>" autocomplete="off">
                                        <? elseif($item[2] == "select"): ?>
                                        <select class="form-control select2" name="<?=$item[1] ?>">
                                            <? 
                                                foreach ($select[$item[1]] as $option){
                                                    echo '<option value="'.$option[$item[4][0]].'"';
                                                    if ($item[3] == $option[$item[4][0]]) echo ' selected';
                                                    echo '>'.$option[$item[4][1]].'</option>';
                                                } 
                                            ?>
                                        </select>
                                        <? elseif($item[2] == "select_multi"): ?>
                                        <select class="form-control select2" name="<?=$item[1] ?>[]" multiple="multiple">
                                            <? 
                                                foreach ($select[$item[1]] as $option){
                                                    echo '<option value="'.$option[$item[4][0]].'"';
                                                    if (is_array($item[3]) && in_array($option[$item[4][0]], $item[3])) echo ' selected';
                                                    echo '>'.$option[$item[4][1]].'</option>';
                                                } 
                                            ?>
                                        </select>
                                        <? elseif($item[2] == "file"): ?>
                                        <input type="file" class="form-control" name="<?=$item[1] ?>">
                                            <? if ($item[3] != ""): ?>
                                            <br>
                                            <div id="file_<?=$item[1] ?>">
                                                <a href="<?=$cdn_url.$item[3] ?>">線上觀看</a>&nbsp;&nbsp;
                                                <button type="button" class="btn btn-sm btn-danger" onclick="delete_file('<?=$item[1] ?>');">刪除檔案</button>
                                            </div>
                                            <input type="hidden" name="<?=$item[1] ?>_deleted" value="false">
                                            <? endif; ?>
                                        <? elseif($item[2] == "img"): ?>
                                            <input data-ratio="<?=$item[4] ?>" data-related="<?=$item[1] ?>" class="img_upload" type="file" id="imgupload_<?=$item[1] ?>" style="display: none;" accept="image/*">
                                            <button type="button" class="btn btn-sm btn-info" onclick="imgupload_<?=$item[1] ?>.click();">選擇照片</button>
                                            <button id="delphoto_<?=$item[1] ?>" type="button" class="btn btn-sm btn-danger" onclick="delete_photo('<?=$item[1] ?>');"<?=($item[3] == "")?' style="display:none;"':"" ?>>刪除照片</button>
                                            <input type="hidden" name="<?=$item[1] ?>" id="<?=$item[1] ?>" value="<?=$item[3] ?>">
                                            <div id="img_<?=$item[1] ?>" style="width: 256px; margin-top: 6px; background-color: #FFF; border:1px solid #DDD; padding: 2px; border-radius: 2px;<?=($item[3] == "")?' display:none;':"" ?>">
                                                <img src="<?=($item[3] != "")?$cdn_url.$item[3]:"" ?>" style="width: 250px;">
                                            </div>
                                        <? elseif($item[2] == "test"): ?>

                                            <input type="file" class="form-control" name="cover[]" value="" multiple>
                                            <!-- <small class="text text-danger">※最多限10張照片</small> -->
                                        
                                            <div class="row">
                                            <?
                                                if ($item[3] != "") {
                                                    $cover = unserialize($item[3]);
                                                    foreach ($cover as $c) {
                                            ?>
                                            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                                <img src="<?=base_url().$c ?>" class="thumbnail" style="width:100%;">
                                                <button type="button" class="btn btn-sm btn-danger del-btn" onclick="delCover(this, '<?=$c ?>');">
                                                    <span class="fa fa-fw ti-trash"></span>
                                                </button>
                                            </div>
                                            <?
                                                    }
                                                }
                                            ?>    
                                            </div>                               

                                        <? endif; ?>
                                    </div>
                                </div>
                                <? endforeach; ?>
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-2">
                                        <button type="button" class="btn btn-md btn-primary submit_btn"><?=$submit_txt ?></button>
                                    </div>
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
<!-- global js -->
<script src="js/app.js" type="text/javascript"></script>

<script src="vendors/datetime/js/jquery.datetimepicker.full.min.js" type="text/javascript"></script>
<script src="vendors/airdatepicker/js/datepicker.min.js" type="text/javascript"></script>
<script src="vendors/airdatepicker/js/datepicker.en.js" type="text/javascript"></script>
<script src="ckeditor/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script>var language = {
        daysMin: ['日', '一', '二', '三', '四', '五', '六'],
        months: ['一月','二月','三月','四月','五月','六月', '七月','八月','九月','十月','十一月','十二月'],
        monthsShort: ['一月','二月','三月','四月','五月','六月', '七月','八月','九月','十月','十一月','十二月'],
        dateFormat: 'yyyy-mm-dd',
        timeFormat: 'hh:ii:00',
        firstDay: 0
    };
    $(document).ready(function () {
        $(".select2").select2();
        $('.daypicker').datepicker({
            language: language,
            minDate: new Date('<?=date('Y-m-d') ?>'),
            position: "bottom left",
            autoClose: true
        });   
        $(".submit_btn").on('click', function(event) {
            $("#new_form").submit();
        });
    });

    function delete_file(id){
        $("#file_"+id).remove();
        $("input[name="+id+"_deleted]").val("true");
    }

    function delete_photo(id){
        $("#delphoto_"+id).hide();
        $("#"+id).val("");
        $("#img_"+id+" img").attr("src", "");
        $("#img_"+id).hide();
    }
    function delCover(obj, pic){
        if (!confirm("確定刪除此照片嗎?刪除後請按下方儲存鈕，才會真正刪除。")) return;
        $(obj).parent("div").fadeOut();
        $("#coverDeleted").val($("#coverDeleted").val()+pic+",");
    }    
    
</script>
<? include("crop.php"); ?>
</body>

</html>
