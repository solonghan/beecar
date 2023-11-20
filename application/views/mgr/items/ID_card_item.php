<!-- 文章總攬tmeplate -->

<tr>
    <!-- <td>
        <?= $item['id'] ?>
    </td> -->
    <td>
        <?= $item['username'] ?>
    </td>
   
    <td><img src="<?= base_url() . $item['frontend'] ?>" alt="" style="width:250px; height: 150px;"></td>
    <td><img src="<?= base_url() . $item['backend'] ?>" alt="" style="width:250px; height: 150px;"></td>
    
    <!-- <td>
        <?= $item['expired_date'] ?>
    </td> -->
    
    
<!-- 
    <td>
     
       
        <?php for($i=0;$i<count($item['friends']);$i++) {?>
        <?=$item['friends'][$i] ?><br>
        <?php }?>
       
    </td>
    <td>
        <?= $item['email'] ?>
    </td>
    <td>
        <?= $item['mobile'] ?>
    </td> -->

    <td> <?
            if ($item['status'] == 'pending') {
                echo '<div class="btn btn-xs btn-success" style="padding: 1px 4px;">審核中</div>';
            } elseif($item['status'] == 'verified') {
                echo '<div class="btn btn-xs btn-primary" style="padding: 1px 4px;">已通過</div>';
            }else{
                echo '<div class="btn btn-xs btn-danger" style="padding: 1px 4px;">未通過</div>';
            }
            ?>
    </td>

    <!-- <td><?
        if ($item['is_verified'] == '1') {
            echo '已認證';
        } else {
            echo '未認證';
        }
        ?>
    </td>

    <td><?
        if ($item['is_super'] == '1') {
            echo '已開啟';
        } else {
            echo '未開啟';
        }
        ?>
    </td> -->

    <!-- <td><?= $item['register_date'] ?></td> -->
    <td>
        <button onclick="location.href='<?= base_url() . "mgr/driver/ID_card_edit/" . $item['id'] ?>'" class="btn btn-primary btn-xs"><span class="fa fa-fw ti-pencil"></span></button>

        <button id="del_<?= $item['id'] ?>" class="btn btn-danger btn-xs del-btn"><span class="fa fa-fw fa-minus-square-o"></span></button>
    </td>
</tr>