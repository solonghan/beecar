<!-- 報名者總攬tmeplate -->

<tr id="tr_<?= $item['id'] ?>">
    <td><?= $item['order_no'] ?></td>

    <td><?= $item['date'] ?><br><?= $item['time'] ?><br>
    </td>


    <td>姓名:<?= $item['name'] ?><br>
        電話:<?= $item['phone'] ?><br>
        航班編號：<?= $item['flight'] ?><br>
        人數：<?= $item['number'] ?>人<br>
        行李：<?= $item['baggage'] ?>件<br>
        備註：<?= $item['remark'] ?><br>
    </td>
    

    <td>
        開始地址：<?= $item['start_city'] . $item['start_dist'] . $item['start_addr'] ?><br>
        車型：<?= $item['car_model'] ?><br>
        <? if ($item['final_status'] == '0') {
            echo '回金：' . $item['final_payment'];
        } elseif ($item['final_status'] == '1') {
            echo '補貼：' . $item['final_payment'];
        } ?><br>
        <? if ($item['price_type'] == '0') {
            echo '收現：' . $item['price'];
        } elseif ($item['price_type'] == '1') {
            echo '轉帳：' . $item['price'];
        } ?><br>
    </td>

    <td>
        <? if ($item['driver_status'] == '') {
            echo '未開始';
        } elseif ($item['driver_status'] == 'start') {
            echo '開始行程';
        } elseif ($item['driver_status'] == 'to_start') {
            echo '前往起點';
        } elseif ($item['driver_status'] == 'arrive_start') {
            echo '抵達起點';
        } elseif ($item['driver_status'] == 'start_trip') {
            echo '開始行程';
        } elseif ($item['driver_status'] == 'end') {
            echo '結束行程';
        } elseif ($item['driver_status'] == 'finish') {
            echo '完成行程';
        }
        ?>

    </td>
    <td><?= $item['driver_name'] ? $item['driver_name'] : "尚無駕駛承接" ?></td>
    <!-- <td></td> -->
    <td><?= $item['owner'] ?></td>
    
    
    <td><?= $item['create_date'] ?></td>

    <td>
        <button onclick="location.href='<?= base_url() . "mgr/user/edit_order/" . $item['id'] ?>'" class="btn btn-primary btn-xs"><span class="fa fa-fw ti-pencil"></span></button>
        <!-- <button onclick="location.href='<?= base_url() . "mgr/user/order_data/" . $item['id'] ?>'" class="btn btn-primary btn-xs"><span class="fa fa-fw  ti-more-alt"></span></button> -->
        <button id="del_<?= $item['id'] ?>" class="btn btn-danger btn-xs del-btn"><span class="fa fa-fw fa-minus-square-o"></span></button>
    </td>

</tr>