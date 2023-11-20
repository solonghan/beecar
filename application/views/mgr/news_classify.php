<!DOCTYPE html>
<html>

<head>
    <? include("header.php"); ?>

    <link href="vendors/clockface/css/clockface.css" rel="stylesheet" type="text/css" />
    <link href="vendors/colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet" type="text/css" />
    <link href="vendors/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="vendors/bootstrap-touchspin/css/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css" />
    <link href="vendors/bootstrap-multiselect/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css" />
    <link href="vendors/clockpicker/css/bootstrap-clockpicker.min.css" rel="stylesheet" type="text/css" />
    <link href="vendors/bootstrap-switch/css/bootstrap-switch.css" rel="stylesheet" type="text/css" />


    <link rel="stylesheet" type="text/css" href="css/pickers.css">


    <link rel="stylesheet" type="text/css" href="vendors/datatables/css/dataTables.bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="vendors/datatablesmark.js/css/datatables.mark.min.css" />

    <link href="vendors/select2/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="vendors/select2/css/select2-bootstrap.css" rel="stylesheet" type="text/css">

    <!--end of page level css-->

</head>
<? include("nav+menu.php"); ?>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            消息分類管理
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?= base_url() ?>mgr/">
                    <i class="fa fa-fw ti-home"></i> 主控板
                </a>
            </li>
            <li class="active">消息分類管理
            </li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="panel filterable">
                    <div class="panel-heading clearfix">
                        <h3 class="panel-title pull-left m-t-6">
                            <i class="ti-view-list"></i> 新增分類
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="m-t-10">
                            <table class="table horizontal_table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width:200px">分類名稱</th>

                                        <th style="width:30px;">動作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <form action="<?= base_url() ?>mgr/news/classify/add" method="POST">
                                        <td>
                                            <input type="text" name="title" class="form-control">
                                        </td>

                                        <td>
                                            <button type="submit" class="btn btn-md btn-danger" id="add_row">新增</button>
                                        </td>
                                    </form>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-xs-12">
                <div class="panel filterable">
                    <div class="panel-heading clearfix">
                        <h3 class="panel-title pull-left m-t-6">
                            <i class="ti-view-list"></i> 大分類
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="m-t-10">
                            <table class="table horizontal_table table-striped" style="font-size:18px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>分類名稱</th>
                                        
                                        <th>建立日期</th>
                                        <th>動作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <? for($i=0;$i<count($list);$i++){ $item = $list[$i]; ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= $item['title'] ?></td>
                                        

                                        <td><?= $item['create_date'] ?></td>
                                        <td style="width:10%;">
                                            <button onclick="location.href='<?= base_url() . "mgr/news/classify/edit/" . $item['id'] ?>'" class="btn btn-primary btn-xs"><span class="fa fa-fw ti-pencil"></span></button>
                                            <button onclick="location.href='<?= base_url() . "mgr/news/classify/delete/" . $item['id'] ?>'" class="btn btn-danger btn-xs"><span class="fa fa-fw ti-trash"></span></button>
                                        </td>
                                    </tr>
                                    <? } ?>
                                </tbody>
                            </table>
                        </div>
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
<!-- end of global js -->
<!-- begining of page level js -->
<script type="text/javascript" src="vendors/datatables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="vendors/datatables/js/dataTables.bootstrap.js"></script>
<script src="vendors/mark.js/jquery.mark.js" charset="UTF-8"></script>
<script src="vendors/datatablesmark.js/js/datatables.mark.min.js" charset="UTF-8"></script>

<script>
    $(document).ready(function() {
        window.onload = function() {
            $(function() {
                dtInstance = $("#showtable").DataTable({
                    "lengthMenu": [25, 50, -1],
                    "responsive": true,
                    bLengthChange: true,
                    "pageLength": 25,
                    // "ordering": false,
                    "order": [
                        [0, "desc"]
                    ],
                    columnDefs: [{
                        targets: [10],
                        orderable: false
                    }, ]
                });
            });
        }
    });
</script>
</body>

</html>