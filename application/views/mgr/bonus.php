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
            滿額送贈品管理
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?= base_url() ?>mgr/">
                    <i class="fa fa-fw ti-home"></i> 主控板
                </a>
            </li>
            <li class="active">
                <a href="<?= base_url() ?>mgr/discount">
                    折扣設定管理
                </a>
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
                            <i class="ti-view-list"></i> 滿額送贈品設定管理
                        </h3>
                    </div>
                    <div class="panel-body">
                        <button class="pull-right btn btn-md btn-primary" style="margin-right: 25px;" onclick="location.href='<?= base_url() ?>mgr/discount/add/1';">新增滿送贈品條件</button>
                        <div class="m-t-10">
                            <table class="table horizontal_table table-striped">
                                <thead>
                                    <tr>
                                        <th>折扣名稱</th>
                                        <th>滿額底線</th>
                                        <th>贈品設定</th>
                                        <th>開始日期</th>
                                        <th>結束日期</th>
                                        <th>動作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <? for ($i = 0; $i < count($list_1); $i++) {
                                        $item = $list_1[$i]; ?>
                                        <tr data-id='<?= $item['id'] ?>'>
                                            <td><?= $item['title'] ?></td>
                                            <td><?= $item['price_limit'] ?></td>
                                            <td><button onclick="location.href='<?= base_url() . "mgr/bonusproduct/index/" . $item['id'] ?>'" class="btn btn-success">新增贈品</button></td>
                                            <td><?= $item['start_date'] ?></td>
                                            <td><?= $item['end_date'] ?></td>
                                            <td style="width:10%;">
                                                <button class="btn btn-primary btn-xs edit-btn" data-toggle="tooltip" data-original-title="編輯"><span class="fa fa-fw ti-pencil"></span></button>
                                                <button class="del-btn btn btn-danger btn-xs"><span class="fa fa-fw ti-trash"></span></button>
                                            </td>
                                        </tr>
                                    <? } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="col-lg-6 col-xs-6">
                <div class="panel filterable">
                    <div class="panel-heading clearfix">
                        <h3 class="panel-title pull-left m-t-6">
                            <i class="ti-view-list"></i> 滿件折扣管理
                        </h3>
                    </div>
                    <div class="panel-body">
                        <button class="pull-right btn btn-md btn-primary" style="margin-right: 25px;" onclick="location.href='<?= base_url() ?>mgr/discount/add/2';">新增滿件折扣</button>
                        <div class="m-t-10">
                            <table class="table horizontal_table table-striped">
                                <thead>
                                    <tr>
                                        <th>折扣名稱</th>
                                        <th>滿件底線</th>
                                        <th>折扣％數</th>
                                        <th>開始日期</th>
                                        <th>結束日期</th>
                                        <th>動作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <? for ($i = 0; $i < count($list_2); $i++) {
                                        $item = $list_2[$i]; ?>
                                        <tr data-id='<?= $item['id'] ?>'>
                                            <td><?= $item['title'] ?></td>
                                            <td><?= $item['quantity_limit'] ?></td>
                                            <td><?= $item['discount'] ?></td>
                                            <td><?= $item['start_date'] ?></td>
                                            <td><?= $item['end_date'] ?></td>
                                            <td style="width:10%;">
                                                <button class="btn btn-primary btn-xs edit-btn" data-toggle="tooltip" data-original-title="編輯"><span class="fa fa-fw ti-pencil"></span></button>
                                                <button class="del-btn btn btn-danger btn-xs"><span class="fa fa-fw ti-trash"></span></button>
                                            </td>
                                        </tr>
                                    <? } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> -->
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

    $(document).on('click', ".del-btn", function(event) {
        if (!confirm("確定刪除此筆資料嗎?")) return;
        var id = $(this).closest('tr').attr("data-id");

        $.ajax({
            url: '<?= base_url() ?>mgr/discount/del',
            data: {
                id: id
            },
            type: "POST",
            dataType: "json",
            success: function(msg) {
                if (msg.status) {
                    $("tr[data-id=" + id + "]").fadeTo('fast', 0.5, function() {
                        $(this).remove();
                    });
                }
            }
        });
    });

    $(document).on('click', ".edit-btn", function(event) {
        var id = $(this).closest('tr').attr("data-id");
        location.href = '<?= base_url() ?>mgr/discount/bonus_edit/' + id;
    });
</script>
</body>

</html>