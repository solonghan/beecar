<!-- 文章總攬tmeplate -->

<tr id="tr_<?= $item['id'] ?>">
    <td><?= $item['date'] ?></td>


    <!-- <td>
        名稱：<?= $item['username'] ?><br>
        <?= $item['mobile'] ?><br>
        lineID：<?= $item['line_id'] ?><br>
    </td> -->

    <!-- <td> <?
            if ($item['role'] == 'driver') {
                echo '<div class="btn btn-xs btn-success" style="padding: 1px 4px;">駕駛</div>';
            } else {
                echo '<div class="btn btn-xs btn-primary" style="padding: 1px 4px;">車行</div>';
            }
            ?>
    </td> -->

    <!-- <td><?
        if ($item['is_verified'] == '1') {
            echo '已認證';
        } else {
            echo '未認證';
        }
        ?>
    </td> -->

    <!-- <td><?
        if ($item['is_super'] == '1') {
            echo '已開啟';
        } else {
            echo '未開啟';
        }
        ?>
    </td> -->

    <!-- <td><?= $item['register_date'] ?></td> -->
    <!-- <td><?
        if ($item['verify_status'] == 'verify') {
            echo '已通過';
        } elseif($item['verify_status'] == 'unverify') {
            echo '未審核';
        }else{
            echo '未通過';
        }
        ?>
    </td> -->
    <td>
        <button onclick="location.href='<?= base_url() . "mgr/user/edit/" . $item['id'] ?>'" class="btn btn-primary btn-xs"><span class="fa fa-fw ti-pencil"></span></button>
        <!-- <button onclick="location.href='<?= base_url() . "mgr/user/order_data/" . $item['id'] ?>'" class="btn btn-primary btn-xs"><span class="fa fa-fw  ti-more-alt"></span></button> -->
        <button id="del_<?= $item['id'] ?>" class="btn btn-danger btn-xs del-btn"><span class="fa fa-fw fa-minus-square-o"></span></button>
    </td>
</tr>