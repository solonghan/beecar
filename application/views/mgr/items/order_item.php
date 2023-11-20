<!-- 報名者總攬tmeplate -->

<tr id="tr_<?= $item['id'] ?>">
    <td><?= $item['order_no'] ?></td>

    <td><?= $item['date'] ?><br><?= $item['time'] ?><br>
    </td>


    <td><?= $item['name'] ?><br>
        <?= $item['phone'] ?><br>
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
    <td><?= $item['owner'] ?></td>


    <td><?= $item['create_date'] ?></td>

</tr>